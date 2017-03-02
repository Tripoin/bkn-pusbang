<?php

use app\Constant\IURLMemberConstant;
use app\Model\MasterWaitingList;
use app\Model\MasterUserAssignment;
use app\Model\TransactionRegistration;
use app\Model\LinkRegistration;
use app\Util\Database;

$transactionRegistration = new TransactionRegistration();
$linkRegistration = new LinkRegistration();
$db = new Database();
$waitingList = new MasterWaitingList();
$userAssignment = new MasterUserAssignment();
$db->connect();
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

    $cek_regis = $db->selectByID($transactionRegistration, $transactionRegistration->getDelegationEmail() . " LIKE '" . $_SESSION[SESSION_USERNAME_GUEST] . "%'");
//    print_r($cek_regis);
    foreach ($list_data['item'] as $value) {
//        echo $_SESSION[SESSION_USERNAME_GUEST];
//        $detailSubject = '<a href="javascript:void(0)" onclick="postAjaxEdit(\'' . URL('member/activity-agenda/activity/view') . '\',\'id=' . $value[$data->getId()] . '\')">' . subMonth($value[$data->getStartActivity()]) . ' - ' . subMonth($value[$data->getEndActivity()]) . '</a>';
        $detailSubject = '' . subMonth($value[$data->getStartActivity()]) . ' - ' . subMonth($value[$data->getEndActivity()]) . '';
//        echo $rs_user_main[0][$userMain->getId()];
        $dt_link_reg = $db->selectByID($linkRegistration, $linkRegistration->getRegistrationId() . equalToIgnoreCase($cek_regis[0][$transactionRegistration->getId()])
                . " AND " . $linkRegistration->getActivityId() . equalToIgnoreCase($value[$data->getId()]));
//        print_r($dt_link_reg);
        $db->sql("SELECT COUNT(" . $userAssignment->getId() . ") as count FROM " . $userAssignment->getEntity() . " WHERE " . $userAssignment->getActivity_id() . EQUAL . $value[$data->getId()]);
        $rs_assign = $db->getResult();
//        print_r($rs_assign);

        $btn_status = '<a href="javascript:void(0)" onclick="pageUser(' . $value[$data->getId()] . ','.$cek_regis[0][$transactionRegistration->getId()].')">' . lang("member.register") . '</a>';
        $btn_str_reg = '<a href="javascript:void(0)" onclick="pageUser(' . $value[$data->getId()] . ','.$cek_regis[0][$transactionRegistration->getId()].')">' . lang("member.participant") . '</a>';
        $status = lang('member.registered');
        $str_reg = "";
        if (empty($dt_link_reg)) {
            $status = $btn_status;
        } else {
            $str_reg = $btn_str_reg;
            if ($rs_assign[0]['count'] == $value[$data->getQuota()]) {
                $status = lang('member.full');
            } else {
                $status = lang('member.available');
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
