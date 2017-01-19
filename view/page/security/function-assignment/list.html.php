
<?php

//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleColumn(array("text-align:center;width:5%;","","","text-align:center;width:100px;"));
$Datatable->header(array(lang("general.no"), lang("general.code"), lang("general.name"), lang("general.action")));
$no = $list_data['from'];


foreach ($list_data['item'] as $value) {
    
//    $action_delete = $Button->url($this->deleteUrl)->value($value[$data->getId()])->buttonDelete();
//    $action_edit = $Button->url($this->editUrl)->value($value[$data->getId()])->buttonEdit();
    $action_view = $Button->onClick('postAjaxEdit(\'' . $this->editUrl . '\',\'id=' . $value[$data->getId()] . '\')')->icon('fa fa-eye')->title(lang("general.view"))->buttonCircleManual();
    
    $Datatable->body(array($no, $value[$data->getCode()], $value[$data->getName()],$action_view));
    $no += 1;
}

    echo $Datatable->show();
?>
<script>
$(function(){
    $('#buttonCreate').hide();
})
</script>
