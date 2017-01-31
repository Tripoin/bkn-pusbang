<?php
//use app\Controller\Base\Controller;
//$contr = Controller::class;
?>
<head>

    <title><?=getSystemParameter('GENERAL_HEADER_TITLE');?> <?= getTitle(); ?> </title>
    <meta charset="utf-8"/>
    <META NAME="Author" CONTENT="Tala Indonesia"/>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type"/>
    <meta name="robots" content="index,follow" />
    <meta name="googlebot" content="index,follow" />
    <meta http-equiv="content-language" content="ID" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta charset="utf-8" />
    <!--<script async src="https://cdn.ampproject.org/v0.js"></script>-->

    <link rel="shortcut icon" href="<?= getTemplateURL(getSystemParameter('GENERAL_FAVICON')); ?>">

    <!--<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>-->
    <!--<link href="http://allfont.net/allfont.css?fonts=montserrat-light" rel="stylesheet" type="text/css" />-->
    <link href="<?= getTemplateURL('/assets/css/css.css'); ?>" rel="stylesheet"  type="text/css">
    <link href="<?= getTemplateURL('/assets/css/montserrat-light.css') ?>" rel="stylesheet"  type="text/css">
    
    
    <link href="<?= getTemplateURL('/import.css'); ?>?v=1" rel="stylesheet"  type="text/css">
    <?php 
    $them_style = getSystemParameter('GENERAL_THEME_STYLE'); 
//    if($them_style == 'default'){
    ?>
    <link href="<?= getTemplateURL('/assets/css/themes/mobile-'.$them_style.'.css?tripoin=').  createRandomBooking(); ?>" rel="stylesheet"  type="text/css">
    <link href="<?= getTemplateURL('/assets/css/themes/'.$them_style.'.css?tripoin=').  createRandomBooking(); ?>" rel="stylesheet"  type="text/css">
    <link href="<?= getTemplateURL('/assets/css/responsive.css'); ?>" rel="stylesheet"  type="text/css">
    <link href="<?= getTemplateURL('/assets/css/form.css'); ?>" rel="stylesheet"  type="text/css">
    
    <script src="<?= getTemplateURL('/assets/js/modernizr-2.8.3.min.js'); ?>"></script>
    <script src="<?= getTemplateURL('/assets/js/jquery-1.11.3.min.js'); ?>"></script>
    <script src="<?= URL('/assets/plugins/galleria/galleria-1.5.1.js'); ?>"></script>
    <script src="<?= URL('/assets/plugins/galleria/flickr/galleria.flickr.js'); ?>"></script>
</head>