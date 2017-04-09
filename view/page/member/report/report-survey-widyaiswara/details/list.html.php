
<?php

use app\Constant\IURLMemberConstant;
use app\Model\TransactionSurvey;
use app\Model\MasterUserAssignment;
use app\Model\MasterUserMain;
use app\Util\Database;

$db = new Database();
$db->connect();
$data_user_member = getUserMember();
$transactionSurvey = new TransactionSurvey();
$masterUserAssignment = new MasterUserAssignment();
$masterUserMain = new MasterUserMain();
$rs_assign_user = $db->selectByID($masterUserAssignment, ""
        . $masterUserAssignment->getActivity_id() . equalToIgnoreCase($_POST['id'])
        . " AND " . $masterUserAssignment->getRoleId() . equalToIgnoreCase(1)
        . " AND " . $masterUserAssignment->getUser_main_id() . equalToIgnoreCase($data_user_member[$masterUserMain->getEntity()][$masterUserMain->getId()])
);
$Datatable->createButton(false);
//$Datatable->headerButton(false);
//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "text-align:center;width:100px;", "", "", "text-align:center;width:100px;", "text-align:center;width:100px;", "text-align:center;width:100px;"));
$Datatable->header(array(lang("general.no"),
    lang("transaction.day/date"),
    lang("transaction.time"),
    lang("transaction.material"),
    lang("transaction.lesson_time"),
    lang("member.total_value")
));
$no = $list_data['from'];

$total = 0;
$count = 0;
foreach ($list_data['item'] as $value) {
    if (!empty($value)) {
        $db->select($transactionSurvey->getEntity(), "SUM(" . $transactionSurvey->getValue() . ") as total_value", array(), $transactionSurvey->getTargetSurveyId() . equalToIgnoreCase($value[$activityDetails->getId()])
                . " AND " . $transactionSurvey->getSurveyCategoryId() . equalToIgnoreCase(1)
        );
        $rs_survey = $db->getResult();
        $startTime = date('h:i', strtotime($value[$activityDetails->getStartTime()]));
        $endTime = date('h:i', strtotime($value[$activityDetails->getEndTime()]));
        $total += $rs_survey[0]['total_value'];
        
        $cek_survey = '<a href="javascript:void(0)" onclick="postAjaxEdit(\'' . URL(IURLMemberConstant::REPORT_SURVEY_WIDYAISWARA_URL . '/edit') . '\',\'id=' . $value[$data->getId()] . '&id_activity=' . $_POST['id'].'\')">' . number_format($rs_survey[0]['total_value'], 2) . '</a>';
        $Datatable->body(array(
            $no,
            fullDateString($value[$activityDetails->getStartTime()]),
            $startTime . " - " . $endTime,
            $value[$activityDetails->getMaterialName()],
            $value[$activityDetails->getDuration()],
            $cek_survey,
        ));
        $count += 1;
    }
}
$average_total = $total / $no;
$Datatable->body(array(
    '',
    '',
    '',
    '',
    lang('general.total'),
    number_format($total, 2),
));
$Datatable->body(array(
    '',
    '',
    '',
    '',
    lang('general.average'),
    number_format($average_total, 2),
));

echo $Datatable->show();
?>
<script>
    $(function () {
        $('.portlet-title > div > span').html('<?= lang('transaction.activity_details'); ?>');
        initDetails();
        initPage();
    });
    function initDetails() {
        $('#actionHeader').html(comButtonBack('<?= lang('general.back'); ?>', 'btn btn-danger', 'fa fa-back'));
        //$('#buttonBack').attr("onclick", "pageParent()");
        $('#list_search_by').attr("class", "input-sm input-xsmall input-inline");
        $('#search_pagination').attr("class", "form-control");
        $('#search_pagination').attr("style", "height:18px;");
        $('.pagination').attr("style", "margin-top:0");
    }
</script>
<!--<script>location.reload(true);</script>-->

