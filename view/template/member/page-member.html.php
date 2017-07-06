<?php

use app\Util\Database;
use app\Model\SecurityFunctionAssignment;
use app\Model\SecurityUser;
use app\Model\SecurityUserProfile;
use app\Model\MasterNotification;
use app\Model\Confirm;

$db = new Database();
$secFuncAssg = new SecurityFunctionAssignment();
$su = new SecurityUser();
$sup = new SecurityUserProfile();
$masterNotification = new MasterNotification();
$db->connect();

$db->select(
        $su->getEntity(), $su->getId() . "," . $su->getExpiredDate(), array(), $su->getCode() . EQUAL . "'" . $_SESSION[SESSION_USERNAME_GUEST] . "'"
);
$cek_user = $db->getResult();
//print_r($cek_user);
$db->select(
        $sup->getEntity(), "*", array(), $sup->getUserId() . EQUAL . "'" . $cek_user[0][$su->getId()] . "'"
);
$cek_user_profile = $db->getResult();
//print_r($cek_user_profile);
//$db = new Database();
//        $db->connect();
if (!empty($cek_user_profile[0][$sup->getPathimage()])) {
    square_crop(URL('uploads/member/' . $_SESSION[SESSION_USERNAME_GUEST] . '/' . $cek_user_profile[0][$sup->getPathimage()]), FILE_PATH('uploads/member/' . $_SESSION[SESSION_USERNAME_GUEST] . '/profile.jpg'), 250);
}
?>
<style>
    .menu-member > a{
        color:#888888;
        font-weight: lighter;
    }

    .menu-member:hover{
        background: #b7b7b7;
    }
    .menu-member > a:hover{
        color: #fff;
    }
    .menu-member > ul{
        background: #F6F6F6;
    }
    .panel-member{
        border: 0px;
    }

    #fade {
        background: none repeat scroll 0 0 #D3DCE3;
        display: none;
        height: 100%;
        left: 0;
        opacity: 0.4;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 99;
    }
    #centerBox {
        background-color: #FFFFFF;
        border: 5px solid #FFFFFF;
        border-radius: 2px 2px 2px 2px;
        box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);
        display: none;
        max-height: 480px;
        overflow: auto;
        visibility: hidden;
        width: 710px;
        z-index: 100;
    }
    .box1 {
        background: none repeat scroll 0 0 #F3F7FD;
        border: 1px solid #D3E1F9;
        font-size: 12px;
        margin-top: 5px;
        padding: 4px;
    }

    .button1 {
        background-color: #FFFFFF;
        background-image: -moz-linear-gradient(center bottom, #EDEDED 30%, #FFFFFF 83%);
        border-color: #999999;
        border-radius: 2px 2px 2px 2px;
        border-style: solid;
        border-width: 1px;
        box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
        color: #333333;
        cursor: pointer;
        display: inline-block;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11px;
        font-weight: 700;
        height: 25px;
        line-height: 24px;
        margin-right: 2px;
        min-width: 40px;
        padding: 0 16px;
        text-align: center;
        text-decoration: none;
        -webkit-user-select: none;  /* Chrome all / Safari all */
        -moz-user-select: none;     /* Firefox all */
        -ms-user-select: none;      /* IE 10+ */
    }
    .button1:hover {
        text-decoration: underline;
    }
    .button1:active, .a:active {
        position: relative;
        top: 1px;
    }


    #imgContainer {
        width: 100%;
        text-align: center;
        position: relative;
    }
    #imgArea {
        display: inline-block;
        margin: 0 auto;
        width: 200px;
        height: 200px;
        position: relative;
        /*background-color: #eee;*/
        font-family: Arial, Helvetica, sans-serif;
        font-size: 13px;
    }
    #imgArea img {
        outline: medium none;
        vertical-align: middle;
        width: 100%;
    }
    #imgChange {
        /*background: url("../img/overlay.png") repeat scroll 0 0 rgba(0, 0, 0, 0);*/
        bottom: 70px;
        color: #FFFFFF;
        display: block;
        height: 30px;
        left: 70px;
        line-height: 32px;
        position: absolute;
        text-align: center;
        width: 100%;
    }
    #imgChange input[type="file"] {
        bottom: 0;
        cursor: pointer;
        height: 100%;
        left: 0;
        margin: 0;
        opacity: 0;
        padding: 0;
        position: absolute;
        width: 100%;
        z-index: 0;
    }
    /* Progressbar */
    .progressBar {
        background: none repeat scroll 0 0 #E0E0E0;
        left: 0;
        padding: 3px 0;
        position: absolute;
        top: 50%;
        width: 100%;
        display: none;
    }
    .progressBar .bar {
        background-color: #FF6C67;
        width: 0%;
        height: 14px;
    }
    .progressBar .percent {
        display: inline-block;
        left: 0;
        position: absolute;
        text-align: center;
        top: 2px;
        width: 100%;
    }

