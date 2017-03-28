<?php

use app\Constant\IURLMemberConstant;
use app\Model\MasterWaitingList;
use app\Model\MasterUserAssignment;
use app\Model\TransactionRegistration;
use app\Model\LinkRegistration;
use app\Model\MasterApproval;
use app\Model\MasterApprovalCategory;
use app\Util\Database;

$transactionRegistration = new TransactionRegistration();
$linkRegistration = new LinkRegistration();
$db = new Database();
$waitingList = new MasterWaitingList();
$userAssignment = new MasterUserAssignment();
$masterApproval = new MasterApproval();
$masterApprovalCategory = new MasterApprovalCategory();
$db->connect();

$db->select($masterApprovalCategory->getEntity(), $masterApprovalCategory->getId(), null, $masterApprovalCategory->getCode() . equalToIgnoreCase('REGISTRATION'));
$rs_approve_category1 = $db->getResult();
$db->select($masterApprovalCategory->getEntity(), $masterApprovalCategory->getId(), null, $masterApprovalCategory->getCode() . equalToIgnoreCase('RE-REGISTRATION'));
$rs_approve_category2 = $db->getResult();
?>
<div class="col-md-12">
    <?php
//    $Datatable->createButton(false);
    $Datatable->deleteCollection(false);

//    $Datatable->styleHeader(array("text-align:center;"));
    $Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "", "", "text-align:center;width:10px;", "text-align:center;width:80px;"));
    $Datatable->header(array(lang("general.no"), lang("member.activity_type"),
        lang("member.alumni"),
        lang("member.budget_of_type"),
        lang("member.execution_time"),
        lang("member.participant"),
        lang("general.status"),
        lang("member.registration"),
    ));
    $no = $list_data['from'];

//    $cek_regis = $db->selectByID($transactionRegistration, $transactionRegistration->getDelegationEmail() . " LIKE '" . $_SESSION[SESSION_USERNAME_GUEST] . "%'");
//    print_r($cek_regis);
    foreach ($list_data['item'] as $value) {
//        echo $_SESSION[SESSION_USERNAME_GUEST];
//        $detailSubject = '<a href="javascript:void(0)" onclick="postAjaxEdit(\'' . URL('member/activity-agenda/activity/view') . '\',\'id=' . $value[$data->getId()] . '\')">' . subMonth($value[$data->getStartActivity()]) . ' - ' . subMonth($value[$data->getEndActivity()]) . '</a>';
        $detailSubject = lang('transaction.tentative');
        $due = strtotime($value[$data->getStartActivity()]);
        if ($due != strtotime('0000-00-00')) {
            $detailSubject = '' . subMonth($value[$data->getStartActivity()]) . ' - ' . subMonth($value[$data->getEndActivity()]) . '';
        } else if ($value[$data->getStartActivity()] == null) {
            $detailSubject = lang('transaction.tentative');
        }

//        echo $rs_user_main[0][$userMain->getId()];
        $dt_link_reg = $db->selectByID($linkRegistration, $linkRegistration->getRegistrationId() . equalToIgnoreCase($rs_registration[0][$transactionRegistration->getId()])
                . " AND " . $linkRegistration->getActivityId() . equalToIgnoreCase($value[$data->getId()])
                . " AND " . $linkRegistration->getRegistrationDetailsId() . " is null");
//        echo json_encode($dt_link_reg);
        $status_activity = null;
        if (!empty($dt_link_reg)) {
            $dt_approval = $db->selectByID($masterApproval, $masterApproval->getApprovalCategoryId() . " IN (" . $rs_approve_category1[0][$masterApprovalCategory->getId()] . "," . $rs_approve_category2[0][$masterApprovalCategory->getId()] . ") "
                    . " AND " . $masterApproval->getApprovalDetailId() . equalToIgnoreCase($dt_link_reg[0][$linkRegistration->getId()]));
            $status_activity = $dt_approval[0][$masterApproval->getStatus()];
//            echo $masterApproval->getApprovalCategoryId() . " IN (" . $rs_approve_category1[0][$masterApprovalCategory->getId()] . "," . $rs_approve_category2[0][$masterApprovalCategory->getId()] . ") "
//                    . " AND " . $masterApproval->getApprovalDetailId() . equalToIgnoreCase($dt_link_reg[0][$linkRegistration->getId()]);
//        print_r($dt_approval);
        }
        $db->sql("SELECT COUNT(" . $userAssignment->getId() . ") as count FROM " . $userAssignment->getEntity() . " WHERE " . $userAssignment->getActivity_id() . EQUAL . $value[$data->getId()]);
        $rs_assign = $db->getResult();
//        print_r($rs_assign);

        $btn_status = '<a href="javascript:void(0)" onclick="postAjaxEdit(\'' . URL(IURLMemberConstant::ACTIVITY_REGISTRATION_TEMP_URL . '/' . $value[$data->getId()] . '/register') . '\',\'registration_id=' . $rs_registration[0][$transactionRegistration->getId()] . '\')">' . lang("member.register") . '</a>';
        $btn_str_reg = '<a href="javascript:void(0)" onclick="pageUser(' . $value[$data->getId()] . ',' . $rs_registration[0][$transactionRegistration->getId()] . ')">' . lang("member.participant") . '</a>';
        $status = lang('member.registered');
        $str_reg = "";
        if (empty($dt_link_reg)) {
            $status = $btn_status;
        } else {
            $str_reg = $btn_str_reg;
            if ($rs_assign[0]['count'] == $value[$data->getQuota()]) {
                $status = lang('member.full');
            } else {
                if($status_activity == null){
                    $status = lang('general.waiting');
                    $str_reg = "";
                } else if($status_activity == 0){
                    $status = lang('general.reject');
                    $str_reg = "";
                } else {
                    $status = lang('member.available');
                }
                
            }
        }
        $Datatable->body(array($no,
            $value[$data->getSubjectName()],
            $value[$data->getGeneration()],
            $value[$data->getBudgetTypeName()],
            $detailSubject,
            $rs_assign[0]['count'] . "/" . $value[$data->getQuota()],
            $status,
            $str_reg));
        $no += 1;
    }


    echo $Datatable->show();
//    echo lang('general.message_register_success');
    ?>
</div>
<script>
    $(function () {
        $('.member-page > span').html('<?= lang('member.registration_activity'); ?>');
        initPage();
    });

    function initPage() {
        $('#list_search_by').attr("class", "input-sm input-xsmall input-inline");
        $('#search_pagination').attr("class", "form-control");
        $('#search_pagination').attr("style", "height:18px;");
        $('.pagination').attr("style", "margin-top:0");
    }
</script>
<!--<script>location.reload(true);</script>-->
