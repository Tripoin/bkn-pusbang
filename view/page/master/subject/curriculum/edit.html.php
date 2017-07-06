
<?php
//$Datatable->createButton(false);
//$Datatable->headerButton(false);
//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "text-align:center;width:100px;"));
$Datatable->header(array(lang("master.material_subject_code"),
    lang("master.material_subject_name"),
    lang("master.material_subject_duration"),
    lang("general.action"),
));
$no = $list_data['from'];


foreach ($list_data['item'] as $value) {

    if (!empty($value)) {
        $action = $Button->onClick('ajaxPostModalByValueHide(\'' . URL($this->admin_theme_url . $this->indexUrl .
                                        '/curriculum/' . $subjectId) . '/create' .
                                '/' . $value[$data->getId()] . '?code=' . $value[$data->getCode()] . '&name=' . $value[$data->getName()] . '\')')
                        ->icon('fa fa-hand-o-left')->title(lang("general.choose"))->buttonCircleManual();
        $Datatable->body(array(
            $value[$data->getCode()],
            $value[$data->getName()],
            $value[$data->getDuration()],
            $action));
        $no += 1;
    }
}

echo $Datatable->show();
?>

<script>
    $(function () {
        $('#modal-title-self').html('<?= lang('general.edit'); ?> <?=lang("master.curriculum");?>');
        initDetails();
    });
    function initDetails() {
        
        $('#actionHeader').html(comButtonCreate('<?= lang('general.create'); ?>', 'btn btn-warning', 'fa fa-plus', '') + " " + comButtonBack('<?= lang('general.back'); ?>', 'btn btn-danger', 'fa fa-back'));
        $('#buttonBack').attr("onclick", "pageParent()");
        $('#buttonCreate').attr("onclick", "ajaxPostModalManual('<?= URL(getAdminTheme() . $this->indexUrl . '/curriculum/' . $subjectId . '/create/subject-list'); ?>','')");
    }
</script>
<!--<script>location.reload(true);</script>-->
