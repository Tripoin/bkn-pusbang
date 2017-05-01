<?php

use app\Constant\IURLMemberConstant;
use app\Model\TransactionSurvey;
use app\Model\TransactionActivity;
use app\Model\SecurityUserProfile;
use app\Model\MasterUserAssignment;
use app\Model\MasterUserMain;
use app\Util\Database;

$transactionActivity = new TransactionActivity();
$transactionSurvey = new TransactionSurvey();
$masterUserAssignment = new MasterUserAssignment();
$securityUserProfile = new SecurityUserProfile();
$masterUserMain = new MasterUserMain();
$db = new Database();
$db->connect();

$data_user = getUserMember();


$Datatable->createButton(true);
$Datatable->deleteCollection(false);
$Datatable->styleHeader(array("text-align:center;width:5%;",
    "text-align:center;", "text-align:left;", "text-align:center;width:30%;", ""));
$Datatable->styleBody(array("text-align:center;", "", "text-align:left;", "text-align:left;", ""));
$Datatable->header(array(lang("general.no"),
    lang("general.title"),
    lang("general.from"),
    lang("general.to"),
    lang("general.status"),
    lang("general.type"),
));
$no = $list_data['from'];

//print_r($list_data['item']);
foreach ($list_data['item'] as $value) {

    $fromUser = $value[$data->getFrom()][$securityUserProfile->getName()];


    $toUser = $value[$data->getTo()][$securityUserProfile->getName()];

    $onclick = 'onclick="viewMessage(' . $value[$data->getId()] . ')"';
    $status = '';
    if ($value[$data->getFrom()][$securityUserProfile->getId()] == $data_user[$securityUserProfile->getEntity()][$securityUserProfile->getId()]) {
        $Datatable->attrRowBody('id="tr-' . $value[$data->getId()] . '" style="cursor:pointer" ' . $onclick);
         if ($value[$data->getRead()] != 1) {
             $status = lang('general.unread');
         } else {
            $status = lang('general.read');
         }
        
    } else if ($value[$data->getRead()] != 1) {
        $Datatable->attrRowBody('id="tr-' . $value[$data->getId()] . '" style="color:black;font-weight:bold;cursor:pointer;" ' . $onclick);
        $status = lang('general.unread');
    } else {
        $Datatable->attrRowBody('id="tr-' . $value[$data->getId()] . '" style="cursor:pointer" ' . $onclick);
        $status = lang('general.read');
    }

    $type = lang("general.inbox");
    if ($value[$data->getFrom()][$securityUserProfile->getId()] == $data_user[$securityUserProfile->getEntity()][$securityUserProfile->getId()]) {
        $type = lang("general.send_message");
    }
    $Datatable->body(array(
        $no,
        $value[$data->getTitle()],
        $fromUser,
        $toUser,
        $status,
        $type
    ));
    $no++;
}

echo $Datatable->show();
?>
<div id="panel-message">

</div>

<script>
    $(function () {

        initPage();
    });
    function viewMessage(id) {
//        var attrStyle = $('#tr-'+id).attr("style");
        var attrId = $('#tr-' + id).attr("id");
        var attrOnclick = $('#tr-' + id).attr("onclick");
        
        $('#tr-' + id).attr("id", attrId);
        $('#tr-' + id).attr("onclick", attrOnclick);
//        if(typeof neverDeclared == "undefined") 
//alert($("[style='cursor:pointer;background:#FFFF96']").attr("style"));
        if ($("[style='cursor:pointer;background:#FFFF96']").attr("style") == 'cursor:pointer;background:#FFFF96') {
            $("[style='cursor:pointer;background:#FFFF96']").attr("style", "cursor:pointer;");
            $('#tr-' + id).attr("style", "cursor:pointer;background:#FFFF96");
        } else {
            $('#tr-' + id).attr("style", "cursor:pointer;background:#FFFF96");
        }
        ajaxPostManual('<?= URL(IURLMemberConstant::NOTIFICATION_URL . '/view'); ?>', 'panel-message', 'id=' + id);
    }
    function initPage() {
        $('#actionHeader').attr("style", "text-align:right;margin-top:10px;");
        $('#list_search_by').attr("class", "input-sm input-xsmall input-inline");
        $('#search_pagination').attr("class", "form-control");
        $('#search_pagination').attr("style", "height:18px;");
        $('.pagination').attr("style", "margin-top:0");
    }
</script>