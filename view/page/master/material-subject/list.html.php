
<?php
//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "text-align:center;width:100px;"));
$Datatable->header(array(lang("general.no"), lang("general.code"),
    lang("general.name"),
    lang("general.is_material"),
    lang("general.action")));
$no = $list_data['from'];


foreach ($list_data['item'] as $value) {

    $action_delete = $Button->url($this->deleteUrl)->value($value[$data->getId()])->buttonDelete();
    $action_edit = $Button->url($this->editUrl)->value($value[$data->getId()])->buttonEdit();

    $is_materi = lang('general.material');
    if ($value[$data->getIsMaterial()] == 0) {
        $is_materi = lang('general.non_material');
    }
    $Datatable->body(array($no, $value[$data->getCode()],
        $value[$data->getName()],
        $is_materi,
        $action_edit . $action_delete));
    $no += 1;
}

echo $Datatable->show();
?>
<!--<script>location.reload(true);</script>-->
