<?php
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/presentation_mode.php';
ensure_hitl_dataset_consistency();
ensure_technician_task_trigger_column();

function technician_asset_url(string $type): string {
    $filename = $type === 'css' ? 'technician.css' : 'technician.js';
    return app_url('technician_website/assets/' . $type . '/' . $filename);
}

function technician_task_reason_text(array $task): string {
    foreach ([
        $task['history_note'] ?? '',
        $task['support_reason'] ?? '',
        $task['technician_sla_reason'] ?? '',
        $task['technician_note'] ?? '',
        $task['sla_reason'] ?? '',
        $task['sla_cause'] ?? '',
    ] as $candidate) {
        $reason = trim((string)$candidate);
        if ($reason === '') continue;
        $reason = str_replace(';', '.', $reason);
        return preg_replace('/\s+/', ' ', $reason);
    }
    return '';
}

function technician_should_show_reason(array $task, bool $force = false): bool {
    if ($force) return technician_task_reason_text($task) !== '';

    $status = strtolower((string)($task['task_status'] ?? ''));
    $stage = strtolower((string)($task['work_stage'] ?? ''));
    $reason = strtolower(technician_task_reason_text($task));

    return str_contains($status, 'support')
        || str_contains($stage, 'support')
        || str_contains($reason, 'support')
        || str_contains($reason, 'parts')
        || str_contains($reason, 'outsourcing')
        || str_contains($reason, 'sla')
        || str_contains($reason, 'breach');
}

function technician_status_label(?string $status): string {
    $value = trim((string)$status);
    if ($value === '') return '-';

    return match (strtolower($value)) {
        'repair in progress', 'started' => 'In Progress',
        'waiting technician acceptance' => 'Assigned',
        'pending senior assignment' => 'Pending Senior Assignment',
        'waiting for parts' => 'Waiting for Parts',
        'pending outsourcing' => 'Pending Outsourcing',
        default => $value,
    };
}

function technician_task_info_grid(array $task, bool $forceReason = false): string {
    $issue = technician_issue_title($task);
    $reason = technician_task_reason_text($task);
    $isRestricted = technician_is_restricted_guidance_task($task);
    $hitlReason = trim((string)($task['hitl_reason'] ?? $task['escalation_trigger'] ?? ''));
    $status = technician_status_label($task['task_status'] ?? '');
    $room = trim((string)($task['room'] ?? '')) ?: 'Not provided';

    $html = '<div class="task-overview">';

    // Keep the most important task facts together in one clean summary strip.
    $html .= '<div class="task-summary-strip">';
    if ($isRestricted) {
        $reviewReason = $hitlReason !== '' ? $hitlReason : 'Human Review Required';
        $html .= '<div class="task-summary-cell task-summary-wide"><span>HITL Reason</span><strong>'.e($reviewReason).'</strong></div>';
    } else {
        $severity = trim((string)($task['severity'] ?? '')) ?: '-';
        $priority = priority_display_name($task['priority'] ?? '');
        $html .= '<div class="task-summary-cell"><span>Severity</span><strong class="'.e(priority_class($severity)).'">'.e($severity).'</strong></div>'
            . '<div class="task-summary-cell"><span>Priority</span><strong class="'.e(priority_class($priority)).'">'.e($priority).'</strong></div>';
    }
    $html .= '<div class="task-summary-cell"><span>Status</span><strong class="'.e(stage_class($status)).'">'.e($status).'</strong></div>'
        . '</div>';

    // Flat detail rows are easier to scan on a phone than a grid of separate boxes.
    $html .= '<dl class="task-detail-list">'
        . '<div class="task-detail-row"><dt>Room</dt><dd>'.e($room).'</dd></div>'
        . '<div class="task-detail-row"><dt>Assigned</dt><dd>'.e(display_task_time($task, 'assigned_time')).'</dd></div>'
        . '<div class="task-detail-row task-detail-text"><dt>Issue</dt><dd>'.e($issue).'</dd></div>';

    if ($reason !== '' && technician_should_show_reason($task, $forceReason)) {
        $html .= '<div class="task-detail-row task-detail-text"><dt>Reason</dt><dd>'.e($reason).'</dd></div>';
    }
    $html .= '</dl>';

    $timelineItems = [
        ['Accepted', display_task_time($task, 'accepted_time')],
        ['Repair Start', display_task_time($task, 'started_time')],
    ];

    $historyStatus = strtolower(trim((string)($task['history_status'] ?? $task['task_status'] ?? '')));
    if ($historyStatus === 'repair completed' || $historyStatus === 'completed') {
        $timelineItems[] = ['Completed', display_task_time($task, 'completed_time')];
    } elseif (trim((string)($task['completed_time'] ?? '')) !== '') {
        $timelineItems[] = ['Released', display_task_time($task, 'completed_time')];
    }

    $html .= '<div class="task-timeline" aria-label="Task timeline">';
    foreach ($timelineItems as [$label, $value]) {
        $isDone = trim((string)$value) !== '' && trim((string)$value) !== '-';
        $html .= '<div class="task-timeline-step'.($isDone ? ' is-done' : '').'">'
            . '<span class="task-timeline-dot" aria-hidden="true"></span>'
            . '<span class="task-timeline-label">'.e($label).'</span>'
            . '<strong>'.e($value).'</strong>'
            . '</div>';
    }
    $html .= '</div></div>';

    return $html;
}

