<?php
require_once __DIR__ . '/includes/helpers.php';

$role = strtolower(trim((string)($_GET['role'] ?? 'admin')));
$view = strtolower(trim((string)($_GET['view'] ?? 'overview')));
$reset = !empty($_GET['reset']);

if ($reset) {
    global $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS;
    smartops_demo_reset_database($DB_HOST, $DB_NAME, $DB_USER, $DB_PASS);
    unset($_SESSION['technician_id'], $_SESSION['admin_notification_seen']);
}

$_SESSION['admin_email'] = 'demo.admin@smartops.local';
$_SESSION['admin_name'] = 'SmartOps Demo Admin';

if ($role === 'technician') {
    $assigned = fetch_one(
        "SELECT tt.technician_id
         FROM technician_tasks tt
         INNER JOIN cases c ON c.case_id=tt.case_id
         WHERE c.room_id='Room 305' AND COALESCE(tt.technician_id,'')<>''
         ORDER BY tt.id DESC LIMIT 1"
    );
    $technicianId = trim((string)($assigned['technician_id'] ?? ''));
    if ($technicianId === '') {
        $fallback = fetch_one("SELECT technician_id FROM technicians WHERE department='HVAC' AND is_active=1 ORDER BY id LIMIT 1");
        $technicianId = (string)($fallback['technician_id'] ?? 'TECH-001');
    }
    $_SESSION['technician_id'] = $technicianId;
    redirect_to(app_url('technician_website/home.php?filter=assigned'));
}

$targets = [
    'overview' => 'admin_portal/overview/dashboard.php',
    'hitl' => 'admin_portal/hitl/dashboard.php',
    'pending' => 'admin_portal/hitl/pending_review.php?demo_case=room305',
    'smart' => 'admin_portal/smart/dashboard.php',
    'workforce' => 'admin_portal/workforce/dashboard.php',
    'notifications' => 'admin_portal/overview/dashboard.php?demo_open_notifications=1',
];
redirect_to(app_url($targets[$view] ?? $targets['overview']));
