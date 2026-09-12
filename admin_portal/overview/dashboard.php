<?php
require_once __DIR__ . '/../admin_auth.php';
require_once __DIR__ . '/../../includes/admin_layout.php';
require_admin();

admin_ui_header(
    'Executive Overview Dashboard',
    'overview',
    'Operational view of complaint intake, AI automation, HITL review, workforce execution, and SLA health.'
);
?>
<section class="kpi-container four-kpi overview-kpi-grid" aria-label="Executive summary KPIs">
  <div class="kpi-card summary-only"><h3>Total Tickets</h3><h2 id="totalComplaint7">0</h2><p>Total maintenance requests</p></div>
  <div class="kpi-card summary-only"><h3>Active Work Orders</h3><h2 id="actionWorkOrder">0</h2><p>Pending, assigned &amp; in progress</p></div>
  <div class="kpi-card summary-only"><h3>Completed Cases</h3><h2 id="completedCases7">0</h2><p>Closed maintenance work</p></div>
  <div class="kpi-card summary-only"><h3>AI Automation Rate</h3><h2 id="aiAutomationRate">0%</h2><p id="aiAutomationText">0 / 0 tickets</p></div>
</section>

<section class="action-card overview-alerts-card">
  <div class="table-header compact-header">
    <div><h2>Operational Alert</h2><p>Critical operational areas requiring management attention.</p></div>
  </div>
  <div class="alert-grid four-alerts">
    <button type="button" class="alert-box alert-red" data-alert="urgent-hitl" onclick="window.location.href='../hitl/pending_review.php'">
      <span class="alert-label">Pending HITL Reviews</span>
      <small>Escalated cases waiting for manager decision.</small>
      <strong id="alertUrgentHitl">0</strong>
      <span class="alert-link">View →</span>
    </button>
    <button type="button" class="alert-box alert-neutral" data-alert="sla-breach" onclick="window.location.href='<?= e(app_url('admin_portal/workforce/sla_department.php?department=All')) ?>'">
      <span class="alert-label">SLA Breaches</span>
      <small>Maintenance work orders exceeding SLA target.</small>
      <strong id="alertSla">0</strong>
      <span class="alert-link">View →</span>
    </button>
    <button type="button" class="alert-box alert-neutral" data-alert="support-required" onclick="window.location.href='../workforce/action_support.php?reason=All'">
      <span class="alert-label">Support Requests</span>
      <small>Tasks requiring parts, senior support, or outsourcing.</small>
      <strong id="alertSupport">0</strong>
      <span class="alert-link">View →</span>
    </button>
    <button type="button" class="alert-box alert-neutral" data-alert="out-of-knowledge-base" onclick="window.location.href='../hitl/trigger_detail.php?trigger=Out%20of%20Knowledge%20Base'">
      <span class="alert-label">Out of Knowledge Base</span>
      <small>Cases the AI cannot classify using the current knowledge base.</small>
      <strong id="alertOutKnowledge">0</strong>
      <span class="alert-link">View →</span>
    </button>
  </div>
</section>

<section class="chart-card overview-trend-card">
  <div class="chart-header">
    <div>
      <h2>Complaint vs Completed Trend</h2>
      <p>Blue counts every complaint received that day; green counts every case completed that day. Historical totals remain visible after status changes.</p>
    </div>
  </div>
  <div class="chart-box overview-trend-box"><canvas id="complaintCompletedTrendChart"></canvas></div>
</section>

<section class="overview-bottom-grid">
  <div class="chart-card compact-chart-card clickable-card" id="technicianCapacityCard" data-card-link="technician_capacity.php" role="button" tabindex="0" aria-label="View available technicians by department">
    <div class="chart-header">
      <div>
        <h2>Technician Capacity</h2>
        <p>Current technician availability and capacity used. Click this card to view available technicians by department.</p>
      </div>
    </div>
    <div class="capacity-snapshot">
      <div class="capacity-gauge-wrap"><canvas id="technicianCapacityChart"></canvas></div>
      <div id="technicianCapacityLegend" class="capacity-legend"></div>
    </div>
  </div>
  <div class="chart-card compact-chart-card">
    <div class="chart-header">
      <div>
        <h2>Unresolved Complaints by Category</h2>
        <p>Current unresolved complaints grouped by maintenance category. Click a bar to view the related cases.</p>
      </div>
    </div>
    <div class="chart-box overview-bottom-chart-box"><canvas id="overviewAssetDistributionChart"></canvas></div>
  </div>
</section>
<?php admin_ui_footer(['https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js']); ?>
