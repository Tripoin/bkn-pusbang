
<?php
$Datatable->createButton(false);
$Datatable->deleteCollection(false);
//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleColumn(array("text-align:center;width:5%;","","","text-align:center;width:100px;"));
$Datatable->header(array(lang("general.no"), lang("general.code"), lang("general.name"), lang("general.action")));
$no = $list_data['from'];


foreach ($list_data['item'] as $value) {
    
    $action_edit = $Button->onClick('postAjaxEdit(\'' . $this->editUrl . '\',\'id=' . $value[$data->getId()] . '\')')->icon('fa fa-eye')->title(lang("general.view"))->buttonCircleManual();
    
    $Datatable->body(array($no, $value[$data->getCode()], $value[$data->getName()],$action_edit));
    $no += 1;
}

    echo $Datatable->show();
?>
<!--<script>location.reload(true);</script>-->
