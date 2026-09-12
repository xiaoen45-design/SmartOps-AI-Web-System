<?php
require_once __DIR__ . '/auth.php';

$techId = require_technician();
$tech = current_technician();

$assigned = scalar("SELECT COUNT(*) FROM technician_tasks WHERE technician_id=? AND task_status IN ('Assigned','Waiting Technician Acceptance','Accepted')", [$techId]);
$progress = scalar("SELECT COUNT(*) FROM technician_tasks WHERE technician_id=? AND task_status IN ('In Progress','Repair In Progress','Started')", [$techId]);
$support = db_table_exists('task_assignment_history')
    ? scalar("SELECT COUNT(*) FROM task_assignment_history WHERE technician_id=? AND end_status IN ('Escalated to Senior','Released - Waiting for Parts','Released - Outsourcing Requested')", [$techId])
    : 0;
$completed = db_table_exists('task_assignment_history')
    ? scalar("SELECT COUNT(*) FROM task_assignment_history WHERE technician_id=? AND end_status='Repair Completed'", [$techId])
    : scalar("SELECT COUNT(*) FROM technician_tasks WHERE technician_id=? AND task_status='Completed'", [$techId]);
$overdue = scalar("SELECT COUNT(*) FROM technician_tasks WHERE technician_id=? AND task_status <> 'Completed' AND sla_status IN ('Response Breach','Repair Breach','Breach','SLA Violation')", [$techId]);
$activeTasks = technician_active_task_count($techId);
$storedStatus = trim((string)($tech['status'] ?? ''));
$displayStatus = str_contains(strtolower($storedStatus), 'leave') ? 'On Leave' : ($activeTasks > 0 ? 'Busy' : 'Available');
$statusClass = match (strtolower($displayStatus)) {
    'available' => 'is-available',
    'busy' => 'is-busy',
    default => 'is-away',
};

$name = trim((string)($tech['name'] ?? $techId));
$nameParts = preg_split('/\s+/', $name) ?: [];
$initials = '';
foreach (array_slice($nameParts, 0, 2) as $part) {
    if ($part !== '') $initials .= strtoupper(substr($part, 0, 1));
}
if ($initials === '') $initials = 'T';

$phone = trim((string)($tech['phone'] ?? ''));
$email = trim((string)($tech['email'] ?? ''));

tech_header('Profile', 'profile');
?>
<section class="card profile-card profile-mobile-card">
  <div class="profile-identity-block">
    <div class="profile-avatar" aria-hidden="true"><?= e($initials) ?></div>
    <div class="profile-identity-copy">
      <h2><?= e($name) ?></h2>
      <p><?= e($techId) ?></p>
    </div>
    <span class="profile-status-badge <?= e($statusClass) ?>"><?= e($displayStatus) ?></span>
  </div>

  <dl class="profile-detail-list">
    <div class="profile-detail-row">
      <dt>Role</dt>
      <dd><?= e(technician_workflow_role_label($tech)) ?></dd>
    </div>
    <div class="profile-detail-row">
      <dt>Department</dt>
      <dd><?= e(technician_department_label($tech)) ?></dd>
    </div>
    <div class="profile-detail-row">
      <dt>Level</dt>
      <dd><?= e(technician_level_label($tech)) ?></dd>
    </div>
    <div class="profile-detail-row">
      <dt>Phone</dt>
      <dd><?php if ($phone !== ''): ?><a href="tel:<?= e($phone) ?>"><?= e($phone) ?></a><?php else: ?>-<?php endif; ?></dd>
    </div>
    <div class="profile-detail-row">
      <dt>Email</dt>
      <dd><?php if ($email !== ''): ?><a href="mailto:<?= e($email) ?>"><?= e($email) ?></a><?php else: ?>-<?php endif; ?></dd>
    </div>
  </dl>

  <div class="profile-section-heading">
    <div>
      <h3>Performance Summary</h3>
      <p>Current workload and completed task records.</p>
    </div>
  </div>

  <div class="profile-metric-grid" aria-label="Technician performance summary">
    <div class="profile-metric"><span>Assigned</span><strong><?= e($assigned) ?></strong></div>
    <div class="profile-metric"><span>In Progress</span><strong><?= e($progress) ?></strong></div>
    <div class="profile-metric"><span>Support</span><strong><?= e($support) ?></strong></div>
    <div class="profile-metric"><span>Completed</span><strong><?= e($completed) ?></strong></div>
    <div class="profile-metric profile-metric-overdue"><span>Overdue</span><strong><?= e($overdue) ?></strong></div>
  </div>

  <a class="btn btn-outline profile-back-button" href="home.php?filter=assigned">Back to My Work</a>
</section>
<?php tech_footer(); ?>
