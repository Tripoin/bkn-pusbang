
<?php

//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "", "text-align:center;width:100px;"));
$Datatable->header(array(lang("general.no"), lang("general.code"), lang("general.name"), lang("security.url"), lang("general.action")));
$no = $list_data['from'];


foreach ($list_data['item'] as $value) {

    $action_delete = $Button->url($this->deleteUrl)->value($value[$data->getId()])->buttonDelete();
    $action_edit = $Button->url($this->editUrl)->value($value[$data->getId()])->buttonEdit();

    $Datatable->body(
            array($no,
                $value[$data->getCode()],
                $value[$data->getName()],
                $value[$data->getUrl()],
                $action_edit . $action_delete
    ));
    $no += 1;
}

echo $Datatable->show();
?>

