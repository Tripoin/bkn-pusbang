<?php
use app\Constant\IURLMemberConstant;
use app\Model\MasterWaitingList;
use app\Model\MasterUserAssignment;
use app\Util\Database;

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
    ));
    $no = $list_data['from'];
    foreach ($list_data['item'] as $value) {

//        $detailSubject = '<a href="javascript:void(0)" onclick="postAjaxEdit(\'' . URL('member/activity-agenda/activity/view') . '\',\'id=' . $value[$data->getId()] . '\')">' . subMonth($value[$data->getStartActivity()]) . ' - ' . subMonth($value[$data->getEndActivity()]) . '</a>';
        $detailSubject = '' . subMonth($value[$data->getStartActivity()]) . ' - ' . subMonth($value[$data->getEndActivity()]) . '';
//        echo $rs_user_main[0][$userMain->getId()];

        $db->sql("SELECT COUNT(" . $userAssignment->getId() . ") as count FROM " . $userAssignment->getEntity() . " WHERE " . $userAssignment->getActivity_id() . EQUAL . $value[$data->getId()]);
        $rs_assign = $db->getResult();
//        print_r($rs_assign);

        $btn_status = '<a href="javascript:void(0)" onclick="pageUser(' . $value[$data->getId()] . ')">' . lang("member.register") . '</a>';
        $status = lang('member.registered');
        if (is_null($value[$data->getStatus()])) {
            $status = $btn_status;
        } else if ($value[$data->getStatus()] == 0) {
            $status = $btn_status;
        } else {
            if ($rs_assign[0]['count'] == $value[$data->getQuota()]) {
                $status = lang('member.full');
            }
        }
        $Datatable->body(array($no,
            $value[$data->getSubjectName()],
            $value[$data->getGeneration()],
            $value[$data->getBudgetTypeName()],
            $detailSubject,
            $rs_assign[0]['count'] . "/" . $value[$data->getQuota()],
            $status));
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
    
    function pageParent() {
        $('#urlPage').val('<?= URL(IURLMemberConstant::ACTIVITY_REGISTRATION_TEMP_URL . '/list'); ?>');
        postAjaxPagination();
    }

    function pageUser(activity) {
        $('#urlPage').val('<?= URL(IURLMemberConstant::ACTIVITY_REGISTRATION_TEMP_URL . '/list-user/'); ?>' + activity);
        postAjaxPagination();
    }

    function initPage() {
        $('#list_search_by').attr("class", "input-sm input-xsmall input-inline");
        $('#search_pagination').attr("class", "form-control");
        $('#search_pagination').attr("style", "height:18px;");
        $('.pagination').attr("style", "margin-top:0");
    }
</script>
<!--<script>location.reload(true);</script>-->
