<?php

use app\Constant\IURLMemberConstant;

include_once getTemplatePath('page/content-page.html.php');
?>
<div id="content" class="container-fluid" style="padding-top: 130px;">
    <?php include_once FILE_PATH(PAGE_MEMBER_PATH); ?>
    <div class="signup col-md-9 member-page">
        <fieldset id="account">
            <legend style="font-weight: bold;"><?= lang('survey.survey_organizer'); ?></legend>
            <div id="bodyPage">
            </div>
        </fieldset>
    </div>
    <input type="hidden" id="urlPage" name="urlPage" value="<?= URL(IURLMemberConstant::SURVEY_ORGANIZER_URL . '/list'); ?>"/>
    <script>
        $(function () {
            postAjaxPagination();
        });
    </script>

    <?php include_once FILE_PATH(END_PAGE_MEMBER_PATH); ?>
</div>
<?php include_once getTemplatePath('page/end-content-page.html.php'); ?>
