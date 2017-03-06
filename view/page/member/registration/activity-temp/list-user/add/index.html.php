<?php
use app\Constant\IURLMemberConstant;
?>
<div id="pageListPesertaAdd" style="margin:20px;"></div>
<input type="hidden" id="urlPageManual-pageListPesertaAdd" name="urlPageManual" 
       value="<?= URL(IURLMemberConstant::ACTIVITY_REGISTRATION_TEMP_LIST_USER_ADD_URL . '/' . $activity . '/list'); ?>"/>
<input type="hidden" id="pagination_parameter-pageListPesertaAdd" value="&registration_id=<?=$_POST['registration_id'];?>" />
<script>
    $(function () {
//        alert('masuk');
        postAjaxPaginationManual('pageListPesertaAdd');
    });
</script>