</style>
<script>
    $(document).on('change', '#image_upload_file', function () {
        var progressBar = $('.progressBar'), bar = $('.progressBar .bar'), percent = $('.progressBar .percent');

        $('#image_upload_form').ajaxForm({
            beforeSend: function () {
                progressBar.fadeIn();
                var percentVal = '0%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            uploadProgress: function (event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            success: function (html, statusText, xhr, $form) {
                obj = $.parseJSON(html);
                if (obj.status) {
                    var percentVal = '100%';
                    bar.width(percentVal)
                    percent.html(percentVal);
                    $("#imgArea>img").prop('src', obj.image_medium);
                } else {
                    alert(obj.error);
                }
            },
            complete: function (xhr) {
                progressBar.fadeOut();
            }
        }).submit();

    });
</script>
<script src="<?= getTemplateURL('/assets/js/jquery.form.js'); ?>"></script>

<?php
//$userMember = getUserMember();

$photo_profile = URL('/assets/img/default_profile.jpg');
if(file_exists(FILE_PATH('uploads/member/' . $_SESSION[SESSION_USERNAME_GUEST] . '/'.$cek_user_profile[0][$sup->getPathimage()]))){
    $photo_profile = URL('uploads/member/' . $_SESSION[SESSION_USERNAME_GUEST] . '/'.$cek_user_profile[0][$sup->getPathimage()]);
} else if(file_exists(FILE_PATH('uploads/member/' . $_SESSION[SESSION_USERNAME_GUEST] . '/medium/'.$cek_user_profile[0][$sup->getPathimage()]))){
    $photo_profile = URL('uploads/member/' . $_SESSION[SESSION_USERNAME_GUEST] . '/medium/'.$cek_user_profile[0][$sup->getPathimage()]);
}  
?>
<div id="content" class="container-fluid">
    <div class="col-md-offset-0 col-lg-offset-0 col-lg-12 zeropad" >
        <div class="panel panel-default panel-member col-md-3" 
             style="text-align:center;background: #F6F6F6">
            <div id="imgContainer" style="box-shadow: 0px 0px 0px 0px #888888;margin-top: -100px;">
                <form enctype="multipart/form-data" action="<?= URL('/page/member/user-profile/change-photo'); ?>" method="post" name="image_upload_form" id="image_upload_form">
                    <div id="imgArea">
                        <img src="<?= $photo_profile; ?>"
                             class="img-circle">
                        <div class="progressBar">
                            <div class="bar"></div>
                            <div class="percent">0%</div>
                        </div>
                        <div id="imgChange">
                            <span class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></span>
                            <input type="file" accept="image/*" name="image_upload_file" id="image_upload_file">
                        </div>
                    </div>
                </form>
            </div>
