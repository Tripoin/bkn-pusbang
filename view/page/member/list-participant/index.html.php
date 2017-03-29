<?php

use app\Constant\IURLMemberConstant;
include_once getTemplatePath('page/content-page.html.php');
?>
<div id="content" class="container-fluid" style="padding-top: 130px;">
<?php include_once FILE_PATH(PAGE_MEMBER_PATH); ?>
    <div class="signup col-md-9 member-page">
        <fieldset id="account">
            <legend><?= lang('member.list_participant'); ?></legend>
            <div id="bodyPage">
                <div id="pageListParticipant">

                </div>
            </div>
        </fieldset>
    </div>
    <input type="hidden" id="urlPageManual-pageListParticipant" name="urlPageManual" value="<?= URL(IURLMemberConstant::LIST_PARTICIPANT_URL . '/list'); ?>"/>
    <input type="hidden" id="pagination_parameter-pageListParticipant" value="" />
    <script>
        $(function () {
            postAjaxPaginationManual('pageListParticipant');
        });
    </script>

<?php include_once FILE_PATH(END_PAGE_MEMBER_PATH); ?>
</div>
<?php include_once getTemplatePath('page/end-content-page.html.php'); ?>
