<?php

use app\Model\SecurityUserProfile;

$securityUserProfile = new SecurityUserProfile();
$data_member = getUserMember();
include_once getTemplatePath('page/content-page.html.php');
?>

<div id="content" class="container-fluid" style="padding-top: 130px;">
    <?php include_once FILE_PATH(PAGE_MEMBER_PATH); ?>
    
    <div class="signup col-md-9 member-page">
        <h3>WELCOME TO E-PUSBANG <?= $data_member[$securityUserProfile->getEntity()][$securityUserProfile->getName()]; ?></h3>
        <hr>
        <div id="bodyPage">
            
        </div>
    </div>
    <?php include_once FILE_PATH(END_PAGE_MEMBER_PATH); ?>
</div>
<?php include_once getTemplatePath('page/end-content-page.html.php'); ?>
