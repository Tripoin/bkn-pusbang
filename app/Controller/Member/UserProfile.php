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
use app\Model\MasterContact;

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
            $Datatable->search = $_POST['search_by'] . '>' . $_POST['search_pagination'];
        }
        $up = new SecurityUserProfile();
        $user = $db->selectByID($up->getUser(), $up->getUser()->getCode() . "='" . $_SESSION[SESSION_USERNAME_GUEST] . "'");
        $cek_user_profile = $db->selectByID($up, $up->getId() . "=" . $user[0][$up->getId()] . "");

        $confirm = new Confirm();
        $list_data = $Datatable->select_pagination($confirm, $confirm->getEntity(), $confirm->getCreatedByUsername() . EQUAL . "'" . $user[0][$up->getUser()->getCode()] . "'");

        $sql_saldo = $db->sql("SELECT SUM(" . $confirm->getTransferAmount() . ") as saldo FROM " . $confirm->getEntity() . " WHERE " . $confirm->getConfirmStatus() . EQUAL . "1 AND " . $confirm->getCreatedByUsername() . "='" . $_SESSION[SESSION_USERNAME_GUEST] . "'");
        $rs_saldo = $db->getResult();
        include_once FILE_PATH('view/page/member/user-profile/user-profile-saldo.html.php');
    }

    public function edit() {
        echo '<form id="form-user" action="' . URL('/page/member/user-profile/save') . '" method="POST" class="form" onsubmit="return false;">';
        $this->changeUserProfile();
        echo '</form>';
    }

    public function changeUserProfile() {
        $Form = new Form();
        $db = new Database();
        $Datatable = new DataTable();
        $su = new SecurityUser();
        $up = new SecurityUserProfile();
        $db->connect();
        $user = $db->selectByID($su, $su->getCode() . "='" . $_SESSION[SESSION_USERNAME_GUEST] . "'");
        $cek_user_profile = $db->selectByID($up, $up->getUserId() . "=" . $user[0][$su->getId()] . "");
        if (!empty($cek_user_profile)) {
            $masterContact = new MasterContact();
            $cek_contact = $db->selectByID($masterContact, $masterContact->getId() . "=" . $cek_user_profile[0][$up->getContactId()] . "");
            $contact = "";
            if (is_array($cek_contact[0])) {
                $contact = $cek_contact[0][$masterContact->getPhoneNumber1()];
            }
        } else {
            $contact = "";
        }
//        $confirm = new Confirm();
//        $list_data = $Datatable->select_pagination($confirm, $confirm->getEntity());
        include_once FILE_PATH('view/page/member/user-profile/user-profile-edit.html.php');
    }

    public function changePassword() {
        setActiveMenuMember('userprofile,changepassword');
        setTitle(' | ' . lang('general.change_password'));
        include_once FILE_PATH('view/page/member/user-profile/change-password.html.php');
    }

    public function changePasswordProses() {
        $user = new SecurityUser();
        $passwordOld = $_POST['password-old'];
        $passwordNew = $_POST['password-new'];
        $passwordRenew = $_POST['password-renew'];

        $dbNew = new Database();
        $dbNew->connect();

        $res_user = $dbNew->selectByID($user, $user->getCode() . "='" . $_SESSION[SESSION_USERNAME_GUEST] . "'");
        if (!empty($res_user)) {
            if (password_verify($passwordOld, $res_user[0][$user->getPassword()])) {
                if (password_verify($passwordRenew, $res_user[0][$user->getPassword()])) {
                    echo toastAlert("error", lang('user.title_change_password_failed'), lang('user.message_change_password_failed_new'));
                    echo "<script>$(function(){postAjaxGetValue('" . URL('/page/member/user-profile/change-password') . "','pageMember','" . json_encode($_POST) . "'); })</script>";
                } else if ($passwordNew != $passwordRenew) {
                    echo toastAlert("error", lang('user.title_change_password_failed'), lang('user.message_change_password_failed_not_same'));
                    echo "<script>$(function(){postAjaxGetValue('" . URL('/page/member/user-profile/change-password') . "','pageMember','" . json_encode($_POST) . "'); })</script>";
                } else {
                    $passwordHashNew = password_hash($passwordRenew, PASSWORD_BCRYPT);
                    $dbNew->update($user->getEntity(), array(
                        $user->getPassword() => $passwordHashNew,
                        $user->getModifiedOn() => date('Y-m-d h:i:s'),
                        $user->getModifiedByUsername() => $_SESSION[SESSION_USERNAME_GUEST],
                            ), $user->getId() . EQUAL . $res_user[0][$user->getId()]);
                    $result_change = $dbNew->getResult();
                    if ($result_change[0] == 1) {
                        echo toastAlert("success", lang('user.title_change_password_success'), lang('user.title_change_password_success'));
                        echo '<script>window.location.href = "' . URL('/page/member/user-profile/change-password') . '";</script>';
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
            $email = $_POST['email'];

            $uploadImg = $_FILES['upload_img'];
//            print_r($uploadImg);
            $ar_up_img = array();
            if ($uploadImg["name"][0] != "") {
                $random = createRandomBooking();
                $path = 'uploads/member/' . $_SESSION[SESSION_USERNAME_GUEST] . '/';
                $upload = uploadImage($uploadImg, $path, $uploadImg["name"][0] . '-' . $random . '-' . date('Ymdhis'));
                $exp_up = explode(",", $upload);
                if ($exp_up[0] == 1) {
                    $ar_up_img = array($up->getPathimage() => $exp_up[1]);
                }
            }

            if ($uploadImg["name"][0] == "") {
                $exp_up[0] = 1;
            }
            if ($exp_up[0] == 1) {
                $user = $db->selectByID($users, $users->getCode() . "='" . $_SESSION[SESSION_USERNAME_GUEST] . "'");
                $userProfile = $db->selectByID($up, $up->getUserId() . "='" . $user[0][$users->getId()] . "'");
//        $user = $db->getResult();
//        print_r($user);
                $db->connect();
                $db->update($users->getEntity(), array(
                    $users->getModifiedOn() => date('Y-m-d h:i:s'),
                    $users->getModifiedByUsername() => $_SESSION[SESSION_USERNAME_GUEST],
                    $users->getEmail() => $email,
                        ), $users->getId() . "=" . $user[0][$users->getId()]);
                $rs_upd_user = $db->getResult();
//                print_r($rs_upd_user);
                $masterContact = new MasterContact();
                $contact = $db->selectByID($masterContact, $masterContact->getId() . "='" . $userProfile[0][$up->getContactId()] . "'");
//                print_r($contact);
                $contactId = 0;
                if (empty($contact)) {
                    $db->insert($masterContact->getEntity(), array(
                        $masterContact->getCode() => createRandomBooking(),
                        $masterContact->getPhoneNumber1() => $telephone
                    ));
                    $rs_insert_contact = $db->getResult();
//                    print_r($rs_insert_contact);
                    if (!is_numeric($rs_insert_contact[0])) {
                        $contactId = null;
                    } else {
                        $contactId = $rs_insert_contact[0];
                    }
                } else {
                    $contactId = $contact[0][$masterContact->getId()];
                    $db->update($masterContact->getEntity(), array(
                        $masterContact->getPhoneNumber1() => $telephone
                            ), $masterContact->getId() . EQUAL . $contactId);
                }
//                print_r($contactId);
                $up_profile = array(
                    $up->getName() => $firstname . ' ' . $lastname,
                    $up->getPlace() => $placeofbirth,
                    $up->getBirthdate() => $birthdate,
                    $up->getContactId() => $contactId,
                );
                $merge_dt_profile = array_merge($ar_up_img, $up_profile);
                $db->update($up->getEntity(), $merge_dt_profile, $up->getId() . "=" . $userProfile[0][$up->getId()]);
                $rs_u = $db->getResult();
//                print_r($rs_u);
                if ($rs_u[0] != 1) {
                    echo toastAlert("error", lang('general.title_update_error'), lang('general.message_update_error'));
                    echo "<script>$(function(){postAjaxGetValue('" . URL('/page/member/user-profile/changeProfile') . "','form-user','" . json_encode($_POST) . "'); })</script>";
                } else {
                    square_crop(URL($path . $exp_up[1]), FILE_PATH('uploads/member/' . $_SESSION[SESSION_USERNAME_GUEST] . '/profile.jpg'), 250);
                    echo toastAlert("success", lang('general.title_update_success'), lang('general.message_update_success'));
                    if ($uploadImg["name"][0] != "") {
                        echo '<script>$(function(){$("#img-user-profile").attr("src","' . URL('uploads/member/' . $_SESSION[SESSION_USERNAME_GUEST] . '/profile.jpg') . '") })</script>';
                    }
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
