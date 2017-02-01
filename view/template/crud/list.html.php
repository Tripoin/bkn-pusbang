<?php
//$autoData = $_SESSION[SESSION_ADMIN_AUTO_DATA];
$autoData = $this->listAutoData;
//    $Datatable->styleHeader(array("text-align:center;"));
//$Datatable->deleteCollection(false);
$arrayHeader = array();
$countAutoData;
foreach ($autoData as $valueData) {
    if ($valueData != 'id' && $valueData != 'description') {
        if (!in_array($valueData, $this->unsetAutoData)) {
            array_push($arrayHeader, lang("general." . $valueData));
        }
    }
}
$Datatable->styleFirstColumn("text-align:center;width:5%;");
$Datatable->styleLastColumn("text-align:center;width:150px;");

$Datatable->header(array_merge(
                array(lang("general.no")), $arrayHeader, array(lang("general.action"))));

$no = $list_data['from'];

$arrayBody = array();
$countItem = count($list_data['item']);
$countBody = 0;
//print_r($list_data['item']);
foreach ($list_data['item'] as $value) {

    $action_delete = $Button->url($this->deleteUrl)->value($value->id)->buttonDelete();
    $action_edit = $Button->url($this->editUrl)->value($value->id)->buttonEdit();
    $arrayBody = array();
    foreach ($autoData as $valueData) {
        if ($valueData != 'id') {
            $countBody += 1;
            if (!in_array($valueData, $this->unsetAutoData)) {
                array_push($arrayBody, $value->$valueData);
            }
        }
    }
    $arrayMergeBody = array_merge(array($no), $arrayBody, array($action_edit . $action_delete));
    $Datatable->body($arrayMergeBody);
//    $Datatable->body(array($no, $value->code, $value->name, $action_edit . $action_delete));
    $no += 1;
}
//print_r($Datatable->getArrayBody());
//echo $countItem.'<br/>';
//echo $countBody;


echo $Datatable->show();
?>
<!--<script>location.reload(true);</script>-->
