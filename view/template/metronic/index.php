<!doctype html>
<html lang="en">
    <?php
    include getAdminTemplatePath(HEAD_SCRIPT_PATH);
    if (isset($_SESSION[SESSION_LOCK_SCREEN])) {
        if ($_SESSION[SESSION_LOCK_SCREEN] == true) {
            echo '<link href="'.getAdminTemplateURL('/assets/css/opensans.css').'" rel="stylesheet" type="text/css">';
//            echo getAdminTemplateURL('/assets/css/lock.min.css');
            include getAdminTemplatePath(LOCK_SCREEN_PATH);
        } else {
            if (isset($_SESSION[SESSION_USERNAME]) && isset($_SESSION[SESSION_GROUP])) {
                if ($_SESSION[SESSION_GROUP] != 1) {
                    include getAdminTemplatePath(CONTENT_PATH);
                } else {
                    echo '<link href="'.getAdminTemplateURL('/assets/css/login-2.min.css').'" rel="stylesheet" type="text/css">';
//                    echo STYLE('/assets/css/login-2.min.css');
                    include getAdminTemplatePath(LOGIN_PATH);
                }
            } else {
//                echo STYLE('/assets/css/login-2.min.css');
                echo '<link href="'.getAdminTemplateURL('/assets/css/login-2.min.css').'" rel="stylesheet" type="text/css">';
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
                echo '<link href="'.getAdminTemplateURL('/assets/css/login-2.min.css').'" rel="stylesheet" type="text/css">';
                include getAdminTemplatePath(LOGIN_PATH);
            }
        } else {
//            echo STYLE('/assets/css/login-2.min.css');
            echo '<link href="'.getAdminTemplateURL('/assets/css/login-2.min.css').'" rel="stylesheet" type="text/css">';
            include getAdminTemplatePath(LOGIN_PATH);
//        echo SCRIPTS('/assets/js/login.min.js');
        }
    }
    ?>
</html>