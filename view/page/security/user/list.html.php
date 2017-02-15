<?php

use app\Model\SecurityUserProfile;
use app\Model\SecurityGroup;
use app\Util\Database;

$db = new Database();
$sfl = new SecurityUserProfile();
$sg = new SecurityGroup();

$db->connect();
//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "", "", "", "text-align:center;width:100px;"));
$Datatable->header(array(lang("general.no"), lang("security.username"), lang("security.fullname"), lang("security.email"), lang("security.group"), lang("security.expired_date"), lang("general.action")));
$no = $list_data['from'];
//LOGGER($list_data['item']);

foreach ($list_data['item'] as $value) {

    $action_delete = $Button->url($this->deleteUrl)->value($value[$data->getId()])->buttonDelete();
    $action_edit = $Button->url($this->editUrl)->value($value[$data->getId()])->buttonEdit();
//    $db->connect();
    /* $getGroup = $db->selectByID($sg, $sg->getId() . EQUAL .
      $value[$data->getGroupId()]);
     * 
     */
//    print_r($value[$data->getGroupId()]['name']);

    $getUser = $db->selectByID($sfl, $sfl->getId() . EQUAL .
            $value[$data->getId()]);
//print_r($getUser);
//    $get_data = $getUser[0];
//    if (!empty($getUser)) {
    $group_name = "";
    if (isset($value[$data->getGroupId()][$sg->getName()])) {
        $group_name = $value[$data->getGroupId()][$sg->getName()];
    }
    $Datatable->body(array($no, $value[$data->getCode()],
        $getUser[0][$sfl->getName()],
        $value[$sfl->getEmail()],
        $group_name,
        $value[$data->getExpiredDate()], $action_edit . $action_delete));
    $no += 1;
//    }
}

echo $Datatable->show();
?>

