
<?php
$Datatable->createButton(false);
//$Datatable->headerButton(false);
//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleColumn(array("text-align:center;width:5%;", "","text-align:center;width:100px;","", "","text-align:center;width:100px;","text-align:center;width:100px;", "text-align:center;width:100px;"));
$Datatable->header(array(lang("general.no"), 
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
        $action_delete = Button()->url(URL($this->admin_theme_url . $this->indexUrl . '/details/' . $activity . '/delete'))->value($value[$data->getId()])->buttonDelete();
//    $action_edit = $Button->url($this->editUrl)->value($value[$data->getId()])->buttonEdit();
        $action_edit = Button()->setClass('btn btn-success')->onClick('ajaxPostModalManual(\'' . URL($this->admin_theme_url . $this->indexUrl . '/details/' . $activity . '/edit') . '\',\'id=' . $value[$data->getId()] . '\')')->icon('icon-note')->title(lang("general.edit"))->buttonCircleManual();
//    $panitia = '<a href="javascript:void(0)" onclick="postAjaxEdit(\'' . $this->editUrl . '\',\'id=\')">' . lang("transaction.organizer") . '</a>';
        $startTime = date('h:i', strtotime($value[$activityDetails->getStartTime()]));
        $endTime = date('h:i', strtotime($value[$activityDetails->getEndTime()]));
   
        $Datatable->body(array(
            $no,
            fullDateString($value[$activityDetails->getStartTime()]),
            $startTime." - ".$endTime,
            $value[$activityDetails->getMaterialName()],
            $value[$activityDetails->getDuration()],
            
            $value[$activityDetails->getUserMainName()],
            $value[$activityDetails->getDescription()],
            $action_edit . $action_delete));
        $no += 1;
    }
}

echo $Datatable->show();
$action_kirim = Button()->onClick('ajaxPostModalManual(\'' . URL($this->admin_theme_url . $this->indexUrl . '/assignment/' . $activity . '/edit') . '\',\'id=0\')')->icon('fa fa-paper-plane')->label('Kirim Surat Penugasan  Widyaiswara')->title('Kirim Surat Penugasan Widyaiswara')->buttonManual();
?>
<?= $action_kirim; ?>
<script>
    $(function () {
        $('.portlet-title > div > span').html('<?= lang('transaction.activity_details'); ?>');
        initDetails();
    });
    function initDetails() {
        $('#actionHeader').html(comButtonCreate('<?= lang('general.create'); ?>', 'btn btn-warning', 'fa fa-plus', '') + " " + comButtonBack('<?= lang('general.back'); ?>', 'btn btn-danger', 'fa fa-back'));
        $('#buttonBack').attr("onclick", "pageParent()");
        $('#buttonCreate').attr("onclick", "ajaxPostModalManual('<?= URL(getAdminTheme() . $this->indexUrl . '/details/' . $activity . '/create'); ?>')");
        $('#url_delete_collection').val('<?= URL($this->admin_theme_url . $this->indexUrl . '/details/' . $activity . '/deleteCollection'); ?>');
    }
</script>
<!--<script>location.reload(true);</script>-->
