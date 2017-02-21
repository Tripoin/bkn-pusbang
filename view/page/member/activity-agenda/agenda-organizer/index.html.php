<?php

use app\Constant\IURLMemberConstant;

include_once getTemplatePath('page/content-page.html.php');
?>
<div id="content" class="container-fluid" style="padding-top: 130px;">
    <?php include_once FILE_PATH(PAGE_MEMBER_PATH); ?>
    <div class="signup col-md-9 member-page">
        <fieldset id="account">
            <legend style="font-weight: bold;"><?= lang('member.agenda_organizer'); ?></legend>
            <div id="bodyPage">
                <!--<div id="pageListAgendaOrganizer">-->

                <!--</div>-->
            </div>
        </fieldset>
    </div>
    <input type="hidden" id="urlPage" name="urlPage" value="<?= URL(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/list'); ?>"/>
        <!--<input type="hidden" id="urlPageManual-pageListAgendaOrganizer" name="urlPageManual" value="<?= URL(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/list'); ?>"/>-->
        <!--<input type="hidden" id="pagination_parameter-pageListAgendaOrganizer" value="" />-->
    <script>
        $(function () {
//            postAjaxPaginationManual('pageListAgendaOrganizer');
            postAjaxPagination();
        });
    </script>

    <?php include_once FILE_PATH(END_PAGE_MEMBER_PATH); ?>
</div>
<?php include_once getTemplatePath('page/end-content-page.html.php'); ?>
