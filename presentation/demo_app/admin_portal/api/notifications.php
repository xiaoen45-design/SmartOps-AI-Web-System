<?php
require_once __DIR__ . '/../admin_auth.php';
if (empty($_SESSION['admin_email'])) {
    http_response_code(401);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success' => false, 'error' => 'unauthorized']);
    exit;
}
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

$rows = fetch_admin_notifications(8);
$notifications = [];
foreach ($rows as $row) {
    $id = (int)($row['id'] ?? 0);
    $notifications[] = [
        'id' => $id,
        'title' => (string)($row['title'] ?? 'Case completed'),
        'message' => (string)($row['message'] ?? ''),
        'case_id' => (string)($row['case_id'] ?? ''),
        'created_at' => (string)($row['created_at'] ?? ''),
        'unread' => empty($row['read_at']),
        'open_url' => app_url('admin_portal/notifications/open.php?id=' . $id),
    ];
}

echo json_encode([
    'success' => true,
    'unread_count' => admin_unread_notification_count(),
    'notifications' => $notifications,
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
