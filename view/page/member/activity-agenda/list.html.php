<?php

use app\Model\MasterWaitingList;
use app\Model\MasterUserAssignment;
use app\Util\Database;
use app\Constant\IURLMemberConstant;


$db = new Database();
$waitingList = new MasterWaitingList();
$userAssignment =  new MasterUserAssignment();
$db->connect();
?>
<div class="col-md-12">
    <?php
//    $Datatable->createButton(false);
    $Datatable->deleteCollection(false);
    $Datatable->setPageTable('pageListActivity');

//    $Datatable->styleHeader(array("text-align:center;"));
    $Datatable->styleColumn(array("text-align:center;width:5%;", "", "text-align:center;", "text-align:center;width:100px;"));
    $Datatable->header(array(lang("general.no"), lang("member.activity_type"), 
        lang("member.alumni"), 
        lang("member.budget_of_type"), 
        lang("member.execution_time"), 
        lang("member.participant"), 
        ));
    $no = $list_data['from'];

//    print_r($list_data);
    
    foreach ($list_data['item'] as $value) {
        $db->sql("SELECT COUNT(".$userAssignment->getId().") as count FROM ".$userAssignment->getEntity()." WHERE ".$userAssignment->getActivity_id().EQUAL.$value[$data->getId()]);
        $rs_assign = $db->getResult();

        $detailSubject = '<a href="javascript:void(0)" onclick="postAjaxEdit(\'' . URL(IURLMemberConstant::AGENDA_KEGIATAN_URL . '/view').'\',\'id=' . $value[$data->getId()] . '\')">' . subMonth($value[$data->getStartActivity()]) . ' - ' . subMonth($value[$data->getEndActivity()]) . '</a>';
        $Datatable->body(array($no,
            $value[$data->getSubjectName()], 
            $value[$data->getGeneration()], 
            $value[$data->getBudgetTypeName()],
            $detailSubject,
            $rs_assign[0]['count']."/".$value[$data->getQuota()]));
        $no += 1;
    }

    echo $Datatable->show();
    ?>
</div>
<script>
    $(function () {
        $('#list_search_by-pageListActivity').attr("class","input-sm input-xsmall input-inline");
        $('#search_pagination-pageListActivity').attr("class","form-control");
        $('#search_pagination-pageListActivity').attr("style","height:18px;");
        $('.pagination').attr("style","margin-top:0");
    });
</script>
<!--<script>location.reload(true);</script>-->
