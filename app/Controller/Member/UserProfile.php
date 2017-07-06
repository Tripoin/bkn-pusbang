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
use app\Model\TransactionRegistration;
use app\Model\MasterUserMain;
use app\Model\MasterNoIdType;
use app\Model\SecurityUser;
use app\Model\SecurityGroup;
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

    public $userMember = array();

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
        $securityGroup = new SecurityGroup();
        $this->userMember = getUserMember();
        if ($this->userMember[$securityGroup->getEntity()][$securityGroup->getCode()] == "DELEGATION") {
            $this->changeUserProfilePIC();
        } else {
            $this->changeUserProfile();
        }
    }

    public function changeUserProfile() {
        $userMember = $this->userMember;
        $securityGroup = new SecurityGroup();
//        print_r($userMember);
        $Form = new Form();
        $db = new Database();
        $Datatable = new DataTable();
        $su = new SecurityUser();
        $up = new SecurityUserProfile();
        $masterContact = new MasterContact();
        $masterReligion = new MasterReligion();
        $masterProvince = new MasterProvince();
        $masterAddress = new MasterAddress();
        $masterCity = new MasterCity();
        $masterDistrict = new MasterDistrict();
        $masterVillage = new MasterVillage();
        $masterNoidType = new MasterNoIdType();
        $masterUserMain = new MasterUserMain();
        $masterWorkingUnit = new MasterWorkingUnit();
        $transactionRegistration = new TransactionRegistration();
        $db->connect();
        $data_gender = array(
            array("id" => "M", "label" => "Laki-Laki"),
            array("id" => "F", "label" => "Perempuan"),
        );
        $data_maritalStatus = array(
            array("id" => "0", "label" => "Belum menikah"),
            array("id" => "1", "label" => "Menikah"),
        );
        $data_province = getLov($masterProvince);
        $data_religion = getLov($masterReligion);
        $data_noid_type = getLov($masterNoidType);
        include_once FILE_PATH('view/page/member/user-profile/user-profile-edit-internal-external.html.php');
    }

    public function changeUserProfilePIC() {
        $userMember = $this->userMember;
        $securityGroup = new SecurityGroup();
//        print_r($userMember);
        $Form = new Form();
        $db = new Database();
        $Datatable = new DataTable();
        $su = new SecurityUser();
        $up = new SecurityUserProfile();
        $masterContact = new MasterContact();
        $masterReligion = new MasterReligion();
        $masterProvince = new MasterProvince();
        $masterAddress = new MasterAddress();
        $masterCity = new MasterCity();
        $masterDistrict = new MasterDistrict();
        $masterVillage = new MasterVillage();
        $masterUserMain = new MasterUserMain();
        $masterWorkingUnit = new MasterWorkingUnit();
        $transactionRegistration = new TransactionRegistration();
        $db->connect();
        $data_denger = array(
            array("id" => "M", "label" => "Laki-Laki"),
            array("id" => "F", "label" => "Perempuan"),
        );
        $data_maritalStatus = array(
            array("id" => "0", "label" => "Belum menikah"),
            array("id" => "1", "label" => "Menikah"),
        );
        $data_province = getLov($masterProvince);
        $data_religion = getLov($masterReligion);

        $data_registration = $db->selectByID($transactionRegistration, $transactionRegistration->getUserId()
                . equalToIgnoreCase($userMember[$su->getEntity()][$su->getId()]));
        include_once FILE_PATH('view/page/member/user-profile/user-profile-edit-pic.html.php');
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
                        $user->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT),
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
        $userMember = getUserMember();
        $securityGroup = new SecurityGroup();
