<div class="col-md-12">
    <?php
    $datatable->deleteCollection(false);
    $datatable->enableSearch(false);
    $datatable->enableRecord(false);
//    $datatable->setPageTable('pageListAlumnus');
    $datatable->styleHeader(array("text-align:center;background: #D01C24;color: #FFF;border-bottom:0","text-align:center;background: #D01C24;color: #FFF;border-bottom:0"));
    $datatable->styleBody(array("background: #FFF","background: #FFF"));
    $datatable->header(array(
        lang("alumnus.participant_name"),
        lang("alumnus.agencies")
    ));

    foreach ($rs_alumnus['item'] as $value) {
        $participant_name = $value['participant_name'];
        $front_degree = $value['front_degree'];
        $behind_degree = $value['behind_degree'];
        if($front_degree != null)
            $participant_name = $front_degree." ".$participant_name;
        if($behind_degree != null)
            $participant_name = $participant_name." ".$behind_degree;

        $government_agencies_id = $value['government_agencies_id'];
        $agencies = $value['agencies'];
        if($government_agencies_id != null) {
            $db->sql("SELECT name FROM mst_government_agencies WHERE id = ".$government_agencies_id);
            $rs_government_agencies = $db->getResult();
            $agencies = $rs_government_agencies[0]['name'];
        }

        $datatable->body(array(
            $participant_name,
            $agencies));
    }

    echo $datatable->show();
    ?>
</div>
<script>
    $(function () {
//        $('#list_search_by-pageListAlumnus').attr("class", "input-sm input-xsmall input-inline");
//        $('#search_pagination-pageListAlumnus').attr("class", "form-control");
//        $('#search_pagination-pageListAlumnus').attr("style", "height:18px;");
//        $('.pagination').attr("style", "margin-top:0");
    });
</script>