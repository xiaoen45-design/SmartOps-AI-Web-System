<?php
// SQL-backed endpoint: data is queried live from the shared smartstay_php database.
require_once __DIR__ . '/csv_common.php';
ensure_hitl_dataset_consistency();
$headers = ['case_id','room_id','timestamp','cleaned_comment','hotel_asset','failure_mode','component','observed_symptoms','possible_root_cause','safety_precautions','verification','corrective_action','preventive_maintenance','severity_level','priority_level','safety','sla','sla_target','actual_time','sla_status','escalation_required','human_approval_required','technician_assigned_timestamp','technician_assigned','technician_name','assigned_to','ticket_status','completed_date','support_status','support_reason','part_name','vendor_status','ai_confidence','risk_score'];
refresh_live_sla_statuses();
try {
    if (!db_table_exists('smart_maintenance_tickets')) empty_csv('smart_maintenance_tickets.csv', $headers);
    $rows = fetch_all("SELECT sm.case_id,sm.room_id,sm.created_at AS timestamp,sm.cleaned_comment,sm.hotel_asset,sm.failure_mode,sm.component,sm.observed_symptoms,sm.possible_root_cause,sm.safety_precautions,sm.verification,sm.corrective_action,sm.preventive_maintenance,sm.severity_level,sm.priority_level,sm.safety,sm.sla,sm.sla_target,sm.actual_time,sm.sla_status,sm.escalation_required,sm.human_approval_required,sm.technician_assigned_timestamp,sm.technician_assigned,t.name AS technician_name,sm.assigned_to,CASE WHEN LOWER(COALESCE(w.task_status,w.work_stage,'')) LIKE '%complete%' THEN 'Completed' ELSE sm.ticket_status END AS ticket_status,COALESCE(sm.completed_date,w.completed_at) AS completed_date,sm.support_status,sm.support_reason,sm.part_name,sm.vendor_status,sm.ai_confidence,sm.risk_score FROM smart_maintenance_tickets sm LEFT JOIN technicians t ON t.technician_id=sm.technician_assigned LEFT JOIN workforce_cases w ON w.case_id=sm.case_id ORDER BY sm.created_at DESC, sm.case_id ASC");
    foreach ($rows as &$row) {
        $rawAsset = $row['hotel_asset'] ?? '';
        $row['hotel_asset'] = asset_display_name($rawAsset);
        $row['component'] = component_display_name($row['component'] ?? '', $rawAsset);
        $row['priority_level'] = $row['priority_level'] ? priority_display_name($row['priority_level']) : '';
    }
    unset($row);
    emit_csv('smart_maintenance_tickets.csv', $headers, $rows);
} catch (Throwable $e) { empty_csv('smart_maintenance_tickets.csv', $headers); }
