<div id="pageListLOV<?=$name;?>" style="margin:20px;"></div>
<input type="hidden" id="urlPageManual-pageListLOV<?=$name;?>" name="urlPageManual" 
       value="<?= URL('/search/lov'); ?>"/>
<input type="hidden" id="pagination_parameter-pageListLOV<?=$name;?>" value="&search=<?=$name;?>" />
<script>
    $(function () {
        postAjaxPaginationManual('pageListLOV<?=$name;?>');
    });
</script>
