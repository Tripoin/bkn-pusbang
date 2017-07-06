<?php

use app\Util\Database;
use app\Model\MasterCategoryAssess;
use app\Model\LinkTrainerAssess;

$db = new Database();
$db->connect();
$masterCategoryAssess = new MasterCategoryAssess();
$linkTrainerAssess = new LinkTrainerAssess();

$curriculumId = $_POST['curriculum_id'];


$db->select($linkTrainerAssess->getEntity(), ''
        . $masterCategoryAssess->getEntity() . DOT . $masterCategoryAssess->getId() . ' as id,'
        . $masterCategoryAssess->getEntity() . DOT . $masterCategoryAssess->getName() . ' as label', array($masterCategoryAssess->getEntity()), 
        $linkTrainerAssess->getEntity() . DOT . $linkTrainerAssess->getCategoryAssessId() . EQUAL . $masterCategoryAssess->getEntity() . DOT . $masterCategoryAssess->getId()
        . " AND " . $linkTrainerAssess->getEntity() . DOT . $linkTrainerAssess->getCurriculumId() . equalToIgnoreCase($curriculumId)
);
$data_link_assess = $db->getResult();

$category_asses_id = "";
foreach ($data_link_assess as $value_assess) {
    $category_asses_id .= $value_assess['id'] . ",";
}
$category_asses_id2 = rtrim($category_asses_id, ",");
$str_query_cai = "";
if(!empty($category_asses_id2)){
    $str_query_cai = " AND " . $masterCategoryAssess->getId() . " NOT IN (" . $category_asses_id2 . ")";
}

$data_category_asses = getLov($masterCategoryAssess, $masterCategoryAssess->getParentId() . equalToIgnoreCase(2)
        .$str_query_cai);
//print_r($data_category_asses);
?>
<?= Form()->formHeader(); ?>
<?php
//echo Form()->title('Aspek Penilaian Peserta Materi :')->label($_POST['subject_name'])->formLayout('form-horizontal')->labels();
echo Form()->idLeft('leftBox[]')->idRight('rightBox[]')
        ->titleLeft(lang('general.aspects_of_assessed'))->titleRight(lang('general.aspects_to_be_assessed'))
        ->dataLeft($data_category_asses)->dataRight($data_link_assess)
        ->listBoxAssignment();
?>
<input type="hidden" id="curriculum_id" name="curriculum_id" value="<?= $_POST['curriculum_id']; ?>"/>
<?= Form()->formFooter(null, null, "postFormAjaxPost('" . URL(getAdminTheme() . $this->indexUrl . '/curriculum/' . $subjectId . '/aspek-penilaian-widyaiswara/save') . "')"); ?>
<script>
    $(function () {
        $('#createToRightleftBox').attr("onclick", "createBox()");

//        postFormAjaxPost()
//        postAjaxEdit();
        $('.portlet-title > div > span').html('Aspek Penilaian Widyaiswara Materi : <span style="color:black"><?= $_POST['subject_name']; ?></span>');
        initDetails();
    });
    function initDetails() {
        $('#actionHeader').html(comButtonBack('<?= lang('general.back'); ?>', 'btn btn-danger', 'fa fa-back'));
        $('#buttonBack').attr("onclick", "pageCurriculum('<?= $subjectId; ?>')");
    }

    function createBox() {
        var id = addGroupSelect('leftBox', 'rightBox');
        ajaxPostBox('', "id=" + id);
//        alert(txt);
    }

    function ajaxPostBox(page, value) {
        $.ajax({
            type: "POST",
            url: page,
            data: value,
            success: function (data) {
                console.log(data.responseText);
            },
            error: function (data) {
                console.log(data.responseText);
            },
        });
    }
</script>