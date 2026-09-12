<?php
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/presentation_mode.php';

if (!presentation_mode_is_active()) {
    redirect_to(app_url('technician_website/login.php'));
}

$technicianId = presentation_mode_technician_id();
$caseId = presentation_mode_case_id();

// Fallback: when presentation mode started before the assignment was captured,
// recover the technician from the current case/task record.
if ($technicianId === '' && $caseId !== '') {
    $task = fetch_one(
        "SELECT COALESCE(NULLIF(technician_id,''), assigned_technician_id) AS technician_id
         FROM technician_tasks
         WHERE case_id=?
         ORDER BY id DESC
         LIMIT 1",
        [$caseId]
    );
    $technicianId = trim((string)($task['technician_id'] ?? ''));
}

if ($technicianId === '') {
    // No technician has been assigned yet. Return to HITL so the manager can assign first.
    redirect_to(app_url('admin_portal/hitl/dashboard.php?presentation_error=assign_first'));
}

$technician = find_technician($technicianId);
if (!$technician || empty($technician['is_active'])) {
    redirect_to(app_url('admin_portal/hitl/dashboard.php?presentation_error=technician_unavailable'));
}

// Presentation-only role switch. It does NOT remove the Admin session, so the
// demo can move back to Admin View without logging in again.
$_SESSION['technician_id'] = $technicianId;
redirect_to(app_url('technician_website/home.php?filter=assigned'));
