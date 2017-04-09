<?php

use app\Constant\IURLConstant;
use app\Model\MasterUserAssignment;
use app\Util\Database;

$masterUserAssignment = new MasterUserAssignment();
$db = new Database();
$db->connect();



$Datatable->createButton(false);
$Datatable->styleHeader(array("text-align:center;width:5%;", "text-align:center;", "text-align:center;", "text-align:center;width:30%;", ""));
$Datatable->styleBody(array("text-align:center;", "", "text-align:center;", "text-align:center;", "text-align:center;"));
$Datatable->header(array(lang("general.no"),
    lang("transaction.type"),
    lang("transaction.batch"),
    lang("transaction.excecution_time"),
    lang("member.participant")
));
$no = $list_data['from'];


foreach ($list_data['item'] as $value) {
    $db->select($masterUserAssignment->getEntity(), 'COUNT(' . $masterUserAssignment->getId() . ') as total', array(), 
            $masterUserAssignment->getActivity_id() . equalToIgnoreCase($value[$data->getId()])
            ." AND ".$masterUserAssignment->getRoleId().  equalToIgnoreCase(1)
            );
    $rs_survey_count = $db->getResult();
//    print_r($rs_survey_count);
    $exTime = '<a href="javascript:void(0)" '
                . 'onclick="postAjaxEdit(\'' . $this->editUrl . '\',\'id=' . $value[$data->getId()] . '\')">' .subMonth($value[$data->getStartActivity()]) . ' - ' . subMonth($value[$data->getEndActivity()]) . '</a>';
    $total_participant = $rs_survey_count[0]['total'];
    
    $Datatable->body(array(
        $no,
        $value[$data->getSubjectName()],
        $value[$data->getGeneration()],
        $exTime,
        $total_participant.'/'.$value[$data->getQuota()]
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