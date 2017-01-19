<?php

/**
 * Description of User Profile
 * @email : sfandrianah2@gmail.com
 * @author Syahrial Fandrianah
 * @FRAMEWORK NATIVE ECCOMERCE V.1.0
 */

namespace app\Controller\Member;

use app\Model\SecurityUserProfile;
use app\Util\Database;
use app\Util\Form;
use app\Util\DataTable;
use app\Model\Confirm;
use app\Model\SecurityUser;

class UserProfile {

    public function __construct() {
        setActiveMenuMember('userprofile,changeprofile');
    }

    public function index() {
        $Form = new Form();
        setTitle(' | ' . lang('general.user-profile'));
        include_once FILE_PATH('view/page/member/user-profile/user-profile.html.php');
    }

    public function detailSaldoTopup() {
        $Form = new Form();
        $db = new Database();
        $Datatable = new DataTable();
        $Datatable->pageId('detailSaldoPage');
        $Datatable->urlPage(URL('page/member/user-profile/list-saldo'));
        $Datatable->searchFilter(array("code" => lang('topupsaldo.invoice_number')));
        if (isset($_POST['current_page'])) {
            $Datatable->current_page = $_POST['current_page'];
        }
        if (isset($_POST['per_page'])) {
            $Datatable->per_page = $_POST['per_page'];
        }
        if (isset($_POST['search_pagination'])) {
            $Datatable->search = $_POST['search_by'].'>'.$_POST['search_pagination'];
        }
        $up = new SecurityUserProfile();
        $user = $db->selectByID($up->getUser(), $up->getUser()->getCode() . "='" . $_SESSION[SESSION_USERNAME] . "'");
        $cek_user_profile = $db->selectByID($up, $up->getId() . "=" . $user[0][$up->getId()] . "");

        $confirm = new Confirm();
        $list_data = $Datatable->select_pagination($confirm, $confirm->getEntity(),$confirm->getCreatedByUsername().EQUAL."'".$user[0][$up->getUser()->getCode()]."'");
        
        $sql_saldo = $db->sql("SELECT SUM(".$confirm->getTransferAmount().") as saldo FROM ".$confirm->getEntity()." WHERE ".$confirm->getConfirmStatus().EQUAL."1 AND ".$confirm->getCreatedByUsername()."='".$_SESSION[SESSION_USERNAME]."'");
        $rs_saldo = $db->getResult();
        include_once FILE_PATH('view/page/member/user-profile/user-profile-saldo.html.php');
    }

    public function edit() {
        echo '<form id="form-user" action="' . URL('/page/member/user-profile/save') . '" method="POST" class="form" onsubmit="return false;">';
        $this->changeUserProfile();
        echo '</form>';
        echo '<div id="detailSaldoPage">';
        $this->detailSaldoTopup();
        echo '</div>';
    }

    public function changeUserProfile() {
        $Form = new Form();
        $db = new Database();
        $Datatable = new DataTable();
//        $su = new SecurityUser();
        $up = new SecurityUserProfile();
        $db->connect();
        $user = $db->selectByID($up->getUser(), $up->getUser()->getCode() . "='" . $_SESSION[SESSION_USERNAME] . "'");
        $cek_user_profile = $db->selectByID($up, $up->getId() . "=" . $user[0][$up->getId()] . "");

        $confirm = new Confirm();
        $list_data = $Datatable->select_pagination($confirm, $confirm->getEntity());
        include_once FILE_PATH('view/page/member/user-profile/user-profile-edit.html.php');
    }

    public function changePassword() {
        setActiveMenuMember('userprofile,changepassword');
        setTitle(' | ' . lang('general.change_password'));
        include_once FILE_PATH('view/page/member/user-profile/change-password.html.php');
    }

