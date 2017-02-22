<style>
    html{
        height: 100%
    }
    body{
        background-repeat: no-repeat;
        background-size: 100% 100%;
        background-image:url(<?= URL('assets/img/bg-blur.jpg'); ?>);
    }
</style>
<body class="login" style="  ">
    <!-- BEGIN LOGO -->
    <div class="logo">
        <a href="<?= URL(''); ?>">
            <img src="<?= URL('/assets/img/logotripoin.png'); ?>" height="150" alt="BKN" /> 
        </a>
    </div>
    <!-- END LOGO -->
    <!-- BEGIN LOGIN -->
    <div class="content" >
        <!-- BEGIN LOGIN FORM -->
        <div id="page-login">
            <form class="login-form" id="login-form"  action="<?= FULLURL('/login/proses'); ?>" method="POST" onsubmit="return false;">
                <div class="form-title">
                    <span class="form-title">Welcome.</span>
                    <span class="form-subtitle">Please login.</span>
                </div>
                <div class="alert alert-danger display-hide">
                    <!--<button class="close" data-close="alert"></button>-->
                    <!--<span> Enter any username and password. </span>-->
                </div>
                <div class="alert alert-success display-hide">
                    <!--<button class="close" data-close="alert"></button>-->
                    <!--<span> Enter any username and password. </span>-->
                </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Username</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" placeholder="Username" name="username" id="username" required/> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" placeholder="Password" name="password" id="password" required/> </div>
                <div class="form-actions">
                    <button type="submit" onsubmit="return false;" onclick="return loginPostAjax('login-form', 'page-login');" class="btn orange btn-block uppercase">Login</button>
                </div>
                <div class="form-actions">
                    <div class="pull-left">
                        <label class="rememberme mt-checkbox mt-checkbox-outline">
                            <input type="checkbox" name="remember" value="1" /> Remember me
                            <span></span>
                        </label>
                    </div>
                    <div class="pull-right forget-password-block">
                        <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>
                    </div>
                </div>
            </form>
        </div>
        <!-- END LOGIN FORM -->
        <!-- BEGIN FORGOT PASSWORD FORM -->
        <form class="forget-form" action="index.html" method="post">
            <div class="form-title">
                <span class="form-title">Forget Password ?</span>
                <span class="form-subtitle">Enter your e-mail to reset it.</span>
            </div>
            <div class="form-group">
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
            <div class="form-actions">
                <button type="button" id="back-btn" class="btn btn-default">Back</button>
                <button type="submit" class="btn btn-primary uppercase pull-right">Submit</button>
            </div>
        </form>
    </div>
    <div class="copyright hide"> <?= getSystemParameter('GENERAL_COPYRIGHT'); ?> </div>
    <?php include getAdminTemplatePath(FOOTER_SCRIPT); ?>
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

