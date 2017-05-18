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
use app\Model\MasterUserMain;
use app\Model\SecurityUser;
use app\Model\MasterContact;
use app\Model\MasterReligion;
use app\Model\MasterAddress;
use app\Model\MasterProvince;
use app\Model\MasterCity;
use app\Model\MasterDistrict;
use app\Model\MasterVillage;
use app\Model\MasterWorkingUnit;
use app\Model\MasterGovernmentAgencies;

class UserProfile {

    public function __construct() {
        setActiveMenuMember('userprofile,changeprofile');
    }

    public function index() {
        $Form = new Form();
        setTitle(' | ' . lang('general.user-profile'));
        include_once FILE_PATH('view/page/member/user-profile/user-profile.html.php');
    }

   
    public function edit() {
//        $this->changeUserProfile();
        $this->changeUserProfileAnggota();
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
            $masterReligion = new MasterReligion();
            $masterProvince = new MasterProvince();
            $masterAddress = new MasterAddress();
            $masterCity = new MasterCity();
            $masterDistrict = new MasterDistrict();
            $masterVillage = new MasterVillage();
            $masterUserMain = new MasterUserMain();
            $masterWorkingUnit = new MasterWorkingUnit();
            $cek_contact = $db->selectByID($masterContact, $masterContact->getId() . "=" . $cek_user_profile[0][$up->getContactId()] . "");
            $cek_religion = $db->selectByID($masterReligion, $masterReligion->getId() . "=" . $cek_user_profile[0][$up->getReligionId()] . "");
            $cek_address = $db->selectByID($masterAddress, $masterAddress->getId() . "=" . $cek_user_profile[0][$up->getAddressId()] . "");
            $cek_user_main = $db->selectByID($masterUserMain, $masterUserMain->getUserProfileId() . "=" . $cek_user_profile[0][$up->getId()] . "");
            $phone1=""; $phone2=""; $religion=""; $addressName=""; $province=""; $city=""; $district=""; $village=""; $zipCode="";
            $data_religion = getLov($masterReligion);
            $data_province = getLov($masterProvince);
            $data_city = getLov($masterCity);
            $data_district = getLov($masterDistrict,$masterDistrict->getCity_id().equalToIgnoreCase($cek_address[0][$masterAddress->getCityId()]));
            $data_village = getLov($masterVillage,$masterVillage->getDistrict_id().equalToIgnoreCase($cek_address[0][$masterAddress->getDistrictId()]));
            $data_company = getLov($masterWorkingUnit);
            if (is_array($cek_user_main)) {
                $cek_working_unit = $db->selectByID($masterWorkingUnit, $masterWorkingUnit->getId() . "=" . $cek_user_main[0][$masterUserMain->getWorkingUnitId()] . "");
                $masterGovermentAgency = new MasterGovernmentAgencies();
                $cek_goverment_agencies = $db->selectByID($masterGovermentAgency, $masterGovermentAgency->getId() . "=" . $cek_working_unit[0][$masterWorkingUnit->getGovernment_agency_id()] . "");
                if (is_array($cek_goverment_agencies)) {
                    $company_unit = $cek_goverment_agencies[0][$masterGovermentAgency->getId()];
                }
                if (is_array($cek_user_main)) {
                    $cek_company_contact = $db->selectByID($masterContact, $masterContact->getId() . "=" . $cek_working_unit[0][$masterWorkingUnit->getContact_id()] . "");
                    if (is_array($cek_user_main)) {
                        $company_phone = $cek_company_contact[0][$masterContact->getPhoneNumber1()];
                        $company_fax = $cek_company_contact[0][$masterContact->getFax()];
                        $cek_company_address = $db->selectByID($masterAddress, $masterAddress->getId() . "=" . $cek_working_unit[0][$masterWorkingUnit->getAddress_id()] . "");
                        if (is_array($cek_user_main)) {
                            $company_address = $cek_company_address[0][$masterAddress->getName()];
                            $company_province = $cek_company_address[0][$masterAddress->getProvinceId()];
                            $company_city = $cek_company_address[0][$masterAddress->getCityId()];
                            $company_district = $cek_company_address[0][$masterAddress->getDistrictId()];
                            $company_village = $cek_company_address[0][$masterAddress->getVillageId()];
                            $company_zip_code = $cek_company_address[0][$masterAddress->getZipCode()];
                            $data_district_company = getLov($masterDistrict,$masterDistrict->getCity_id().equalToIgnoreCase($cek_company_address[0][$masterAddress->getCityId()]));
                            $data_village_company = getLov($masterVillage,$masterVillage->getDistrict_id().equalToIgnoreCase($cek_company_address[0][$masterAddress->getDistrictId()]));
                        }
                    }
                }
                $company_name = $cek_working_unit[0][$masterWorkingUnit->getId()];
//                $company_name = $cek_company[0][$masterCompany->getName()];
            }
            if (is_array($cek_contact[0])) {
                $phone1 = $cek_contact[0][$masterContact->getPhoneNumber1()];
                $phone2 = $cek_contact[0][$masterContact->getPhoneNumber2()];
                if(!empty($cek_religion)) $religion = $cek_religion[0][$masterReligion->getId()];
                if(!empty($cek_address)){
                    $addressName = $cek_address[0][$masterAddress->getName()];
                    $province = $cek_address[0][$masterAddress->getProvinceId()];
                    $city = $cek_address[0][$masterAddress->getCityId()];
                    $district = $cek_address[0][$masterAddress->getDistrictId()];
                    $village = $cek_address[0][$masterAddress->getVillageId()];
                    $zipCode = $cek_address[0][$masterAddress->getZipCode()];
                }
            }
        } else {
            $phone1 = ""; $phone2 = "";
        }
        $data_denger = array(
            array("id"=>"M","label"=>"Laki-Laki"),
            array("id"=>"F","label"=>"Perempuan"),
        );
        $data_maritalStatus = array(
            array("id"=>"0","label"=>"Belum menikah"),
            array("id"=>"1","label"=>"Menikah"),
        );
        
