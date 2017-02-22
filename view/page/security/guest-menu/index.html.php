<?php
$sys_url_admin = getSystemParameter('SYSTEM_ADMINISTRATOR_URL');
?>
<!doctype html>
<html lang="en">
    <?= contentPage(); ?>
    <?= pageAutoCrudBody(); ?>
    <div id="bodyPage">
        
    </div>
    <script>
        $(function () {
            //        location.reload(true);
            postAjaxEdit('<?=URL($sys_url_admin.'/security/function-assignment/edit');?>','id=1');
//            $('#actionHeader').html('');
        });
    </script>
    <?= endPageBody(); ?>
    <?= endContentPage(); ?>
</html>