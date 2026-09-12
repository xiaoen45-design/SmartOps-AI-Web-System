<?php
require_once __DIR__ . '/../../includes/admin_layout.php';
require_once __DIR__ . '/../admin_auth.php';
require_admin();
refresh_live_sla_statuses();

$department = trim((string)($_GET['department'] ?? 'HVAC'));
$allowed = ['All', 'HVAC', 'Plumbing', 'Electrical', 'Fire Protection', 'Conveying', 'Out of Knowledge Base'];
if (!in_array($department, $allowed, true)) $department = 'HVAC';

admin_ui_header(
    ($department === 'All' ? 'All Departments' : $department) . ' SLA Breach Analysis',
    'workforce',
    'Review the breached work orders contributing to this department and identify where follow-up is required.',
    true
);

$rows = fetch_all(
    "SELECT w.*, h.hitl_reason AS joined_hitl_reason
     FROM workforce_cases w
     LEFT JOIN hitl_cases h ON h.case_id = w.case_id
     WHERE w.work_stage <> 'Completed'
     ORDER BY w.assigned_at DESC, w.case_id DESC"
);

$rows = array_values(array_filter($rows, static function(array $row) use ($department): bool {
    return is_sla_breach($row) && ($department === 'All' || workforce_sla_department($row) === $department);
}));

$highSeverity = 0;
$supportRequired = 0;
$assignedTechnicians = [];
$stageCounts = [
    'In Progress' => 0,
    'Outsourcing' => 0,
    'Senior Required' => 0,
    'Parts Required' => 0,
];
foreach ($rows as $row) {
    if (str_contains(strtolower((string)($row['severity'] ?? '')), 'high') ||
        str_contains(strtolower((string)($row['severity'] ?? '')), 'critical')) {
        $highSeverity++;
    }
    if (workforce_case_needs_manager_action($row)) $supportRequired++;
    $technician = trim((string)($row['assigned_technician_id'] ?? ''));
    if ($technician !== '') $assignedTechnicians[$technician] = true;

    $workStage = trim((string)($row['work_stage'] ?? ''));
    $supportReason = trim((string)($row['support_reason'] ?? ''));
    if ($supportReason === 'Outsourcing' && in_array($workStage, ['Pending Outsourcing','Outsourced','Pending Reassignment'], true)) {
        $stageCounts['Outsourcing']++;
    } elseif ($supportReason === 'Senior Support' && $workStage === 'Pending Senior Assignment') {
        $stageCounts['Senior Required']++;
    } elseif ($supportReason === 'Parts Required' && in_array($workStage, ['Waiting for Parts','Pending Reassignment'], true)) {
        $stageCounts['Parts Required']++;
    } else {
        $stageCounts['In Progress']++;
    }
}
$total = count($rows);
?>
<section class="kpis one-row four workforce-detail-kpis">
  <div class="kpi"><h3>Total SLA Breaches</h3><h2><?= e(number_format($total)) ?></h2></div>
  <div class="kpi"><h3>High Cases</h3><h2><?= e(number_format($highSeverity)) ?></h2></div>
  <div class="kpi"><h3>Support Required</h3><h2><?= e(number_format($supportRequired)) ?></h2></div>
  <div class="kpi"><h3>Technicians Affected</h3><h2><?= e(number_format(count($assignedTechnicians))) ?></h2></div>
</section>

<section class="card sla-stage-analysis-card">
  <div class="table-header">
    <div>
      <h2>Breach Stage Breakdown</h2>
      <p>Shows where breached work orders are currently held in the maintenance workflow.</p>
    </div>
  </div>
  <div class="sla-stage-grid">
    <?php if (!$stageCounts): ?>
      <div class="sla-stage-item"><span>No breached stages</span><strong>0</strong><small>0% of selected cases</small></div>
    <?php endif; ?>
    <?php foreach ($stageCounts as $stage => $count):
        $share = $total > 0 ? round(($count / $total) * 100, 1) : 0;
    ?>
      <div class="sla-stage-item">
        <span><?= e($stage) ?></span>
        <strong><?= e(number_format($count)) ?></strong>
        <small><?= e(number_format($share, 1)) ?>% of selected cases</small>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="card detail-table-card">
  <div class="table-header">
    <div>
      <h2><?= e($department === 'All' ? 'All Department' : $department) ?> Breached Work Orders</h2>
      <p>Prioritise high-severity and long-running work orders, then review technician assignment and support requirements.</p>
    </div>
  </div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Case ID</th>
          <th>Room</th>
          <th>Hotel Asset</th>
          <th>Component</th>
          <th>Severity</th>
          <th>Priority</th>
          <th>Work Stage</th>
          <th>SLA Status</th>
          <th>Assigned Technician</th>
          <th>Support</th>
        </tr>
      </thead>
      <tbody>
      <?php if (!$rows): ?>
        <tr><td colspan="10" class="empty-table-message">No SLA-breached work orders were found for this department.</td></tr>
      <?php endif; ?>
      <?php foreach ($rows as $row): ?>
        <tr>
          <td><strong><?= e($row['case_id'] ?? '') ?></strong></td>
          <td><?= e($row['room'] ?: '-') ?></td>
          <td><?= e(asset_display_name($row['hotel_asset'] ?? 'Unknown')) ?></td>
          <td><?= e(component_display_name($row['component'] ?? '-', $row['hotel_asset'] ?? '')) ?></td>
          <td><?= severity_badge_html($row['severity'] ?? '') ?></td>
          <td><?= e(priority_display_name($row['priority'] ?? '')) ?></td>
          <td><?= e($row['work_stage'] ?: '-') ?></td>
          <td><span class="sla-breach-badge"><?= e($row['sla_status'] ?: $row['overall_sla_status'] ?: 'Breached') ?></span></td>
          <td><?= e($row['assigned_technician_id'] ?: 'Unassigned') ?></td>
          <td><?= e($row['support_reason'] ?: 'Not Required') ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>
<?php admin_ui_footer(); ?>
