<?php

use app\Constant\IURLMemberConstant;

include_once getTemplatePath('page/content-page.html.php');
?>
<div id="content" class="container-fluid" style="padding-top: 130px;">
    <?php include_once FILE_PATH(PAGE_MEMBER_PATH); ?>
    <div class="signup col-md-9 member-page">
        <span style="font-weight:bold;"><?= lang('member.registration_activity'); ?></span>
        <hr>
        <div id="bodyPage">

        </div>
    </div>

    <input type="hidden" id="urlPage" name="urlPage" 
           value="<?= URL(IURLMemberConstant::ACTIVITY_REGISTRATION_TEMP_URL . '/list'); ?>"/>
    <script>
        $(function () {
            postAjaxPagination();
        });


        function pageParent() {
            $('#urlPage').val('<?= URL(IURLMemberConstant::ACTIVITY_REGISTRATION_TEMP_URL . '/list'); ?>');
            postAjaxPagination();
        }

        function pageUser(activity, registration) {
            $('#urlPage').val('<?= URL(IURLMemberConstant::ACTIVITY_REGISTRATION_TEMP_URL . '/list-user/'); ?>' + activity + '?registration_id=' + registration);
            postAjaxPagination();
        }
    </script>
    <?php include_once FILE_PATH(END_PAGE_MEMBER_PATH); ?>
</div>
<?php include_once getTemplatePath('page/end-content-page.html.php'); ?>
