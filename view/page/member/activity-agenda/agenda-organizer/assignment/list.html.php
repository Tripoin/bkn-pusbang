
<?php
$Datatable->createButton(false);
//$Datatable->headerButton(false);
//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "text-align:center;width:100px;"));
$Datatable->header(array(lang("general.no"), lang("general.name"),
    lang("general.status"),
    lang("general.action")));
$no = $list_data['from'];


foreach ($list_data['item'] as $value) {
    if (!empty($value)) {
        $action_delete = Button()->url(URL($this->admin_theme_url . $this->indexUrl . '/assignment/' . $activity . '/delete'))->value($value[$data->getId()])->buttonDelete();
//    $action_edit = $Button->url($this->editUrl)->value($value[$data->getId()])->buttonEdit();
        $action_edit = Button()->setClass('btn btn-success')->onClick('ajaxPostModalManual(\'' . URL($this->admin_theme_url . $this->indexUrl . '/assignment/' . $activity . '/edit') . '\',\'id=' . $value[$data->getId()] . '\')')->icon('icon-note')->title(lang("general.edit"))->buttonCircleManual();
//    $panitia = '<a href="javascript:void(0)" onclick="postAjaxEdit(\'' . $this->editUrl . '\',\'id=\')">' . lang("transaction.organizer") . '</a>';
        $Datatable->body(array(
            $no,
            $value[$data->getName()],
            $value[$data->getDescription()],
            $action_edit . $action_delete));
        $no += 1;
    }
}

echo $Datatable->show();
$action_kirim = Button()->onClick('ajaxPostModalManual(\'' . URL($this->admin_theme_url . $this->indexUrl . '/assignment/' . $activity . '/edit') . '\',\'id=0\')')->icon('fa fa-paper-plane')->label('Kirim Surat Penugasan Panitia')->title('Kirim Surat Penugasan Panitia')->buttonManual();
?>
<?= $action_kirim; ?>
<script>
    $(function () {
        $('.portlet-title > div > span').html('<?= lang('transaction.assignment'); ?>');
        initPanitia();
        initPage();
    });
    function initPanitia() {
        $('#actionHeader').html(comButtonCreate('<?= lang('general.create'); ?>', 'btn btn-warning', 'fa fa-plus', '') + " " + comButtonBack('<?= lang('general.back'); ?>', 'btn btn-danger', 'fa fa-back'));
        $('#buttonBack').attr("onclick", "pageParent()");
        $('#buttonCreate').attr("onclick", "ajaxPostModalManual('<?= URL(getAdminTheme() . $this->indexUrl . '/assignment/' . $activity . '/create'); ?>')");
        $('#url_delete_collection').val('<?= URL($this->admin_theme_url . $this->indexUrl . '/assignment/' . $activity . '/deleteCollection'); ?>');
    }
</script>
<!--<script>location.reload(true);</script>-->
