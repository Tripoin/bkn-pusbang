<?php

use app\Util\Database;
use app\Model\SecurityFunctionAssignment;
use app\Model\SecurityUser;
use app\Model\SecurityUserProfile;
use app\Model\Notification;
use app\Model\Confirm;

$db = new Database();
$secFuncAssg = new SecurityFunctionAssignment();
$su = new SecurityUser();
$sup = new SecurityUserProfile();
$db->connect();
$db->select(
        $su->getEntity(), $su->getId() . "," . $su->getExpiredDate(), array(), $su->getCode() . EQUAL . "'" . $_SESSION[SESSION_USERNAME_GUEST] . "'"
);
$cek_user = $db->getResult();

$db->select(
        $sup->getEntity(), "*", array(), $sup->getId() . EQUAL . "'" . $cek_user[0][$su->getId()] . "'"
);
$cek_user_profile = $db->getResult();
//$db = new Database();
//        $db->connect();
square_crop(URL('uploads/member/' . $_SESSION[SESSION_USERNAME_GUEST] . '/' . $cek_user_profile[0][$sup->getPathimage()]), 
                        FILE_PATH('uploads/member/' . $_SESSION[SESSION_USERNAME_GUEST] . '/profile.jpg'),250);
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
</style>
<div id="content" class="container-fluid">
    <div class="col-md-offset-0 col-lg-offset-0 col-lg-12 zeropad" >
        <div class="panel panel-default panel-member col-md-3" style="text-align:center;background: #F6F6F6">
            <a href="<?= URL('/page/member/user-profile'); ?>">
                <img src="<?= URL('uploads/member/' . $_SESSION[SESSION_USERNAME_GUEST] . '/profile.jpg');?>"  <?= notFoundImg('noim.jpg'); ?>
                     style="box-shadow: 0px 0px 0px 0px #888888;margin-top: -100px;"
                     id="img-user-profile"
                     class="img-circle" alt="<?= $_SESSION[SESSION_FULLNAME_GUEST]; ?>" width="200" height="200"/>
            </a>
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