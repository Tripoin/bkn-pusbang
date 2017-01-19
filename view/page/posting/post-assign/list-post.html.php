
<?php
$Datatable->createButton(false);
$Datatable->deleteCollection(false);
$Datatable->backButton(true);
$Datatable->setPageTable('bodyPageManual');
//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleColumn(array("text-align:center;width:5%;","","","text-align:center;width:100px;"));
$Datatable->header(array(lang("general.no"), lang("general.code"), lang("general.name"), lang("general.action")));
$no = $list_data['from'];

//print_r($list_data['item']);
foreach ($list_data['item'] as $value) {
    
    $action_view = $Button->onClick('ajaxPostModalByValue(\'' . URL($this->admin_theme_url . '/page/posting/post-assign/edit/view-post-assign') . '\',\'View Posting\',\'id_post='.$value[$masterPost->getId()].'\')')->icon('fa fa-eye')->title(lang("general.view"))->buttonCircleManual();
    $action_delete = $Button->setclass('btn-danger')->onClick('postAjaxDeleteV2(\'' . URL($this->admin_theme_url . '/page/posting/post-assign/edit/delete-post-assign') . '\',\'&id_post=' . $value[$masterPost->getId()] . '&id_function=' . $_POST['id'] . '\',\'bodyPageManual\')')->icon('fa fa-trash')->title(lang("general.delete"))->buttonCircleManual();
    
    $Datatable->body(array($no, $value[$masterPost->getCode()], $value[$masterPost->getTitle()],$action_view.$action_delete));
    $no += 1;
}

    echo $Datatable->show();
?>
<!--<script>location.reload(true);</script>-->
