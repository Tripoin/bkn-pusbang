<?php
use app\Model\MasterCategoryAssess;
use app\Util\Database;

$data = new MasterCategoryAssess();
$db = new Database();

//$Datatable->createButton(false);
//$Datatable->headerButton(false);
//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->setPageTable('pageListNewEdit');
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "text-align:center;width:100px;"));
$Datatable->header(array(lang("master.assessment_category"),
    lang("master.field_description"),
    lang("general.action"),
));
$no = $list_data['from'];

$id_edit = "";
if (isset($_POST['id_edit'])) {
    $id_edit = "&id_edit=" . $_POST['id_edit'];
}
foreach ($list_data['item'] as $value) {

    if (!empty($value)) {
        $action = $Button->onClick('ajaxPostModalByValueHide(\'' . URL($this->admin_theme_url . $this->indexUrl .
                                        '/assessment-point/' . $subjectId . '/new-edit/create').'\',\'id='.$value[$data->getId()].$id_edit.'\')')
                        ->icon('fa fa-hand-o-left')->title(lang("general.choose"))->buttonCircleManual();
        
//        $data_assessment_category = $db->selectByID($data, $data->getId().  equalToIgnoreCase($value[$data->getParentId()]));
//        print_r($data_assessment_category);
        $assessment_category_name = "";
        if(isset($value[$data->getParentId()][$data->getName()])){
            $assessment_category_name = $value[$data->getParentId()][$data->getName()];
        }
        $Datatable->body(array(
            $assessment_category_name,
            $value[$data->getName()],
            $action));
        $no += 1;
    }
}

echo $Datatable->show();

$title_modal = lang('general.create');
if($_POST['action'] == 'edit'){
    $title_modal = lang('general.edit');
}
?>

<script>
    $(function () {
//        ajaxPostModalByValueHide
        $('#modal-title-self').html('<?= $title_modal; ?> <?=lang("general.aspects_assessment_of_activities");?>');
        initDetails();
    });
    function initDetails() {
        $('#actionHeader').html(comButtonCreate('<?= lang('general.create'); ?>', 'btn btn-warning', 'fa fa-plus', '') + " " + comButtonBack('<?= lang('general.back'); ?>', 'btn btn-danger', 'fa fa-back'));
        $('#buttonBack').attr("onclick", "pageParent()");
        $('#buttonCreate').attr("onclick", "ajaxPostModalManual('<?= URL(getAdminTheme() . $this->indexUrl . '/assessment-point/' . $subjectId . '/new-edit'); ?>','action=create')");
    }
</script>
<!--<script>location.reload(true);</script>-->
