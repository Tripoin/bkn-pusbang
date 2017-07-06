<div id="pageListNewEdit">

</div>
<?php
$id_edit = "";
if (isset($_POST['id_edit'])) {
    $id_edit = "&id_edit=" . $_POST['id_edit'];
}
?>
<input type="hidden" id="urlPageManual-pageListNewEdit" name="urlPageManual" 
       value="<?= URL(getAdminTheme() . $this->indexUrl . '/assessment-point/' . $subjectId . '/new-edit/list'); ?>"/>
<input type="hidden" id="pagination_parameter-pageListNewEdit" value="&action=<?= $_POST['action']; ?><?=$id_edit;?>" />
<script>
    $(function () {
        postAjaxPaginationManual('pageListNewEdit');
    });
//location.reload(true);
</script>
