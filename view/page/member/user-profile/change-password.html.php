
<?php
include_once getTemplatePath('page/content-page.html.php');
    echo '<div id="content" class="container-fluid" style="padding-top: 130px;">
    
</div>';
?>
<?php include_once FILE_PATH(PAGE_MEMBER_PATH); ?>
<div class="signup col-md-9 member-page">
    <form id="signup_form" autocomplete="off" action="<?= URL('page/member/user-profile/change-password/proses'); ?>" method="POST" class="form" onsubmit="return false;">
        <!--<p><?= lang('general.message_register_have_account'); ?></p>-->
        <fieldset id="account">
            <?php
            $exp_name = explode(" ", $cek_user_profile[0][$sup->getName()]);
            ?>
            <legend><?= lang('general.change_password'); ?></legend>
            <div class="form-group col-md-24 required">
                <label for="input-password-old"><?= lang('user.password_old'); ?></label>
                <input type="password"  name="password-old" placeholder="<?= lang('user.password_old'); ?>" id="password-old" class="form-control" autocomplete="off" maxlength="32"/>
            </div>
            <div class="form-group col-md-24 required">
                <label for="input-password-new"><?= lang('user.password_new'); ?></label>
                <input type="password" name="password-new" placeholder="<?= lang('user.password_new'); ?>" id="password-new" class="form-control" autocomplete="off" maxlength="32"/>
            </div>
            <div class="form-group col-md-24 required">
                <label for="input-password-renew"><?= lang('user.password_renew'); ?></label>
                <input type="password" name="password-renew" placeholder="<?= lang('user.password_renew'); ?>" id="password-renew" class="form-control" autocomplete="off" maxlength="96"/>
            </div>
            
        </fieldset>

        <button id="btn_signup" class="btn btn-danger" type="submit" onsubmit="return false;" onclick="return postAjax('signup_form', 'signup_form')" class="btn"><?= lang('general.save'); ?></button>
    </form>
</div>
<?php include_once FILE_PATH(END_PAGE_MEMBER_PATH); ?>
<?php include_once getTemplatePath('page/end-content-page.html.php');  ?>
