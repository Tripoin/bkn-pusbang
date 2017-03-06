<?php
$Datatable->deleteCollection(false);
$Datatable->setPageTable('pageListLOV' . $searchData);
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "text-align:center;width:100px;"));
$Datatable->header(array(lang("general.no"), lang("general.code"), lang("general.name"), lang("general.action")));
$no = $list_data['from'];
foreach ($list_data['item'] as $value) {
    $action_view = Button()->onClick('setLov(\''.$value['id'].'\',\''.$value['name'].'\')')->icon('fa fa-hand-o-left')
            ->title(lang("general.choose"))->buttonCircleManual();
    $Datatable->body(array($no,
        $value['code'],
        $value['name'],
        $action_view));
    $no += 1;
}

echo $Datatable->show();
?>
<script>
    $(function () {
        $("#buttonBack").show();
        $("[rel='tooltip']").tooltip('hide');
        $('#list_search_by-pageListLOV<?= $searchData; ?>').attr("class", "input-sm input-xsmall input-inline");
        $('#search_pagination-pageListLOV<?= $searchData; ?>').attr("class", "form-control input-sm input-xsmall input-inline");
        $('#search_pagination-pageListLOV<?= $searchData; ?>').attr("style", "height:18px;");
    });
    
    function setLov(id,name){
        $('#myModal_self').modal('hide');
        $('#<?= $searchData; ?>-name').val(name);
        $('#<?= $searchData; ?>').val(id);
    }
</script>
<!--<script>location.reload(true);</script>-->