        include_once FILE_PATH('view/page/member/user-profile/user-profile-edit.html.php');
    }

    public function changeUserProfileAnggota() {
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
            $masterReligion = new MasterReligion();
            $masterProvince = new MasterProvince();
            $masterAddress = new MasterAddress();
            $masterCity = new MasterCity();
            $masterDistrict = new MasterDistrict();
            $masterVillage = new MasterVillage();
            $masterUserMain = new MasterUserMain();
            $masterWorkingUnit = new MasterWorkingUnit();
            $cek_contact = $db->selectByID($masterContact, $masterContact->getId() . "=" . $cek_user_profile[0][$up->getContactId()] . "");
            $cek_religion = $db->selectByID($masterReligion, $masterReligion->getId() . "=" . $cek_user_profile[0][$up->getReligionId()] . "");
            $cek_address = $db->selectByID($masterAddress, $masterAddress->getId() . "=" . $cek_user_profile[0][$up->getAddressId()] . "");
            $cek_user_main = $db->selectByID($masterUserMain, $masterUserMain->getUserProfileId() . "=" . $cek_user_profile[0][$up->getId()] . "");
            $phone1=""; $phone2=""; $religion=""; $addressName=""; $province=""; $city=""; $district=""; $village=""; $zipCode="";
            $data_religion = getLov($masterReligion);
            $data_province = getLov($masterProvince);
            $data_city = getLov($masterCity);
            $data_district = getLov($masterDistrict,$masterDistrict->getCity_id().equalToIgnoreCase($cek_address[0][$masterAddress->getCityId()]));
            $data_village = getLov($masterVillage,$masterVillage->getDistrict_id().equalToIgnoreCase($cek_address[0][$masterAddress->getDistrictId()]));
            $data_company = getLov($masterWorkingUnit);
            if (is_array($cek_user_main)) {
                $cek_working_unit = $db->selectByID($masterWorkingUnit, $masterWorkingUnit->getId() . "=" . $cek_user_main[0][$masterUserMain->getWorkingUnitId()] . "");
                $masterGovermentAgency = new MasterGovernmentAgencies();
                $cek_goverment_agencies = $db->selectByID($masterGovermentAgency, $masterGovermentAgency->getId() . "=" . $cek_working_unit[0][$masterWorkingUnit->getGovernment_agency_id()] . "");
                if (is_array($cek_goverment_agencies)) {
                    $company_unit = $cek_goverment_agencies[0][$masterGovermentAgency->getId()];
                }
                if (is_array($cek_user_main)) {
                    $cek_company_contact = $db->selectByID($masterContact, $masterContact->getId() . "=" . $cek_working_unit[0][$masterWorkingUnit->getContact_id()] . "");
                    if (is_array($cek_user_main)) {
                        $company_phone = $cek_company_contact[0][$masterContact->getPhoneNumber1()];
                        $company_fax = $cek_company_contact[0][$masterContact->getFax()];
                        $cek_company_address = $db->selectByID($masterAddress, $masterAddress->getId() . "=" . $cek_working_unit[0][$masterWorkingUnit->getAddress_id()] . "");
                        if (is_array($cek_user_main)) {
                            $company_address = $cek_company_address[0][$masterAddress->getName()];
                            $company_province = $cek_company_address[0][$masterAddress->getProvinceId()];
                            $company_city = $cek_company_address[0][$masterAddress->getCityId()];
                            $company_district = $cek_company_address[0][$masterAddress->getDistrictId()];
                            $company_village = $cek_company_address[0][$masterAddress->getVillageId()];
                            $company_zip_code = $cek_company_address[0][$masterAddress->getZipCode()];
                            $data_district_company = getLov($masterDistrict,$masterDistrict->getCity_id().equalToIgnoreCase($cek_company_address[0][$masterAddress->getCityId()]));
                            $data_village_company = getLov($masterVillage,$masterVillage->getDistrict_id().equalToIgnoreCase($cek_company_address[0][$masterAddress->getDistrictId()]));
                        }
                    }
                }
                $company_name = $cek_working_unit[0][$masterWorkingUnit->getId()];
//                $company_name = $cek_company[0][$masterCompany->getName()];
            }
            if (is_array($cek_contact[0])) {
                $phone1 = $cek_contact[0][$masterContact->getPhoneNumber1()];
                $phone2 = $cek_contact[0][$masterContact->getPhoneNumber2()];
                if(!empty($cek_religion)) $religion = $cek_religion[0][$masterReligion->getId()];
                if(!empty($cek_address)){
                    $addressName = $cek_address[0][$masterAddress->getName()];
                    $province = $cek_address[0][$masterAddress->getProvinceId()];
                    $city = $cek_address[0][$masterAddress->getCityId()];
                    $district = $cek_address[0][$masterAddress->getDistrictId()];
                    $village = $cek_address[0][$masterAddress->getVillageId()];
                    $zipCode = $cek_address[0][$masterAddress->getZipCode()];
                }
            }
        } else {
            $phone1 = ""; $phone2 = "";
        }
        $data_denger = array(
            array("id"=>"M","label"=>"Laki-Laki"),
            array("id"=>"F","label"=>"Perempuan"),
        );
        $data_maritalStatus = array(
            array("id"=>"0","label"=>"Belum menikah"),
            array("id"=>"1","label"=>"Menikah"),
        );
        
        include_once FILE_PATH('view/page/member/user-profile/user-profile-edit-anggota.html.php');
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
                        $user->getModifiedOn() =>  date(DATE_FORMAT_PHP_DEFAULT),
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
    
    //UNTUK LOGIN ANGGOTA
    public function save() {
        if (isset($_POST)) {
            $db = new Database();
            $up = new SecurityUserProfile();
            $users = new SecurityUser();
            $userMain = new MasterUserMain();
            $name = $_POST['name'];
            $placeofbirth = $_POST['place'];
            $birthdate = $_POST['birthdate'];
            $telephone = $_POST['telephone'];
            $telephone2 = $_POST['telephone2'];
            $email = $_POST['email'];
            $gender = $_POST['gender'];
            $religion = $_POST['religion'];
            $maritalStatus = $_POST['maritalStatus'];
            
            
            $addressName = $_POST['addressName'];
            $province = $_POST['province'];
            $city = $_POST['city'];
            $district = $_POST['district'];
            $village = $_POST['village'];
            $zipCode = $_POST['zipCode'];
            $companyName = $_POST['companyName'];
            $companyUnit = $_POST['companyUnit'];
            $companyAddress = $_POST['companyAddress'];
            $companyProvince = $_POST['companyProvince'];
            $companyCity = $_POST['companyCity'];
            $companyDistrict = $_POST['companyDistrict'];
            $companyVillage = $_POST['companyVillage'];
            $companyZipCode = $_POST['companyZipCode'];

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
                    $users->getModifiedOn() =>  date(DATE_FORMAT_PHP_DEFAULT),
                    $users->getModifiedByUsername() => $_SESSION[SESSION_USERNAME_GUEST],
                    $users->getEmail() => $email,
                        ), $users->getId() . "=" . $user[0][$users->getId()]);
                $rs_upd_user = $db->getResult();
                /*$db->update($userMain->getEntity(),array(
                    $userMain->getCode()=>$_POST['email']
                ),$userMain->getUserProfileId().EQUAL.$userProfile[0][$up->getId()]);
                $resultUpdateUserMain = $db->getResult();
                 * 
                 */
                
