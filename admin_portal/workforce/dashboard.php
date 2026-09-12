<?php
require_once __DIR__ . '/../../includes/admin_layout.php';
require_once __DIR__ . '/../admin_auth.php';
require_admin();

admin_ui_header(
    'Workforce & Task Monitoring',
    'workforce',
    'Technician availability, work order execution, support actions, and SLA performance monitoring.'
);

$dbMessage = database_ready_message();
if ($dbMessage !== '') { ?>
  <section class="card"><h2>Database is not ready</h2><p><?= e($dbMessage) ?></p></section>
<?php admin_ui_footer(); exit; }
refresh_live_sla_statuses();
refresh_all_technician_summaries();
$available = available_technician_count();
$activeOpen = scalar("SELECT COUNT(*) FROM workforce_cases WHERE work_stage <> 'Completed'");
$slaBreach = scalar("SELECT COUNT(*) FROM workforce_cases WHERE work_stage <> 'Completed' AND sla_status IN ('Response Breach','Repair Breach','Breach','SLA Violation')");
$supportRequired = scalar("SELECT COUNT(*) FROM workforce_cases WHERE " . workforce_manager_action_where());
$activeTechnicianTotal = scalar("SELECT COUNT(*) FROM technicians WHERE is_active=1");
$totalActiveCapacity = $activeTechnicianTotal * SMARTSTAY_MAX_ACTIVE_TASKS;

$statusBreakdown = [
    'Waiting Acceptance' => scalar("SELECT COUNT(*) FROM workforce_cases WHERE work_stage='Assigned - Not Started'"),
    'In Progress' => scalar("SELECT COUNT(*) FROM workforce_cases WHERE work_stage='Repair In Progress'"),
    'Outsourcing' => scalar("SELECT COUNT(*) FROM workforce_cases WHERE support_reason='Outsourcing' AND work_stage IN ('Pending Outsourcing','Outsourced','Pending Reassignment')"),
    'Senior Support' => scalar("SELECT COUNT(*) FROM workforce_cases WHERE support_reason='Senior Support' AND work_stage='Pending Senior Assignment'"),
    'Parts Required' => scalar("SELECT COUNT(*) FROM workforce_cases WHERE support_reason='Parts Required' AND work_stage IN ('Waiting for Parts','Pending Reassignment')"),
];

$departments = ['HVAC', 'Plumbing', 'Electrical', 'Fire Protection', 'Conveying'];
$capacityLabels = [];
$availableTech = [];
$assignedTask = [];
foreach ($departments as $department) {
    $capacityLabels[] = $department;

    // Show the currently available regular Technicians in each department.
    $availableTech[] = scalar(
        "SELECT COUNT(*)
         FROM technicians
         WHERE is_active=1
           AND status='Available'
           AND role='Technician'
           AND department=?",
        [$department]
    );
    $assignedTask[] = scalar(
        "SELECT COUNT(*)
         FROM workforce_cases w
         INNER JOIN technicians t ON t.technician_id = w.assigned_technician_id
         WHERE w.work_stage <> 'Completed'
           AND t.is_active=1
           AND t.role='Technician'
           AND t.department=?",
        [$department]
    );
}

// Technical Specialists remain a separate role group across all departments.
$capacityLabels[] = 'Technical Specialist';
$availableTech[] = scalar(
    "SELECT COUNT(*)
     FROM technicians
     WHERE is_active=1
       AND status='Available'
       AND role='Technical Specialist'"
);
$assignedTask[] = scalar(
    "SELECT COUNT(*)
     FROM workforce_cases w
     INNER JOIN technicians t ON t.technician_id = w.assigned_technician_id
     WHERE w.work_stage <> 'Completed'
       AND t.is_active=1
       AND t.role='Technical Specialist'"
);

$supportActionDefinitions = [
    'Outsourcing' => [
        'description' => 'External service and outsourcing approval requests.',
        'action' => 'Open Requests'
    ],
    'Senior Support' => [
        'description' => 'Cases released for a senior technician assignment.',
        'action' => 'Open Requests'
    ],
    'Parts Required' => [
        'description' => 'Parts requests, ordering, readiness, and reassignment.',
        'action' => 'Open Requests'
    ],
];

$supportActions = [];
$managerActionWhere = workforce_manager_action_where();
foreach ($supportActionDefinitions as $reason => $definition) {
    $total = scalar(
        "SELECT COUNT(*) FROM workforce_cases
         WHERE support_reason=?",
        [$reason]
    );
    $pending = scalar(
        "SELECT COUNT(*) FROM workforce_cases
         WHERE {$managerActionWhere}
           AND support_reason=?",
        [$reason]
    );
    $newCount = scalar(
        "SELECT COUNT(*) FROM workforce_cases
         WHERE {$managerActionWhere}
           AND support_reason=?
           AND support_requested_at IS NOT NULL
           AND support_requested_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)",
        [$reason]
    );
    // Keep the latest request visible even after its manager action is completed.
    // The pending counter can drop, but the total and latest case remain available.
    $latest = fetch_one(
        "SELECT case_id, support_requested_at
         FROM workforce_cases
         WHERE support_reason=?
         ORDER BY COALESCE(support_requested_at, case_created_at, assigned_at) DESC, case_id DESC
         LIMIT 1",
        [$reason]
    );

    $supportActions[$reason] = [
        'total' => (int)$total,
        'pending' => (int)$pending,
        'handled' => max(0, (int)$total - (int)$pending),
        'new_count' => (int)$newCount,
        'latest_case_id' => (string)($latest['case_id'] ?? ''),
        'latest_requested_at' => (string)($latest['support_requested_at'] ?? ''),
        'description' => $definition['description'],
        'action' => $definition['action'],
    ];
}

