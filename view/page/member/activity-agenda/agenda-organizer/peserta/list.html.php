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
    lang("transaction.no_id"),
    lang("transaction.participant_name"),
    lang("general.action"),
));
$no = $list_data['from'];


foreach ($list_data['item'] as $value) {
    if (!empty($value)) {

        $action_edit = Button()->setClass('btn btn-primary')
                        ->onClick('postAjaxEdit(\'' . URL(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/list-peserta/' . $activity . '/view') . '\',\'id=' . $value[$data->getUser_main_id()]['id'] . '\')')
                        ->icon('fa fa-eye')->title(lang("general.view"))->buttonCircleManual();


        $Datatable->body(array(
            $no,
            $value[$data->getUser_main_id()][$userMain->getIdNumber()],
            $value[$data->getUser_main_id()][$userMain->getFront_degree()] . " " . $value[$data->getUser_main_id()][$userMain->getName()] . " " . $value[$data->getUser_main_id()][$userMain->getBehind_degree()],
            $action_edit));
        $no += 1;
    }
}

echo $Datatable->show();
$action_kirim = Button()->onClick('ajaxPostModalManual(\'' . URL(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/assignment/' . $activity . '/edit') . '\',\'id=0\')')->icon('fa fa-paper-plane')->label('Kirim Sertifikat Peserta')->title('Kirim Sertifikat Peserta')->buttonManual();
?>
<?= $action_kirim; ?>
<script>
    $(function () {
        $('#account > legend').html('<?= lang('transaction.participant_list'); ?>');
        initDetails();
        initPage();
    });
    function initDetails() {
        $('#actionHeader').html(comButtonBack('<?= lang('general.back'); ?>', 'btn btn-danger', 'fa fa-back'));
        $('#buttonBack').attr("onclick", "pageParent()");

    }
</script>
<!--<script>location.reload(true);</script>-->
