
<?php
//    $Datatable->styleHeader(array("text-align:center;"));
//$Datatable->deleteCollection(false);
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "text-align:center;width:150px;"));
$Datatable->header(array(lang("general.no"), lang("general.code"), lang("general.name"), lang("general.action")));
$no = $list_data['from'];


foreach ($list_data['item'] as $value) {

    $action_delete = $Button->url($this->deleteUrl)->value($value->id)->buttonDelete();
    $action_edit = $Button->url($this->editUrl)->value($value->id)->buttonEdit();

    $Datatable->body(array($no, $value->code, $value->name, $action_edit . $action_delete));
    $no += 1;
}

echo $Datatable->show();
?>
<!--<script>location.reload(true);</script>-->
