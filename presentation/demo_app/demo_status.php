<?php
require_once __DIR__ . '/includes/helpers.php';
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

$caseId = trim((string)(fetch_one(
    "SELECT meta_value FROM demo_meta WHERE meta_key='demo_case_id' LIMIT 1"
)['meta_value'] ?? ''));
if ($caseId === '') {
    $case = fetch_one("SELECT case_id FROM cases WHERE room_id='Room 305' ORDER BY id DESC LIMIT 1");
    $caseId = (string)($case['case_id'] ?? '');
}
$task = $caseId === '' ? null : fetch_one(
    "SELECT tt.technician_id, tt.task_status, tt.accepted_time, tt.started_time, tt.completed_time,
            COALESCE(t.name,'') AS technician_name
     FROM technician_tasks tt
     LEFT JOIN technicians t ON t.technician_id=tt.technician_id
     WHERE tt.case_id=? ORDER BY tt.id DESC LIMIT 1",
    [$caseId]
);
$review = $caseId === '' ? null : fetch_one("SELECT review_status FROM hitl_cases WHERE case_id=? LIMIT 1", [$caseId]);
$notificationCount = $caseId === '' ? 0 : scalar("SELECT COUNT(*) FROM admin_notifications WHERE case_id=? AND read_at IS NULL", [$caseId]);
$demoMetaRows = fetch_all("SELECT meta_key, meta_value FROM demo_meta WHERE meta_key IN ('dataset_mode','rebased_for_date','data_policy')");
$demoMeta = [];
foreach ($demoMetaRows as $metaRow) {
    $demoMeta[(string)($metaRow['meta_key'] ?? '')] = (string)($metaRow['meta_value'] ?? '');
}
$status = strtolower(trim((string)($task['task_status'] ?? '')));
$technicianId = trim((string)($task['technician_id'] ?? ''));
$assigned = $technicianId !== '' && !in_array($status, ['', 'pending assignment'], true);
$completed = $status === 'completed' || !empty($task['completed_time']);

echo json_encode([
    'success' => true,
    'case_id' => $caseId,
    'review_status' => (string)($review['review_status'] ?? ''),
    'technician_id' => $technicianId,
    'technician_name' => (string)($task['technician_name'] ?? ''),
    'task_status' => (string)($task['task_status'] ?? 'Pending HITL'),
    'assigned' => $assigned,
    'accepted' => !empty($task['accepted_time']) || in_array($status, ['accepted','in progress','completed'], true),
    'started' => !empty($task['started_time']) || in_array($status, ['in progress','completed'], true),
    'completed' => $completed,
    'notification_count' => $notificationCount,
    'dataset_mode' => (string)($demoMeta['dataset_mode'] ?? ''),
    'rebased_for_date' => (string)($demoMeta['rebased_for_date'] ?? ''),
    'data_policy' => (string)($demoMeta['data_policy'] ?? ''),
], JSON_UNESCAPED_SLASHES);
