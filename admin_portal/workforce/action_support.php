<?php
require_once __DIR__ . '/../../includes/admin_layout.php';
require_once __DIR__ . '/../admin_auth.php';
require_admin();
ensure_workflow_support_columns();
refresh_live_sla_statuses();

$reason = trim((string)($_GET['reason'] ?? $_POST['reason'] ?? 'All'));
$allowedReasons = ['All', 'Outsourcing', 'Senior Support', 'Parts Required'];
if (!in_array($reason, $allowedReasons, true)) $reason = 'All';

// Always show the full request list. Pending requests appear first, while handled
// cases remain visible after the manager completes an action.
$view = 'all';

$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $caseId = trim((string)($_POST['case_id'] ?? ''));
    $actionType = trim((string)($_POST['action_type'] ?? ''));
    $managerAction = trim((string)($_POST['manager_action'] ?? ''));
    $case = $caseId !== '' ? fetch_one('SELECT * FROM workforce_cases WHERE case_id=?', [$caseId]) : null;

    if (!$case) {
        $errorMessage = 'The selected support request could not be found.';
    } elseif ($actionType === 'Senior Support' && $managerAction === 'assign_senior') {
        $seniorId = trim((string)($_POST['senior_technician_id'] ?? ''));
        $previous = find_technician((string)($case['previous_technician_id'] ?? ''));
        $senior = find_technician($seniorId);
        $sourceRole = (string)($previous['role'] ?? 'Technician');
        $department = normalize_technician_department((string)($previous['department'] ?? $case['hotel_asset'] ?? ''));
        $valid = $senior && technician_level_label($senior) === 'Senior' && technician_has_capacity($seniorId, $caseId);

        if ($valid && $sourceRole === 'Technical Specialist') {
            $valid = ($senior['role'] ?? '') === 'Technical Specialist';
        }
        if ($valid && $sourceRole === 'Technician') {
            $valid = ($senior['role'] ?? '') === 'Technician'
                && normalize_technician_department((string)($senior['department'] ?? '')) === $department;
        }

        if (!$valid) {
            $errorMessage = 'Please select an available senior technician from the correct workflow group.';
        } elseif (assign_case_to_technician($caseId, $seniorId, 'Senior Assigned', 'Senior escalation assigned to ' . $seniorId . '.')) {
            execute_sql("UPDATE workforce_cases SET transfer_reason='Senior Support', support_status='Senior Assigned' WHERE case_id=?", [$caseId]);
            execute_sql("UPDATE technician_tasks SET support_status='Senior Assigned' WHERE case_id=?", [$caseId]);
            $successMessage = 'The case was transferred to ' . $seniorId . '.';
        }
    } elseif ($actionType === 'Parts Required') {
        $part = trim((string)($case['requested_part'] ?? ''));

        if ($part === '') {
            $errorMessage = 'The technician has not selected the required part yet.';
        } elseif ($managerAction === 'parts_ordered') {
            execute_sql(
                "UPDATE workforce_cases
                 SET parts_status='Ordered', parts_ordered_at=NOW(), support_status='Parts Ordered', manager_note=?
                 WHERE case_id=?",
                ['Parts ordered: ' . $part, $caseId]
            );
            execute_sql("UPDATE technician_tasks SET support_status='Parts Ordered' WHERE case_id=?", [$caseId]);
            $successMessage = 'Parts marked as ordered for ' . $caseId . '.';
        } elseif (in_array($managerAction, ['use_stock', 'mark_parts_ready', 'reassign_parts'], true)) {
            execute_sql(
                "UPDATE workforce_cases
                 SET parts_status='Ready', parts_ready_at=COALESCE(parts_ready_at,NOW()),
                     support_status='Parts Ready - Pending Reassignment',
                     work_stage='Pending Reassignment', task_status='Pending Reassignment', manager_note=?
                 WHERE case_id=?",
                [($managerAction === 'use_stock' ? 'Use stock' : 'Parts ready') . ': ' . $part, $caseId]
            );
            execute_sql(
                "UPDATE technician_tasks
                 SET support_status='Parts Ready - Pending Reassignment', task_status='Pending Reassignment'
                 WHERE case_id=?",
                [$caseId]
            );
            $assigned = auto_reassign_case($caseId, 'Parts Ready - Assigned');
            $successMessage = $assigned
                ? 'Parts are ready and the case was assigned to ' . $assigned . '.'
                : 'Parts are ready. No technician is currently available; the case remains pending reassignment.';
        } else {
            $errorMessage = 'Select a valid parts action.';
        }
    } elseif ($actionType === 'Outsourcing') {
        if ($managerAction === 'approve_outsourcing') {
            execute_sql(
                "UPDATE workforce_cases
                 SET work_stage='Outsourced', task_status='Outsourced', support_status='Outsourced',
                     outsourcing_status='Approved', outsourced_at=NOW(), manager_note='Outsourcing approved'
                 WHERE case_id=?",
                [$caseId]
            );
            execute_sql("UPDATE technician_tasks SET task_status='Outsourced', support_status='Outsourced' WHERE case_id=?", [$caseId]);
            execute_sql("UPDATE smart_maintenance_tickets SET ticket_status='Outsourced', support_status='Outsourced' WHERE case_id=?", [$caseId]);
            $successMessage = 'Outsourcing approved for ' . $caseId . '.';
        } elseif ($managerAction === 'reject_outsourcing') {
            execute_sql(
                "UPDATE workforce_cases
                 SET work_stage='Pending Reassignment', task_status='Pending Reassignment',
                     support_status='Outsourcing Rejected - Pending Reassignment',
                     outsourcing_status='Rejected',
                     manager_note='Outsourcing rejected; internal reassignment required'
                 WHERE case_id=?",
                [$caseId]
            );
            execute_sql(
                "UPDATE technician_tasks
                 SET task_status='Pending Reassignment', support_status='Outsourcing Rejected - Pending Reassignment'
                 WHERE case_id=?",
                [$caseId]
            );
            $assigned = auto_reassign_case($caseId, 'Outsourcing Rejected - Reassigned');
            $successMessage = $assigned
                ? 'Outsourcing rejected and the case was reassigned to ' . $assigned . '.'
                : 'Outsourcing rejected. No technician is currently available.';
        } elseif ($managerAction === 'reassign_outsourcing') {
            $assigned = auto_reassign_case($caseId, 'Outsourcing Rejected - Reassigned');
            $successMessage = $assigned
                ? 'The case was reassigned to ' . $assigned . '.'
                : 'No same-workflow technician is currently available; the case remains pending reassignment.';
        } elseif ($managerAction === 'complete_outsourcing') {
            execute_sql(
                "UPDATE workforce_cases
                 SET work_stage='Completed', task_status='Completed',
                     support_status='Outsourced Work Completed', outsourcing_status='Completed',
                     completed_at=NOW(), assigned_technician_id=NULL, technician_id=NULL,
                     manager_note='Outsourced work completed'
                 WHERE case_id=?",
                [$caseId]
            );
            execute_sql(
                "UPDATE technician_tasks
                 SET task_status='Completed', support_status='Outsourced Work Completed',
                     completed_time=NOW(), technician_id=NULL, assigned_technician_id=NULL
                 WHERE case_id=?",
                [$caseId]
            );
            execute_sql(
                "UPDATE smart_maintenance_tickets
                 SET ticket_status='Completed', support_status='Outsourced Work Completed', completed_date=NOW()
                 WHERE case_id=?",
                [$caseId]
            );
            $successMessage = 'Outsourced work marked completed for ' . $caseId . '.';
        } else {
            $errorMessage = 'Select a valid outsourcing action.';
        }
    }

    refresh_live_sla_statuses();
    refresh_all_technician_summaries();
}

