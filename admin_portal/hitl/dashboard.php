<?php
require_once __DIR__ . '/../../includes/admin_layout.php';
require_once __DIR__ . '/../admin_auth.php';
require_admin();

admin_ui_header(
    'Human-In-The-Loop Escalation Dashboard',
    'hitl',
    'Manager review workload, escalation breakdown, and pending cases requiring attention.'
);

$dbMessage = database_ready_message();
if ($dbMessage !== '') { ?>
  <section class="card"><h2>Database is not ready</h2><p><?= e($dbMessage) ?></p></section>
<?php admin_ui_footer(); exit; }

$hasHitlCreatedAt = db_column_exists('hitl_cases', 'created_at');
$hitlRows = fetch_all("SELECT h.*, s.ai_confidence, s.created_at AS ticket_created_at
                       FROM hitl_cases h
                       LEFT JOIN smart_maintenance_tickets s ON s.case_id = h.case_id
                       ORDER BY h.id");

$eventTimestamps = [];
foreach ($hitlRows as &$row) {
    $hitlTs = $hasHitlCreatedAt ? strtotime((string)($row['created_at'] ?? '')) : false;
    $ticketTs = strtotime((string)($row['ticket_created_at'] ?? ''));
    $row['_dashboard_ts'] = $hitlTs ?: $ticketTs ?: time();
    $eventTimestamps[] = (int)$row['_dashboard_ts'];
}
unset($row);
$referenceTs = $eventTimestamps ? max($eventTimestamps) : time();
$referenceDay = strtotime(date('Y-m-d 00:00:00', $referenceTs));

$isPending = static function(array $row): bool {
    $value = strtolower(trim((string)($row['review_status'] ?? '')));
    return $value === '' || str_contains($value, 'pending') || str_contains($value, 'review');
};

$pendingRows = array_values(array_filter($hitlRows, $isPending));
$totalPending = count($pendingRows);
$criticalCount = count(array_filter(
    $pendingRows,
    static fn(array $row): bool => hitl_primary_escalation_trigger($row) === 'Critical'
));
$highSeverityCount = count(array_filter(
    $pendingRows,
    static fn(array $row): bool => hitl_primary_escalation_trigger($row) === 'High'
));
$lowConfidenceCount = count(array_filter(
    $pendingRows,
    static fn(array $row): bool => hitl_primary_escalation_trigger($row) === 'Low Confidence'
));

$rawOutOfKbRows = array_values(array_filter($pendingRows, 'hitl_is_out_of_knowledge_case'));
$outOfKbCount = count($rawOutOfKbRows);

$triggerBreakdown = [
    'Immediate' => $criticalCount,
    'Urgent' => $highSeverityCount,
    'Low Confidence' => $lowConfidenceCount,
    'Out of Knowledge Base' => $outOfKbCount,
];

// Always show the five core maintenance categories in a stable D10-D50 order.
// Counts include every pending HITL case that belongs to a recognised maintenance category.
$maintenanceCategories = ['Conveying', 'Plumbing', 'HVAC', 'Fire Protection', 'Electrical'];
$assetBreakdown = array_fill_keys($maintenanceCategories, 0);
foreach ($pendingRows as $row) {
    $asset = asset_display_name($row['hotel_asset'] ?? 'Unknown');
    if (array_key_exists($asset, $assetBreakdown)) {
        $assetBreakdown[$asset]++;
    }
}

$trendLabels = [];
$trendCritical = [];
$trendHigh = [];
$trendLowConfidence = [];
$trendOokb = [];
for ($i = 6; $i >= 0; $i--) {
    $dayTs = strtotime("-{$i} days", $referenceDay);
    $dayKey = date('Y-m-d', $dayTs);
    $trendLabels[] = date('d M', $dayTs);

    $dailyCounts = [
        'Critical' => 0,
        'High' => 0,
        'Low Confidence' => 0,
        'Out of Knowledge Base' => 0,
    ];

    // The daily trend is historical volume, so approved or completed cases
    // remain counted on the date they entered HITL. Current queue charts below
    // still use $pendingRows.
    foreach ($hitlRows as $row) {
        if (date('Y-m-d', (int)$row['_dashboard_ts']) !== $dayKey) continue;
        $trigger = hitl_primary_escalation_trigger($row);
        if (array_key_exists($trigger, $dailyCounts)) {
            $dailyCounts[$trigger]++;
        }
    }

    $trendCritical[] = $dailyCounts['Critical'];
    $trendHigh[] = $dailyCounts['High'];
    $trendLowConfidence[] = $dailyCounts['Low Confidence'];
    $trendOokb[] = $dailyCounts['Out of Knowledge Base'];
}

$hitlDashboardData = [
    'triggerLabels' => array_keys($triggerBreakdown),
    'triggerValues' => array_values($triggerBreakdown),
    'triggerRoutes' => ['Critical', 'High', 'Low Confidence', 'Out of Knowledge Base'],
    'assetLabels' => array_keys($assetBreakdown),
    'assetValues' => array_values($assetBreakdown),
    'trendLabels' => $trendLabels,
    'trendCritical' => $trendCritical,
    'trendHigh' => $trendHigh,
    'trendLowConfidence' => $trendLowConfidence,
    'trendOokb' => $trendOokb,
];

$bannerStateClass = '';
$bannerHref = 'admin_portal/hitl/trigger_detail.php?trigger=Critical';
if ($criticalCount > 0) {
    $bannerStateClass = ' has-immediate';
} elseif ($totalPending > 0) {
    $bannerStateClass = ' has-pending-review';
    $bannerHref = 'admin_portal/hitl/pending_review.php';
}
?>
<a class="hitl-action-banner hitl-immediate-banner is-pulsing<?= e($bannerStateClass) ?>" href="<?= e(app_url($bannerHref)) ?>">
  <div>
    <h2>Immediate Safety Action Required</h2>
    <p>Safety-critical cases requiring immediate manager review and action.</p>
  </div>
  <div class="hitl-action-count" aria-label="<?= e(number_format($criticalCount)) ?> immediate safety-critical cases">
    <strong><?= e(number_format($criticalCount)) ?></strong>
  </div>
</a>

<section class="kpis five hitl-redesign-kpis" aria-label="HITL summary KPIs">
  <div class="kpi summary-only static-card"><h3>Total Pending Review Cases</h3><h2><?= e(number_format($totalPending)) ?></h2><p>Cases awaiting manager review.</p></div>
  <div class="kpi summary-only static-card"><h3>Immediate Priority Cases</h3><h2><?= e(number_format($criticalCount)) ?></h2><p>Critical cases needing immediate review.</p></div>
  <div class="kpi summary-only static-card"><h3>Urgent Priority Cases</h3><h2><?= e(number_format($highSeverityCount)) ?></h2><p>High-severity cases needing urgent review.</p></div>
  <div class="kpi summary-only static-card"><h3>Low Confidence Cases</h3><h2><?= e(number_format($lowConfidenceCount)) ?></h2><p>AI decisions needing human verification.</p></div>
  <div class="kpi summary-only static-card"><h3>Out of Knowledge Base Cases</h3><h2><?= e(number_format($outOfKbCount)) ?></h2><p>Cases outside the current knowledge base.</p></div>
</section>

<section class="card chart-card hitl-trend-full">
  <div class="chart-title-row clean-title"><div><h2>Daily HITL Escalation Volume</h2><p>All HITL escalations are counted on the day they entered review, even after approval or dispatch. Hover or click a point to view the trigger breakdown.</p></div></div>
  <div class="chart-box hitl-trend-box"><canvas id="hitlTrendChart"></canvas></div>
</section>

<section class="dashboard-two-col-grid hitl-third-layer">
  <div class="card chart-card">
    <div class="chart-title-row clean-title"><h2>HITL Review Queue Breakdown</h2></div>
    <div class="chart-box hitl-bottom-chart-box"><canvas id="hitlTriggerChart"></canvas></div>
  </div>
  <div class="card chart-card">
    <div class="chart-title-row clean-title"><div><h2>Pending HITL Cases by Category</h2><p>Pending human-review cases across all five maintenance categories.</p></div></div>
    <div class="chart-box hitl-bottom-chart-box"><canvas id="hitlAssetChart"></canvas></div>
  </div>
</section>

<div class="review-modal hitl-trend-summary-modal" id="hitlTrendSummaryModal" aria-hidden="true">
  <div class="review-modal-card hitl-trend-summary-card" role="dialog" aria-modal="true" aria-labelledby="hitlTrendSummaryTitle">
    <button class="review-modal-close hitl-trend-summary-close" type="button" aria-label="Close">×</button>
    <h2 id="hitlTrendSummaryTitle">Daily HITL Escalation Summary</h2>
    <p class="hitl-trend-summary-subtitle" id="hitlTrendSummarySubtitle">Selected date escalation overview</p>
    <div class="review-detail-grid hitl-trend-detail-grid" id="hitlTrendSummaryGrid"></div>
    <div class="hitl-trend-summary-note" id="hitlTrendSummaryNote"></div>
    <div class="review-modal-actions">
      <button type="button" class="review-secondary hitl-trend-summary-close-button">Close</button>
    </div>
  </div>
</div>

<script>window.hitlDashboardData = <?= json_encode($hitlDashboardData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>; window.hitlTriggerUrl = <?= json_encode(app_url('admin_portal/hitl/trigger_detail.php')) ?>; window.hitlAssetUrl = <?= json_encode(app_url('admin_portal/hitl/asset_components.php')) ?>;</script>
<?php admin_ui_footer(['https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js']); ?>
