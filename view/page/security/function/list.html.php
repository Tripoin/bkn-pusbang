
<?php

//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "", "text-align:center;width:100px;"));
$Datatable->header(array(lang("general.no"), lang("general.code"), lang("general.name"), lang("security.url"), lang("general.action")));
$no = $list_data['from'];


foreach ($list_data['item'] as $value) {

    $action_delete = $Button->url($this->deleteUrl)->value($value[$data->getId()])->buttonDelete();
    $action_edit = $Button->url($this->editUrl)->value($value[$data->getId()])->buttonEdit();
    $url_name = "";
    if (isset($value[$data->getUrl()]['name'])) {
        $url_name = $value[$data->getUrl()]['name'];
    }
    $Datatable->body(
            array($no,
                $value[$data->getCode()],
                $value[$data->getName()],
                $url_name,
                $action_edit . $action_delete
    ));
    $no += 1;
}

echo $Datatable->show();
?>