admin_ui_header(
    $reason === 'All' ? 'Action Support Required' : $reason . ' Support Review',
    'workforce',
    'Review pending requests while keeping handled cases available for reference.',
    true
);

$managerActionWhere = workforce_manager_action_where();
$baseWhere = "support_reason IN ('Outsourcing','Senior Support','Parts Required')";
$baseParams = [];
if ($reason !== 'All') {
    $baseWhere .= ' AND support_reason=?';
    $baseParams[] = $reason;
}

$totalRequests = scalar("SELECT COUNT(*) FROM workforce_cases WHERE {$baseWhere}", $baseParams);
$pendingWhere = "({$baseWhere}) AND ({$managerActionWhere})";
$pendingRequests = scalar("SELECT COUNT(*) FROM workforce_cases WHERE {$pendingWhere}", $baseParams);
$newRequests = scalar(
    "SELECT COUNT(*) FROM workforce_cases
     WHERE {$pendingWhere}
       AND support_requested_at IS NOT NULL
       AND support_requested_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)",
    $baseParams
);

$listWhere = $baseWhere;

$cases = fetch_all(
    "SELECT *
     FROM workforce_cases
     WHERE {$listWhere}
     ORDER BY CASE WHEN {$managerActionWhere} THEN 0 ELSE 1 END,
              COALESCE(support_requested_at, case_created_at, assigned_at) DESC,
              case_id DESC",
    $baseParams
);

