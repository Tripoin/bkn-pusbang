<div id="pageListPost">
    
</div>

<input type="hidden" id="urlPageManual-pageListPost" name="urlPageManual" value="<?= URL($this->admin_theme_url . '/posting/post-assign/edit/list-post-assign'); ?>"/>
<input type="hidden" id="pagination_parameter-pageListPost" value="&id=<?= $_POST['id']; ?>" />
<?= $Form->formFooter($this->updateUrl, ' '); ?>
<script>
    $(function () {
        postAjaxPaginationManual('pageListPost');
    });
//location.reload(true);
</script>
