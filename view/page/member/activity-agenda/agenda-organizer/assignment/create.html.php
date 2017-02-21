<div id="pageListUser">
    
</div>

<input type="hidden" id="urlPageManual-pageListUser" name="urlPageManual" value="<?= URL(getAdminTheme() . $this->indexUrl . '/assignment/'.$activity.'/list-user'); ?>"/>
<input type="hidden" id="pagination_parameter-pageListUser" value="&id=<?=$id;?>" />
<?= $Form->formFooter($this->updateUrl, ' '); ?>
<script>
    $(function () {
        postAjaxPaginationManual('pageListUser');
    });
//location.reload(true);
</script>
