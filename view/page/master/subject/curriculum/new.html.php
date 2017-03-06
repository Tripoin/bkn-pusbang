<?= Form()->formHeader(); ?>

<?php
//$Datatable->createButton(true);
//$Datatable->headerButton(false);
//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "text-align:center;width:100px;"));
$Datatable->header(array( lang("master.curriculum_code"),
    lang("master.curriculum_name"),
    lang('master.curriculum_duration'),
    lang('master.participant_assessment_point'),
    lang('master.widyaswara_assessment_point'),
    lang("general.action")));


foreach ($list_data['item'] as $value) {

    $action_delete = Button()->url($this->deleteUrl)->value($value[$masterCurriculum->getId()])->buttonDelete();
    $action_edit =  Button()->url($this->editUrl)->value($value[$masterCurriculum->getId()])->buttonEdit();
print_r($value);
    $Datatable->body(array('a',
        'a',
        'a',
        'uhuy',
        'uhuy',
       'pilih'));

}
echo $Datatable->show();
//
//$action_kirim = Button()->onClick('ajaxPostModalManual(\'' . URL($this->admin_theme_url . $this->indexUrl . '/assignment/' . $activity . '/edit') . '\',\'id=0\')')->icon('fa fa-paper-plane')->label('Kirim Surat Penugasan  Widyaiswara')->title('Kirim Surat Penugasan Widyaiswara')->buttonManual();
?>


<?php // echo Form()->textbox();?>
<?= Form()->formFooter($this->insertUrl); ?>
<script>
    $(function () {
        initDetails();
    });
    </script>
