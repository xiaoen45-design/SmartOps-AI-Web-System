<?php
require_once __DIR__ . '/../admin_auth.php';
require_once __DIR__ . '/../../includes/admin_layout.php';
require_admin();

admin_ui_header(
    'Smart Maintenance Intelligence',
    'smart',
    'AI complaint intake, ticket routing status, complaint trends, category distribution, and unresolved complaint aging.'
);
?>
<section class="kpi-container three-kpi smart-kpi-grid" aria-label="Smart Maintenance summary KPIs">
  <div class="kpi-card summary-only"><h3>Total Maintenance Complaints</h3><h2 id="smTotalComplaint">0</h2><p>Total complaints received in the last 7 days</p></div>
  <div class="kpi-card summary-only"><h3>Unresolved Complaints</h3><h2 id="smUnsolvedComplaint">0</h2><p>Unresolved complaints from the last 7 days</p></div>
  <div class="kpi-card summary-only"><h3>New Complaints</h3><h2 id="smNewComplaintToday">0</h2><p>Complaints received on the current day</p></div>
</section>

<section class="chart-card hitl-status-card routing-summary-card">
  <div class="chart-header"><div><h2>AI Ticket Routing Summary</h2><p>Tickets routed automatically by AI or escalated for human review.</p></div></div>
  <div class="hitl-status-grid routing-status-grid">
    <article class="hitl-status-panel hitl-required-panel routing-status-panel" aria-label="HITL required cases">
      <h3>HITL Required</h3>
      <strong><span id="hitlRequiredCount">0</span> <span class="case-unit">cases</span></strong>
      <p id="hitlRequiredPercent">0.0% of total tickets</p>
    </article>
    <article class="hitl-status-panel no-hitl-panel routing-status-panel" aria-label="No HITL required cases">
      <h3>No HITL Required</h3>
      <strong><span id="noHitlCount">0</span> <span class="case-unit">cases</span></strong>
      <p id="noHitlPercent">0.0% of total tickets</p>
    </article>
  </div>
</section>

<section class="chart-card smart-trend-middle-card">
  <div class="chart-header"><div><h2>Daily Complaint Resolution Trend</h2><p>Blue counts all complaints received that day; green counts all cases completed that day. Completing a case does not remove it from historical totals.</p></div></div>
  <div class="chart-box smart-middle-chart-box"><canvas id="smTrendChart"></canvas></div>
</section>

<section class="smart-bottom-grid">
  <div class="chart-card">
    <div class="chart-header"><div><h2>Unresolved Complaints by Category</h2><p>Current unresolved complaints grouped by maintenance category. Click a bar to view the related cases.</p></div></div>
    <div class="chart-box smart-lower-chart-box"><canvas id="smAssetChart"></canvas></div>
  </div>
  <div class="chart-card">
    <div class="chart-header"><div><h2>Unresolved Complaint Aging</h2><p>Current unresolved complaints grouped by how long they have remained unresolved. Click a bar for details.</p></div></div>
    <div class="chart-box smart-lower-chart-box"><canvas id="smAgingChart"></canvas></div>
  </div>
</section>


<div class="smart-trend-modal" id="smartTrendSummaryModal" aria-hidden="true">
  <div class="smart-trend-modal-card" role="dialog" aria-modal="true" aria-labelledby="smartTrendModalTitle">
    <button type="button" class="smart-trend-modal-close" data-smart-trend-close aria-label="Close">×</button>
    <span class="smart-trend-modal-eyebrow">Daily operational summary</span>
    <h2 id="smartTrendModalTitle">Complaint and Completion Details</h2>
    <p class="smart-trend-modal-date" id="smartTrendModalDate">Selected date</p>
    <div class="smart-trend-modal-grid">
      <div><span>Total Complaints</span><strong id="smartTrendModalTotal">0</strong></div>
      <div><span>Completed Cases</span><strong id="smartTrendModalCompleted">0</strong></div>
      <div><span>Currently Open from Intake</span><strong id="smartTrendModalUnsolved">0</strong></div>
      <div><span>Same-Day Completion Rate</span><strong id="smartTrendModalCompletionRate">0%</strong></div>
    </div>
    <p class="smart-trend-modal-note" id="smartTrendModalNote"></p>
    <div class="smart-trend-modal-actions">
      <button type="button" data-smart-trend-close>Close</button>
      <a id="smartTrendModalViewCases" href="trend_detail.php">View Cases</a>
    </div>
  </div>
</div>
<?php admin_ui_footer(['https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js']); ?>
