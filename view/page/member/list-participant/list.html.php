<?php

use app\Model\MasterWaitingList;
use app\Model\MasterUserAssignment;
use app\Constant\IURLMemberConstant;
use app\Util\Database;

$db = new Database();
$waitingList = new MasterWaitingList();
$userAssignment = new MasterUserAssignment();
$db->connect();
?>
<div class="col-md-12">
    <?php
//    $Datatable->createButton(false);
    $Datatable->deleteCollection(false);
    $Datatable->setPageTable('pageListActivity');

//    $Datatable->styleHeader(array("text-align:center;"));
    $Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "", "", "text-align:center;width:10px;", "text-align:center;width:80px;"));
    $Datatable->header(array(lang("general.no"),
//        lang("general.username"),
        lang("general.name"),
//        lang("member.budget_of_type"),
//        lang("member.execution_time"),
//        lang("member.participant"),
        lang("general.action"),
    ));
    $no = $list_data['from'];

    foreach ($list_data['item'] as $value) {
        if ($value['user_id'] == null) {
            $btn = '<a href="javascript:void(0)" onclick="ajaxPostManual(\'' . URL(IURLMemberConstant::LIST_PARTICIPANT_EDIT_URL) . '\',\'pageListParticipant\',\'id=' . $value['id'] . '\')">' . lang('general.edit') . '</a>';
        } else {
            $btn = '<a href="javascript:void(0)" onclick="ajaxPostManual(\'' . URL(IURLMemberConstant::LIST_PARTICIPANT_VIEW_URL) . '\',\'pageListParticipant\',\'id=' . $value['id'] . '\')">' . lang('general.view') . '</a>';
        }
        $Datatable->body(array($no,
            $value['front_degree'] . " " . $value['name'] . " " . $value['behind_degree'],
//                $value[$data->getGeneration()],
//                $value[$data->getBudgetTypeName()],
//                $detailSubject,
//                $rs_assign[0]['count'] . "/" . $value[$data->getQuota()],
            $btn
        ));

        $no += 1;
    }

    echo $Datatable->show();
    ?>
</div>

<form id="form-upload-user" 
      action="<?= URL(IURLMemberConstant::LIST_PARTICIPANT_UPLOAD_URL) ?>" 
      method="POST" class="form" onsubmit="return false;">
    <div id="form-message"></div>
    <?=
            Form()->id('upload_participant')->required(true)->value('')
            ->title(lang('general.upload_participant') . " (format:'csv')")
            ->placeholder(lang('general.upload_participant'))->fileinput();
    ?>

    <button id="btn_signup" type="submit" onsubmit="return false;" 
            onclick="return ajaxPostFormManual('form-upload-user', 'pageListParticipant', 'form-message')" 
            class="btn btn-danger"><i class="fa fa-upload"></i> <?= lang('general.upload'); ?>
    </button>
</form>
<script>
    $(function () {
//        postAjaxEdit()
        $('#list_search_by-pageListActivity').attr("class", "input-sm input-xsmall input-inline");
        $('#search_pagination-pageListActivity').attr("class", "form-control");
        $('#search_pagination-pageListActivity').attr("style", "height:18px;");
        $('.pagination').attr("style", "margin-top:0");
    });
</script>
<!--<script>location.reload(true);</script>-->
