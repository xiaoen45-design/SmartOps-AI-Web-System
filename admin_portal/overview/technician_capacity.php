<?php
require_once __DIR__ . '/../admin_auth.php';
require_once __DIR__ . '/../../includes/admin_layout.php';
require_admin();

admin_ui_header(
    'Technician Capacity',
    'overview',
    'Review technician availability by department and open department technician details when needed.',
    true
);
?>
<section class="detail-page" data-overview-page="technician-capacity-detail">
  <section class="kpi-container four-kpi detail-kpi-grid capacity-detail-kpis">
    <div class="kpi-card summary-only"><h3>Total Technicians</h3><h2 id="totalTechniciansCount">0</h2><p>Active technician accounts</p></div>
    <div class="kpi-card summary-only capacity-kpi capacity-kpi-available"><h3>Available</h3><h2 id="availableTechniciansCount">0</h2><p>Ready for task assignment</p></div>
    <div class="kpi-card summary-only capacity-kpi capacity-kpi-busy"><h3>Busy</h3><h2 id="busyTechniciansCount">0</h2><p>Currently handling active work</p></div>
    <div class="kpi-card summary-only capacity-kpi capacity-kpi-leave"><h3>On Leave</h3><h2 id="leaveTechniciansCount">0</h2><p>Temporarily unavailable</p></div>
  </section>

  <section class="chart-card capacity-department-table-card">
    <div class="table-header">
      <div>
        <h2>Technician Availability by Department</h2>
        <p>Compare technician availability by department and open the full department team when needed.</p>
      </div>
    </div>

    <div class="table-box capacity-summary-table-box">
      <table class="dashboard-table capacity-summary-table">
        <thead>
          <tr>
            <th>Department</th>
            <th>Total Technicians</th>
            <th>Available</th>
            <th>Busy</th>
            <th>On Leave</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="departmentCapacityBody"></tbody>
      </table>
    </div>
  </section>

  <section class="chart-card capacity-drilldown-card" id="departmentTechnicianDrilldown" hidden>
    <div class="table-header capacity-drilldown-header">
      <div>
        <h2 id="departmentTechnicianTitle">Department Technicians</h2>
        <p id="departmentTechnicianCount">Showing 0 technician(s)</p>
      </div>
      <button id="closeDepartmentTechnicians" class="secondary-btn" type="button">Close</button>
    </div>

    <div class="table-box detail-table-box">
      <table class="dashboard-table department-technician-table">
        <thead>
          <tr>
            <th>Technician ID</th>
            <th>Name</th>
            <th>Department</th>
            <th>Role</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody id="departmentTechnicianBody"></tbody>
      </table>
    </div>
  </section>
</section>
<?php admin_ui_footer(); ?>
