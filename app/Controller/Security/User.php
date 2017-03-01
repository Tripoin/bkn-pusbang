<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SECURITY -> USER
 * @email : sfandrianah2@gmail.com
 * @author Syahrial Fandrianah
 * @FRAMEWORK NATIVE ADMIN TEMPLATE V.1.0
 */

namespace app\Controller\Security;

use app\Controller\Base\Controller;
use app\Model\SecurityUser;
use app\Model\SecurityUserProfile;
use app\Model\SecurityGroup;
use app\Constant\IURLConstant;
use app\Constant\IViewConstant;
use app\Util\Database;

class User extends Controller {

    //put your code here
    public $userProfile;
    public $data_group;

    public function __construct() {
        $sup = new SecurityUserProfile();
        $su = new SecurityUser();
        $this->userProfile = $sup;
        $this->modelData = $su;

        $db = new Database();
        $sg = new SecurityGroup();
        $rs_data_sg = $db->selectByID($sg, $sg->getStatus() . EQUAL . "1");
        $rs = convertJsonCombobox($rs_data_sg, $sg->getId(), $sg->getName());
        $this->data_group = $rs;

        $this->setTitle(lang('security.user'));
        $this->setBreadCrumb(array(lang('security.security') => "", lang('security.user') => URL()));
//        $this->search_by = 'code';
        $this->search_filter = array("code" => lang('general.code'));
        $this->indexUrl = IURLConstant::USER_INDEX_URL;
        $this->viewPath = IViewConstant::USER_VIEW_INDEX;
        $this->setAutoCrud();
    }


    public function save() {
        $db = new Database();
        $sup = new SecurityUserProfile();
        $su = new SecurityUser();
//        $group = new SecurityGroup();
//        $data = $this->modelData;
        $code = $_POST['code'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $group = $_POST['group'];
        $password = PASSWORD_DEFAULT_USER;
        if ($group == 1 || $group == 2) {
            $salt = substr(md5(uniqid(rand(), true)), 0, 9);
            $password_e = sha1($salt . sha1($salt . sha1($password)));
        } else {
            $len = 5;
            $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $salt = substr(str_shuffle(str_repeat($pool, ceil($len / strlen($pool)))), 0, $len);
            $password_e = hash("sha256", $password . $salt);
            
        }


        $db->connect();
//        $db->createAuditrail();
        $db->insert($su->getEntity(), array(
            $su->getCode() => $code,
            $su->getEmail() => $email,
            $su->getSalt() => $salt,
            $su->getPassword() => $password_e,
            $su->getGroupId() => $group,
            $su->getCreatedByUsername() => $_SESSION[SESSION_USERNAME],
            $su->getCreatedOn() =>  date(DATE_FORMAT_PHP_DEFAULT),
//            $su->getCreatedByIp() => getClientIp(),
//            $su->getApproved() => 1,
        ));
        $result_user = $db->getResult();
        if (is_numeric($result_user[0])) {
//            $db->connect();
            $db->insert($sup->getEntity(), array(
                $sup->getId() => $result_user[0],
                $sup->getName() => $fullname,
//                $sup->getEmail() => $email,
                $sup->getCode() => $code
            ));
            $result_user_profile = $db->getResult();
            if (is_numeric($result_user_profile[0])) {
                echo toastAlert("success", lang('general.title_insert_success'), lang('general.message_insert_success') . "<br/> Your Password Default : " . PASSWORD_DEFAULT_USER);
                echo '<script>$(function(){postAjaxPagination()});</script>';
            } else {
                echo toastAlert("error", lang('general.title_insert_error'), lang('general.message_insert_error'));
                echo resultPageMsg('danger', lang('general.title_insert_error'), $result_user_profile[0]);
            }
        } else {
            echo toastAlert("error", lang('general.title_insert_error'), lang('general.message_insert_error'));
            echo resultPageMsg('danger', lang('general.title_insert_error'), $result_user[0]);
        }
    }
    
    public function delete() {
        $db = new Database();
        $su = new SecurityUserProfile();
        $db->connect();
        $id = $_POST['id'];
        $get_data = $db->delete($su->getEntity(), $su->getUser()->getId() . EQUAL . $id);
//        print_r($get_data);
        if ($get_data == 1) {
            parent::delete();
        }
    }

    public function update() {

        $db = new Database();
        $sup = new SecurityUserProfile();
        $su = new SecurityUser();

        $code = $_POST['code'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $group = $_POST['group'];
        $id = $_POST['id'];

        $db->connect();
//        $db->createAuditrail();
        $db->update($su->getEntity(), array(
            $su->getCode() => $code,
            $su->getEmail() => $email,
            $su->getGroupId() => $group,
            $su->getModifiedByUsername() => $_SESSION[SESSION_USERNAME],
            $su->getModifiedOn() =>  date(DATE_FORMAT_PHP_DEFAULT),
//            $su->getModifiedOn() => getClientIp(),
//            $su->getApproved() => 1,
                ), $su->getId() . EQUAL . $id);
        $result_user = $db->getResult();
        if ($result_user[0] == 1) {
//            $db->connect();
            $select_user = $db->selectByID($sup, $sup->getUser()->getId() . EQUAL . $id);
            if (empty($select_user)) {
                $db->insert($sup->getEntity(), array(
                    $sup->getId() => $id,
                    $sup->getName() => $fullname,
//                    $sup->getEmail() => $email,
                    $sup->getCode() => $code
                ));
                $result_user_profile = $db->getResult();
                if (is_numeric($result_user_profile[0])) {
                    echo toastAlert("success", lang('general.title_insert_success'), lang('general.message_insert_success') );
                    echo '<script>$(function(){postAjaxPagination()});</script>';
                } else {
                    echo toastAlert("error", lang('general.title_insert_error'), lang('general.message_insert_error'));
                    echo resultPageMsg('danger', lang('general.title_insert_error'), $result_user_profile[0]);
                }
            } else {
                $db->update($sup->getEntity(), array(
                    $sup->getUser()->getId() => $id,
                    $sup->getFullname() => $fullname,
                    $sup->getEmail() => $email,
                    $sup->getCode() => $code
                ), $sup->getUser()->getId() . EQUAL . $id);
                $result_user_profile = $db->getResult();
                if ($result_user_profile[0] == 1) {
                    echo toastAlert("success", lang('general.title_update_success'), lang('general.message_update_success'));
                    echo '<script>$(function(){postAjaxPagination()});</script>';
                } else {
                    echo toastAlert("error", lang('general.title_update_error'), lang('general.message_update_error'));
                    echo resultPageMsg('danger', lang('general.title_update_error'), $result_user_profile[0]);
                }
            }
        } else {
            echo toastAlert("error", lang('general.title_update_error'), lang('general.message_update_error'));
            echo resultPageMsg('danger', lang('general.title_update_error'), $result_user[0]);
        }
    }

}
