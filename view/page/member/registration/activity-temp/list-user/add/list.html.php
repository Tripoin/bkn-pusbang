<?php
use app\Constant\IURLMemberConstant;
$Datatable->deleteCollection(false);
$Datatable->setPageTable('pageListPesertaAdd');
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "text-align:center;width:100px;"));
$Datatable->header(array(lang("general.no"), lang("general.code"), lang("general.name"), lang("general.action")));
$no = $list_data['from'];
foreach ($list_data['item'] as $value) {
    $action_view = Button()->onClick('ajaxPostManual(\''.URL(IURLMemberConstant::ACTIVITY_REGISTRATION_TEMP_LIST_USER_ADD_URL . '/' . $activity . '/add').'\',\'pageListPeserta\',\'registration_id='.$registrationId.'&registration_detail_id='.$value['id'].'\')')->icon('fa fa-hand-o-left')
            ->title(lang("general.choose"))->buttonCircleManual();
    $Datatable->body(array($no,
        $value[$data->getIdNumber()],
        $value[$data->getName()],
        $action_view));
    $no += 1;
}

echo $Datatable->show();
?>
<script>
    $(function () {
        ajaxPostManual();
        $("#buttonBack").show();
        $("[rel='tooltip']").tooltip('hide');
        $('#list_search_by-pageListPesertaAdd').attr("class", "input-sm input-xsmall input-inline");
        $('#search_pagination-pageListPesertaAdd').attr("class", "form-control input-sm input-xsmall input-inline");
        $('#search_pagination-pageListPesertaAdd').attr("style", "height:18px;");
    });
    
    function setLov(id,name){
        $('#myModal_self').modal('hide');
    }
</script>
<!--<script>location.reload(true);</script>-->
