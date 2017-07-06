<div id="pageListNewEdit">

</div>
<?php
$id_edit = "";
if (isset($_POST['id_edit'])) {
    $id_edit = "&id_edit=" . $_POST['id_edit'];
}

$material_subject_id = "";
if (isset($_POST['material_subject_id'])) {
    $material_subject_id = "&material_subject_id=" . $_POST['material_subject_id'];
}

?>
<input type="hidden" id="urlPageManual-pageListNewEdit" name="urlPageManual" 
       value="<?= URL(getAdminTheme() . $this->indexUrl . '/curriculum/' . $subjectId . '/new-edit/list'); ?>"/>
<input type="hidden" id="pagination_parameter-pageListNewEdit" value="&action=<?= $_POST['action']; ?><?=$id_edit;?><?=$material_subject_id;?>" />
<script>
    $(function () {
        postAjaxPaginationManual('pageListNewEdit');
    });
//location.reload(true);
</script>
