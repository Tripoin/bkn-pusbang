<?php
//echo $_SESSION[SESSION_ADMIN_AUTHORIZATION];
//    $Datatable->styleHeader(array("text-align:center;"));
//$Datatable->deleteCollection(false);
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "text-align:center", "text-align:center", "text-align:center", "text-align:center;width:150px;"));
$Datatable->header(array(lang("general.no"),
    lang("master.assessment_category"),
    lang("master.field_description"),
    lang("general.action")));
$no = $list_data['from'];

//print_r($list_data['item']);
foreach ($list_data['item'] as $value) {
    $assessment_category_id = "";
    if (isset($value['category_assess_id'][$masterCategoryAssess->getId()])) {
        $assessment_category_id = $value['category_assess_id'][$masterCategoryAssess->getId()];
    }
    $action_delete = Button()->url(URL(getAdminTheme() . $this->indexUrl . '/assessment-point/' . $subjectId . '/new-edit/delete'))->value($assessment_category_id)->buttonDelete();
    $action_edit = Button()->url($this->editUrl)
            ->onClick("ajaxPostModalManual('" . URL(getAdminTheme() . $this->indexUrl . '/assessment-point/' . $subjectId . '/new-edit') . "','action=edit&id_edit=" . $assessment_category_id . "')")
            ->buttonEdit();
    $assessment_category = "";
    if (isset($value['category_assess_parent_id'][$masterCategoryAssess->getName()])) {
        $assessment_category = $value['category_assess_parent_id'][$masterCategoryAssess->getName()];
    }

    $Datatable->body(array($no,
        $assessment_category,
        $value['category_assess_name'],
        $action_edit . $action_delete));
    $no += 1;
}
echo $Datatable->show();
?>
<!--<script>location.reload(true);</script>-->
<script>
    $(function () {
//        postAjaxEdit();
        $('.portlet-title > div > span').html('<?= lang('general.aspects_assessment_of_activities'); ?>');
        initDetails();
    });
    function initDetails() {
        $('#actionHeader').html(comButtonCreate('<?= lang('general.create'); ?>', 'btn btn-warning', 'fa fa-plus', '') + " " + comButtonBack('<?= lang('general.back'); ?>', 'btn btn-danger', 'fa fa-back'));
        $('#buttonBack').attr("onclick", "pageParent()");
        $('#buttonCreate').attr("onclick", "ajaxPostModalManual('<?= URL(getAdminTheme() . $this->indexUrl . '/assessment-point/' . $subjectId . '/new-edit'); ?>','action=create')");
//        $('#url_delete_collection').val('<?//= URL($this->admin_theme_url . $this->indexUrl . '/details/' . $id. '/deleteCollection'); ?>//');
    }
</script>