$casePayload = [];
foreach ($cases as $case) {
    $isPending = workforce_case_needs_manager_action($case);
    $previous = find_technician((string)($case['previous_technician_id'] ?? ''));
    $sourceRole = (string)($previous['role'] ?? 'Technician');
    $sourceDepartment = normalize_technician_department((string)($previous['department'] ?? $case['hotel_asset'] ?? ''));
    $eligible = $isPending && ($case['support_reason'] ?? '') === 'Senior Support'
        ? fetch_assignable_senior_technicians($sourceRole, $sourceDepartment)
        : [];

    $casePayload[$case['case_id']] = [
        'case_id' => $case['case_id'],
        'room' => $case['room'],
        'hotel_asset' => support_asset_group((string)$case['hotel_asset']),
        'component' => $case['component'],
        'issue' => $case['issue'] ?: $case['issue_summary'],
        'severity' => $case['severity'],
        'priority' => priority_display_name($case['priority'] ?? ''),
        'previous_technician_id' => $case['previous_technician_id'],
        'assigned_technician_id' => $case['assigned_technician_id'] ?? '',
        'support_reason' => $case['support_reason'],
        'support_status' => $case['support_status'] ?: 'Pending Manager Action',
        'support_requested_at' => $case['support_requested_at'] ?? '',
        'technician_note' => $case['technician_note'],
        'manager_note' => $case['manager_note'] ?? '',
        'work_stage' => $case['work_stage'] ?? '',
        'task_status' => $case['task_status'] ?? '',
        'completed_at' => $case['completed_at'] ?? '',
        'safety_flag' => $case['safety_flag'],
        'sla_status' => $case['sla_status'] ?: $case['overall_sla_status'],
        'required_external_service' => $case['required_external_service'] ?? '',
        'outsourcing_reason' => $case['outsourcing_reason'] ?? '',
        'requested_part' => $case['requested_part'] ?? '',
        'support_other_detail' => $case['support_other_detail'] ?? '',
        'parts_status' => $case['parts_status'] ?? '',
        'outsourcing_status' => $case['outsourcing_status'] ?? '',
        'is_pending' => $isPending,
        'eligible_seniors' => array_map(
            static fn(array $technician): array => [
                'technician_id' => $technician['technician_id'],
                'name' => $technician['name'] ?: $technician['technician_id'],
                'department' => technician_department_label($technician),
                'role' => technician_workflow_role_label($technician),
                'level' => technician_level_label($technician),
                'active_tasks' => (int)($technician['active_tasks'] ?? 0),
            ],
            $eligible
        ),
    ];
}

$tableTitle = $reason === 'All'
    ? 'All Support Requests'
    : $reason . ' Support Requests';
