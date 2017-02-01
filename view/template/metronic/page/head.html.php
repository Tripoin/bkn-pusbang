<?php

use app\Util\Database;

$db = new Database();
$admin_url = getAdminTheme();
?>
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="<?= URL(getAdminTheme()); ?>" class="">
                <?php
                $logo_text = COMPANY_NAME;
                if (getSystemParameter('SYSTEM_ADMINISTRATOR_COMPANY_NAME') != '') {
                    $logo_text = getSystemParameter('SYSTEM_ADMINISTRATOR_COMPANY_NAME');
                }
                ?>

                <div style="font-size: 25px;font-family: 'deftone-stylus';margin-top: -6px;" 
                      class="logo-default text-logo"> <?= $logo_text; ?></div>
                <!--<img src="<?= URL('/assets/img/logotripoin.png'); ?>" height="30" alt="logo" class="logo-default" /> </a>-->
            </a>
            <div class="menu-toggler sidebar-toggler" id="menu-toogle">
                <span></span>
            </div>

        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
            <span></span>
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">

                <!-- END TODO DROPDOWN -->
                <!-- BEGIN USER LOGIN DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <img alt="" class="img-circle" src="<?= URL('/assets/img/user.png'); ?>" />
                        <span class="username username-hide-on-mobile"> <?= $_SESSION[SESSION_USERNAME]; ?> </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="<?= URL($admin_url . '/profile'); ?>">
                                <i class="icon-user"></i> <?=lang('general.my_profile');?> </a>
                        </li>
                        <li>
                            <a href="<?= URL($admin_url . '/settings'); ?>">
                                <i class="icon-settings"></i> <?=lang('general.settings');?> </a>
                        </li>
                        <li>
                            <a href="<?= URL($admin_url . '/change-password'); ?>">
                                <i class="icon-key"></i> <?=lang('general.change_password');?> </a>
                        </li>
                        <!--                        <li>
                                                    <a href="app_todo.html">
                                                        <i class="icon-rocket"></i> My Tasks
                                                        <span class="badge badge-success"> 7 </span>
                                                    </a>
                                                </li>-->
                        <li class="divider"> </li>
                        <li>
                            <a href="<?= URL(''); ?>" target="_blank">
                                <i class="icon-globe"></i> <?=lang('general.view_website');?> </a>
                        </li>
                        <li>
                            <a href="<?= URL($admin_url . '/lock-screen'); ?>">
                                <i class="icon-lock"></i> <?=lang('general.lock_screen');?> </a>
                        </li>
                        <li>
                            <a href="<?= URL($admin_url . '/logout'); ?>">
                                <i class="icon-key"></i> <?=lang('general.log_out');?> </a>
                        </li>
                    </ul>
                </li>
                <!-- END USER LOGIN DROPDOWN -->
                <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <!--                <li class="dropdown dropdown-quick-sidebar-toggler">
                                    <a href="javascript:;" class="dropdown-toggle">
                                        <i class="icon-logout"></i>
                                    </a>
                                </li>-->
                <!-- END QUICK SIDEBAR TOGGLER -->
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>