//        print_r($userMember);
        $db = new Database();
        $securityUser = new SecurityUser();
        $securityUserProfile = new SecurityUserProfile();
        $masterContact = new MasterContact();
        $masterReligion = new MasterReligion();
        $masterProvince = new MasterProvince();
        $masterAddress = new MasterAddress();
        $masterCity = new MasterCity();
        $masterDistrict = new MasterDistrict();
        $masterVillage = new MasterVillage();
        $masterUserMain = new MasterUserMain();
        $masterWorkingUnit = new MasterWorkingUnit();
        $masterGovernmentAgencies = new MasterGovernmentAgencies();
        $transactionRegistration = new TransactionRegistration();
        if (isset($_POST)) {
            $db->connect();
            if ($userMember[$securityGroup->getEntity()][$securityGroup->getCode()] == "DELEGATION") {

                /* foreach ($_POST as $key => $value) {
                  echo '$' . $key . ' = $_POST[\'' . $key . '\'];<br/>';
                  }
                 * 
                 */
                $name = $_POST['name'];
                $email = $_POST['email'];
                $telephone = $_POST['telephone'];
                $birthdate = $_POST['birthdate'];
                $place = $_POST['place'];
                $gender = $_POST['gender'];
                $religion = $_POST['religion'];
                $maritalStatus = $_POST['maritalStatus'];
                $province = $_POST['province'];
                $city = $_POST['city'];
                $district = $_POST['district'];
                $village = $_POST['village'];
                $zipCode = $_POST['zipCode'];
                $agencies_name = $_POST['agencies_name'];
                $working_unit = "";
                if (isset($_POST['working_unit'])) {
                    $working_unit = $_POST['working_unit'];
                }

//                $wu_phone_number = "";
//                $wu_fax = "";
//                $wu_address = "";
                $wu_province = "";
                $wu_city = "";
                $wu_district = "";
                $wu_village = "";
                $wu_zipCode = "";
                $wu_phone_number = $_POST['wu_phone_number'];
                $wu_fax = $_POST['wu_fax'];
                $wu_address = $_POST['wu_address'];
                if (isset($_POST['wu_province'])) {

                    $wu_province = $_POST['wu_province'];
                    $wu_city = $_POST['wu_city'];
                    $wu_district = $_POST['wu_district'];
                    $wu_village = $_POST['wu_village'];
                    $wu_zipCode = $_POST['wu_zipCode'];
                }

                $result_update = true;
                $db->update($securityUser->getEntity(), array(
                    $securityUser->getEmail() => $email,
                    $securityUser->getModifiedByUsername() => $userMember[$securityUser->getEntity()][$securityUser->getCode()],
                    $securityUser->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT)
                        ), $securityUser->getId() . equalToIgnoreCase($userMember[$securityUser->getEntity()][$securityUser->getId()]));
                $rs_update_user = $db->getResult();
                if (is_numeric($rs_update_user[0]) == 1) {
                    $db->update($securityUserProfile->getEntity(), array(
                        $securityUserProfile->getName() => $name,
                        $securityUserProfile->getBirthdate() => $birthdate,
                        $securityUserProfile->getGender() => $gender,
                        $securityUserProfile->getReligionId() => $religion,
                        $securityUserProfile->getPlace() => $place,
                        $securityUserProfile->getMarriage() => $maritalStatus,
                        $securityUserProfile->getModifiedByUsername() => $userMember[$securityUser->getEntity()][$securityUser->getCode()],
                        $securityUserProfile->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT)
                            ), $securityUserProfile->getId() . equalToIgnoreCase($userMember[$securityUserProfile->getEntity()][$securityUserProfile->getId()]));
                    $rs_update_user_profile = $db->getResult();
                    if (is_numeric($rs_update_user_profile[0]) == 1) {
                        $rs_update_contact_user = true;
                        if ($userMember[$securityUserProfile->getEntity()][$securityUserProfile->getContactId()] == null) {
                            $db->insert($masterContact->getEntity(), array(
                                $masterContact->getEmail1() => $email,
                                $masterContact->getPhoneNumber1() => $telephone,
                                $masterContact->getStatus() => 1,
                                $masterContact->getCreatedByUsername() => $userMember[$securityUser->getEntity()][$securityUser->getCode()],
                                $masterContact->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT)
                            ));
                            $rs_insert_contact = $db->getResult();
                            if (!is_numeric($rs_insert_contact[0])) {
                                $rs_update_contact_user = false;
                            } else {
                                $db->update($securityUserProfile->getEntity(), array(
                                    $securityUserProfile->getContactId() => $rs_insert_contact[0],
                                        ), $securityUserProfile->getId() . equalToIgnoreCase($userMember[$securityUserProfile->getEntity()][$securityUserProfile->getId()]));
                                if (is_numeric($rs_insert_contact[0]) != 1) {
                                    $rs_update_contact_user = false;
                                }
                            }
                        } else {
                            $db->update($masterContact->getEntity(), array(
                                $masterContact->getEmail1() => $email,
                                $masterContact->getPhoneNumber1() => $telephone,
                                $masterContact->getModifiedByUsername() => $userMember[$securityUser->getEntity()][$securityUser->getCode()],
                                $masterContact->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT)
                                    ), $masterContact->getId() . equalToIgnoreCase($userMember[$securityUserProfile->getEntity()][$securityUserProfile->getContactId()]));
                            $rs_update_contact = $db->getResult();
                            if (is_numeric($rs_update_contact[0]) != 1) {
                                $rs_update_contact_user = false;
                            }
                        }
                        if ($rs_update_contact_user == true) {
                            $rs_update_address_user = true;
                            if ($userMember[$securityUserProfile->getEntity()][$securityUserProfile->getAddressId()] == null) {
                                $db->insert($masterAddress->getEntity(), array(
                                    $masterAddress->getProvinceId() => $province,
                                    $masterAddress->getCityId() => $city,
                                    $masterAddress->getDistrictId() => $district,
                                    $masterAddress->getVillageId() => $village,
                                    $masterAddress->getZipCode() => $zipCode,
                                    $masterAddress->getStatus() => 1,
                                    $masterAddress->getCreatedByUsername() => $userMember[$securityUser->getEntity()][$securityUser->getCode()],
                                    $masterAddress->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT)
                                ));
                                $rs_insert_address = $db->getResult();
                                if (!is_numeric($rs_insert_address[0])) {
                                    $rs_update_address_user = false;
                                } else {
                                    $db->update($securityUserProfile->getEntity(), array(
                                        $securityUserProfile->getAddressId() => $rs_insert_address[0],
                                            ), $securityUserProfile->getId() . equalToIgnoreCase($userMember[$securityUserProfile->getEntity()][$securityUserProfile->getId()]));
                                    if (is_numeric($rs_insert_contact[0]) != 1) {
                                        $rs_update_address_user = false;
                                    }
                                }
                            } else {
                                $db->update($masterAddress->getEntity(), array(
                                    $masterAddress->getProvinceId() => $province,
                                    $masterAddress->getCityId() => $city,
                                    $masterAddress->getDistrictId() => $district,
                                    $masterAddress->getVillageId() => $village,
                                    $masterAddress->getZipCode() => $zipCode,
                                    $masterAddress->getModifiedByUsername() => $userMember[$securityUser->getEntity()][$securityUser->getCode()],
                                    $masterAddress->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT)
                                        ), $masterAddress->getId() . equalToIgnoreCase($userMember[$securityUserProfile->getEntity()][$securityUserProfile->getAddressId()]));
                                $rs_update_address = $db->getResult();
                                if (is_numeric($rs_update_address[0]) != 1) {
                                    $rs_update_address_user = false;
                                }
                            }
                            if ($rs_update_address_user == true) {
//                                $masterGovernmentAgencies;
                                $data_registration = $db->selectByID($transactionRegistration, $transactionRegistration->getUserId()
                                        . equalToIgnoreCase($userMember[$securityUserProfile->getEntity()][$securityUserProfile->getId()]));
                                if ($data_registration[0][$transactionRegistration->getParticipantTypeId()] == 2) {
                                    $data_agencies = $db->selectByID($masterGovernmentAgencies, 'UCASE(' . $masterGovernmentAgencies->getName() . ')' . equalToIgnoreCase(strtoupper($agencies_name)));
                                    $agencies_id = null;
                                    if (empty($data_agencies)) {
                                        $db->insert($masterGovernmentAgencies->getEntity(), array(
                                            $masterGovernmentAgencies->getCode() => createRandomBooking(),
                                            $masterGovernmentAgencies->getName() => strtoupper($agencies_name),
                                            $masterGovernmentAgencies->getCreatedByUsername() => $userMember[$securityUser->getEntity()][$securityUser->getCode()],
                                            $masterGovernmentAgencies->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT)
                                        ));
                                        $rs_insert_government = $db->getResult();
                                        if (is_numeric($rs_insert_government[0])) {
                                            $agencies_id = $rs_insert_government[0];
                                        } else {
                                            $agencies_id = null;
                                        }
                                    } else {
                                        $agencies_id = $data_agencies[0][$masterGovernmentAgencies->getId()];
                                    }

                                    $data_working_unit = $db->selectByID($masterWorkingUnit, 'UCASE(' . $masterWorkingUnit->getName() . ')' . equalToIgnoreCase(strtoupper($working_unit)));
                                    $working_unit_id = null;
                                    if (empty($data_working_unit)) {
                                        $db->insert($masterContact->getEntity(), array(
                                            $masterContact->getPhoneNumber1() => $wu_phone_number,
                                            $masterContact->getFax() => $wu_fax,
                                            $masterContact->getStatus() => 1,
                                            $masterContact->getCreatedByUsername() => $userMember[$securityUser->getEntity()][$securityUser->getCode()],
                                            $masterContact->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT)
                                        ));
                                        $rs_insert_wu_contact = $db->getResult();
                                        if (is_numeric($rs_insert_wu_contact[0])) {
                                            $db->insert($masterAddress->getEntity(), array(
                                                $masterAddress->getProvinceId() => $wu_province,
                                                $masterAddress->getCityId() => $wu_city,
                                                $masterAddress->getDistrictId() => $wu_district,
                                                $masterAddress->getVillageId() => $wu_village,
                                                $masterAddress->getZipCode() => $wu_zipCode,
                                                $masterAddress->getStatus() => 1,
                                                $masterAddress->getCreatedByUsername() => $userMember[$securityUser->getEntity()][$securityUser->getCode()],
                                                $masterAddress->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT)
                                            ));
                                            $rs_insert_wu_address = $db->getResult();
                                            if (is_numeric($rs_insert_wu_address[0])) {
                                                $db->insert($masterWorkingUnit->getEntity(), array(
                                                    $masterWorkingUnit->getCode() => createRandomBooking(),
                                                    $masterWorkingUnit->getName() => strtoupper($working_unit),
                                                    $masterWorkingUnit->getContact_id() => $rs_insert_wu_contact[0],
                                                    $masterWorkingUnit->getAddress_id() => $rs_insert_wu_address[0],
                                                    $masterWorkingUnit->getGovernment_agency_id() => $agencies_id,
                                                    $masterWorkingUnit->getStatus() => 1,
                                                    $masterWorkingUnit->getCreatedByUsername() => $userMember[$securityUser->getEntity()][$securityUser->getCode()],
                                                    $masterWorkingUnit->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT)
                                                ));
                                                $rs_insert_wu_working_unit = $db->getResult();
                                                if (is_numeric($rs_insert_wu_working_unit[0])) {
                                                    $working_unit_id = $rs_insert_wu_working_unit[0];
                                                }
                                            }
                                        }
                                    } else {
                                        $working_unit_id = $data_working_unit[0][$masterWorkingUnit->getId()];
                                    }
                                    $db->update($transactionRegistration->getEntity(), array(
                                        $transactionRegistration->getWorkingUnitId() => $working_unit_id,
                                        $transactionRegistration->getModifiedByUsername() => $userMember[$securityUser->getEntity()][$securityUser->getCode()],
                                        $transactionRegistration->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT)
                                            ), $transactionRegistration->getUserId() . equalToIgnoreCase($userMember[$securityUser->getEntity()][$securityUser->getId()]));
                                    $rs_update_reg = $db->getResult();
                                    if (is_numeric($rs_update_reg[0]) == 1) {
                                        $result_update = true;
                                    } else {
                                        $result_update = false;
                                    }
                                } else {
                                    $db->update($transactionRegistration->getEntity(), array(
                                        $transactionRegistration->getWorkingUnitId() => null,
                                        $transactionRegistration->getWorkingUnitName() => $agencies_name,
                                        $transactionRegistration->getWuAddress() => $wu_address,
                                        $transactionRegistration->getWuFax() => $wu_fax,
                                        $transactionRegistration->getWuProvinceId() => $wu_province,
                                        $transactionRegistration->getWuCityId() => $wu_city,
                                        $transactionRegistration->getWuDistrictId() => $wu_district,
                                        $transactionRegistration->getWuVillageId() => $wu_village,
                                        $transactionRegistration->getWuZipCode() => $wu_zipCode,
                                        $transactionRegistration->getModifiedByUsername() => $userMember[$securityUser->getEntity()][$securityUser->getCode()],
                                        $transactionRegistration->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT)
                                            ), $transactionRegistration->getUserId() . equalToIgnoreCase($userMember[$securityUser->getEntity()][$securityUser->getId()]));
                                    $rs_update_reg = $db->getResult();
                                    if (is_numeric($rs_update_reg[0]) == 1) {
                                        $result_update = true;
                                    } else {
                                        $result_update = false;
                                    }
                                }
                            } else {
                                $result_update = false;
                            }
                        } else {
                            $result_update = false;
                        }
                    } else {
                        $result_update = false;
                    }
                } else {
                    $result_update = false;
                }
                if ($result_update == true) {
                    echo resultPageMsg('success', lang('general.title_update_success'), lang('general.message_update_success'));
                } else {
                    echo resultPageMsg('danger', lang('general.title_update_error'), lang('general.message_update_error'));
                }
            } else {
                /* foreach ($_POST as $key => $value) {
                  echo '$' . $key . ' = $_POST[\'' . $key . '\'];<br/>';
                  } */
                $db = new Database();
                $up = new SecurityUserProfile();
                $users = new SecurityUser();
                $userMain = new MasterUserMain();
                $db->connect();

                $participant_name = $_POST['participant_name'];
                $idNumber = $_POST['idNumber'];
                $noidType = $_POST['noidType'];
                $front_degree = $_POST['front_degree'];
                $behind_degree = $_POST['behind_degree'];
                $place_of_birth = $_POST['place_of_birth'];
                $date_of_birth = $_POST['date_of_birth'];
                $religion = $_POST['religion'];
                $gender = null;
                if (isset($_POST['gender'])) {
                    $gender = $_POST['gender'];
                }
                $maritalStatus = null;
                if (isset($_POST['maritalStatus'])) {
                    $maritalStatus = $_POST['maritalStatus'];
                }
                $email = $_POST['email'];
                $telephone = $_POST['telephone'];
                $fax = $_POST['fax'];

                $province = null;
                $city = null;
                $district = null;
                $village = null;

                if ($_POST['participant_province'] != "") {
                    $province = $_POST['participant_province'];
                }
                if ($_POST['participant_city'] != "") {
                    $city = $_POST['participant_city'];
                }
                if ($_POST['participant_district'] != "") {
                    $district = $_POST['participant_district'];
                }
                if ($_POST['participant_village'] != "") {
                    $village = $_POST['participant_village'];
                }


                $zipCode = $_POST['zipCode'];
                $government_classification = $_POST['government_classification'];
                $json_occupation = $_POST['json_occupation'];
                $degree = $_POST['degree'];
                $collegeName = $_POST['college-name'];
//                $college = $_POST['college'];
                $college = null;
                if ($_POST['college'] != "") {
                    $college = $_POST['college'];
                }
                $faculity = $_POST['faculity'];
                $study_programName = $_POST['study_program-name'];
                $study_program = null;
                if ($_POST['study_program'] != "") {
                    $study_program = $_POST['study_program'];
                }
                $graduation_year = $_POST['graduation_year'];
                $result_update = true;
                $result_update_message = "";
                $db->update($securityUser->getEntity(), array(
                    $securityUser->getEmail() => $email,
                    $securityUser->getModifiedByUsername() => $userMember[$securityUser->getEntity()][$securityUser->getCode()],
                    $securityUser->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT)
                        ), $securityUser->getId() . equalToIgnoreCase($userMember[$securityUser->getEntity()][$securityUser->getId()]));
                $rs_update_user = $db->getResult();

                if (is_numeric($rs_update_user[0]) == 1) {
                    $db->update($securityUserProfile->getEntity(), array(
                        $securityUserProfile->getName() => $participant_name,
                        $securityUserProfile->getBirthdate() => $date_of_birth,
                        $securityUserProfile->getGender() => $gender,
                        $securityUserProfile->getReligionId() => $religion,
                        $securityUserProfile->getPlace() => $place_of_birth,
                        $securityUserProfile->getMarriage() => $maritalStatus,
                        $securityUserProfile->getModifiedByUsername() => $userMember[$securityUser->getEntity()][$securityUser->getCode()],
                        $securityUserProfile->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT)
                            ), $securityUserProfile->getId() . equalToIgnoreCase($userMember[$securityUserProfile->getEntity()][$securityUserProfile->getId()]));
                    $rs_update_user_profile = $db->getResult();

                    if (is_numeric($rs_update_user_profile[0]) == 1) {
                        $rs_update_contact_user = true;
                        if ($userMember[$securityUserProfile->getEntity()][$securityUserProfile->getContactId()] == null) {
                            $db->insert($masterContact->getEntity(), array(
                                $masterContact->getEmail1() => $email,
                                $masterContact->getPhoneNumber1() => $telephone,
                                $masterContact->getFax() => $fax,
                                $masterContact->getStatus() => 1,
                                $masterContact->getCreatedByUsername() => $userMember[$securityUser->getEntity()][$securityUser->getCode()],
                                $masterContact->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT)
                            ));
                            $rs_insert_contact = $db->getResult();
                            if (!is_numeric($rs_insert_contact[0])) {
                                $rs_update_contact_user = false;
                            } else {
                                $db->update($securityUserProfile->getEntity(), array(
                                    $securityUserProfile->getContactId() => $rs_insert_contact[0],
                                        ), $securityUserProfile->getId() . equalToIgnoreCase($userMember[$securityUserProfile->getEntity()][$securityUserProfile->getId()]));
                                if (is_numeric($rs_insert_contact[0]) != 1) {
                                    $rs_update_contact_user = false;
                                }
                            }
                        } else {
                            $db->update($masterContact->getEntity(), array(
                                $masterContact->getEmail1() => $email,
                                $masterContact->getPhoneNumber1() => $telephone,
                                $masterContact->getFax() => $fax,
                                $masterContact->getModifiedByUsername() => $userMember[$securityUser->getEntity()][$securityUser->getCode()],
                                $masterContact->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT)
                                    ), $masterContact->getId() . equalToIgnoreCase($userMember[$securityUserProfile->getEntity()][$securityUserProfile->getContactId()]));
                            $rs_update_contact = $db->getResult();

                            if (is_numeric($rs_update_contact[0]) != 1) {
                                $rs_update_contact_user = false;
                            }
                        }
                        if ($rs_update_contact_user == true) {
                            $rs_update_address_user = true;
                            if ($userMember[$securityUserProfile->getEntity()][$securityUserProfile->getAddressId()] == null) {
                                $db->insert($masterAddress->getEntity(), array(
                                    $masterAddress->getProvinceId() => $province,
                                    $masterAddress->getCityId() => $city,
                                    $masterAddress->getDistrictId() => $district,
                                    $masterAddress->getVillageId() => $village,
                                    $masterAddress->getZipCode() => $zipCode,
                                    $masterAddress->getStatus() => 1,
                                    $masterAddress->getCreatedByUsername() => $userMember[$securityUser->getEntity()][$securityUser->getCode()],
                                    $masterAddress->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT)
                                ));
                                $rs_insert_address = $db->getResult();
                                if (!is_numeric($rs_insert_address[0])) {
                                    $rs_update_address_user = false;
                                } else {
                                    $db->update($securityUserProfile->getEntity(), array(
                                        $securityUserProfile->getAddressId() => $rs_insert_address[0],
                                            ), $securityUserProfile->getId() . equalToIgnoreCase($userMember[$securityUserProfile->getEntity()][$securityUserProfile->getId()]));
                                    if (is_numeric($rs_insert_contact[0]) != 1) {
                                        $rs_update_address_user = false;
                                    }
                                }
                            } else {
                                $db->update($masterAddress->getEntity(), array(
                                    $masterAddress->getProvinceId() => $province,
                                    $masterAddress->getCityId() => $city,
                                    $masterAddress->getDistrictId() => $district,
                                    $masterAddress->getVillageId() => $village,
                                    $masterAddress->getZipCode() => $zipCode,
                                    $masterAddress->getModifiedByUsername() => $userMember[$securityUser->getEntity()][$securityUser->getCode()],
                                    $masterAddress->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT)
                                        ), $masterAddress->getId() . equalToIgnoreCase($userMember[$securityUserProfile->getEntity()][$securityUserProfile->getAddressId()]));
                                $rs_update_address = $db->getResult();