$tableDescription = 'Pending requests appear first. Once a manager action is completed, the case stays in this table as a read-only record.';
?>
<section class="kpis one-row three workforce-detail-kpis support-history-kpis">
  <div class="kpi"><h3>Total Requests</h3><h2><?= e(number_format($totalRequests)) ?></h2><p>All retained support cases</p></div>
  <div class="kpi"><h3>Pending Manager Action</h3><h2><?= e(number_format($pendingRequests)) ?></h2><p>Requires action now</p></div>
  <div class="kpi<?= $newRequests > 0 ? ' support-new-kpi' : '' ?>">
    <h3>New in Last 24 Hours</h3>
    <h2><?= e(number_format($newRequests)) ?></h2>
    <p><?= $newRequests > 0 ? 'New pending request received' : 'No new pending request' ?></p>
  </div>
</section>

<?php if ($successMessage !== ''): ?>
  <div class="support-success-message" role="status"><?= e($successMessage) ?></div>
<?php endif; ?>
<?php if ($errorMessage !== ''): ?>
  <div class="support-error-message" role="alert"><?= e($errorMessage) ?></div>
<?php endif; ?>

<section class="card detail-table-card support-history-table-card">
  <div class="table-header">
    <div>
      <h2><?= e($tableTitle) ?></h2>
      <p><?= e($tableDescription) ?></p>
    </div>
  </div>

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Case ID</th>
          <th>Room</th>
          <th>Hotel Asset</th>
          <th>Previous Technician</th>
          <th>Support Reason</th>
          <th>Requested At</th>
          <th>Support Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$cases): ?>
          <tr><td colspan="8" class="empty-table-message">No support requests were found.</td></tr>
        <?php endif; ?>

        <?php foreach ($cases as $case):
            $isPending = workforce_case_needs_manager_action($case);
            $requestedAt = trim((string)($case['support_requested_at'] ?? ''));
            $requestedLabel = $requestedAt !== '' ? date('d M Y, H:i', strtotime($requestedAt)) : '-';
        ?>
          <tr id="case-<?= e($case['case_id']) ?>">
            <td><strong><?= e($case['case_id']) ?></strong></td>
            <td><?= e($case['room']) ?></td>
            <td><?= e(support_asset_group((string)$case['hotel_asset'])) ?></td>
            <td><?= e($case['previous_technician_id'] ?: 'Unassigned') ?></td>
            <td><?= e($case['support_reason']) ?></td>
            <td><?= e($requestedLabel) ?></td>
            <td>
              <span class="support-status-pill<?= $isPending ? ' is-pending' : ' is-handled' ?>">
                <?= e($case['support_status'] ?: ($isPending ? 'Pending Manager Action' : 'Handled')) ?>
              </span>
            </td>
            <td>
              <button
                type="button"
                class="<?= $isPending ? 'primary-btn' : 'secondary-action-btn' ?> support-open-btn"
                data-case-id="<?= e($case['case_id']) ?>"
                data-action-type="<?= e($case['support_reason']) ?>"
                data-readonly="<?= $isPending ? '0' : '1' ?>"
              ><?= $isPending ? 'Manage' : 'View' ?></button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>

