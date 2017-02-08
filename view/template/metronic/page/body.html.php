<?php

use app\Model\MemberPost;
use app\Util\Database;
use app\Model\SecurityUser;
use app\Model\SecurityUserProfile;

$db = new Database();
$memberPost = new MemberPost();
$user = new SecurityUser();
$userProfile = new SecurityUserProfile();

$db->connect();




/*
$db->sql("SELECT up." . $userProfile->getFullname() . ",COUNT(mp." . $memberPost->getId() . ") total_post FROM " . $memberPost->getEntity() . " as mp 
    JOIN " . $user->getEntity() . " as u ON mp." . $memberPost->getCreatedByUsername() . "=u." . $user->getCode() .
        " JOIN " . $userProfile->getEntity() . " as up ON u." . $user->getId() . "=up." . $userProfile->getUser()->getId() .
        " GROUP BY mp." . $memberPost->getCreatedByUsername() . " ORDER BY COUNT(mp." . $memberPost->getId() . ") DESC LIMIT 0,10"
);
$rs_member = $db->getResult();
*/
//LOGGER($rs_member);
?>
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <h1 class="page-title"> <?=lang('general.dashboard');?>
            <!--<small>bootstrap inputs, input groups, custom checkboxes and radio controls and more</small>-->
        </h1>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12 ">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet light bordered">

                    <div class="portlet-body form">
                        <div class="row">


                            
                            
                        </div>
                    </div>
                </div>
                <div class="portlet light bordered col-md-4">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-share font-dark hide"></i>
                            <!--<span class="caption-subject font-dark bold uppercase">Laporan 10 Member Tertinggi</span>-->
                        </div>

                    </div>
                    <div class="portlet-body">
<!--                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 300px;"><div class="scroller" style="height: 300px; overflow: hidden; width: auto;" data-always-visible="1" data-rail-visible="0" data-initialized="1">
                                
                            </div>
                            <div class="slimScrollBar" style="background: rgb(187, 187, 187); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; height: 186.335px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(a234, 234, 234); opacity: 0.2; z-index: 90; right: 1px;"></div></div>-->

                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- END CONTENT BODY -->
</div>