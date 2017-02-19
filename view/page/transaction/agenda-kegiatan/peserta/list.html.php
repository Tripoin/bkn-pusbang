
<?php
$Datatable->createButton(false);
//$Datatable->headerButton(false);
//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "text-align:center;width:100px;"));
$Datatable->header(array(lang("general.no"), 
    lang("transaction.no_id"),
    lang("transaction.participant_name"),
    ));
$no = $list_data['from'];


foreach ($list_data['item'] as $value) {
    if (!empty($value)) {

        $action_edit = Button()->setClass('btn btn-primary')
                ->onClick('postAjaxEdit(\'' . URL($this->admin_theme_url . $this->indexUrl . '/list-peserta/' . $activity . '/view') . '\',\'id=' . $value[$data->getUser_main_id()]['id'] . '\')')->icon('icon-eye')->title(lang("general.view"))->buttonCircleManual();

        
        $Datatable->body(array(
            $no,
            $value[$data->getUser_main_id()][$userMain->getIdNumber()],
            $value[$data->getUser_main_id()][$userMain->getFront_degree()]." ".$value[$data->getUser_main_id()][$userMain->getName()]." ".$value[$data->getUser_main_id()][$userMain->getBehind_degree()],
            $action_edit));
        $no += 1;
    }
}

echo $Datatable->show();
$action_kirim = Button()->onClick('ajaxPostModalManual(\'' . URL($this->admin_theme_url . $this->indexUrl . '/assignment/' . $activity . '/edit') . '\',\'id=0\')')->icon('fa fa-paper-plane')->label('Kirim Sertifikat Peserta')->title('Kirim Sertifikat Peserta')->buttonManual();
?>
<?= $action_kirim; ?>
<script>
    $(function () {
        $('.portlet-title > div > span').html('<?= lang('transaction.participant_list'); ?>');
        initDetails();
    });
    function initDetails() {
        $('#actionHeader').html(comButtonBack('<?= lang('general.back'); ?>', 'btn btn-danger', 'fa fa-back'));
        $('#buttonBack').attr("onclick", "pageParent()");
        
    }
</script>
<!--<script>location.reload(true);</script>-->
