<!doctype html>
<html lang="en">
<!--   -->
    <?php
    include getAdminTemplatePath(HEAD_SCRIPT_PATH);
    if (isset($_SESSION[SESSION_LOCK_SCREEN])) {
        if ($_SESSION[SESSION_LOCK_SCREEN] == true) {
            echo '<link href="' . getAdminTemplateURL('/assets/css/opensans.css') . '" rel="stylesheet" type="text/css">';
//            echo getAdminTemplateURL('/assets/css/lock.min.css');
            echo '<link href="' . getAdminTemplateURL('/assets/css/lock.min.css') . '?tripoin=' . createRandomBooking() . '" rel="stylesheet" type="text/css">';
            include getAdminTemplatePath(LOCK_SCREEN_PATH);
        } else {
            if (isset($_SESSION[SESSION_USERNAME]) && isset($_SESSION[SESSION_GROUP])) {
                if ($_SESSION[SESSION_GROUP] != 1) {
                    include getAdminTemplatePath(CONTENT_PATH);
                } else {
                    echo '<link href="' . getAdminTemplateURL('/assets/css/login-2.min.css') . '?tripoin=' . createRandomBooking() . '" rel="stylesheet" type="text/css">';
//                    echo STYLE('/assets/css/login-2.min.css');
                    include getAdminTemplatePath(LOGIN_PATH);
                }
            } else {
//                echo STYLE('/assets/css/login-2.min.css');
                echo '<link href="' . getAdminTemplateURL('/assets/css/login-2.min.css') . '?tripoin=' . createRandomBooking() . '" rel="stylesheet" type="text/css">';
                include getAdminTemplatePath(LOGIN_PATH);
//        echo SCRIPTS('/assets/js/login.min.js');
            }
        }
    } else {

        if (isset($_SESSION[SESSION_USERNAME]) && isset($_SESSION[SESSION_GROUP])) {
            if ($_SESSION[SESSION_GROUP] != 1) {
                include getAdminTemplatePath(CONTENT_PATH);
            } else {
//                echo STYLE('/assets/css/login-2.min.css');
                echo '<link href="' . getAdminTemplateURL('/assets/css/login-2.min.css') . '?tripoin=' . createRandomBooking() . '" rel="stylesheet" type="text/css">';
                include getAdminTemplatePath(LOGIN_PATH);
            }
        } else {
//            echo STYLE('/assets/css/login-2.min.css');
            echo '<link href="' . getAdminTemplateURL('/assets/css/login-2.min.css') . '?tripoin=' . createRandomBooking() . '" rel="stylesheet" type="text/css">';
            include getAdminTemplatePath(LOGIN_PATH);
//        echo SCRIPTS('/assets/js/login.min.js');
        }
    }
    ?>
     <div id="refresh-loader" class="background-refresh-overlay">
        <div class="page-spinner-bar"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>
    </div>
    <script>
        $(function () {
            $('#refresh-loader').fadeOut('slow', function () {
                $(this).remove();
            });
        });
    </script>
</html>