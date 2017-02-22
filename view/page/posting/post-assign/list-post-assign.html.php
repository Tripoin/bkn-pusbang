<div class="col-md-12">
    <?php
    $Datatable->createButton(false);
    $Datatable->deleteCollection(false);
    $Datatable->backButton(true);
    $Datatable->setPageTable('pageListPost');

//    $Datatable->styleHeader(array("text-align:center;"));
    $Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "text-align:center;width:100px;"));
    $Datatable->header(array(lang("general.no"), lang("general.code"), lang("general.name"), lang("general.action")));
    $no = $list_data['from'];

//    print_r($list_data);
    foreach ($list_data['item'] as $value) {

        $action_view = $Button->onClick('ajaxPostModalByValueHide(\'' . URL($this->admin_theme_url . '/posting/post-assign/edit/add-post-assign') . '\',\'id_post=' . $value[$masterPost->getId()] . '&id_function=' . $_POST['id'] . '\')')->icon('fa fa-hand-o-left')->title(lang("general.choose"))->buttonCircleManual();
//        $action_delete = $Button->setclass('btn-danger')->onClick('postAjaxDelete(\'' . FULLURL('delete') . '\',\'id_post=' . $value[$masterPost->getId()] . '&id_function=' . $_POST['id'] . '\')')->icon('fa fa-trash')->title(lang("general.delete"))->buttonCircleManual();

        $Datatable->body(array($no, $value[$masterPost->getCode()], $value[$masterPost->getTitle()],$action_view));
        $no += 1;
    }

    echo $Datatable->show();
    ?>
</div>
<!--<script>location.reload(true);</script>-->