//                print_r($rs_upd_user);
                $masterContact = new MasterContact();
                $contact = $db->selectByID($masterContact, $masterContact->getId() . "='" . $userProfile[0][$up->getContactId()] . "'");
//                print_r($contact);
                $contactId = 0;
                if (empty($contact)) {
                    $db->insert($masterContact->getEntity(), array(
                        $masterContact->getCode() => createRandomBooking(),
                        $masterContact->getPhoneNumber1() => $telephone,
                        $masterContact->getPhoneNumber2() => $telephone2
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
                        $masterContact->getPhoneNumber1() => $telephone,
                        $masterContact->getPhoneNumber2() => $telephone2
                    ), $masterContact->getId() . EQUAL . $contactId);
                }
//                print_r($contactId);
                $up_profile = array(
                    $up->getName() => $name,
                    $up->getPlace() => $placeofbirth,
                    $up->getBirthdate() => $birthdate,
                    $up->getContactId() => $contactId,
                    $up->getGender() => $gender,
                    $up->getReligionId() => $religion,
                    $up->getMarriage() => $maritalStatus,
                );
                $merge_dt_profile = array_merge($ar_up_img, $up_profile);
                $db->update($up->getEntity(), $merge_dt_profile, $up->getId() . "=" . $userProfile[0][$up->getId()]);
                $rs_u = $db->getResult();
