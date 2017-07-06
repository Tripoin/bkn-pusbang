<?php
//$Datatable->createButton(true);
//$Datatable->headerButton(false);
//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "text-align:center;width:100px;", "text-align:center;width:100px;", "text-align:center;width:100px;"));
$Datatable->header(array(lang("master.curriculum_code"),
    lang("master.curriculum_name"),
    lang('master.curriculum_duration'),
    lang('master.participant_assessment_point'),
    lang('master.widyaswara_assessment_point'),
    lang("general.action")));


foreach ($list_data['item'] as $value) {

    $action_delete = Button()->url(URL(getAdminTheme() . $this->indexUrl . '/curriculum/' . $subjectId . '/new-edit/delete'))->value($value['curriculum_id'])->buttonDelete();
    $action_edit = Button()->url($this->editUrl)
            ->onClick("ajaxPostModalManual('".URL(getAdminTheme() . $this->indexUrl . '/curriculum/' . $subjectId . '/new-edit')."','action=edit&id_edit=".$value['curriculum_id']."&material_subject_id=".$value['material_subject_id'][$masterMaterialSubject->getId()]."')")
//            ->value($value['id'])
            ->buttonEdit();

    $data_unit = $db->selectById($masterUnit, $masterUnit->getId() . equalToIgnoreCase($value['unit_id']));
//    print_r($data_unit);
    $data_unit_name = "";
    if (!empty($data_unit)) {
        $data_unit_name = $data_unit[0][$masterUnit->getName()];
    }
    $action_ap_peserta = '<a href="javascript:void" onclick="postAjaxEdit(\''.URL(getAdminTheme() . $this->indexUrl . '/curriculum/' . $subjectId . '/aspek-penilaian-peserta').'\',\'curriculum_id='.$value['curriculum_id'].'&subject_name='.$value['name'].'\')">'.lang('general.detail').'</a>';
    $action_ap_widyaiswara = '<a href="javascript:void" onclick="postAjaxEdit(\''.URL(getAdminTheme() . $this->indexUrl . '/curriculum/' . $subjectId . '/aspek-penilaian-widyaiswara').'\',\'curriculum_id='.$value['curriculum_id'].'&subject_name='.$value['name'].'\')">'.lang('general.detail').'</a>';
    $Datatable->body(array($value['code'],
        $value['name'],
        $value['duration'] . ' ' . $data_unit_name,
        $action_ap_peserta,
        $action_ap_widyaiswara,
        $action_edit . $action_delete));
}
echo $Datatable->show();
//$action_kirim = Button()->onClick('ajaxPostModalManual(\'' . URL($this->admin_theme_url . $this->indexUrl . '/assignment/' . $activity . '/edit') . '\',\'id=0\')')->icon('fa fa-paper-plane')->label('Kirim Surat Penugasan  Widyaiswara')->title('Kirim Surat Penugasan Widyaiswara')->buttonManual();
?>
<script>
    $(function () {
//        postAjaxEdit();
        $('.portlet-title > div > span').html('<?= lang('master.curriculum'); ?>');
        initDetails();
    });
    function initDetails() {
        $('#actionHeader').html(comButtonCreate('<?= lang('general.create'); ?>', 'btn btn-warning', 'fa fa-plus', '') + " " + comButtonBack('<?= lang('general.back'); ?>', 'btn btn-danger', 'fa fa-back'));
        $('#buttonBack').attr("onclick", "pageParent()");
        $('#buttonCreate').attr("onclick", "ajaxPostModalManual('<?= URL(getAdminTheme() . $this->indexUrl . '/curriculum/' . $subjectId . '/new-edit'); ?>','action=create')");
//        $('#url_delete_collection').val('<?//= URL($this->admin_theme_url . $this->indexUrl . '/details/' . $id. '/deleteCollection'); ?>//');
    }
</script>
<!--<script>location.reload(true);</script>-->