$slaDepartmentLabels = ['HVAC', 'Plumbing', 'Electrical', 'Fire Protection', 'Conveying', 'Out of Knowledge Base'];
$slaDepartmentCounts = array_fill_keys($slaDepartmentLabels, 0);
$slaRows = fetch_all(
    "SELECT w.*, h.hitl_reason AS joined_hitl_reason
     FROM workforce_cases w
     LEFT JOIN hitl_cases h ON h.case_id = w.case_id
     WHERE w.work_stage <> 'Completed'"
);
foreach ($slaRows as $row) {
    if (!is_sla_breach($row)) continue;
    $department = workforce_sla_department($row);
    if (isset($slaDepartmentCounts[$department])) $slaDepartmentCounts[$department]++;
}
$breachedDepartmentCount = count(array_filter($slaDepartmentCounts, fn(int $count): bool => $count > 0));

$workforceDashboardData = [
    'statusLabels' => array_keys($statusBreakdown),
    'statusValues' => array_values($statusBreakdown),
    'capacityLabels' => $capacityLabels,
    'availableTech' => $availableTech,
    'assignedTask' => $assignedTask,
    'slaDepartmentLabels' => array_keys($slaDepartmentCounts),
    'slaDepartmentValues' => array_values($slaDepartmentCounts),
    'statusDetailUrl' => app_url('admin_portal/workforce/status_detail.php'),
    'capacityDetailUrl' => app_url('admin_portal/workforce/capacity_detail.php'),
    'slaDepartmentDetailUrl' => app_url('admin_portal/workforce/sla_department.php'),
];
?>
<section class="kpis five workforce-redesign-kpis">
  <div class="kpi summary-only static-card"><h3>Available Technicians</h3><h2><?= e(number_format($available)) ?></h2><p>No active task</p></div>
  <div class="kpi summary-only static-card"><h3>Active Work Orders</h3><h2><?= e(number_format($activeOpen)) ?></h2><p>Currently assigned tasks</p></div>
  <div class="kpi summary-only static-card"><h3>Total Active Capacity</h3><h2><?= e(number_format($totalActiveCapacity)) ?></h2><p><?= e(number_format($activeTechnicianTotal)) ?> technicians × 1 task</p></div>
  <div class="kpi summary-only static-card"><h3>Support Required</h3><h2><?= e(number_format($supportRequired)) ?></h2><p>Cases needing manager action</p></div>
  <div class="kpi summary-only static-card"><h3>SLA Breaches</h3><h2><?= e(number_format($slaBreach)) ?></h2><p>Active cases exceeding target</p></div>
</section>

<section class="dashboard-two-col-grid workforce-two-col-grid">
  <div class="card chart-card">
    <div class="chart-title-row clean-title">
      <div><h2>Work Order Status Breakdown</h2><p>Click a status to view the related active work orders.</p></div>
    </div>
    <div class="chart-box"><canvas id="workOrderStatusChart"></canvas></div>
  </div>

  <div class="card chart-card">
    <div class="chart-title-row clean-title">
      <div><h2>Technician Availability vs Assigned Workload</h2><p>Click a department or the Technical Specialist group to inspect related workload cases.</p></div>
    </div>
    <div class="chart-box"><canvas id="capacityWorkloadChart"></canvas></div>
  </div>

  <div class="card action-section support-action-section-refined">
    <div class="chart-title-row clean-title">
      <div><h2>Action Support Required</h2><p>Review technician-submitted support requests and recent manager actions.</p></div>
    </div>
    <div class="support-action-grid support-action-grid-refined">
      <?php foreach ($supportActions as $reason => $item):
        $latestTimestamp = trim((string)$item['latest_requested_at']);
        $latestLabel = $latestTimestamp !== '' ? date('d M, H:i', strtotime($latestTimestamp)) : '';
      ?>
        <a class="support-action-card support-action-card-refined<?= $item['new_count'] > 0 ? ' has-new-support' : '' ?>" href="<?= e(app_url('admin_portal/workforce/action_support.php?reason=' . rawurlencode($reason))) ?>">
          <span class="support-action-card-top">
            <span class="support-action-label"><?= e($reason) ?></span>
            <?php if ($item['new_count'] > 0): ?>
              <span class="support-new-badge">New</span>
            <?php endif; ?>
          </span>

          <span class="support-total-row support-total-row-refined">
            <strong><?= e(number_format($item['total'])) ?></strong>
            <span>Total requests</span>
          </span>

          <p class="support-action-description"><?= e($item['description']) ?></p>

          <span class="support-pending-inline">Pending <?= e(number_format($item['pending'])) ?></span>

          <?php if ($item['new_count'] > 0): ?>
            <span class="support-activity-line support-new-cases-line is-new">
              <span class="support-activity-dot" aria-hidden="true"></span>
              <span>New cases · Latest: <?= e($item['latest_case_id']) ?><?= $latestLabel !== '' ? ' · ' . e($latestLabel) : '' ?></span>
            </span>
          <?php else: ?>
            <span class="support-activity-line support-new-cases-line is-clear">
              <span class="support-clear-check" aria-hidden="true">✓</span>
              <span>No new request</span>
            </span>
          <?php endif; ?>

          <span class="support-action-link">Open details →</span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="card chart-card sla-department-card">
    <div class="chart-title-row clean-title">
      <div><h2>SLA Breaches by Department</h2><p>Compare breached work orders across the five maintenance departments and Out of Knowledge Base cases.</p></div>
    </div>
    <div class="chart-box"><canvas id="slaDepartmentChart"></canvas></div>
  </div>
</section>
<script>window.workforceDashboardData = <?= json_encode($workforceDashboardData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;</script>
<?php admin_ui_footer(['https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js']); ?>