//                print_r($rs_u);
                if ($rs_u[0] != 1) {
                    echo toastAlert("error", lang('general.title_update_error'), lang('general.message_update_error'));
                    echo "<script>$(function(){postAjaxGetValue('" . URL('/page/member/user-profile/changeProfileAnggota') . "','form-user','" . json_encode($_POST) . "'); })</script>";
                } else {
                    square_crop(URL($path . $exp_up[1]), FILE_PATH('uploads/member/' . $_SESSION[SESSION_USERNAME_GUEST] . '/profile.jpg'), 250);
                    echo toastAlert("success", lang('general.title_update_success'), lang('general.message_update_success'));
                    if ($uploadImg["name"][0] != "") {
                        echo '<script>$(function(){$("#img-user-profile").attr("src","' . URL('uploads/member/' . $_SESSION[SESSION_USERNAME_GUEST] . '/profile.jpg') . '") })</script>';
                    }
                    echo "<script>$(function(){postAjaxGetValue('" . URL('/page/member/user-profile/changeProfileAnggota') . "','form-user','" . json_encode($_POST) . "'); })</script>";
                }
            } else {
                echo toastAlert("error", lang('general.title_update_error'), $exp_up[1]);
                echo '<script>$(function(){$("#img-user-profile").attr("src","' . URL($path . $exp_up[1]) . '") })</script>';
                echo "<script>$(function(){postAjaxGetValue('" . URL('/page/member/user-profile/changeProfileAnggota') . "','form-user','" . json_encode($_POST) . "'); })</script>";
            }
        }
    }

