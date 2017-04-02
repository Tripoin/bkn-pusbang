<?php

use app\Constant\IURLMemberConstant;
?>
<div class="row">
    <div class="col-md-9">
        <?= $data_activity[0][$modelActivity->getSubjectName()]; ?>
        :
        <?= subMonth($data_activity[0][$modelActivity->getStartActivity()]) . ' - ' . subMonth($data_activity[0][$modelActivity->getEndActivity()]); ?>
    </div>
    <div class="col-md-3" style="margin-bottom: 20px;" id="pageBtnHeader">
        
        <button id="buttonBack" title="<?= lang('general.back'); ?>" 
                rel="tooltip"
                class="btn btn-danger pull-right" type="submit" 
                onsubmit="return false;" onclick="pageParent()" 
                style="margin-left: 10px;"
                class="btn">
            <i class="fa fa-arrow-circle-left"></i> <?= lang('general.back'); ?>
        </button>
        
        <button id="buttonCreate" title="<?= lang('general.create'); ?>" 
                rel="tooltip"
                class="btn btn-warning pull-right" type="submit" 
                onsubmit="return false;" onclick="pageParent()" 
                class="btn">
            <i class="fa fa-plus"></i> <?= lang('general.create'); ?>
        </button>
    </div>
</div>
<?php
$Datatable->createButton(true);
$Datatable->backButton(true);


//$Datatable->headerButton(false);
//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleHeader(array(
    "text-align: center;width:15%;",
    "text-align: center;width:22%;",
    "text-align: center;width:22%;",
    "text-align: center;width:22%;",
    "text-align: center;width:22%;",
    "text-align: center;width:22%;",
    "text-align: center;width:22%;"));
//$Datatable->styleColumnBody(array("text-align:center;width:5%;", "", "", "text-align:center;width:100px;"));
$Datatable->header(array(
    lang("transaction.day/date"),
    lang("transaction.time"),
    lang("transaction.material"),
    lang("transaction.lesson_time"),
    lang("transaction.trainer"),
    lang("general.status"),
    lang("general.action")));
$no = $list_data['from'];

foreach ($list_data['item'] as $value) {
    if (!empty($value)) {
        $action_delete = Button()->icon('fa fa-times')->url(URL(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/details/' . $activity . '/delete'))->value($value[$data->getId()])->buttonDelete();
//    $action_edit = $Button->url($this->editUrl)->value($value[$data->getId()])->buttonEdit();
        $action_edit = Button()->setClass('btn btn-success')->onClick('ajaxPostModalManual(\'' . URL(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/details/' . $activity . '/edit') . '\',\'id=' . $value[$data->getId()] . '\')')->icon('fa fa-pencil-square-o')->title(lang("general.edit"))->buttonCircleManual();
//    $panitia = '<a href="javascript:void(0)" onclick="postAjaxEdit(\'' . $this->editUrl . '\',\'id=\')">' . lang("transaction.organizer") . '</a>';
        $startTime = date('H:i', strtotime($value[$activityDetails->getStartTime()]));
        $endTime = date('H:i', strtotime($value[$activityDetails->getEndTime()]));

        $Datatable->body(array(
            date('d-M-Y', strtotime($value[$activityDetails->getStartTime()])),
            $startTime . " - " . $endTime,
            $value[$activityDetails->getMaterialName()],
            $value[$activityDetails->getDuration()],
            $value[$activityDetails->getUserMainName()],
            $value[$activityDetails->getDescription()],
            $action_edit . $action_delete));
        $no += 1;
    }
}

echo $Datatable->show();
$action_kirim = Button()->onClick('ajaxPostModalManual(\'' . URL(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/assignment/' . $activity . '/edit') . '\',\'id=0\')')->icon('fa fa-paper-plane')->label('Kirim Surat Penugasan  Widyaiswara')->title('Kirim Surat Penugasan Widyaiswara')->buttonManual();
?>
<?= $action_kirim; ?>
<script>
    $(function () {
        $('#account > legend').html('<?= lang('transaction.activity_details'); ?>');
        initPage();
        initDetails();

    });


    function initDetails() {
        $('#buttonBack').attr("onclick", "pageParent()");
        $('#buttonCreate').attr("onclick", "ajaxPostModalManual('<?= URL(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/details/' . $activity . '/create'); ?>')");
        $('#url_delete_collection').val('<?= URL(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/details/' . $activity . '/deleteCollection'); ?>');
    }
</script>
<!--<script>location.reload(true);</script>-->
