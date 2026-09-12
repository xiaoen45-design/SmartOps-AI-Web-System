<?php
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/presentation_mode.php';
require_once __DIR__ . '/../admin_auth.php';
require_admin();
ensure_hitl_dataset_consistency();
ensure_technician_task_trigger_column();
ensure_workflow_support_columns();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect_to(app_url('admin_portal/hitl/dashboard.php'));

$caseId = trim((string)($_POST['case_id'] ?? ''));
$technicianId = trim((string)($_POST['technician_id'] ?? ''));
$back = $_SERVER['HTTP_REFERER'] ?? app_url('admin_portal/hitl/dashboard.php');
if ($caseId === '' || $technicianId === '') redirect_to($back);

$hitl = fetch_one("SELECT hc.*, sm.created_at AS complaint_created_at, sm.ai_confidence, sm.severity_level AS model_severity, sm.priority_level AS model_priority, sm.corrective_action AS model_corrective_action, sm.preventive_maintenance AS model_preventive_maintenance, sm.verification AS model_verification FROM hitl_cases hc LEFT JOIN smart_maintenance_tickets sm ON sm.case_id=hc.case_id WHERE hc.case_id=? LIMIT 1", [$caseId]);
$technician = find_technician($technicianId);
if (!$hitl || !$technician || ($technician['role'] ?? '') !== 'Technical Specialist' || !technician_has_capacity($technicianId, $caseId)) {
    $separator = str_contains($back, '?') ? '&' : '?';
    redirect_to($back . $separator . 'capacity_error=1');
}

$room=(string)($hitl['room'] ?? '');
$issueSummary=(string)($hitl['issue_summary'] ?? $hitl['issue'] ?? '');
$issue=(string)($hitl['issue'] ?? $hitl['issue_summary'] ?? '');
$hotelAsset=(string)($hitl['hotel_asset'] ?? '');
$component=clean_component_name($hitl['component'] ?? '');
$severity=trim((string)(($hitl['severity'] ?? '') ?: ($hitl['model_severity'] ?? '')));
$priority=priority_display_name(($hitl['priority'] ?? '') ?: ($hitl['model_priority'] ?? '') ?: $severity);
if ($priority==='-') $priority='';
$trigger=hitl_primary_escalation_trigger($hitl);
$restricted=in_array($trigger,['Low Confidence','Out of Knowledge Base'],true);
if ($restricted) { $severity=''; $priority=''; }
if ($trigger==='Out of Knowledge Base') { $hotelAsset='Other'; $component=''; }
$createdAt=trim((string)($hitl['complaint_created_at'] ?? '')) ?: date('Y-m-d H:i:s');

$pdo = smartstay_pdo();
try {
    $pdo->beginTransaction();
    execute_sql("INSERT INTO workforce_cases (case_id,room,issue_summary,issue,hotel_asset,component,severity,priority,work_stage,task_status,response_target_minutes,repair_target_minutes,overall_sla_status,sla_status,hitl_status,safety_flag,case_created_at) VALUES (?,?,?,?,?,?,?,?,'Pending Assignment','Pending Assignment','30','90','Pending','Pending','Approved for Dispatch',?,?) ON DUPLICATE KEY UPDATE room=VALUES(room),issue_summary=VALUES(issue_summary),issue=VALUES(issue),hotel_asset=VALUES(hotel_asset),component=VALUES(component),severity=VALUES(severity),priority=VALUES(priority),hitl_status='Approved for Dispatch',safety_flag=VALUES(safety_flag),case_created_at=COALESCE(case_created_at,VALUES(case_created_at))", [$caseId,$room,$issueSummary,$issue,$hotelAsset,$component,$severity,$priority,(string)($hitl['safety_flag'] ?? ''),$createdAt]);
    execute_sql("INSERT INTO technician_tasks (case_id,room,issue_summary,issue,priority,severity,escalation_trigger,task_status,response_target_minutes,repair_target_minutes,overall_sla_status,sla_status,safety_flag,component,failure_mode,observed_symptoms,possible_root_cause,corrective_action,preventive_maintenance,verification,hotel_asset,case_created_at) VALUES (?,?,?,?,?,?,?,'Pending Assignment','30','90','Pending','Pending',?,?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE room=VALUES(room),issue_summary=VALUES(issue_summary),issue=VALUES(issue),priority=VALUES(priority),severity=VALUES(severity),escalation_trigger=VALUES(escalation_trigger),safety_flag=VALUES(safety_flag),component=VALUES(component),failure_mode=VALUES(failure_mode),observed_symptoms=VALUES(observed_symptoms),possible_root_cause=VALUES(possible_root_cause),corrective_action=VALUES(corrective_action),preventive_maintenance=VALUES(preventive_maintenance),verification=VALUES(verification),hotel_asset=VALUES(hotel_asset),case_created_at=COALESCE(case_created_at,VALUES(case_created_at))", [$caseId,$room,$issueSummary,$issue,$priority,$severity,$trigger,(string)($hitl['safety_flag'] ?? ''),$component,(string)($hitl['failure_mode'] ?? $component),(string)($hitl['observed_symptoms'] ?? $issueSummary),(string)($hitl['possible_root_cause'] ?? ''),$restricted?'':(string)($hitl['model_corrective_action'] ?? ''),$restricted?'':(string)($hitl['model_preventive_maintenance'] ?? ''),$restricted?'':(string)($hitl['model_verification'] ?? ''),$hotelAsset,$createdAt]);
    if (!assign_case_to_technician($caseId,$technicianId,'','HITL approved and assigned.')) {
        throw new RuntimeException('The selected technician is no longer available.');
    }
    execute_sql("UPDATE hitl_cases SET review_status='Approved for Dispatch', manager_comment=? WHERE id=?", ["Approved and assigned to {$technicianId}",$hitl['id']]);
    $pdo->commit();
    presentation_mode_set_assignment($caseId, $technicianId);
} catch (Throwable $error) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    $separator = str_contains($back, '?') ? '&' : '?';
    redirect_to($back . $separator . 'capacity_error=1');
}
redirect_to($back);
