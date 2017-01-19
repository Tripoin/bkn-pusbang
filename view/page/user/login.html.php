<form role="form" id="form-newedit" action="#" onsubmit="return false;" method="POST" novalidate="novalidate">
    <div id="form-message">
    </div>
    <div class="signup">
        <div class="row">
            <div class="col-md-6">
                <?php
                echo $Form->id('username')->placeholder(lang('security.email') . ' ....')
                        ->title(lang('security.email'))
                        ->textbox();
                ?>
                <?php
                echo $Form->id('password')->placeholder(lang('security.password') . ' ....')
                        ->title(lang('security.password'))
                        ->textpassword();
                ?>
                <button type="button" class="btn btn-danger"><?= lang('general.sign_in'); ?></button>
            </div>
            <div class="col-md-6">
                <p style="margin: 15%;">
                    Anda Belum Memiliki Akun??<br/>
                    <button type="button" class="btn btn-danger" onclick="ajaxPostModal('<?=URL('member/register');?>','<?= lang('general.sign_up'); ?>')"><?= lang('general.sign_up'); ?></button>
                </p>
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