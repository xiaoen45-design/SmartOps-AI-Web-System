<?php
// SQL-backed endpoint: data is queried live from the shared smartstay_php database.
require_once __DIR__ . '/csv_common.php';
$headers = ['technician_id','name','status','department','role','technician_level','total_tasks','active_tasks','completed_tasks','overdue_tasks','workload_percent'];
try {
    if (!db_table_exists('technicians')) empty_csv('technicians.csv', $headers);
    $rows = fetch_all("SELECT technician_id,name,status,department,role,technician_level,total_tasks,active_tasks,completed_tasks,overdue_tasks,workload_percent FROM technicians WHERE is_active=1 ORDER BY technician_id");
    emit_csv('technicians.csv', $headers, $rows);
} catch (Throwable $e) { empty_csv('technicians.csv', $headers); }
