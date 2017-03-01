<form role="form" id="login_form" action="<?= URL('/page/login/proses'); ?>" onsubmit="return false;" method="POST" novalidate="novalidate">
    <div id="form-message-login">
    </div>
    <div class="signup">
        <div class="row">
            <div class="col-md-12">
                <?php
                echo Form()->id('username')->placeholder(lang('security.id_username') . ' ....')
                        ->title(lang('security.id_username'))
                        ->textbox();
                ?>
                <?php
                echo Form()->id('password')->placeholder(lang('security.password') . ' ....')
                        ->title(lang('security.password'))
                        ->textpassword();
                ?>
                <?php
                echo Form()->id('security_code')->placeholder(lang('general.security_code') . ' ....')
                        ->title(lang('general.security_code'))
                        ->formLayout('vertical')
                        ->captcha();
                ?>
                <div class="col-md-12">
                    <button type="button" style="width:100%" onclick="return postAjax('login_form', 'form-message-login')"  
                            class="btn btn-danger"><?= strtoupper(lang('general.sign_in')); ?></button>
                </div>
            </div>

        </div>
    </div>
</form>
<script>
    $(function () {
//        location.reload(true);
        $('.myModal_self-title').attr('class', 'modal-dialog modal-sm');
        $('.modal-dialog').attr('class', 'modal-dialog modal-sm');
        $('[rel="tooltip"]').tooltip();
        $("#username").on('keyup', function (e) {
            if (e.keyCode == 13) {
                postAjax('login_form', 'form-message-login');
            }
        });
        $("#password").on('keyup', function (e) {
            if (e.keyCode == 13) {
                postAjax('login_form', 'form-message-login');
            }
        });
        $("#security_code").on('keyup', function (e) {
            if (e.keyCode == 13) {
                postAjax('login_form', 'form-message-login');
            }
        });
    })
</script>