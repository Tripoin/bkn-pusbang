<!doctype html>
<html lang="en">
    <?= contentPage(); ?>
    <?= pageBody(); ?>
    <?= $Form->formHeader(); ?>

    <?php echo $Form->id('old_password')->type('password')->title(lang('security.old_password'))->placeholder(lang('security.holder_old_password'))->textbox(); ?>
    <?php echo $Form->id('new_password')->type('password')->title(lang('security.new_password'))->placeholder(lang('security.holder_new_password'))->textbox(); ?>
    <?php echo $Form->id('renew_password')->type('password')->title(lang('security.renew_password'))->placeholder(lang('security.holder_renew_password'))->textbox(); ?>

    <?= $Form->formFooter(null, null, "postFormAjaxPost('" . FULLURL('/update') . "')"); ?>
    <script>
        $(function () {

            $('#buttonBack').remove();
    //        $('.datepicker').datepicker();

        })
    </script>
    <?= endPageBody(); ?>
    <?= endContentPage(); ?>
</html>