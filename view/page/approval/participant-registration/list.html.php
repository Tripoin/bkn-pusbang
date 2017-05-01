<?php

use app\Constant\IURLConstant;
use app\Util\Database;
use app\Model\TransactionRegistrationDetails;
use app\Model\LinkRegistration;
use app\Model\MasterApproval;

$db = new Database;
$db->connect();

$regDetail = new TransactionRegistrationDetails();
$linkRegistration = new LinkRegistration();
$masterApproval = new MasterApproval();


//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "", "", "", "text-align:center;width:100px;"));
$Datatable->header(array(lang("general.no"), lang("general.code"),
    lang("approval.pic_name"),
    lang("approval.approval_category"),
    lang("approval.user"),
    lang("approval.status"),
    lang("approval.time"),
    lang("general.action")
));
$no = $list_data['from'];

//print_r($list_data['item']);
foreach ($list_data['item'] as $value) {

    $action_delete = $Button->url($this->deleteUrl)->value($value[$data->getId()])->buttonDelete();
    $action_edit = $Button->url($this->editUrl)->value($value[$data->getId()])->buttonEdit();

//    $status = "";
//    if (is_null($value[$data->getStatus()])) {
    $status = '<a href="javascript:void(0)" '
            . 'onclick="postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_PARTICIPANT_REGISTRATION_INDEX_URL . '/edit') . '\',\'id=' . $value[$data->getId()] . '\')">' . lang("general.detail") . '</a>';
//    } else if ($value[$data->getStatus()] == 1) {
//        $status = '<span class="text-success">' . lang('general.approve') . '</span>';
//    } else if($value[$data->getStatus()] == 0) {
//        $status = '<span class="text-danger">' . lang('general.reject') . '</span>';
//    }

    $db->select($linkRegistration->getEntity(), 
            "COUNT(" . $regDetail->getEntity() . DOT . $regDetail->getId() . ") as total,"
            . $regDetail->getEntity() . DOT . $regDetail->getId().","
            ."COUNT(". $regDetail->getEntity() . DOT . $regDetail->getId() . ") as total_reg_detail"
            . "", array($regDetail->getEntity()), ""
//            . "  " . $masterApproval->getEntity() . DOT . $masterApproval->getApprovalDetailId() . EQUAL . $linkRegistration->getEntity() . DOT . $linkRegistration->getId()
            . "  " . $linkRegistration->getEntity() . DOT . $linkRegistration->getRegistrationDetailsId() . EQUAL . $regDetail->getEntity() . DOT . $regDetail->getId() . ""
            . " AND " . $linkRegistration->getEntity() . DOT . $linkRegistration->getRegistrationDetailsId() . " is not null"
            . " AND " . $linkRegistration->getEntity() . DOT . $linkRegistration->getStatus() . " is null "
//            . " AND " . $masterApproval->getEntity() . DOT . $masterApproval->getId() . equalToIgnoreCase($value['id']) . ""
            . " AND " . $linkRegistration->getEntity() . DOT . $linkRegistration->getActivityId() . equalToIgnoreCase($value['activity_id']) . ""
            . " AND " . $linkRegistration->getEntity() . DOT . $linkRegistration->getRegistrationId() . equalToIgnoreCase($value['registration_id']) . ""
            
            . "", null, null);
//echo $db->getSql();
    $rs_count_reg_detail = $db->getResult();
//    print_r($rs_count_reg_detail);

    $str_notif_reg = "";
    if (isset($rs_count_reg_detail[0]['total'])) {
        $notif_reg = $rs_count_reg_detail[0]['total'];
        if ($notif_reg == 0) {
            $str_notif_reg = "";
        } else {
            $str_notif_reg = '<span class="badge badge-success">' . $notif_reg . '</span>';
        }
    }
    $Datatable->body(array($no,
        '<a href="javascript:void(0)" onclick="postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_PARTICIPANT_REGISTRATION_INDEX_URL . '/edit') . '\',\'id=' . $value[$data->getId()] . '\')">' . $value[$data->getCode()] . '</a>',
        $value['pic_name'],
        $value['approval_category_name'] . " <b>(" . $value['activity_name'] . ")</b>",
        $value['username'],
        $status . $str_notif_reg,
        $value['created_on'],
        $action_delete
    ));
    $no += 1;
}

echo $Datatable->show();
?>
<!--<script>location.reload(true);</script>-->
