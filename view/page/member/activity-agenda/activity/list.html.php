<div class="col-md-12">
    <?php
//    $Datatable->createButton(false);
    $Datatable->deleteCollection(false);
    $Datatable->setPageTable('pageListActivity');

//    $Datatable->styleHeader(array("text-align:center;"));
    $Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "text-align:center;width:100px;"));
    $Datatable->header(array(lang("general.no"), lang("general.name"), 
        lang("member.alumni"), 
        lang("member.budget_of_type"), 
        lang("member.execution_time"), 
        lang("member.participant"), 
        ));
    $no = $list_data['from'];

//    print_r($list_data);
    
    foreach ($list_data['item'] as $value) {

        $detailSubject = '<a href="javascript:void(0)" onclick="postAjaxEdit(\'' . URL('member/activity-agenda/activity/view').'\',\'id=' . $value[$data->getId()] . '\')">' . subMonth($value[$data->getStartActivity()]) . ' - ' . subMonth($value[$data->getEndActivity()]) . '</a>';
        $Datatable->body(array($no, 
            $value[$data->getSubjectName()], 
            $value[$data->getGeneration()], 
            $value[$data->getBudgetTypeName()],
            $detailSubject,
            $value[$data->getQuota()]));
        $no += 1;
    }

    echo $Datatable->show();
    ?>
</div>
<script>
    $(function () {
        $('#list_search_by-pageListActivity').attr("class","input-sm input-xsmall input-inline");
        $('#search_pagination-pageListActivity').attr("class","form-control");
        $('#search_pagination-pageListActivity').attr("style","height:18px;");
        $('.pagination').attr("style","margin-top:0");
    });
</script>
<!--<script>location.reload(true);</script>-->
