<?php

use app\Util\Database;
use app\Constant\IURLConstant;

$db = new Database();
$admin_url = getAdminTheme();

use app\Model\TransactionRegistrationDetails;
use app\Model\LinkRegistration;
use app\Model\MasterApproval;
use app\Model\MasterWaitingList;
use app\Model\MasterApprovalCategory;
use app\Model\MasterUserMain;
use app\Model\TransactionRegistration;

$db->connect();

$regDetail = new TransactionRegistrationDetails();
$linkRegistration = new LinkRegistration();
$masterApproval = new MasterApproval();
$masterApprovalCategory = new MasterApprovalCategory();
$masterWaitingList = new MasterWaitingList();
$masterUserMain = new MasterUserMain();
$transactionRegistration = new TransactionRegistration();

$db->select($masterApproval->getEntity(), "COUNT(" . $masterApproval->getEntity() . DOT . $masterApproval->getId() . ") as total"
        . "", array($masterApprovalCategory->getEntity(), $transactionRegistration->getEntity(), $linkRegistration->getEntity()), ""
        . $masterApprovalCategory->getEntity() . DOT . $masterApprovalCategory->getId() . EQUAL . $masterApproval->getEntity() . DOT . $masterApproval->getApprovalCategoryId() . ""
        . " AND " . $masterApproval->getEntity() . DOT . $masterApproval->getApprovalDetailId() . EQUAL . $linkRegistration->getEntity() . DOT . $linkRegistration->getId() . ""
        . " AND " . $linkRegistration->getEntity() . DOT . $linkRegistration->getRegistrationId() . EQUAL . $transactionRegistration->getEntity() . DOT . $transactionRegistration->getId() . ""
        . " AND " . $masterApproval->getEntity() . DOT . $masterApproval->getStatus() . " is null "
        . " AND " . $masterApprovalCategory->getEntity() . DOT . $masterApproval->getCode() . in(array('REGISTRATION', 'RE-REGISTRATION')) . ""
        . "", null, null);
//echo $db->getSql();
$rs_count_app_pic = $db->getResult();
$total_app_pic = 0;
if (isset($rs_count_app_pic[0]['total'])) {
    $total_app_pic = $rs_count_app_pic[0]['total'];
}


$db->select($linkRegistration->getEntity(), "COUNT(" . $regDetail->getEntity() . DOT . $regDetail->getId() . ") as total"
        . "", array($regDetail->getEntity()), ""
        . "  " . $linkRegistration->getEntity() . DOT . $linkRegistration->getRegistrationDetailsId() . EQUAL . $regDetail->getEntity() . DOT . $regDetail->getId() . ""
        . " AND " . $linkRegistration->getEntity() . DOT . $linkRegistration->getRegistrationDetailsId() . " is not null"
        . " AND " . $linkRegistration->getEntity() . DOT . $linkRegistration->getStatus() . " is null "
        . "", null, null);
//echo $db->getSql();
$rs_count_app_participant = $db->getResult();
$total_app_participant = 0;
if (isset($rs_count_app_participant[0]['total'])) {
    $total_app_participant = $rs_count_app_participant[0]['total'];
}

$db->select($masterApproval->getEntity(), "COUNT(" . $masterApproval->getEntity() . DOT . $masterApproval->getId() . ") as total"
        . "", array($masterApprovalCategory->getEntity(),
    $masterWaitingList->getEntity(),
    $masterUserMain->getEntity()), ""
        . $masterApprovalCategory->getEntity() . DOT . $masterApprovalCategory->getId() . EQUAL . $masterApproval->getEntity() . DOT . $masterApproval->getApprovalCategoryId() . ""
        . " AND " . $masterApproval->getEntity() . DOT . $masterApproval->getApprovalDetailId() . EQUAL . $masterWaitingList->getEntity() . DOT . $masterWaitingList->getId() . ""
        . " AND " . $masterWaitingList->getEntity() . DOT . $masterWaitingList->getUserMainId() . EQUAL . $masterUserMain->getEntity() . DOT . $masterUserMain->getId() . ""
        . " AND " . $masterApprovalCategory->getEntity() . DOT . $masterApproval->getCode() . equalToIgnoreCase('WAITING-LIST') . ""
        . "", null, null);
$rs_count_app_activity = $db->getResult();
$total_app_activity = 0;
if (isset($rs_count_app_activity[0]['total'])) {
    $total_app_activity = $rs_count_app_activity[0]['total'];
}

$total_notif_all = $total_app_pic + $total_app_participant + $total_app_activity;
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
//                print_r($rs_count_app_activity);
                ?>

                <div style="font-size: 20px;font-weight: bold;margin-top: -3px;" 
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
                <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"
                       data-hover="dropdown" data-close-others="true" aria-expanded="true">
                        <i class="icon-bell"  style="color:white"></i>
                        <span class="badge badge-success"> <?=$total_notif_all;?> </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="external">
                            <h3>
                                <span class="bold">12 pending</span> Approval</h3>
                            <!--<a href="page_user_profile_1.html">view all</a>-->
                        </li>
                        <li>
                            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 250px;"><ul class="dropdown-menu-list scroller" style="height: 250px; overflow: hidden; width: auto;" data-handle-color="#637283" data-initialized="1">
                                    <li>
                                        <a href="<?=URL($admin_url.IURLConstant::APPROVAL_PIC_REGISTRATION_INDEX_URL);?>">
                                            <!--<span class="time">just now</span>-->
                                            <span class="details">
                                                <span class="label label-sm label-icon label-success">
                                                    <span class="label label-success"> 
                                                        <b><?php echo $total_app_pic; ?></b> 
                                                    </span>
                                                </span> Pending Approval Registrasi PIC </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?=URL($admin_url.IURLConstant::APPROVAL_PARTICIPANT_REGISTRATION_INDEX_URL);?>">
                                            <!--<span class="time">just now</span>-->
                                            <span class="details">
                                                <span class="label label-sm label-icon label-success">
                                                    <span class="label label-success"> <b><?php echo $total_app_participant; ?></b> </span>
                                                </span> Pending Approval Registrasi Peserta </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?=URL($admin_url.IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL);?>">
                                            <!--<span class="time">just now</span>-->
                                            <span class="details">
                                                <span class="label label-sm label-icon label-success">
                                                    <span class="label label-success"> <b><?php echo $total_app_activity; ?></b> </span>
                                                </span> Pending Approval Registrasi Kegiatan </span>
                                        </a>
                                    </li>

                                </ul><div class="slimScrollBar" style="background: rgb(99, 114, 131); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 120.89px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(234, 234, 234); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                        </li>
                    </ul>
                </li>

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
                                <i class="icon-user"></i> <?= lang('general.my_profile'); ?> </a>
                        </li>
                        <li>
                            <a href="<?= URL($admin_url . '/settings'); ?>">
                                <i class="icon-settings"></i> <?= lang('general.settings'); ?> </a>
                        </li>
                        <li>
                            <a href="<?= URL($admin_url . '/change-password'); ?>">
                                <i class="icon-key"></i> <?= lang('general.change_password'); ?> </a>
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
                                <i class="icon-globe"></i> <?= lang('general.view_website'); ?> </a>
                        </li>
                        <li>
                            <a href="<?= URL($admin_url . '/lock-screen'); ?>">
                                <i class="icon-lock"></i> <?= lang('general.lock_screen'); ?> </a>
                        </li>
                        <li>
                            <a href="<?= URL($admin_url . '/logout'); ?>">
                                <i class="icon-key"></i> <?= lang('general.log_out'); ?> </a>
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
