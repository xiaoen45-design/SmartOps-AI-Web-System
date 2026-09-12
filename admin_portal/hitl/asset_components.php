<?php
require_once __DIR__ . '/../../includes/admin_layout.php';
require_once __DIR__ . '/../admin_auth.php';
require_admin();
$asset=trim((string)($_GET['asset']??''));
if($asset==='') redirect_to(app_url('admin_portal/hitl/dashboard.php'));
admin_ui_header(asset_display_name($asset).' HITL Category Summary','hitl','Review pending HITL cases for this maintenance category by component.',true);
$rows=fetch_all("SELECT h.*,s.ai_confidence FROM hitl_cases h LEFT JOIN smart_maintenance_tickets s ON s.case_id=h.case_id WHERE (h.review_status IS NULL OR h.review_status='' OR h.review_status LIKE '%Pending%' OR h.review_status LIKE '%Review%') AND (h.hotel_asset=? OR REPLACE(h.hotel_asset,'D30 ','')=? OR REPLACE(h.hotel_asset,'D20 ','')=? OR REPLACE(h.hotel_asset,'D50 ','')=? OR REPLACE(h.hotel_asset,'D40 ','')=? OR REPLACE(h.hotel_asset,'D10 ','')=?)",[$asset,clean_asset_name($asset),clean_asset_name($asset),clean_asset_name($asset),clean_asset_name($asset),clean_asset_name($asset)]);
$summary=[];
foreach ($rows as $row) {
    $component = (string)($row['component'] ?: 'Unknown');
    if (!isset($summary[$component])) {
        $summary[$component] = ['total' => 0, 'immediate' => 0, 'urgent' => 0, 'low_confidence' => 0, 'out_of_kb' => 0];
    }
    $summary[$component]['total']++;
    $primaryTrigger = hitl_primary_escalation_trigger($row);
    if ($primaryTrigger === 'Critical') $summary[$component]['immediate']++;
    elseif ($primaryTrigger === 'High') $summary[$component]['urgent']++;
    elseif ($primaryTrigger === 'Low Confidence') $summary[$component]['low_confidence']++;
    elseif ($primaryTrigger === 'Out of Knowledge Base') $summary[$component]['out_of_kb']++;
}
uasort($summary,fn($a,$b)=>$b['total']<=>$a['total']);
?>
<section class="kpis three detail-summary-kpis"><div class="kpi"><h3>Total HITL Cases</h3><h2><?=e(number_format(count($rows)))?></h2></div><div class="kpi"><h3>Components</h3><h2><?=e(number_format(count($summary)))?></h2></div><div class="kpi"><h3>Selected Category</h3><h2 class="text-kpi"><?=e(clean_asset_name($asset))?></h2></div></section>
<section class="card"><div class="table-header"><div><h2>Component Categories</h2><p>Select a component to continue to its tailored HITL case records.</p></div></div><div class="table-box"><table class="dashboard-table component-summary-table"><thead><tr><th>Component</th><th>Total Cases</th><th>Immediate</th><th>Urgent</th><th>Low Confidence</th><th>Out of KB</th><th>Action</th></tr></thead><tbody>
<?php foreach($summary as $component=>$v): ?>
<tr><td><strong><?=e(component_display_name($component,$asset))?></strong></td><td><?=e($v['total'])?></td><td><?=e($v['immediate'])?></td><td><?=e($v['urgent'])?></td><td><?=e($v['low_confidence'])?></td><td><?=e($v['out_of_kb'])?></td><td><a class="review-btn" href="<?=e(app_url('admin_portal/hitl/component_cases.php?asset='.urlencode($asset).'&component='.urlencode($component)))?>">View Cases</a></td></tr>
<?php endforeach; ?>
</tbody></table></div></section>
<?php admin_ui_footer(); ?>
