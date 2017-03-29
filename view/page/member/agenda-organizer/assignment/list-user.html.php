<div class="col-md-12">
    <?php
//    $Datatable->createButton(false);
    $Datatable->deleteCollection(false);
//    $Datatable->backButton(true);
    $Datatable->setPageTable('pageListUser');

//    $Datatable->styleHeader(array("text-align:center;"));
    $Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "text-align:center;width:100px;"));
    $Datatable->header(array(lang("general.no"), lang("general.name"), lang("general.action")));
    $no = $list_data['from'];

//    print_r($list_data);
    $act = 'update';
    if ($id == 0) {
        $act = 'save';
    }
    foreach ($list_data['item'] as $value) {

        $action_view = $Button->onClick('ajaxPostModalByValueHide(\'' . URL($this->admin_theme_url . $this->indexUrl . '/assignment/' . $activity . '/'.$act) . '\',\'id=' . $value[$data->getId()] . '&id_panitia=' . $id . '\')')->icon('fa fa-hand-o-left')->title(lang("general.choose"))->buttonCircleManual();
//        $action_delete = $Button->setclass('btn-danger')->onClick('postAjaxDelete(\'' . FULLURL('delete') . '\',\'id_post=' . $value[$masterPost->getId()] . '&id_function=' . $_POST['id'] . '\')')->icon('fa fa-trash')->title(lang("general.delete"))->buttonCircleManual();

        $Datatable->body(array($no, $value['front_degree'] . ' ' . $value['fullname'] . ' ' . $value['behind_degree'], $action_view));
        $no += 1;
    }

    echo $Datatable->show();
    ?>
</div>
<script>
    $(function () {
        initPanitia();
        $('#modal-title-self').html('<?= lang('transaction.organizer'); ?>');
        initPage();
    });
</script>
<!--<script>location.reload(true);</script>-->
