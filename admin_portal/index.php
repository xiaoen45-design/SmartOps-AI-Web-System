<?php
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/admin_auth.php';
require_admin();

$page = $_GET['page'] ?? 'overview';
if ($page === 'hitl') {
    redirect_to(app_url('admin_portal/hitl/dashboard.php'));
}
if ($page === 'workforce') {
    redirect_to(app_url('admin_portal/workforce/dashboard.php'));
}
redirect_to(app_url('admin_portal/overview/dashboard.php'));
