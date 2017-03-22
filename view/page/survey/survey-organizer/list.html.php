<?php
use app\Constant\IURLConstant;
//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "","","","", "text-align:center;width:100px;"));
$Datatable->header(array(lang("general.no"),
    lang("transaction.type"),
    lang("transaction.batch"),
    lang('transaction.budget_type'),
    lang("transaction.excecution_time"),
    lang("general.action"),
    //lang("general.action")
));
$no = $list_data['from'];


foreach ($list_data['item'] as $value) {

    $Datatable->body(array(
        $no,
        $value[$data->getSubjectName()],
        $value[$data->getGeneration()],
        $value[$data->getBudgetTypeName()],
//        $value[$data->getName()],
        $exTime = subMonth($value[$data->getStartActivity()]) . ' - ' . subMonth($value[$data->getEndActivity()]),
        $status = '<a href="javascript:void(0)" '
            . 'onclick="postAjaxEdit(\'' . URL(getAdminTheme().IURLConstant::SURVEY_TRAINER_INDEX_URL . '/detail') . '\',\'id=' . $value[$data->getId()] . '\')">' . lang("survey.survey") . '</a>'
    ));
    $no++;
}

echo $Datatable->show();
?>
<!--<script>location.reload(true);</script>-->
