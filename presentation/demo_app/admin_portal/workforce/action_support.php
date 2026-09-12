<?php
require_once __DIR__ . '/../../includes/admin_layout.php';
require_once __DIR__ . '/../admin_auth.php';
require_admin();
ensure_workflow_support_columns();
refresh_live_sla_statuses();

$sourceDashboard = strtolower(trim((string)($_GET['source'] ?? $_POST['source'] ?? 'workforce')));
$backDashboard = $sourceDashboard === 'overview'
    ? 'admin_portal/overview/dashboard.php'
    : 'admin_portal/workforce/dashboard.php';
$reason=trim($_GET['reason'] ?? $_POST['reason'] ?? 'All');
$allowed=['All','Outsourcing','Senior Support','Parts Required'];
if (!in_array($reason,$allowed,true)) $reason='All';
$successMessage=''; $errorMessage='';

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $caseId=trim($_POST['case_id'] ?? '');
    $actionType=trim($_POST['action_type'] ?? '');
    $managerAction=trim($_POST['manager_action'] ?? '');
    $case=$caseId!=='' ? fetch_one('SELECT * FROM workforce_cases WHERE case_id=?',[$caseId]) : null;
    if (!$case) $errorMessage='The selected support request could not be found.';
    elseif ($actionType==='Senior Support' && $managerAction==='assign_senior') {
        $seniorId=trim($_POST['senior_technician_id'] ?? '');
        $previous=find_technician((string)($case['previous_technician_id'] ?? ''));
        $senior=find_technician($seniorId);
        $sourceRole=(string)($previous['role'] ?? 'Technician');
        $department=normalize_technician_department((string)($previous['department'] ?? $case['hotel_asset'] ?? ''));
        $valid=$senior && technician_level_label($senior)==='Senior' && technician_has_capacity($seniorId,$caseId);
        if ($valid && $sourceRole==='Technical Specialist') $valid=($senior['role'] ?? '')==='Technical Specialist';
        if ($valid && $sourceRole==='Technician') $valid=($senior['role'] ?? '')==='Technician' && normalize_technician_department((string)($senior['department'] ?? ''))===$department;
        if (!$valid) $errorMessage='Please select an available senior technician from the correct workflow group.';
        elseif (assign_case_to_technician($caseId,$seniorId,'Senior Assigned','Senior escalation assigned to '.$seniorId.'.')) {
            execute_sql("UPDATE workforce_cases SET transfer_reason='Senior Support', support_status='Senior Assigned' WHERE case_id=?",[$caseId]);
            execute_sql("UPDATE technician_tasks SET support_status='Senior Assigned' WHERE case_id=?",[$caseId]);
            $successMessage='The case was transferred to '.$seniorId.'.';
        }
    } elseif ($actionType==='Parts Required') {
        $part=trim((string)($case['requested_part'] ?? ''));
        if ($part==='') $errorMessage='The technician has not selected the required part yet.';
        elseif ($managerAction==='parts_ordered') {
            execute_sql("UPDATE workforce_cases SET parts_status='Ordered',parts_ordered_at=NOW(),support_status='Parts Ordered',manager_note=? WHERE case_id=?",['Parts ordered: '.$part,$caseId]);
            execute_sql("UPDATE technician_tasks SET support_status='Parts Ordered' WHERE case_id=?",[$caseId]);
            $successMessage='Parts marked as ordered for '.$caseId.'.';
        } elseif (in_array($managerAction,['use_stock','mark_parts_ready','reassign_parts'],true)) {
            execute_sql("UPDATE workforce_cases SET parts_status='Ready',parts_ready_at=COALESCE(parts_ready_at,NOW()),support_status='Parts Ready - Pending Reassignment',work_stage='Pending Reassignment',task_status='Pending Reassignment',manager_note=? WHERE case_id=?",[($managerAction==='use_stock'?'Use stock':'Parts ready').': '.$part,$caseId]);
            execute_sql("UPDATE technician_tasks SET support_status='Parts Ready - Pending Reassignment',task_status='Pending Reassignment' WHERE case_id=?",[$caseId]);
            $assigned=auto_reassign_case($caseId,'Parts Ready - Assigned');
            $successMessage=$assigned ? 'Parts are ready and the case was assigned to '.$assigned.'.' : 'Parts are ready. No technician is currently available; the case remains pending reassignment.';
        } else $errorMessage='Select a valid parts action.';
    } elseif ($actionType==='Outsourcing') {
        if ($managerAction==='approve_outsourcing') {
            execute_sql("UPDATE workforce_cases SET work_stage='Outsourced',task_status='Outsourced',support_status='Outsourced',outsourcing_status='Approved',outsourced_at=NOW(),manager_note='Outsourcing approved' WHERE case_id=?",[$caseId]);
            execute_sql("UPDATE technician_tasks SET task_status='Outsourced',support_status='Outsourced' WHERE case_id=?",[$caseId]);
            execute_sql("UPDATE smart_maintenance_tickets SET ticket_status='Outsourced',support_status='Outsourced' WHERE case_id=?",[$caseId]);
            $successMessage='Outsourcing approved for '.$caseId.'.';
        } elseif ($managerAction==='reject_outsourcing') {
            execute_sql("UPDATE workforce_cases SET work_stage='Pending Reassignment',task_status='Pending Reassignment',support_status='Outsourcing Rejected - Pending Reassignment',outsourcing_status='Rejected',manager_note='Outsourcing rejected; internal reassignment required' WHERE case_id=?",[$caseId]);
            execute_sql("UPDATE technician_tasks SET task_status='Pending Reassignment',support_status='Outsourcing Rejected - Pending Reassignment' WHERE case_id=?",[$caseId]);
            $assigned=auto_reassign_case($caseId,'Outsourcing Rejected - Reassigned');
            $successMessage=$assigned ? 'Outsourcing rejected and the case was reassigned to '.$assigned.'.' : 'Outsourcing rejected. No technician is currently available.';
        } elseif ($managerAction==='reassign_outsourcing') {
            $assigned=auto_reassign_case($caseId,'Outsourcing Rejected - Reassigned');
            $successMessage=$assigned ? 'The case was reassigned to '.$assigned.'.' : 'No same-workflow technician is currently available; the case remains pending reassignment.';
        } elseif ($managerAction==='complete_outsourcing') {
            execute_sql("UPDATE workforce_cases SET work_stage='Completed',task_status='Completed',support_status='Outsourced Work Completed',outsourcing_status='Completed',completed_at=NOW(),assigned_technician_id=NULL,technician_id=NULL,manager_note='Outsourced work completed' WHERE case_id=?",[$caseId]);
            execute_sql("UPDATE technician_tasks SET task_status='Completed',support_status='Outsourced Work Completed',completed_time=NOW(),technician_id=NULL,assigned_technician_id=NULL WHERE case_id=?",[$caseId]);
            execute_sql("UPDATE smart_maintenance_tickets SET ticket_status='Completed',support_status='Outsourced Work Completed',completed_date=NOW() WHERE case_id=?",[$caseId]);
            $successMessage='Outsourced work marked completed for '.$caseId.'.';
        } else $errorMessage='Select a valid outsourcing action.';
    }
    refresh_live_sla_statuses();
    refresh_all_technician_summaries();
}

