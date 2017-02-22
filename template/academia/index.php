<!doctype html>
<html class="no-js" lang="">
    <?php
    include_once getTemplatePath(HEAD_SCRIPT_PATH);
    ?>
    <body>
        <?php include_once getTemplatePath(HEAD_PATH); ?>

        <?php include_once getTemplatePath(HEAD_MENUBAR_PATH); ?>
        <?php include_once getTemplatePath(HEAD_MENUBAR_MOBILE_PATH); ?>
        <?php include_once getTemplatePath(SLIDER_PATH); ?>
        
        <?php include_once getTemplatePath('page/content.html.php'); ?>
        
        <?php include_once getTemplatePath(FOOTER_PATH); ?>
        <?php include_once getTemplatePath(FOOTER_SCRIPT); ?>
    </body>
</html>