function technician_is_ookb_task(array $task): bool {
    // Only a real HITL record can be treated as Out of Knowledge Base.
    // Normal AI Automation tasks must never lose their guidance because of
    // an unrelated or stale escalation_trigger value.
    $storedReason = trim((string)($task['hitl_reason'] ?? ''));
    $hasHitlRecord = trim((string)($task['hitl_case_id'] ?? '')) !== '' || $storedReason !== '';
    if (!$hasHitlRecord) return false;

    if ($storedReason !== '') {
        return str_contains(strtolower($storedReason), 'out of knowledge');
    }

    $storedTrigger = trim((string)($task['escalation_trigger'] ?? ''));
    return strcasecmp($storedTrigger, 'Out of Knowledge Base') === 0;
}


function technician_is_restricted_guidance_task(array $task): bool {
    $storedReason = trim((string)($task['hitl_reason'] ?? ''));
    $storedTrigger = trim((string)($task['escalation_trigger'] ?? ''));
    $reason = strtolower($storedReason !== '' ? $storedReason : $storedTrigger);

    $hasHitlRecord = trim((string)($task['hitl_case_id'] ?? '')) !== '' || $storedReason !== '';
    if (!$hasHitlRecord) return false;

    return str_contains($reason, 'out of knowledge')
        || str_contains($reason, 'low confidence');
}

function technician_guidance_panel(array $task, bool $showPreventive): string {
    if (technician_is_restricted_guidance_task($task)) return '';
    $corrective = trim((string)($task['corrective_action'] ?? ''));
    $verification = trim((string)($task['verification'] ?? ''));
    $preventive = trim((string)($task['preventive_maintenance'] ?? ''));

    $items = [];
    if ($corrective !== '') $items[] = '<div class="task-guidance-item"><small>Corrective Action</small><strong>'.e($corrective).'</strong></div>';
    if ($verification !== '') $items[] = '<div class="task-guidance-item"><small>Verification</small><strong>'.e($verification).'</strong></div>';
    if ($showPreventive && $preventive !== '') $items[] = '<div class="task-guidance-item"><small>Preventive Maintenance</small><strong>'.e($preventive).'</strong></div>';
    return $items ? '<section class="task-guidance-panel"><div class="task-guidance-heading">Repair Guidance</div>'.implode('', $items).'</section>' : '';
}

function tech_header(string $title, string $active = ''): void {
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Cache-Control" content="no-store">
  <title><?= e($title) ?> - SmartOps Technician</title>
  <link rel="stylesheet" href="<?= e(technician_asset_url('css')) ?>?v=20260727-mobile-profile-v64">
  <?php if (presentation_mode_is_active()): ?><link rel="stylesheet" href="<?= e(app_url('presentation/assets/presentation_mode.css')) ?>?v=20260727-presentation-update-v2"><?php endif; ?>
</head>
<body class="tech-body<?= presentation_mode_is_active() ? ' presentation-demo-active' : '' ?>">
  <?php presentation_mode_bar('technician'); ?>
  <main class="phone-shell">
    <header class="tech-top dashboard-style-topbar">
      <a class="brand" href="<?= e(app_url('technician_website/home.php?filter=assigned')) ?>">
        <span class="brand-name"><span>Smart</span><strong>Ops</strong></span>
        <small>Technician Portal</small>
      </a>
      <div class="tech-top-actions">
        <a class="pill-link <?= $active === 'profile' ? 'active' : '' ?>" href="<?= e(app_url('technician_website/profile.php')) ?>">Profile</a>
        <a class="pill-link <?= $active === 'history' ? 'active' : '' ?>" href="<?= e(app_url('technician_website/history.php')) ?>">History</a>
        <div class="settings-menu">
          <button type="button" class="pill-link settings-toggle <?= $active === 'settings' ? 'active' : '' ?>" id="settingsToggle" aria-expanded="false" aria-controls="settingsMenuPanel">Settings</button>
          <div class="settings-menu-panel" id="settingsMenuPanel" hidden>
            <a href="<?= e(app_url('technician_website/settings.php')) ?>">Settings</a>
            <a class="danger" href="<?= e(app_url('technician_website/logout.php')) ?>">Logout</a>
          </div>
        </div>
      </div>
    </header>

    <section class="tech-page-heading">
      <div>
        <h1><?= e($title) ?></h1>
      </div>
      <?php if ($active === 'history'): ?>
        <a class="btn btn-outline tech-heading-action" href="<?= e(app_url('technician_website/home.php?filter=assigned')) ?>">Back to My Work</a>
      <?php endif; ?>
    </section>

    <?php if (in_array($active, ['assigned','progress','support','overdue'], true)): ?>
      <nav class="tech-tabs" aria-label="Work task filters">
        <a class="<?= $active==='assigned'?'active':'' ?>" href="<?= e(app_url('technician_website/home.php?filter=assigned')) ?>">Assigned</a>
        <a class="<?= $active==='progress'?'active':'' ?>" href="<?= e(app_url('technician_website/home.php?filter=progress')) ?>">In Progress</a>
        <a class="<?= $active==='support'?'active':'' ?>" href="<?= e(app_url('technician_website/home.php?filter=support')) ?>">Support</a>
        <a class="<?= $active==='overdue'?'active':'' ?>" href="<?= e(app_url('technician_website/home.php?filter=overdue')) ?>">Overdue</a>
      </nav>
    <?php endif; ?>
<?php }

function tech_footer(): void { ?>
  </main>
  <script src="<?= e(technician_asset_url('js')) ?>?v=20260727-mobile-profile-v64"></script>
</body>
</html>
<?php }