admin_ui_header($reason==='All'?'Action Support Required':$reason.' Support Review','workforce','Review technician-submitted support requests and complete the required manager action.',true,$backDashboard);
$managerActionWhere = workforce_manager_action_where();
$where = $reason === 'All'
    ? $managerActionWhere
    : $managerActionWhere . ' AND support_reason=?';
$params = $reason === 'All' ? [] : [$reason];
$cases=fetch_all("SELECT * FROM workforce_cases WHERE {$where} ORDER BY support_requested_at DESC,case_id DESC",$params);
$pending=count($cases);
$casePayload=[];
foreach($cases as $case){
    $previous=find_technician((string)($case['previous_technician_id'] ?? ''));
    $sourceRole=(string)($previous['role'] ?? 'Technician');
    $sourceDepartment=normalize_technician_department((string)($previous['department'] ?? $case['hotel_asset'] ?? ''));
    $eligible=fetch_assignable_senior_technicians($sourceRole,$sourceDepartment);
    $casePayload[$case['case_id']]=[
        'case_id'=>$case['case_id'],'room'=>$case['room'],'hotel_asset'=>support_asset_group((string)$case['hotel_asset']),'component'=>$case['component'],
        'issue'=>$case['issue'] ?: $case['issue_summary'],'severity'=>$case['severity'],'priority'=>priority_display_name($case['priority'] ?? ''),
        'previous_technician_id'=>$case['previous_technician_id'],'support_reason'=>$case['support_reason'],'support_status'=>$case['support_status'] ?: 'Pending Manager Action',
        'technician_note'=>$case['technician_note'],'safety_flag'=>$case['safety_flag'],'sla_status'=>$case['sla_status'] ?: $case['overall_sla_status'],
        'required_external_service'=>$case['required_external_service'] ?? '','outsourcing_reason'=>$case['outsourcing_reason'] ?? '','requested_part'=>$case['requested_part'] ?? '',
        'support_other_detail'=>$case['support_other_detail'] ?? '','parts_status'=>$case['parts_status'] ?? '','outsourcing_status'=>$case['outsourcing_status'] ?? '',
        'eligible_seniors'=>array_map(static fn(array $t):array=>['technician_id'=>$t['technician_id'],'name'=>$t['name'] ?: $t['technician_id'],'department'=>technician_department_label($t),'role'=>technician_workflow_role_label($t),'level'=>technician_level_label($t),'active_tasks'=>(int)($t['active_tasks'] ?? 0)],$eligible),
    ];
}
?>
<section class="kpis one-row three workforce-detail-kpis">
  <div class="kpi"><h3>Total Requests</h3><h2><?= e(number_format(count($cases))) ?></h2></div>
  <div class="kpi"><h3>Pending Manager Action</h3><h2><?= e(number_format($pending)) ?></h2></div>
  <div class="kpi"><h3>Review Scope</h3><h2 class="text-value"><?= e($reason==='All'?'All Support Cases':$reason) ?></h2></div>
