<?php

use app\Util\Database;
use app\Model\MasterBudgetType;

$db = new Database();
$masterBudgetType = new MasterBudgetType();
$db->connect();
//echo $_SESSION[SESSION_ADMIN_AUTHORIZATION];
//    $Datatable->styleHeader(array("text-align:center;"));


$Datatable->deleteCollection(false);
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "text-align:center", "text-align:center", "text-align:center", "text-align:center;width:150px;"));
$Datatable->header(array(lang("general.no"), lang("general.code")
    , lang("general.name")
    , lang("master.budget_type_id")
    , lang("master.curriculum")
    , lang("master.assessment_points")
    , lang("general.action")));
$no = $list_data['from'];

//print_r($list_data['item']);
foreach ($list_data['item'] as $value) {

    $action_delete = $Button->url($this->deleteUrl)->value($value->id)->buttonDelete();
    $action_edit = $Button->url($this->editUrl)->value($value->id)->buttonEdit();
    $curicullum_detail = '<a href="javascript:void(0)" onclick="pageCurriculum(' . $value->id . ')">' . ' Link to Curicullum detail' . '</a>';
    $assessment_points = '<a href="javascript:void(0)" onclick="pageAssessmentPoint(' . $value->id . ')">' . ' Link to Assessment Points detail' . '</a>';


    //   $budgetName='';
//if(isset($value->budget_type_id)){
    //  $budgetName=$value->budget_type_id->name;
//}
    $db->select($masterBudgetType->getEntity(), $masterBudgetType->getName(), array(), $masterBudgetType->getId() . equalToIgnoreCase($value->budget_type_id));
    $data_budget = $db->getResult();

    $budget_name = "";
    if (isset($data_budget[0][$masterBudgetType->getName()])) {
        $budget_name = $data_budget[0][$masterBudgetType->getName()];
    }
    $Datatable->body(array($no,
        $value->code,
        $value->name,
        $budget_name,
        $curicullum_detail,
        $assessment_points,
        $action_edit . $action_delete));
    $no += 1;
}
echo $Datatable->show();
?>


<script>
    $(function () {
        $('.portlet-title > div > span').html('<?= lang('master.subject'); ?>');
        $('#buttonBack').remove();
    });

    function pageCurriculum(subjectId) {
        $('#urlPage').val('<?= URL(getAdminTheme() . $this->indexUrl . '/curriculum/'); ?>' + subjectId);
        postAjaxPagination();
    }
    function pageListPeserta(activity) {
        $('#urlPage').val('<?= URL(getAdminTheme() . $this->indexUrl . '/list-peserta/'); ?>' + activity);
        postAjaxPagination();
    }
    function pageDetails(activity) {
        $('#urlPage').val('<?= URL(getAdminTheme() . $this->indexUrl . '/details/'); ?>' + activity);
        postAjaxPagination();
    }
    
    function pageAssessmentPoint(subjectId) {
        $('#urlPage').val('<?= URL(getAdminTheme() . $this->indexUrl . '/assessment-point/'); ?>' + subjectId);
        postAjaxPagination();
    }
    function pageParent() {
        $('#urlPage').val('<?= URL(getAdminTheme() . $this->indexUrl . '/list'); ?>');
        postAjaxPagination();
    }
</script>