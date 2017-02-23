
<?php
//echo $_SESSION[SESSION_ADMIN_AUTHORIZATION];
//    $Datatable->styleHeader(array("text-align:center;"));


$Datatable->deleteCollection(false);
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "","text-align:center","text-align:center","text-align:center", "text-align:center;width:150px;"));
$Datatable->header(array(lang("general.no"), lang("general.code")
    ,lang("general.name")
    ,lang("master.budget_type_id")
    ,"test"
    ,lang("master.curriculum")
    ,lang("master.assessment_points")
    , lang("general.action")));
$no = $list_data['from'];


foreach ($list_data['item'] as $value) {

        $action_delete = $Button->url($this->deleteUrl)->value($value->id)->buttonDelete();
        $action_edit = $Button->url($this->editUrl)->value($value->id)->buttonEdit();
   $curicullum_detail = '<a href="javascript:void(0)" onclick="pageCurriculum(' . $value->id . ')">' . ' Link to Curicullum detail' . '</a>';
        $assessment_points = '<a href="javascript:void(0)" onclick="pageDetails(' . $value->budget_type_id . ')">' . ' Link to Assessment Points detail' . '</a>';


    //   $budgetName='';
//if(isset($value->budget_type_id)){
  //  $budgetName=$value->budget_type_id->name;

//}
    $Datatable->body(array($no, $value->code, $value->name
            , $value->budget_type_id

            , $curicullum_detail
            ,$assessment_points
            , $action_edit . $action_delete));
    $no += 1;
}
echo $Datatable->show();
?>


<script>
    $(function () {
        $('.portlet-title > div > span').html('<?=lang('master.subject');?>');
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
    function pageParent() {
        $('#urlPage').val('<?= URL(getAdminTheme() . $this->indexUrl . '/list'); ?>');
        postAjaxPagination();
    }
</script>