
<?php
//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->deleteCollection(false);
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "text-align:center;width:150px;"));
$Datatable->header(array(lang("general.no"), lang("general.code"), lang("general.name"), lang("general.action")));
$no = $list_data['from'];


foreach ($list_data['item'] as $value) {

    if ($value[$data->getId()] == 1 || $value[$data->getId()] == 2 || $value[$data->getId()] == 3 || $value[$data->getId()] == 4) {
        $action_delete = 'Can\'t Delete or Edit';
        $action_edit = '';
    } else {
        $action_delete = $Button->url($this->deleteUrl)->value($value[$data->getId()])->buttonDelete();
        $action_edit = $Button->url($this->editUrl)->value($value[$data->getId()])->buttonEdit();
    }

    $Datatable->body(array($no, $value[$data->getCode()], $value[$data->getName()], $action_edit . $action_delete));
    $no += 1;
}

echo $Datatable->show();
?>
<!--<script>location.reload(true);</script>-->