<!--            <a href="<?= URL('/page/member/user-profile'); ?>">
                <img src="<?= URL('uploads/member/' . $_SESSION[SESSION_USERNAME_GUEST] . '/profile.jpg'); ?>"  <?= notFoundImg('noim.jpg'); ?>
                     style="box-shadow: 0px 0px 0px 0px #888888;margin-top: -100px;"
                     id="img-user-profile"
                     class="img-circle" alt="<?= $_SESSION[SESSION_FULLNAME_GUEST]; ?>" width="200" height="200"/>
            </a>-->
            <div class="panel-body">
                <div class="exceprt" style="color:#888888;font-weight:bold;">
                    <?= $_SESSION[SESSION_FULLNAME_GUEST]; ?>
                    <h5></h5>
                </div>

                <div class="profile-usermenu" style="text-align: left;margin-top: -0px;">
                    <ul class="nav nav-inline">
                        <?php
                        $db->connect();
                        $db->select(
                                $secFuncAssg->getEntity(), $secFuncAssg->getFunction()->getEntity() . ".*", array(
                            $secFuncAssg->getFunction()->getEntity(), $secFuncAssg->getGroup()->getEntity()), $secFuncAssg->getFunction()->getEntity() . DOT . $secFuncAssg->getFunction()->getId() . EQUAL . $secFuncAssg->getEntity() . DOT . $secFuncAssg->getFunctionId()
                                . " AND " . $secFuncAssg->getGroup()->getEntity() . DOT . $secFuncAssg->getGroup()->getId() . EQUAL . $secFuncAssg->getEntity() . DOT . $secFuncAssg->getGroupId()
                                . " AND " . $secFuncAssg->getEntity() . DOT . $secFuncAssg->getStatus() . EQUAL . "1"
                                . " AND " . $secFuncAssg->getEntity() . DOT . $secFuncAssg->getGroupId() . EQUAL . $_SESSION[SESSION_GROUP_GUEST]
                                . " AND " . $secFuncAssg->getFunction()->getEntity() . DOT . $secFuncAssg->getFunction()->getLevel() . EQUAL . "0"
                                , $secFuncAssg->getFunctionAssignmentOrder() . ' ASC'
                        );
                        $function_member = $db->getResult();