//    UNTUK LOGIN USER
//    public function save() {
//        if (isset($_POST)) {
//            $db = new Database();
//            $up = new SecurityUserProfile();
//            $users = new SecurityUser();
//            $userMain = new MasterUserMain();
//            $name = $_POST['name'];
//            $placeofbirth = $_POST['place'];
//            $birthdate = $_POST['birthdate'];
//            $telephone = $_POST['telephone'];
//            $telephone2 = $_POST['telephone2'];
//            $email = $_POST['email'];
//            $gender = $_POST['gender'];
//            $religion = $_POST['religion'];
//            $maritalStatus = $_POST['maritalStatus'];
//            
//            
//            $addressName = $_POST['addressName'];
//            $province = $_POST['province'];
//            $city = $_POST['city'];
//            $district = $_POST['district'];
//            $village = $_POST['village'];
//            $zipCode = $_POST['zipCode'];
//            $companyName = $_POST['companyName'];
//            $companyUnit = $_POST['companyUnit'];
//            $companyAddress = $_POST['companyAddress'];
//            $companyProvince = $_POST['companyProvince'];
//            $companyCity = $_POST['companyCity'];
//            $companyDistrict = $_POST['companyDistrict'];
//            $companyVillage = $_POST['companyVillage'];
//            $companyZipCode = $_POST['companyZipCode'];
//
//            $uploadImg = $_FILES['upload_img'];
////            print_r($uploadImg);
//            $ar_up_img = array();
//            if ($uploadImg["name"][0] != "") {
//                $random = createRandomBooking();
//                $path = 'uploads/member/' . $_SESSION[SESSION_USERNAME_GUEST] . '/';
//                $upload = uploadImage($uploadImg, $path, $uploadImg["name"][0] . '-' . $random . '-' . date('Ymdhis'));
//                $exp_up = explode(",", $upload);
//                if ($exp_up[0] == 1) {
//                    $ar_up_img = array($up->getPathimage() => $exp_up[1]);
//                }
//            }
//
//            if ($uploadImg["name"][0] == "") {
//                $exp_up[0] = 1;
//            }
//            if ($exp_up[0] == 1) {
//                $user = $db->selectByID($users, $users->getCode() . "='" . $_SESSION[SESSION_USERNAME_GUEST] . "'");
//                $userProfile = $db->selectByID($up, $up->getUserId() . "='" . $user[0][$users->getId()] . "'");
////        $user = $db->getResult();
////        print_r($user);
//                $db->connect();
//                $db->update($users->getEntity(), array(
//                    $users->getModifiedOn() =>  date(DATE_FORMAT_PHP_DEFAULT),
//                    $users->getModifiedByUsername() => $_SESSION[SESSION_USERNAME_GUEST],
//                    $users->getEmail() => $email,
//                        ), $users->getId() . "=" . $user[0][$users->getId()]);
//                $rs_upd_user = $db->getResult();
//                /*$db->update($userMain->getEntity(),array(
//                    $userMain->getCode()=>$_POST['email']
//                ),$userMain->getUserProfileId().EQUAL.$userProfile[0][$up->getId()]);
//                $resultUpdateUserMain = $db->getResult();
//                 * 
//                 */
//                
////                print_r($rs_upd_user);
//                $masterContact = new MasterContact();
//                $contact = $db->selectByID($masterContact, $masterContact->getId() . "='" . $userProfile[0][$up->getContactId()] . "'");
////                print_r($contact);
//                $contactId = 0;
//                if (empty($contact)) {
//                    $db->insert($masterContact->getEntity(), array(
//                        $masterContact->getCode() => createRandomBooking(),
//                        $masterContact->getPhoneNumber1() => $telephone,
//                        $masterContact->getPhoneNumber2() => $telephone2
//                    ));
//                    $rs_insert_contact = $db->getResult();
////                    print_r($rs_insert_contact);
//                    if (!is_numeric($rs_insert_contact[0])) {
//                        $contactId = null;
//                    } else {
//                        $contactId = $rs_insert_contact[0];
//                    }
//                } else {
//                    $contactId = $contact[0][$masterContact->getId()];
//                    $db->update($masterContact->getEntity(), array(
//                        $masterContact->getPhoneNumber1() => $telephone,
//                        $masterContact->getPhoneNumber2() => $telephone2
//                    ), $masterContact->getId() . EQUAL . $contactId);
//                }
////                print_r($contactId);
//                $up_profile = array(
//                    $up->getName() => $name,
//                    $up->getPlace() => $placeofbirth,
//                    $up->getBirthdate() => $birthdate,
//                    $up->getContactId() => $contactId,
//                    $up->getGender() => $gender,
//                    $up->getReligionId() => $religion,
//                    $up->getMarriage() => $maritalStatus,
//                );
//                $merge_dt_profile = array_merge($ar_up_img, $up_profile);
//                $db->update($up->getEntity(), $merge_dt_profile, $up->getId() . "=" . $userProfile[0][$up->getId()]);
//                $rs_u = $db->getResult();
////                print_r($rs_u);
//                if ($rs_u[0] != 1) {
//                    echo toastAlert("error", lang('general.title_update_error'), lang('general.message_update_error'));
//                    echo "<script>$(function(){postAjaxGetValue('" . URL('/page/member/user-profile/changeProfile') . "','form-user','" . json_encode($_POST) . "'); })</script>";
//                } else {
//                    square_crop(URL($path . $exp_up[1]), FILE_PATH('uploads/member/' . $_SESSION[SESSION_USERNAME_GUEST] . '/profile.jpg'), 250);
//                    echo toastAlert("success", lang('general.title_update_success'), lang('general.message_update_success'));
//                    if ($uploadImg["name"][0] != "") {
//                        echo '<script>$(function(){$("#img-user-profile").attr("src","' . URL('uploads/member/' . $_SESSION[SESSION_USERNAME_GUEST] . '/profile.jpg') . '") })</script>';
//                    }
//                    echo "<script>$(function(){postAjaxGetValue('" . URL('/page/member/user-profile/changeProfile') . "','form-user','" . json_encode($_POST) . "'); })</script>";
//                }
//            } else {
//                echo toastAlert("error", lang('general.title_update_error'), $exp_up[1]);
//                echo '<script>$(function(){$("#img-user-profile").attr("src","' . URL($path . $exp_up[1]) . '") })</script>';
//                echo "<script>$(function(){postAjaxGetValue('" . URL('/page/member/user-profile/changeProfile') . "','form-user','" . json_encode($_POST) . "'); })</script>";
//            }
//        }
//    }
    

}
