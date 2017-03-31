<?php

use app\Constant\IURLConstant;

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

    $Datatable->body(array(
        $no,
        $value[$data->getSubjectName()],
        $value[$data->getGeneration()],
        $exTime = subMonth($value[$data->getStartActivity()]) . ' - ' . subMonth($value[$data->getEndActivity()]),
        $status = '<a href="javascript:void(0)" '
        . 'onclick="postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::SURVEY_ORGANIZER_INDEX_URL . '/detail') . '\',\'id=' . $value[$data->getId()] . '\')">' . lang("survey.survey") . '</a>'
    ));
    $no++;
}

echo $Datatable->show();
?>
<script>
    $(function () {
//        $('#account > legend').html('<?= lang('member.agenda_organizer'); ?>');
//        $('#buttonBack').remove();
        initPage();
    });
    function initPage() {
        $('#list_search_by').attr("class", "input-sm input-xsmall input-inline");
        $('#search_pagination').attr("class", "form-control");
        $('#search_pagination').attr("style", "height:18px;");
        $('.pagination').attr("style", "margin-top:0");
    }
</script>