</section>
<?php if($successMessage!==''):?><div class="support-success-message" role="status"><?=e($successMessage)?></div><?php endif;?>
<?php if($errorMessage!==''):?><div class="support-error-message" role="alert"><?=e($errorMessage)?></div><?php endif;?>
<section class="card detail-table-card"><div class="table-header"><div><h2><?=e($reason==='All'?'All Support Requests':$reason.' Requests')?></h2><p>Use the existing support workflow to assign, prepare, outsource, or reassign each case.</p></div></div>
<div class="table-wrap"><table><thead><tr><th>Case ID</th><th>Room</th><th>Hotel Asset</th><th>Component</th><th>Previous Technician</th><th>Support Reason</th><th>Support Status</th><th>Action</th></tr></thead><tbody>
<?php if(!$cases):?><tr><td colspan="8" class="empty-table-message">No support requests were found.</td></tr><?php endif;?>
<?php foreach($cases as $case):?><tr><td><strong><?=e($case['case_id'])?></strong></td><td><?=e($case['room'])?></td><td><?=e(support_asset_group((string)$case['hotel_asset']))?></td><td><?=e($case['component'])?></td><td><?=e($case['previous_technician_id'] ?: 'Unassigned')?></td><td><?=e($case['support_reason'])?></td><td><?=e($case['support_status'] ?: 'Pending Manager Action')?></td><td><button type="button" class="primary-btn support-open-btn" data-case-id="<?=e($case['case_id'])?>" data-action-type="<?=e($case['support_reason'])?>">Manage</button></td></tr><?php endforeach;?>
</tbody></table></div></section>
<div class="support-modal" id="supportActionModal" aria-hidden="true"><div class="support-modal-card support-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="supportModalTitle" aria-describedby="supportModalDescription"><button type="button" class="support-modal-close" aria-label="Close">×</button><div class="support-modal-heading"><p class="support-modal-kicker" id="supportModalKicker">Support</p><h2 id="supportModalTitle">Manage Request</h2><p id="supportModalDescription">Review the technician-submitted details and complete the manager action.</p></div><div class="support-case-grid" id="supportCaseGrid"></div>
<form method="post" class="support-action-form" id="supportActionForm"><input type="hidden" name="source" value="<?=e($sourceDashboard)?>"><input type="hidden" name="reason" value="<?=e($reason)?>"><input type="hidden" name="case_id" id="supportCaseId"><input type="hidden" name="action_type" id="supportActionType">
<div class="support-form-section"><label>Manager Action<select name="manager_action" id="managerActionSelect" required></select></label></div>
<div class="support-request-review" id="outsourcingFields" hidden><div class="support-review-item"><span>Required External Service</span><strong id="requestedExternalService">-</strong></div><div class="support-review-item"><span>Reason for Outsourcing</span><strong id="requestedOutsourcingReason">-</strong></div></div>
<div class="support-form-section" id="seniorFields" hidden><label>Senior Technician<select name="senior_technician_id" id="seniorTechnicianSelect"><option value="">Select a senior technician</option></select></label></div>
<div class="support-request-review" id="partsFields" hidden><div class="support-review-item"><span>Requested Part</span><strong id="requestedPartValue">-</strong></div><div class="support-review-item"><span>Parts Status</span><strong id="requestedPartsStatus">-</strong></div></div>
<div class="support-modal-actions"><button type="button" class="secondary-action-btn support-cancel-btn">Cancel</button><button type="submit" class="primary-btn" id="supportSubmitButton">Confirm</button></div></form></div></div>
<script>
window.supportActionData=<?=json_encode(['cases'=>$casePayload],JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)?>;
document.addEventListener('DOMContentLoaded',()=>{
 const data=window.supportActionData||{},modal=document.getElementById('supportActionModal'),form=document.getElementById('supportActionForm'),caseGrid=document.getElementById('supportCaseGrid'),caseIdInput=document.getElementById('supportCaseId'),typeInput=document.getElementById('supportActionType'),actionSelect=document.getElementById('managerActionSelect'),seniorFields=document.getElementById('seniorFields'),seniorSelect=document.getElementById('seniorTechnicianSelect'),partsFields=document.getElementById('partsFields'),outsourcingFields=document.getElementById('outsourcingFields');
 const esc=v=>String(v??'-').replace(/[&<>'\"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;',"'":'&#039;','"':'&quot;'}[c]));
 function options(item,type){ if(type==='Senior Support') return [['assign_senior','Assign Senior']]; if(type==='Parts Required'){ const s=String(item.parts_status||'').toLowerCase(); if(s==='ordered') return [['mark_parts_ready','Mark Parts Ready']]; if(s==='ready') return [['reassign_parts','Reassign Technician']]; return [['use_stock','Use Stock'],['parts_ordered','Parts Ordered']]; } const os=String(item.outsourcing_status||'').toLowerCase(); if(os==='approved') return [['complete_outsourcing','Mark Outsourced Work Completed']]; if(os==='rejected') return [['reassign_outsourcing','Retry Internal Reassignment']]; return [['approve_outsourcing','Approve Outsourcing'],['reject_outsourcing','Reject & Reassign']]; }
 function openModal(caseId,type){ const item=data.cases?.[caseId]; if(!item)return; caseIdInput.value=caseId; typeInput.value=type; seniorFields.hidden=type!=='Senior Support'; partsFields.hidden=type!=='Parts Required'; outsourcingFields.hidden=type!=='Outsourcing'; actionSelect.innerHTML=options(item,type).map(([v,l])=>`<option value="${esc(v)}">${esc(l)}</option>`).join(''); caseGrid.innerHTML=[['Case ID',item.case_id],['Room',item.room],['Hotel Asset',item.hotel_asset],['Component',item.component],['Severity',item.severity],['Priority',item.priority],['Previous Technician',item.previous_technician_id||'Unassigned'],['Issue',item.issue],['SLA Status',item.sla_status]].map(([n,v])=>`<div class="support-case-item"><span>${esc(n)}</span><strong>${esc(v)}</strong></div>`).join('');
  if(type==='Senior Support'){ seniorSelect.innerHTML='<option value="">Select a senior technician</option>'+((item.eligible_seniors||[]).map(t=>`<option value="${esc(t.technician_id)}">${esc(t.name)} (${esc(t.technician_id)}) — ${esc(t.role)}, ${esc(t.level)} — ${Number(t.active_tasks||0)}/1 active</option>`).join('')); seniorSelect.required=true; } else {seniorSelect.required=false;}
  if(type==='Parts Required'){document.getElementById('requestedPartValue').textContent=item.requested_part||'Not provided';document.getElementById('requestedPartsStatus').textContent=item.parts_status||'Requested';}
  if(type==='Outsourcing'){document.getElementById('requestedExternalService').textContent=item.required_external_service||'Not provided';document.getElementById('requestedOutsourcingReason').textContent=item.outsourcing_reason||'Not provided';}
  modal.classList.add('is-open');modal.setAttribute('aria-hidden','false');document.body.classList.add('modal-open'); }
 function close(){modal.classList.remove('is-open');modal.setAttribute('aria-hidden','true');document.body.classList.remove('modal-open');form.reset();}
 document.querySelectorAll('.support-open-btn').forEach(b=>b.addEventListener('click',()=>openModal(b.dataset.caseId,b.dataset.actionType))); modal.querySelectorAll('.support-modal-close,.support-cancel-btn').forEach(b=>b.addEventListener('click',close)); modal.addEventListener('click',e=>{if(e.target===modal)close();});
});
</script>
<?php admin_ui_footer(); ?>
