
<?php

use app\Model\SecurityUser;
use app\Model\SecurityUserProfile;
use app\Util\Database;

$db = new Database();
$sup = new SecurityUserProfile();
$su = new SecurityUser();

$rs_user = $db->selectByID($su, $su->getCode() . "='" . $_SESSION[SESSION_USERNAME] . "'");
$rs_user_profile = $db->selectByID($sup, $sup->getUser()->getId() . "='" . $rs_user[0][$sup->getUser()->getId()] . "'");
?>
<body class="login">
<div class="page-lock">
    <div class="page-logo">
        <a class="brand" href="<?= URL(); ?>">
            <img src="<?= URL('/assets/images/logo.png'); ?>" alt="TALA INDONESIA ADMIN" > </a>
    </div>
    <div class="page-body">
        <div class="lock-head"> Locked </div>
        <div class="lock-body">
            <div class="alert alert-danger display-hide">
                <!--<button class="close" data-close="alert"></button>-->
                <!--<span> Enter any username and password. </span>-->
            </div>
            <div class="alert alert-success display-hide">
                <!--<button class="close" data-close="alert"></button>-->
                <!--<span> Enter any username and password. </span>-->
            </div>
            <div class="pull-left lock-avatar-block">
                <img <?= notFoundImg('user.png'); ?> src="<?= URL('assets/img/photos.jpg'); ?>" class="lock-avatar"> 
            </div>
            <form id="login-form"  class="lock-form pull-left" action="<?= URL('/page/login/proses'); ?>" method="POST" onsubmit="return false;">
                <h4><?= $rs_user_profile[0][$sup->getFullname()]; ?></h4>
                <div class="form-group">
                    <input type="hidden" name="username" id="username" value="<?=$_SESSION[SESSION_USERNAME];?>"/>
                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password"> </div>
                <div class="form-actions">
                    <button type="submit" onsubmit="return false;" onclick="return loginPostAjax('login-form', 'page-login');" class="btn red uppercase">Login</button>
                </div>
            </form>
        </div>
        <div class="lock-bottom">
            <a href="<?= URL('page/logout'); ?>">Not <?= $rs_user_profile[0][$sup->getFullname()]; ?>?</a>
        </div>
    </div>
    <div class="page-footer-custom"><?= getOption('GENERAL_COPYRIGHT'); ?></div>
</div>
<?php include FILE_PATH(FOOTER_SCRIPT_PATH); ?>
    <script>
        $(function () {

            $(".login-form").validate({
                errorElement: "span",
                errorClass: "help-block",
                focusInvalid: !1,
                rules: {
                    username: {
                        required: !0
                    },
                    password: {
                        required: !0
                    },
                    remember: {
                        required: !1
                    }
                },
                messages: {
                    username: {
                        required: "Username is required."
                    },
                    password: {
                        required: "Password is required."
                    }
                },
                invalidHandler: function (e, r) {
//                    $(".alert-danger", $(".login-form")).show()
                    $(".alert-danger").show();
                    $(".alert-danger").html('Enter any username and password. ');

                },
                highlight: function (e) {
                    $(e).closest(".form-group").addClass("has-error")
                },
                success: function (e) {
                    e.closest(".form-group").removeClass("has-error"), e.remove()
                },
                errorPlacement: function (e, r) {
                    e.insertAfter(r.closest(".input-icon"))
                },
                submitHandler: function (e) {
//                    e.submit()
                    loginPostAjax('login-form', 'page-login');
                }
            }), $(".login-form input").keypress(function (e) {
                return 13 == e.which ? ($(".login-form").validate().form() && $(".login-form").submit(), !1) : void 0
            })
        });
    </script>
    </body>