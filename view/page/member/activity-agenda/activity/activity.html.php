
<?php
include_once getTemplatePath('page/content-page.html.php');
echo '<div id="content" class="container-fluid" style="padding-top: 130px;">
    
</div>';
?>
<?php include_once FILE_PATH(PAGE_MEMBER_PATH); ?>
<div class="signup col-md-9"  style="box-shadow: 0px 0px 0px 1px #B7B7B7;text-align: left;margin-top: -100px;">
    <fieldset id="account">
        <legend><?= lang('member.agenda_activity'); ?></legend>
        <div id="bodyPage">
            <div id="pageListActivity">

            </div>
        </div>
    </fieldset>
</div>

<input type="hidden" id="urlPageManual-pageListActivity" name="urlPageManual" value="<?= URL('member/activity-agenda/activity/list'); ?>"/>
<input type="hidden" id="pagination_parameter-pageListActivity" value="" />
<script>
    $(function () {
        postAjaxPaginationManual('pageListActivity');
    });
</script>

<?php include_once FILE_PATH(END_PAGE_MEMBER_PATH); ?>
<?php include_once getTemplatePath('page/end-content-page.html.php'); ?>
