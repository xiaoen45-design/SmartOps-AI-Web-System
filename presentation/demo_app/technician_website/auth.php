<?php
require_once __DIR__ . '/../includes/technician_layout.php';

function require_technician(): string {
    $technicianId = trim((string)($_SESSION['technician_id'] ?? ''));
    if (defined('SMARTOPS_DEMO_RUNTIME') && SMARTOPS_DEMO_RUNTIME) {
        $assigned = fetch_one(
            "SELECT tt.technician_id
             FROM technician_tasks tt
             INNER JOIN cases c ON c.case_id=tt.case_id
             WHERE c.room_id='Room 305' AND COALESCE(tt.technician_id,'')<>''
             ORDER BY tt.id DESC LIMIT 1"
        );
        if (!empty($assigned['technician_id'])) $technicianId = (string)$assigned['technician_id'];
        if ($technicianId === '') {
            $fallback = fetch_one("SELECT technician_id FROM technicians WHERE department='HVAC' AND is_active=1 ORDER BY id LIMIT 1");
            $technicianId = (string)($fallback['technician_id'] ?? 'TECH-001');
        }
        $_SESSION['technician_id'] = $technicianId;
    } elseif ($technicianId === '') {
        redirect_to('login.php');
    }

    $technician = find_technician($technicianId);
    if (!$technician) {
        unset($_SESSION['technician_id']);
        if (defined('SMARTOPS_DEMO_RUNTIME') && SMARTOPS_DEMO_RUNTIME) {
            throw new RuntimeException('The assigned demo technician is unavailable.');
        }
        redirect_to('login.php?access=removed');
    }
    smartops_sync_pending_ai_cases();
    return $technicianId;
}

function current_technician(): ?array {
    return !empty($_SESSION['technician_id']) ? find_technician((string)$_SESSION['technician_id']) : null;
}