//                    print_r($function_member);
                        ?>
                        <?php
                        foreach ($function_member as $val_func_member) {
                            $db->sql(SELECT . "COUNT(" . $secFuncAssg->getFunction()->getEntity() . DOT . $secFuncAssg->getFunction()->getId() . ") as count" .
                                    FROM . $secFuncAssg->getEntity() . JOIN . $secFuncAssg->getFunction()->getEntity() .
                                    ON . $secFuncAssg->getFunction()->getEntity() . DOT . $secFuncAssg->getFunction()->getId() . EQUAL . $secFuncAssg->getEntity() . DOT . $secFuncAssg->getFunctionId() .
                                    WHERE . $secFuncAssg->getFunction()->getParent() . EQUAL . $val_func_member[$secFuncAssg->getFunction()->getId()]
                                    . " AND " . $secFuncAssg->getEntity() . DOT . $secFuncAssg->getStatus() . EQUAL . "1"
                            );
                            $sf_item = $db->getResult();
                            $countitem = $sf_item[0]['count'];
                            $chevron = "";
                            $url = URL($val_func_member[$secFuncAssg->getFunction()->getUrl()]);
                            $target_url = "";
                            $target_url_1 = "";
                            if ($countitem != 0) {
                                $class = "class='has-submenu'";
                                $url = "javascript::";
                                $chevron = '<i class="fa fa-chevron-right pull-right"></i>';
                                $target_url = 'data-toggle="collapse" data-target="#' . $val_func_member[$secFuncAssg->getFunction()->getCode()] . '"';
                                $target_url_1 = $val_func_member[$secFuncAssg->getFunction()->getCode()];
                            }
                            $activeMenuParent = '';
                            $activeMenuChild = '';
                            $activeMenuChild1 = '';
                            $expAct = explode(",", getActiveMenuMember());
                            if ($expAct[0] == $val_func_member[$secFuncAssg->getFunction()->getCode()]) {
                                $activeMenuParent = 'active';
                            }
                            if (count($expAct) == 2) {
                                if ($expAct[0] == $val_func_member[$secFuncAssg->getFunction()->getCode()]) {
                                    $activeMenuChild = 'in';
                                    $activeMenuChild1 = $expAct[1];
                                    $activeMenuParent = '';
                                }
                            }
                            ?>
                            <li class="<?= $activeMenuParent; ?> menu-member">
                                <a id="menu-<?= $val_func_member[$secFuncAssg->getFunction()->getCode()]; ?>" 
                                   class="<?= $activeMenuParent; ?>" href="<?= $url; ?>" <?= $target_url; ?>  >
                                    <i class="<?= $val_func_member[$secFuncAssg->getFunction()->getStyle()]; ?>"></i>
                                    <?= FunctionLanguageName($val_func_member); ?>
                                    <?= $chevron; ?>
                                    <?php
                                    if ($val_func_member[$secFuncAssg->getFunction()->getCode()] == 'parent-pesan') {
                                        if (isset($cek_user_profile[0][$su->getId()])) {
                                            $db->select($masterNotification->getEntity(), "COUNT(" . $masterNotification->getId() . ") as total", array(), ""
                                                    . "" . $masterNotification->getTo() . equalToIgnoreCase($cek_user_profile[0][$su->getId()])
//                                                . " OR " . $masterNotification->getFrom() . equalToIgnoreCase($cek_user_profile[0][$su->getId()]) . ")"
                                                    . " AND (" . $masterNotification->getRead() . "<>1"
                                                    . " OR " . $masterNotification->getRead() . " is null)");
                                            $data_notification = $db->getResult();
//                                        print_r($data_notification);
                                            if (!empty($data_notification)) {
                                                if (isset($data_notification[0]['total'])) {
                                                    if ($data_notification[0]['total'] == 0) {
                                                        echo '<span class="badge badge-info" id="notif-message"></span>';
                                                    } else {
                                                        echo '<span class="badge badge-info" id="notif-message">' . $data_notification[0]['total'] . '</span>';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    ?>

                                </a>
                                <?php
                                if ($countitem != 0) {
                                    $db->select(
                                            $secFuncAssg->getEntity(), $secFuncAssg->getFunction()->getEntity() . ".*", array(
                                        $secFuncAssg->getFunction()->getEntity(), $secFuncAssg->getGroup()->getEntity()), $secFuncAssg->getFunction()->getEntity() . DOT . $secFuncAssg->getFunction()->getId() . EQUAL . $secFuncAssg->getEntity() . DOT . $secFuncAssg->getFunctionId()
                                            . " AND " . $secFuncAssg->getGroup()->getEntity() . DOT . $secFuncAssg->getGroup()->getId() . EQUAL . $secFuncAssg->getEntity() . DOT . $secFuncAssg->getGroupId()
                                            . " AND " . $secFuncAssg->getEntity() . DOT . $secFuncAssg->getStatus() . EQUAL . "1"
                                            . " AND " . $secFuncAssg->getEntity() . DOT . $secFuncAssg->getGroupId() . EQUAL . $_SESSION[SESSION_GROUP_GUEST]
                                            . " AND " . $secFuncAssg->getFunction()->getEntity() . DOT . $secFuncAssg->getFunction()->getParent() . EQUAL . $val_func_member[$secFuncAssg->getFunction()->getId()]
                                            . " AND " . $secFuncAssg->getFunction()->getEntity() . DOT . $secFuncAssg->getFunction()->getLevel() . EQUAL . "1"
                                            , $secFuncAssg->getFunctionAssignmentOrder() . ' ASC'
                                    );
                                    $function_member_child = $db->getResult();
//                                    print_r($function_member_child);
                                    ?>
                                    <ul class="nav collapse <?= $activeMenuChild; ?>" id="<?= $target_url_1; ?>" role="menu" aria-labelledby="btn-1">
                                        <?php
                                        foreach ($function_member_child as $val_func_member_child) {
                                            $act_menu_1 = 'class="menu-member"';
                                            if ($activeMenuChild1 == $val_func_member_child[$secFuncAssg->getFunction()->getCode()]) {
                                                $act_menu_1 = 'class="menu-member active "';
                                            }
                                            ?>

                                            <li <?= $act_menu_1; ?>>
                                                <a <?= $act_menu_1; ?> href="<?= URL($val_func_member_child[$secFuncAssg->getFunction()->getUrl()]); ?>">
                                                    &nbsp;&nbsp;&nbsp;<i class="<?= $val_func_member_child[$secFuncAssg->getFunction()->getStyle()]; ?>"></i>
                                                    <?= FunctionLanguageName($val_func_member_child); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </li>
                            <?php
                        }
                        ?>
                        <li class=" menu-member">
                            <a href="<?= URL('/page/logout'); ?>">
                                <i class="fa fa-sign-out"></i>
                                <?= lang('general.sign_out'); ?>
                            </a>
                        </li>

                    </ul>
                </div>
                <!-- END MENU -->

            </div>
        </div>