    public function changePasswordProses() {
        $user = new SecurityUser();
//        $userProfile = new SecurityUserProfile();
//        $username = $_POST['username'];
        $passwordOld = $_POST['password-old'];
        $passwordNew = $_POST['password-new'];
        $passwordRenew = $_POST['password-renew'];

//        $salt = substr(md5(uniqid(rand(), true)), 0, 9);
//        $password_e = sha1($salt . sha1($salt . sha1($passwordOld)));
        $dbNew = new Database();
        $dbNew->connect();
//        $dbNew->insert($user->getEntity(),$user);

        $res_user = $dbNew->selectByID($user, $user->getCode() . "='" . $_SESSION[SESSION_USERNAME] . "'");
        if (!empty($res_user)) {
            $salt = $res_user[0][$user->getSalt()];
            $password_e = sha1($salt . sha1($salt . sha1($passwordOld)));
            $password_e_new = sha1($salt . sha1($salt . sha1($passwordNew)));
            if ($res_user[0][$user->getPassword()] == $password_e) {
                if ($password_e_new == $res_user[0][$user->getPassword()]) {
                    echo toastAlert("error", lang('user.title_change_password_failed'), lang('user.message_change_password_failed_new'));
                    echo "<script>$(function(){postAjaxGetValue('" . URL('/page/member/user-profile/change-password') . "','pageMember','" . json_encode($_POST) . "'); })</script>";
                } else if ($passwordNew != $passwordRenew) {
                    echo toastAlert("error", lang('user.title_change_password_failed'), lang('user.message_change_password_failed_not_same'));
                    echo "<script>$(function(){postAjaxGetValue('" . URL('/page/member/user-profile/change-password') . "','pageMember','" . json_encode($_POST) . "'); })</script>";
                } else {
//                    $db->connect();
                    
                    $salt_new = substr(md5(uniqid(rand(), true)), 0, 9);
                    $passwordHashNew = sha1($salt_new . sha1($salt_new . sha1($passwordNew)));
                    $dbNew->update($user->getEntity(), array(
                        $user->getSalt() => $salt_new,
                        $user->getPassword() => $passwordHashNew,
                        $user->getModifiedById() => $res_user[0][$user->getId()],
                        $user->getModifiedOn() => date('Y-m-d h:i:s'),
                        $user->getModifiedByUsername() => $_SESSION[SESSION_USERNAME],
                            ), $user->getId() . "=" . $res_user[0][$user->getId()]);
                    $result_change = $dbNew->getResult();
                    if($result_change[0] == 1){
                        echo toastAlert("success", lang('user.title_change_password_success'), lang('user.title_change_password_success'));
                        echo '<script>window.location.href = "' . URL('/page/member/user-profile/change-password') . '";</script>';
//                         echo "<script>$(function(){postAjaxGetValue('" . URL('/page/member/user-profile/change-password') . "','pageMember','" . json_encode($_POST) . "'); })</script>";
                    } else {
                        echo toastAlert("error", lang('user.title_change_password_failed'), lang('user.message_change_password_failed'));
                        echo "<script>$(function(){postAjaxGetValue('" . URL('/page/member/user-profile/change-password') . "','pageMember','" . json_encode($_POST) . "'); })</script>";
                    }
                }
            } else {
                echo toastAlert("error", lang('user.title_change_password_failed'), lang('user.message_change_password_failed_old'));
                echo "<script>$(function(){postAjaxGetValue('" . URL('/page/member/user-profile/change-password') . "','pageMember','" . json_encode($_POST) . "'); })</script>";
            }
        } else {
            echo toastAlert("error", lang('user.title_change_password_failed'), lang('user.message_change_password_failed'));
            echo "<script>$(function(){postAjaxGetValue('" . URL('/page/member/user-profile/change-password') . "','pageMember','" . json_encode($_POST) . "'); })</script>";
        }
        

//        $res_user = $dbNew->selectByID($user, $user->getEmail() . "='" . $email . "'");
    }

    public function save() {
        if (isset($_POST)) {
            $db = new Database();
            $up = new SecurityUserProfile();
            $users = new SecurityUser();
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $placeofbirth = $_POST['place'];
            $birthdate = $_POST['birthdate'];
            $telephone = $_POST['telephone'];

            $uploadImg = $_FILES['upload_img'];
            $random = createRandomBooking();
            $path = 'uploads/member/' . $_SESSION[SESSION_USERNAME] . '/';
            $upload = uploadImage($uploadImg, $path, $uploadImg["name"][0] . '-' . $random . '-' . date('Ymdhis'));
            $exp_up = explode(",", $upload);
            if ($exp_up[0] == 1) {
                $user = $db->selectByID($up->getUser(), $up->getUser()->getCode() . "='" . $_SESSION[SESSION_USERNAME] . "'");
//        $user = $db->getResult();
//        print_r($user);
                $db->connect();
                $db->update($users->getEntity(), array(
                    $users->getModifiedById() => $user[0][$up->getUser()->getId()],
                    $users->getModifiedOn() => date('Y-m-d h:i:s'),
                    $users->getModifiedByUsername() => $_SESSION[SESSION_USERNAME],
                        ), $up->getUser()->getId() . "=" . $user[0][$up->getUser()->getId()]);

                $db->update($up->getEntity(), array(
                    $up->getFullname() => $firstname . ' ' . $lastname,
                    $up->getPlace() => $placeofbirth,
                    $up->getBirthdate() => $birthdate,
                    $up->getTelp() => $telephone,
                    $up->getPathimage() => $exp_up[1],
                        ), $up->getUser()->getId() . "=" . $user[0][$up->getUser()->getId()]);
                $rs_u = $db->getResult();
                if ($rs_u[0] != 1) {
                    echo toastAlert("error", lang('general.title_update_error'), lang('general.message_update_error'));
                    echo "<script>$(function(){postAjaxGetValue('" . URL('/page/member/user-profile/changeProfile') . "','form-user','" . json_encode($_POST) . "'); })</script>";
                } else {
                    echo toastAlert("success", lang('general.title_update_success'), lang('general.message_update_success'));
                    echo '<script>$(function(){$("#img-user-profile").attr("src","' . URL($path . $exp_up[1]) . '") })</script>';
                    echo "<script>$(function(){postAjaxGetValue('" . URL('/page/member/user-profile/changeProfile') . "','form-user','" . json_encode($_POST) . "'); })</script>";
                }
            } else {
                echo toastAlert("error", lang('general.title_update_error'), $exp_up[1]);
                echo '<script>$(function(){$("#img-user-profile").attr("src","' . URL($path . $exp_up[1]) . '") })</script>';
                echo "<script>$(function(){postAjaxGetValue('" . URL('/page/member/user-profile/changeProfile') . "','form-user','" . json_encode($_POST) . "'); })</script>";
            }
        }
    }

}
