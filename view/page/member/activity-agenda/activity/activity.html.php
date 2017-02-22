<?php

use app\Constant\IURLMemberConstant;
include_once getTemplatePath('page/content-page.html.php');
?>
<div id="content" class="container-fluid" style="padding-top: 130px;">
<?php include_once FILE_PATH(PAGE_MEMBER_PATH); ?>
    <div class="signup col-md-9 member-page">
        <fieldset id="account">
            <legend><?= lang('member.agenda_activity'); ?></legend>
            <div id="bodyPage">
                <div id="pageListActivity">

                </div>
            </div>
        </fieldset>
    </div>

    <input type="hidden" id="urlPageManual-pageListActivity" name="urlPageManual" value="<?= URL(IURLMemberConstant::ACTIVITY_URL . '/list'); ?>"/>
    <input type="hidden" id="pagination_parameter-pageListActivity" value="" />
    <script>
        $(function () {
            postAjaxPaginationManual('pageListActivity');
        });
    </script>

<?php include_once FILE_PATH(END_PAGE_MEMBER_PATH); ?>
</div>
<?php include_once getTemplatePath('page/end-content-page.html.php'); ?>
