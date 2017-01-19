<form role="form" id="form-newedit" action="#" onsubmit="return false;" method="POST" novalidate="novalidate">
    <div id="form-message">
    </div>
    <div class="signup">
        <div class="row">
            <div class="col-md-12">
            <legend>
                <?= lang('general.message_register_have_account'); ?> <button type="button" class="btn btn-danger btn-sm"><?= lang('general.sign_in'); ?></button>
            </legend>
            </div>
            <div class="col-md-6">
                <?php
                echo $Form->id('firstname')->placeholder(lang('security.firstname') . ' ....')
                        ->title(lang('security.firstname'))
                        ->textbox();
                ?>
                <?php
                echo $Form->id('email')->placeholder(lang('security.email') . ' ....')
                        ->title(lang('security.email'))
                        ->textbox();
                ?>
                <?php
                echo $Form->id('password')->placeholder(lang('security.password') . ' ....')
                        ->title(lang('security.password'))
                        ->textpassword();
                ?>
                <button type="button" class="btn btn-danger" onclick="ajaxPostModal('<?= URL('member/register'); ?>', '<?= lang('general.sign_up'); ?>')"><?= lang('general.sign_up'); ?></button>
            </div>
            <div class="col-md-6">
                <?php
                echo $Form->id('lastname')->placeholder(lang('security.lastname') . ' ....')
                        ->title(lang('security.lastname'))
                        ->textbox();
                ?>
                <?php
                echo $Form->id('phone')->placeholder(lang('security.phone') . ' ....')
                        ->title(lang('security.phone'))
                        ->textbox();
                ?>
                <?php
                echo $Form->id('confirm_password')->placeholder(lang('security.confirm_password') . ' ....')
                        ->title(lang('security.confirm_password'))
                        ->textpassword();
                ?>
            </div>
        </div>
    </div>
</form>
<script>
    $(function () {
//        location.reload(true);
        $('[rel="tooltip"]').tooltip();
    })
</script>