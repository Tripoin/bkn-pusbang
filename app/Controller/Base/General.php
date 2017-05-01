<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controller\Base;

/**
 * Description of General
 *
 * @author sfandrianah
 */
use app\Util\Form;
use app\Model\SecurityUser;
use app\Model\SecurityUserProfile;
use app\Util\Database;
use app\Model\MasterProvince;
use app\Model\MasterCity;
use app\Model\MasterDistrict;
use app\Model\MasterVillage;

//use app\Model\D
class General {

    //put your code here

    public function profile() {
        $Form = new Form();

        setTitle(lang('security.title_user_profile'));
        setTitleBody(lang('security.title_user_profile'));
        setBreadCrumb(array(lang('security.title_user_profile') => FULLURL()));

        include FILE_PATH('/view/page/general/profile.html.php');
    }

    public function profileUpdate() {
        $db = new Database();
        $sup = new SecurityUserProfile();
        $su = new SecurityUser();

        $db->connect();
        $result = true;

        $id = $_POST['id'];
//        $email = $_POST['email'];
        $fullname = $_POST['fullname'];
        $placeOfBirth = $_POST['placeOfBirth'];
        $birthdate = $_POST['birthdate'];

        $db->update($sup->getEntity(), array(
//            $sup->getEmail() => $email,
            $sup->getName() => $fullname,
            $sup->getPlace() => $placeOfBirth,
            $sup->getBirthdate() => $birthdate,
                ), $sup->getUser()->getId() . EQUAL . $id);
        $rs = $db->getResult();
        if ($rs[0] == 1) {
            echo resultPageMsg("success", lang('general.title_update_success'), lang('general.message_update_success'));
        } else {
            echo resultPageMsg("danger", lang('general.title_update_error'), lang('general.message_update_error'));
        }

//        include FILE_PATH('/view/page/general/profile.html.php');
    }

    public function changePassword() {
        $Form = new Form();

        setTitle(lang('security.title_change_password'));
        setTitleBody(lang('security.title_change_password'));
        setBreadCrumb(array(lang('security.title_change_password') => FULLURL()));

        include FILE_PATH('/view/page/general/change-password.html.php');
    }

    public function changePasswordUpdate() {
        $db = new Database();
        $sup = new SecurityUserProfile();
        $su = new SecurityUser();

//        $id = $_POST['id'];
        $oldPassword = $_POST['old_password'];
        $newPassword = $_POST['new_password'];
        $renewPassword = $_POST['renew_password'];

        $getUser = $db->selectByID($su, $su->getCode() . "='" . $_SESSION[SESSION_USERNAME] . "'");

        /* $password_e = hash("sha256", $oldPassword . $getUser[0][$su->getSalt()]);
          $checkOldPassword = $db->selectByID($su, $su->getCode() . "='" . $_SESSION[SESSION_USERNAME] . "'"
          . " AND " . $su->getPassword() . " = '" . $password_e . "'"); */

//        password_hash('trijep3t3', PASSWORD_BCRYPT);
//        if (!empty($checkOldPassword)) {
        if (password_verify($oldPassword, $getUser[0][$su->getPassword()])) {
            if ($newPassword == $renewPassword) {
//                $len = 5;
//                $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
//                $salt = substr(str_shuffle(str_repeat($pool, ceil($len / strlen($pool)))), 0, $len);
//                $password_new = hash("sha256", $renewPassword . $salt);

                $db->connect();
                $password_new = password_hash($renewPassword, PASSWORD_BCRYPT);
                $db->update($su->getEntity(), array(
                    $su->getPassword() => $password_new
                        ), $su->getCode() . "='" . $_SESSION[SESSION_USERNAME] . "'");
                $rsChangePassword = $db->getResult();
                if ($rsChangePassword[0] == 1) {
                    echo resultPageMsg("success", lang('general.title_update_success'), lang('general.message_update_success'));
                } else {
                    echo resultPageMsg("danger", lang('general.title_update_error'), lang('general.message_update_error'));
                }
            } else {
                echo resultPageMsg("danger", lang('general.title_update_error'), lang('security.message_renew_password_error'));
            }
        } else {
            echo resultPageMsg("danger", lang('general.title_update_error'), lang('security.message_old_password_error'));
        }

//        include FILE_PATH('/view/page/general/profile.html.php');
    }

    public function searchFunction() {
        echo '<a href="javascript:;" class="icon-btn" style="width:150px;height:100px;padding-top:30px;">
                                                                <i class="fa fa-group" style="font-size:30px;"></i>
                                                                <div  style="font-size:15px;"> Users </div>
                                                            </a>';
    }

    public function getArea() {
        $db = new Database();
        $selected = "";
        if (isset($_GET['action'])) {
            $selected = $_GET['action'];
        }
        if ($selected == "province") {
            $search = $_GET['search'];
            $masterProvince = new MasterProvince();
            $db->connect();
            $db->select($masterProvince->getEntity(), "*", null, null, null);
            $rs = $db->getResult();
            $data = convertJsonComboboxJquery($rs, $masterProvince->getId(), $masterProvince->getName());
        } else if ($selected == "city") {
            $masterCity = new MasterCity();
            $search = $_GET['search'];
            $db->connect();
            $db->select($masterCity->getEntity(), "*", null, $masterCity->getProvince_id() . EQUAL . $search, null);
            $rs = $db->getResult();
//            print_r($rs);
//            echo $db->getSql();
            $data = convertJsonComboboxJquery($rs, $masterCity->getId(), $masterCity->getName());
        } else if ($selected == "district") {
            $masterDistrict = new MasterDistrict();
            $search = $_GET['search'];
            $db->connect();
            $db->select($masterDistrict->getEntity(), "*", null, $masterDistrict->getCity_id() . EQUAL . $search, null);
            $rs = $db->getResult();
//            print_r($rs);
//            echo $db->getSql();
            $data = convertJsonComboboxJquery($rs, $masterDistrict->getId(), $masterDistrict->getName());
        } else if ($selected == "village") {
            $masterVillage = new MasterVillage();
            $search = $_GET['search'];
            $db->connect();
            $db->select($masterVillage->getEntity(), "*", null, $masterVillage->getDistrict_id() . EQUAL . $search, null);
            $rs = $db->getResult();
//            print_r($rs);
//            echo $db->getSql();
            $data = convertJsonComboboxJquery($rs, $masterVillage->getId(), $masterVillage->getName());
        } else {
            $data = array();
        }

        echo json_encode($data);
    }
    
    public function aboutApplication() {
        $Form = new Form();

        setTitle('About Tripoin E-Pusbang');
        setTitleBody('About Tripoin E-Pusbang');
        setBreadCrumb(array('About Tripoin E-Pusbang' => FULLURL()));

        include FILE_PATH('/view/page/general/about-application.html.php');
    }

}