<div class="support-modal" id="supportActionModal" aria-hidden="true">
  <div class="support-modal-card support-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="supportModalTitle" aria-describedby="supportModalDescription">
    <button type="button" class="support-modal-close" aria-label="Close">×</button>

    <div class="support-modal-heading">
      <p class="support-modal-kicker" id="supportModalKicker">Support Request</p>
      <h2 id="supportModalTitle">Manage Request</h2>
      <p id="supportModalDescription">Review the technician-submitted details and complete the manager action.</p>
    </div>

    <div class="support-case-grid" id="supportCaseGrid"></div>

    <div class="support-history-readonly-note" id="supportHistoryNote" hidden>
      This manager action has already been handled. The case remains available as a read-only record and will not disappear from this page.
    </div>

    <form method="post" class="support-action-form" id="supportActionForm">
      <input type="hidden" name="reason" value="<?= e($reason) ?>">
      <input type="hidden" name="view" value="<?= e($view) ?>">
      <input type="hidden" name="case_id" id="supportCaseId">
      <input type="hidden" name="action_type" id="supportActionType">

      <div class="support-form-section">
        <label>
          Manager Action
          <select name="manager_action" id="managerActionSelect" required></select>
        </label>
      </div>

      <div class="support-request-review" id="outsourcingFields" hidden>
        <div class="support-review-item"><span>Required External Service</span><strong id="requestedExternalService">-</strong></div>
        <div class="support-review-item"><span>Reason for Outsourcing</span><strong id="requestedOutsourcingReason">-</strong></div>
      </div>

      <div class="support-form-section" id="seniorFields" hidden>
        <label>
          Senior Technician
          <select name="senior_technician_id" id="seniorTechnicianSelect">
            <option value="">Select a senior technician</option>
          </select>
        </label>
      </div>

      <div class="support-request-review" id="partsFields" hidden>
        <div class="support-review-item"><span>Requested Part</span><strong id="requestedPartValue">-</strong></div>
        <div class="support-review-item"><span>Parts Status</span><strong id="requestedPartsStatus">-</strong></div>
      </div>

      <div class="support-modal-actions">
        <button type="button" class="secondary-action-btn support-cancel-btn">Cancel</button>
        <button type="submit" class="primary-btn" id="supportSubmitButton">Confirm</button>
      </div>
    </form>

    <div class="support-modal-actions support-history-close-actions" id="supportHistoryActions" hidden>
      <button type="button" class="primary-btn support-cancel-btn">Close</button>
    </div>
  </div>
</div>

