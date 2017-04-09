<?php

use app\Constant\IURLConstant;
use app\Model\TransactionSurvey;
use app\Model\TransactionActivity;
use app\Model\MasterUserAssignment;
use app\Model\MasterUserMain;
use app\Util\Database;

$transactionActivity = new TransactionActivity();
$transactionSurvey = new TransactionSurvey();
$masterUserAssignment = new MasterUserAssignment();
$masterUserMain = new MasterUserMain();
$db = new Database();
$db->connect();

$data_user = getUserMember();


$Datatable->createButton(false);
$Datatable->styleHeader(array("text-align:center;width:5%;", "text-align:center;", "text-align:center;", "text-align:center;width:30%;", ""));
$Datatable->styleBody(array("text-align:center;", "", "text-align:center;", "text-align:center;", ""));
$Datatable->header(array(lang("general.no"),
    lang("transaction.type"),
    lang("transaction.batch"),
    lang("transaction.excecution_time"),
    lang("general.action")
));
$no = $list_data['from'];


foreach ($list_data['item'] as $value) {
    $db->select($transactionSurvey->getEntity(), 'COUNT(' .$transactionSurvey->getEntity().DOT. $transactionSurvey->getId() . ') as total', 
            array($transactionActivity->getEntity(), $masterUserAssignment->getEntity()), 
            $transactionSurvey->getEntity() . DOT . $transactionSurvey->getUserAssignmentId() . EQUAL . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getId()
            . " AND " . $transactionActivity->getEntity() . DOT . $transactionActivity->getId() . EQUAL . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getActivity_id()
            . " AND " . $transactionSurvey->getEntity().DOT.$transactionSurvey->getTargetSurveyId() . equalToIgnoreCase($value[$data->getId()])
            . " AND " . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getUser_main_id() . equalToIgnoreCase($data_user[$masterUserMain->getEntity()][$masterUserMain->getId()])
    );
//    echo $db->getSql();
    $rs_survey_count = $db->getResult();
//    print_r($rs_survey_count);
    $exTime = subMonth($value[$data->getStartActivity()]) . ' - ' . subMonth($value[$data->getEndActivity()]);
    $status = '<label class="label label-success">Sudah Di survei</label>';
    if ($rs_survey_count[0]['total'] == 0) {
        $status = '<a href="javascript:void(0)" '
                . 'onclick="postAjaxEdit(\'' . $this->editUrl . '\',\'id=' . $value[$data->getId()] . '\')">' . lang("survey.survey") . '</a>';
    }
    $Datatable->body(array(
        $no,
        $value[$data->getSubjectName()],
        $value[$data->getGeneration()],
        $exTime,
        $status
    ));
    $no++;
}

echo $Datatable->show();
?>
<script>
    $(function () {
        initPage();
    });
    function initPage() {
        $('#list_search_by').attr("class", "input-sm input-xsmall input-inline");
        $('#search_pagination').attr("class", "form-control");
        $('#search_pagination').attr("style", "height:18px;");
        $('.pagination').attr("style", "margin-top:0");
    }
</script>