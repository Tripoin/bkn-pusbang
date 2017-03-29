<?php

use app\Constant\IURLMemberConstant;
?>
<div class="row">
    <div class="col-md-9">
        <?= $data_activity[0][$modelActivity->getSubjectName()]; ?>
        :
        <?= subMonth($data_activity[0][$modelActivity->getStartActivity()]) . ' - ' . subMonth($data_activity[0][$modelActivity->getEndActivity()]); ?>
    </div>
    <div class="col-md-3" style="margin-bottom: 20px;">
        <button id="btn_signup" title="<?= lang('general.back'); ?>" 
                rel="tooltip"
                class="btn btn-danger pull-right" type="submit" 
                onsubmit="return false;" onclick="pageParent()" 
                class="btn">
            <i class="fa fa-arrow-circle-left"></i> <?= lang('general.back'); ?>
        </button>
    </div>
</div>
<?php
$Datatable->createButton(false);
//$Datatable->headerButton(false);
//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "text-align:center;width:100px;"));
$Datatable->header(array(lang("general.no"),
    lang("general.code"),
    lang("member.approval_category"),
    lang("member.user"),
    lang("general.status"),
    lang("member.time"),
));
$no = $list_data['from'];


foreach ($list_data['item'] as $value) {
    if (!empty($value)) {

        

        $status = "";
        if ($value[$masterApproval->getStatus()] == 1) {
            $status = '<span class="text-success">'.lang('general.approve').'</span>';
        } else if ($value[$masterApproval->getStatus()] == 0) {
            $status = '<span class="text-danger">'.lang('general.reject').'</span>';
        } else {
            $status = '<a href="javascript:void(0)" onclick="postAjaxEdit(\'' . URL(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/view/' . $activity . '/detail') . '\',\'id=' . $value[$masterWaitingList->getUserMainId()].'&waiting_list_id='.$value['waiting_list_id'].'\')">' . lang("general.detail") . '</a>';
        }
        $Datatable->body(array(
            $no,
            $value[$masterApproval->getCode()],
            $value[$masterApprovalCategory->getName()],
            $value[$masterApproval->getCreatedByUsername()],
            $status,
            $value[$masterApproval->getCreatedOn()],
//            $action_edit
                )
        );
        $no += 1;
    }
}

echo $Datatable->show();
?>
<script>
    $(function () {
        $('#account > legend').html('<?= lang('member.candidates_approval'); ?>');
        initDetails();
        initPage();
    });
    function initDetails() {
        $('#actionHeader').html(comButtonBack('<?= lang('general.back'); ?>', 'btn btn-danger', 'fa fa-back'));
        $('#buttonBack').attr("onclick", "pageParent()");

    }
</script>
<!--<script>location.reload(true);</script>-->
