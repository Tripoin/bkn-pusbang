<head>
    <?php
//    COMPANY_NAME
    $logo_text = COMPANY_NAME;
    if (getSystemParameter('SYSTEM_ADMINISTRATOR_COMPANY_NAME') != '') {
        $logo_text = getSystemParameter('SYSTEM_ADMINISTRATOR_COMPANY_NAME');
    }
    ?>
    <title><?= $logo_text; ?> | <?=getTitle();?></title>
    <meta charset="utf-8"/>
    <META NAME="Author" CONTENT="Tripoin Team @Tripoin Inc."/>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type"/>
    <meta name="robots" content="index,follow" />
    <meta name="googlebot" content="index,follow" />
    <meta http-equiv="content-language" content="ID" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta charset="utf-8" />
    <!--<script async src="https://cdn.ampproject.org/v0.js"></script>-->

    <link href="<?= getAdminTemplateURL('/assets/css/opensans.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= URL('/assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= URL('/assets/plugins/bootstrap/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= getAdminTemplateURL('/assets/css/toastr.min.css'); ?>" rel="stylesheet" type="text/css">

    <link href="<?= URL('/assets/plugins/simple-line-icons/simple-line-icons.min.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= URL('/assets/plugins/bootstrap-switch/css/bootstrap-switch.min.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= URL('/assets/plugins/datatables/datatables.min.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= URL('/assets/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= URL('/assets/plugins/bootstrap-sweetalert/sweetalert.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= URL('/assets/plugins/bootstrap-toastr/toastr.min.css'); ?>" rel="stylesheet" type="text/css">

    <link href="<?= URL('/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= URL('/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>" rel="stylesheet" type="text/css">

    <link href="<?= URL('/assets/plugins/jquery-nestable/jquery.nestable.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= URL('/assets/plugins/select2/css/select2.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= URL('/assets/plugins/select2/css/select2-bootstrap.min.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= URL('/assets/plugins/typeahead/typeahead.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= getAdminTemplateURL('/assets/css/components.min.css'); ?>?tripoin=<?= createRandomBooking(); ?>" rel="stylesheet" type="text/css">
    <link href="<?= getAdminTemplateURL('/assets/css/plugins.min.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= getAdminTemplateURL('/assets/css/layout.min.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= getAdminTemplateURL('/assets/css/themes/' . getSystemParameter('SYSTEM_ADMINISTRATOR_THEME_STYLE') . '.css'); ?>?tripoin=<?= createRandomBooking(); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= getAdminTemplateURL('/assets/css/custom.min.css'); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= getAdminTemplateURL('/assets/css/style.css'); ?>?tripoin=<?= createRandomBooking(); ?>" rel="stylesheet" type="text/css"/>



    <script src="<?= getAdminTemplateURL('/assets/js/jquery-1.11.2.min.js'); ?>"></script>



<!--<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>-->
</head>