//                                $result_update_message= $rs_update_address[0];

                                if (is_numeric($rs_update_address[0]) != 1) {
                                    $rs_update_address_user = false;
                                }
                            }
                            if ($rs_update_address_user == true) {
//                                print_r($userMain);
                                $db->update($masterUserMain->getEntity(), array(
                                    $masterUserMain->getFront_degree() => $front_degree,
                                    $masterUserMain->getBehind_degree() => $behind_degree,
                                    $masterUserMain->getIdNumber() => $idNumber,
                                    $masterUserMain->getNoIdTypeId() => $noidType,
                                    $masterUserMain->getJsonOccupation() => $json_occupation,
                                    $masterUserMain->getGovernmentClassificationId() => $government_classification,
                                    $masterUserMain->getDegree() => $degree,
                                    $masterUserMain->getCollege() => $collegeName,
                                    $masterUserMain->getCollegeId() => $college,
                                    $masterUserMain->getGraduationYear() => $graduation_year,
                                    $masterUserMain->getFaculty() => $faculity,
                                    $masterUserMain->getStudyProgramId() => $study_program,
                                    $masterUserMain->getStudyProgram() => $study_programName,
                                        ), $masterUserMain->getId() . equalToIgnoreCase($userMember[$masterUserMain->getEntity()][$masterUserMain->getId()]));
                                $rs_update_user_main = $db->getResult();
//                                echo $study_program;
                                $result_update_message = $rs_update_user_main[0];
                                if (is_numeric($rs_update_user_main[0]) == 1) {
                                    $result_update = true;
                                } else {
                                    $result_update = false;
                                }
                            } else {
                                $result_update = false;
                            }
                        } else {
                            $result_update = false;
                        }
                    } else {
                        $result_update = false;
                    }
                } else {
                    $result_update = false;
                }
                if ($result_update == true) {
                    echo resultPageMsg('success', lang('general.title_update_success'), lang('general.message_update_success'));
                } else {
                    echo resultPageMsg('danger', lang('general.title_update_error'), lang('general.message_update_error'));
                    echo $result_update_message;
                }
                /*

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
                  $users->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT),
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
                 * 
                 */
            }
        }
    }

    public function changePhoto() {
        $userMember = getUserMember();
        $db = new Database();
        $db->connect();
        $securityUserProfile = new SecurityUserProfile();
        ini_set("memory_limit", "99M");
        ini_set('post_max_size', '20M');
        ini_set('max_execution_time', 600);
        define('IMAGE_SMALL_DIR', FILE_PATH('uploads/member/' . $_SESSION[SESSION_USERNAME_GUEST] . '/small/'));
        define('IMAGE_SMALL_SIZE', 150);
        define('IMAGE_MEDIUM_DIR', FILE_PATH('uploads/member/' . $_SESSION[SESSION_USERNAME_GUEST] . '/medium/'));
        define('IMAGE_MEDIUM_SIZE', 750);
        /* defined settings - end */

        if (isset($_FILES['image_upload_file'])) {
            $output['status'] = FALSE;
            set_time_limit(0);
            $allowedImageType = array("image/gif", "image/jpeg", "image/pjpeg", "image/png", "image/x-png");

            if ($_FILES['image_upload_file']["error"] > 0) {
                $output['error'] = "Error in File";
            } elseif (!in_array($_FILES['image_upload_file']["type"], $allowedImageType)) {
                $output['error'] = "You can only upload JPG, PNG and GIF file";
            } elseif (round($_FILES['image_upload_file']["size"] / 1024) > 4096) {
                $output['error'] = "You can upload file size up to 4 MB";
            } else {
                /* create directory with 777 permission if not exist - start */
                createDir(IMAGE_SMALL_DIR);
                createDir(IMAGE_MEDIUM_DIR);
                /* create directory with 777 permission if not exist - end */
                $path[0] = $_FILES['image_upload_file']['tmp_name'];
                $file = pathinfo($_FILES['image_upload_file']['name']);
                $fileType = $file["extension"];
                $desiredExt = 'jpg';
                $fileNameNew = rand(333, 999) . time() . ".$desiredExt";
                $path[1] = IMAGE_MEDIUM_DIR . $fileNameNew;
                $path[2] = IMAGE_SMALL_DIR . $fileNameNew;

                if (createThumb($path[0], $path[1], $fileType, IMAGE_MEDIUM_SIZE, IMAGE_MEDIUM_SIZE, IMAGE_MEDIUM_SIZE)) {

                    if (createThumb($path[1], $path[2], "$desiredExt", IMAGE_SMALL_SIZE, IMAGE_SMALL_SIZE, IMAGE_SMALL_SIZE)) {
                        $db->update($securityUserProfile->getEntity(), array(
                            $securityUserProfile->getPathimage() => $fileNameNew
                                ), $securityUserProfile->getId() . equalToIgnoreCase($userMember[$securityUserProfile->getEntity()][$securityUserProfile->getId()]));
                        $rs_update_photo = $db->getResult();
                        if (is_numeric($rs_update_photo[0]) == 1) {
                            $output['status'] = TRUE;
                            $output['image_medium'] = URL('uploads/member/' . $_SESSION[SESSION_USERNAME_GUEST] . '/medium/' . $fileNameNew);
                            $output['image_small'] = URL('uploads/member/' . $_SESSION[SESSION_USERNAME_GUEST] . '/small/' . $fileNameNew);
//                            $output['image_medium'] = $path[1];
//                            $output['image_small'] = $path[2];
                        }
                    }
                }
            }
            echo json_encode($output);
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
