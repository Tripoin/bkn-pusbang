<?php
//use app\Util\Database;
//use app\Model\SecurityFunction;
//
//$db = new Database();
//$securityFunction =new SecurityFunction();


        
//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "", "text-align:center;width:100px;"));
$Datatable->header(array(lang("general.no"), lang("general.code"), lang("general.name"), lang("security.url"), lang("security.parent"), lang("general.action")));
$no = $list_data['from'];


foreach ($list_data['item'] as $value) {

    $action_delete = $Button->url($this->deleteUrl)->value($value[$data->getId()])->buttonDelete();
    $action_edit = $Button->url($this->editUrl)->value($value[$data->getId()])->buttonEdit();
    
//    $rs_parent = $db->selectByID($securityFunction, $securityFunction->getParent().EQUAL.$value[$data->getParent()]);
    
    $url_name = "";
    if (isset($value['url'])) {
        $url_name = $value['url'];
    }
    $parent = "Parent Menu";
    if(isset($value[$data->getParent()][$data->getName()])){
        $parent = $value[$data->getParent()][$data->getName()];
    }
    $Datatable->body(
            array($no,
                $value[$data->getCode()],
                $value[$data->getName()],
                $url_name,
                $parent,
                $action_edit . $action_delete
    ));
    $no += 1;
}

echo $Datatable->show();
?>