<script>
window.supportActionData = <?= json_encode(['cases' => $casePayload], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;

document.addEventListener('DOMContentLoaded', () => {
  const data = window.supportActionData || {};
  const modal = document.getElementById('supportActionModal');
  const form = document.getElementById('supportActionForm');
  const caseGrid = document.getElementById('supportCaseGrid');
  const caseIdInput = document.getElementById('supportCaseId');
  const typeInput = document.getElementById('supportActionType');
  const actionSelect = document.getElementById('managerActionSelect');
  const seniorFields = document.getElementById('seniorFields');
  const seniorSelect = document.getElementById('seniorTechnicianSelect');
  const partsFields = document.getElementById('partsFields');
  const outsourcingFields = document.getElementById('outsourcingFields');
  const historyNote = document.getElementById('supportHistoryNote');
  const historyActions = document.getElementById('supportHistoryActions');
  const modalKicker = document.getElementById('supportModalKicker');
  const modalTitle = document.getElementById('supportModalTitle');
  const modalDescription = document.getElementById('supportModalDescription');

  const esc = value => String(value ?? '-').replace(/[&<>'"]/g, character => ({
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    "'": '&#039;',
    '"': '&quot;'
  }[character]));

  const displayDate = value => {
    if (!value) return '-';
    const parsed = new Date(String(value).replace(' ', 'T'));
    return Number.isNaN(parsed.getTime()) ? String(value) : parsed.toLocaleString();
  };

  function options(item, type) {
    if (type === 'Senior Support') return [['assign_senior', 'Assign Senior']];
    if (type === 'Parts Required') {
      const status = String(item.parts_status || '').toLowerCase();
      if (status === 'ordered') return [['mark_parts_ready', 'Mark Parts Ready']];
      if (status === 'ready') return [['reassign_parts', 'Reassign Technician']];
      return [['use_stock', 'Use Stock'], ['parts_ordered', 'Parts Ordered']];
    }

    const outsourcingStatus = String(item.outsourcing_status || '').toLowerCase();
    if (outsourcingStatus === 'approved') return [['complete_outsourcing', 'Mark Outsourced Work Completed']];
    if (outsourcingStatus === 'rejected') return [['reassign_outsourcing', 'Retry Internal Reassignment']];
    return [['approve_outsourcing', 'Approve Outsourcing'], ['reject_outsourcing', 'Reject & Reassign']];
  }

  function openModal(caseId, type, readOnlyRequested) {
    const item = data.cases?.[caseId];
    if (!item) return;

    const readOnly = readOnlyRequested || !item.is_pending;
    caseIdInput.value = caseId;
    typeInput.value = type;

    modalKicker.textContent = readOnly ? 'Handled Support Request' : 'Pending Support Request';
    modalTitle.textContent = readOnly ? 'Request Details' : 'Manage Request';
    modalDescription.textContent = readOnly
      ? 'Review the request, manager outcome, and current case status.'
      : 'Review the technician-submitted details and complete the manager action.';

    form.hidden = readOnly;
    historyNote.hidden = !readOnly;
    historyActions.hidden = !readOnly;

    seniorFields.hidden = readOnly || type !== 'Senior Support';
    partsFields.hidden = readOnly || type !== 'Parts Required';
    outsourcingFields.hidden = readOnly || type !== 'Outsourcing';

    const detailSections = [
      {
        title: 'Request Overview',
        rows: [
          ['Case ID', item.case_id],
          ['Room', item.room],
          ['Hotel Asset', item.hotel_asset],
          ['Component', item.component],
          ['Issue', item.issue]
        ]
      },
      {
        title: 'Priority & Timing',
        rows: [
          ['Severity', item.severity],
          ['Priority', item.priority],
          ['Requested At', displayDate(item.support_requested_at)],
          ['SLA Status', item.sla_status]
        ]
      },
      {
        title: 'Assignment & Progress',
        rows: [
          ['Support Reason', item.support_reason],
          ['Previous Technician', item.previous_technician_id || 'Unassigned'],
          ['Current Technician', item.assigned_technician_id || 'Unassigned'],
          ['Support Status', item.support_status],
          ['Work Stage', item.work_stage || item.task_status]
        ]
      },
      {
        title: 'Notes',
        rows: [
          ['Technician Note', item.technician_note || 'Not provided'],
          ['Manager Note', item.manager_note || 'Not provided']
        ]
      }
    ];

    caseGrid.innerHTML = detailSections.map(section => `
      <section class="support-detail-section">
        <h3>${esc(section.title)}</h3>
        <div class="support-detail-rows">
          ${section.rows.map(([name, value]) => `
            <div class="support-detail-row">
              <span>${esc(name)}</span>
              <strong>${esc(value)}</strong>
            </div>
          `).join('')}
        </div>
      </section>
    `).join('');

    if (!readOnly) {
      actionSelect.innerHTML = options(item, type)
        .map(([value, label]) => `<option value="${esc(value)}">${esc(label)}</option>`)
        .join('');

      if (type === 'Senior Support') {
        seniorSelect.innerHTML = '<option value="">Select a senior technician</option>' +
          (item.eligible_seniors || []).map(technician =>
            `<option value="${esc(technician.technician_id)}">${esc(technician.name)} (${esc(technician.technician_id)}) — ${esc(technician.role)}, ${esc(technician.level)} — ${Number(technician.active_tasks || 0)}/1 active</option>`
          ).join('');
        seniorSelect.required = true;
      } else {
        seniorSelect.required = false;
      }

      if (type === 'Parts Required') {
        document.getElementById('requestedPartValue').textContent = item.requested_part || 'Not provided';
        document.getElementById('requestedPartsStatus').textContent = item.parts_status || 'Requested';
      }

      if (type === 'Outsourcing') {
        document.getElementById('requestedExternalService').textContent = item.required_external_service || 'Not provided';
        document.getElementById('requestedOutsourcingReason').textContent = item.outsourcing_reason || 'Not provided';
      }
    }

    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('modal-open');
  }

  function closeModal() {
    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('modal-open');
    form.hidden = false;
    historyNote.hidden = true;
    historyActions.hidden = true;
    form.reset();
  }

  document.querySelectorAll('.support-open-btn').forEach(button => {
    button.addEventListener('click', () => {
      openModal(
        button.dataset.caseId,
        button.dataset.actionType,
        button.dataset.readonly === '1'
      );
    });
  });

  modal.querySelectorAll('.support-modal-close, .support-cancel-btn').forEach(button => {
    button.addEventListener('click', closeModal);
  });

  modal.addEventListener('click', event => {
    if (event.target === modal) closeModal();
  });
});
</script>
<?php admin_ui_footer(); ?>
