<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
    <div class="page-wrapper">
        <?php include getAdminTemplatePath(HEAD_PATH); ?>
        <div class="clearfix"></div>
        <div class="page-container">
            <?php include getAdminTemplatePath(HEAD_MENUBAR_PATH); ?>
            <?php include getAdminTemplatePath(BODY_CONTENT_PATH); ?>
        </div>
        <?php include getAdminTemplatePath(FOOTER_PATH); ?>
    </div>

    <?php // echo FILE_PATH('view/template/footer_script.html.php');?>
    <!--<div class="section-space"></div>-->

    <?php include getAdminTemplatePath(FOOTER_SCRIPT); ?>

    <script type="text/javascript">
        $().ready(function () {
        });
    </script>
    <?php // include FILE_PATH(FOOTER_MODAL); ?>


</body>