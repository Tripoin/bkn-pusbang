<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controller\Member\Registration;

/**
 * Description of AgendaKegiatanMember
 *
 * @author sfandrianah
 */
use app\Constant\IViewMemberConstant;
use app\Model\TransactionActivity;
use app\Model\TransactionActivityDetails;
use app\Model\TransactionRegistration;
use app\Model\MasterAttachment;
use app\Model\TransactionRegistrationDetails;
use app\Model\LinkRegistration;
use app\Model\SecurityUser;
use app\Model\SecurityUserProfile;
use app\Model\MasterUserMain;
use app\Model\MasterReligion;
use app\Model\MasterApproval;
use app\Model\MasterApprovalCategory;
use app\Model\MasterWaitingList;
use app\Model\MasterProvince;
use app\Model\MasterGovernmentClassification;
use app\Model\MasterCollege;
use app\Model\MasterStudyProgram;
use app\Model\MasterNoIdType;
use app\Util\DataTable;
use app\Util\Database;
use app\Util\Button;
use app\Util\Form;

class RegistrationActivityTemp {

    //put your code here
    public function index() {

//        setActiveMenuMember('userprofile,changepassword');
        setTitle(' | ' . lang('member.registration_activity'));
        include_once FILE_PATH(IViewMemberConstant::REGISTRATION_ACTIVITY_TEMP_VIEW_INDEX);
    }

    public function listData() {
//        echo 'tes';
        $Form = new Form();
        $Datatable = new DataTable();
        $Button = new Button();
        $db = new Database();
//        $group = new SecurityGroup();
        $data = new TransactionActivity();
        $transactionRegistration = new TransactionRegistration();
//        $userMain = new MasterUserMain();
        if ($_POST['per_page'] == "") {
            $Datatable->per_page = 10;
        } else {
            $Datatable->per_page = $_POST['per_page'];
        }
        $Datatable->urlDeleteCollection(false);

        $Datatable->searchFilter(array("start_activity" => lang("member.year")));
        $Datatable->current_page = $_POST['current_page'];
        if ($_POST['current_page'] == '') {
            $Datatable->current_page = 1;
        }
        $search = $_POST['search_pagination'];
        if ($_POST['search_by'] == '') {
            $search = $data->getEntity() . ".start_activity LIKE  '%" . $search . "%'";
        } else if ($_POST['search_by'] == 'null') {
            $search = $data->getEntity() . ".start_activity LIKE  '%" . $search . "%'";
        } else {
            if (!empty($data->search($_POST['search_by']))) {
                $search = $data->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search . "%'";
            }
        }

        $whereList = $search;
        $list_data = $Datatable->select_pagination($data, $data->getEntity(), $whereList, null, null, null, null
                , null);
//        print_r($list_data);

        $user = new SecurityUser();
        $userProfile = new SecurityUserProfile();
        $userMain = new MasterUserMain();


        $rs_user = $db->selectByID($user, $user->getCode() . "='" . $_SESSION[SESSION_USERNAME_GUEST] . "'");
        $rs_user_profile = $db->selectByID($userProfile, $userProfile->getUserId() . "='" . $rs_user[0][$user->getId()] . "'");
        $rs_user_main = $db->selectByID($userMain, $userMain->getUserProfileId() . "='" . $rs_user_profile[0][$userProfile->getId()] . "'");
        $rs_registration = $db->selectByID($transactionRegistration, $transactionRegistration->getUserId().  equalToIgnoreCase($rs_user[0][$user->getId()]));
        if(empty($rs_registration)){
            $list_data = array("from"=>0,"item"=>array());
        }
//        print_r($rs_registration);

        include_once FILE_PATH(IViewMemberConstant::REGISTRATION_ACTIVITY_TEMP_LIST_VIEW_INDEX);
    }

    public function indexChooseUser($activity) {
        include_once FILE_PATH(IViewMemberConstant::REGISTRATION_ACTIVITY_TEMP_LIST_USER_ADD_VIEW_INDEX);
    }

    public function registerActivityPage($activity) {
        $db = new Database();
        $modelActivity = new TransactionActivity();
        $data_activity = $db->selectByID($modelActivity, $modelActivity->getId() . EQUAL . $activity);
        include_once FILE_PATH(IViewMemberConstant::REGISTRATION_ACTIVITY_TEMP_REGISTER_VIEW_INDEX);
    }

    public function saveRegisterActivity($activity) {
        $db = new Database();
        $db->connect();
        $linkRegistration = new LinkRegistration();
        $masterAttachment = new MasterAttachment();
        $masterApproval = new MasterApproval();
        $masterApprovalCategory = new MasterApprovalCategory();

        $registrationId = $_POST['registration_id'];
//        print_r($_FILES['recommend_letter']);
        $recommendLetter = $_FILES['recommend_letter'];
        $reArray = reArrayFiles($recommendLetter);
        $upload = uploadFileImg($reArray[0], $reArray[0]['name'], FILE_PATH('uploads/' . $_SESSION[SESSION_USERNAME_GUEST] . '/'));
        if ($upload['result'] == true) {
            $code = createRandomBooking();
            $db->insert($masterAttachment->getEntity(), array(
                $masterAttachment->getCode() => $code . "-" . $upload['file_name'],
                $masterAttachment->getName() => $upload['file_name'],
            ));
            $rs_insert_attach = $db->getResult();
            if (is_numeric($rs_insert_attach[0])) {
                $db->insert($linkRegistration->getEntity(), array(
                    $linkRegistration->getActivityId() => $activity,
                    $linkRegistration->getRegistrationId() => $registrationId,
                    $linkRegistration->getAttachmentLetterId() => $rs_insert_attach[0],
                    $linkRegistration->getStatus() => null
                ));
                $rs_insert_link_registration = $db->getResult();
                if (is_numeric($rs_insert_link_registration[0])) {
                    $rs_app_cat = $db->selectByID($masterApprovalCategory, $masterApprovalCategory->getCode() . equalToIgnoreCase('RE-REGISTRATION'));
                    $db->insert($masterApproval->getEntity(), array(
                        $masterApproval->getCode() => $code . "-" . $registrationId . "",
                        $masterApproval->getName() => $code . "-" . $registrationId . "",
                        $masterApproval->getApprovalCategoryId() => $rs_app_cat[0][$masterApproval->getId()],
                        $masterApproval->getApprovalDetailId() => $rs_insert_link_registration[0],
                        $masterApproval->getStatus() => null
                    ));
                    $rs_insert_approval = $db->getResult();
                    if (is_numeric($rs_insert_link_registration[0])) {
                        echo toastAlert('success', lang('general.title_register_success'), lang('general.messsage_register_success'));
                        echo resultPageMsg('success', lang('general.title_register_success'), lang('general.messsage_register_success'));
                        echo postAjaxPagination();
                    } else {
                        echo toastAlert('error', lang('general.title_register_failed'), lang('general.messsage_register_failed'));
                        echo resultPageMsg('danger', lang('general.title_register_failed'), lang('general.messsage_register_failed'));
                    }
                } else {
                    echo toastAlert('error', lang('general.title_register_failed'), lang('general.messsage_register_failed'));
                    echo resultPageMsg('danger', lang('general.title_register_failed'), lang('general.messsage_register_failed'));
                }
            } else {
                echo toastAlert('error', lang('general.title_register_failed'), lang('general.messsage_register_failed'));
                echo resultPageMsg('danger', lang('general.title_register_failed'), lang('general.messsage_register_failed'));
            }
        } else {
            echo toastAlert('error', lang('general.title_upload_failed'), $upload['message']);
            echo resultPageMsg('danger', lang('general.title_upload_failed'), $upload['message']);
        }
//        include_once FILE_PATH(IViewMemberConstant::REGISTRATION_ACTIVITY_TEMP_REGISTER_VIEW_INDEX);
    }

    public function addChooseUser($activity) {
        $registrationId = $_POST['registration_id'];
        $registrationDetailId = $_POST['registration_detail_id'];
        $linkRegistration = new LinkRegistration();
        $masterApproval = new MasterApproval();
        $transactionRegistrationDetails = new TransactionRegistrationDetails();
        $db = new Database();
        $db->connect();

        $db->insert($linkRegistration->getEntity(), array(
            $linkRegistration->getActivityId() => $activity,
            $linkRegistration->getRegistrationId() => $registrationId,
            $linkRegistration->getRegistrationDetailsId() => $registrationDetailId,
            $linkRegistration->getStatus() => null,
            $linkRegistration->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
            $linkRegistration->getCreatedBy() => $_SESSION[SESSION_USERNAME_GUEST],
        ));

        $rs_insert_link_reg = $db->getResult();
        if (is_numeric($rs_insert_link_reg[0])) {
            $masterApprovalCategory = new MasterApprovalCategory();
            $dataApprovalCategory = $db->selectByID($masterApprovalCategory, $masterApprovalCategory->getCode() . equalToIgnoreCase('REGISTRATION-DETAILS'));
            $dataRegistrationDetail = $db->selectByID($transactionRegistrationDetails, $transactionRegistrationDetails->getId() . equalToIgnoreCase($registrationDetailId));
            $codeApproval = createRandomBooking();
            $db->insert($masterApproval->getEntity(), array(
                $masterApproval->getCode() => $dataRegistrationDetail[0][$transactionRegistrationDetails->getIdNumber()] . "-" . $codeApproval,
                $masterApproval->getName() => $dataRegistrationDetail[0][$transactionRegistrationDetails->getIdNumber()],
                $masterApproval->getDescription() => "Registration Details dengan Nomor ID : " . $dataRegistrationDetail[0][$transactionRegistrationDetails->getIdNumber()],
                $masterApproval->getApprovalCategoryId() => $dataApprovalCategory[0][$masterApprovalCategory->getId()],
                $masterApproval->getApprovalDetailId() => $rs_insert_link_reg[0],
                $masterApproval->getStatus() => null,
                $masterApproval->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                $masterApproval->getCreatedByUsername() => $_SESSION[SESSION_USERNAME_GUEST],
            ));
            $rs_insert_approval = $db->getResult();
            if (is_numeric($rs_insert_approval[0])) {
                echo toastAlert('success', lang('general.title_insert_success'), lang('general.message_insert_success'));
                echo modalHide();
                echo postAjaxPagination();
            } else {
                echo toastAlert('error', lang('general.title_insert_error'), lang('general.message_insert_error'));
                $db->delete($linkRegistration->getEntity(), $linkRegistration->getId() . equalToIgnoreCase($rs_insert_link_reg[0]));
            }
        } else {
            echo toastAlert('error', lang('general.title_insert_error'), lang('general.message_insert_error'));
        }
    }

    public function listChooseUser($activity) {
        $registrationId = $_POST['registration_id'];
//        $registrationId = $_POST['registration_id'];
        $Form = new Form();
        $Datatable = new DataTable();
        $Button = new Button();
        $db = new Database();
        $db->connect();
        $data = new TransactionRegistrationDetails;
//        $data->getIdNumber();
//        $data->getName();
        $linkRegistration = new LinkRegistration();

        $db->select($linkRegistration->getEntity(), $linkRegistration->getRegistrationDetailsId(), null, ""
                . "" . $linkRegistration->getRegistrationId() . equalToIgnoreCase($registrationId)
//                . " AND " . $linkRegistration->getActivityId() . equalToIgnoreCase($activity)
        );
        $dt_link_reg = $db->getResult();
//        print_r($dt_link_reg);
        $list_reg_id_detail = '';
        foreach ($dt_link_reg as $value) {
            $list_reg_id_detail .= $value[$linkRegistration->getRegistrationDetailsId()] . ",";
        }
        $list_reg_id_detail = rtrim($list_reg_id_detail, ',');
//        $implode_reg_id_detail = implode(',', $dt_link_reg[0][$linkRegistration]);
//                print_r($dt_link_reg);

        $db->select($linkRegistration->getEntity(), $linkRegistration->getRegistrationDetailsId(), null, ""
                . "" . $linkRegistration->getRegistrationId() . equalToIgnoreCase($registrationId)
                . " AND " . $linkRegistration->getActivityId() . equalToIgnoreCase($activity)
        );
        $dt_link_reg2 = $db->getResult();
        $list_reg_id_detail2 = '';
        foreach ($dt_link_reg2 as $value) {
            $list_reg_id_detail2 .= $value[$linkRegistration->getRegistrationDetailsId()] . ",";
        }
        $list_reg_id_detail2 = rtrim($list_reg_id_detail2, ',');


        if ($_POST['per_page'] == "") {
            $Datatable->per_page = 10;
        } else {
            $Datatable->per_page = $_POST['per_page'];
        }
        $Datatable->urlDeleteCollection(false);
        $Datatable->searchFilter(array("code" => lang("general.code"), "name" => lang("general.name")));
        $Datatable->current_page = $_POST['current_page'];
        if ($_POST['current_page'] == '') {
            $Datatable->current_page = 1;
        }
        $search = $_POST['search_pagination'];
        if (isset($_POST['search_by'])) {
            if ($_POST['search_by'] == '') {
                $search = " AND " . $data->getEntity() . ".code LIKE  '%" . $search . "%'";
            } else if ($_POST['search_by'] == 'null') {
                $search = " AND " . $data->getEntity() . ".code LIKE  '%" . $search . "%'";
            } else {
                if (!empty($data->search($_POST['search_by']))) {
                    $search = " AND " . $data->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search . "%'";
                }
            }
        }
        $sql_detail2 = "";
        if(!empty($list_reg_id_detail2)){
           $sql_detail2 = " AND ".$data->getEntity() . DOT . $data->getId() . " NOT IN (" . $list_reg_id_detail2 . ") ";
        }
        $sql_detail = $data->getEntity() . DOT . $data->getId() . " IN ('')";
        if(!empty($list_reg_id_detail)){
            $sql_detail = $data->getEntity() . DOT . $data->getId() . " IN (" . $list_reg_id_detail . ")";
        }
        $whereList = $sql_detail
                .$sql_detail2 . $search;
        
//        echo $whereList;
//        $Datatable->debug(true);
        $list_data = $Datatable->select_pagination($data, $data->getEntity(), $whereList, null, null, null, null
                , null);
//        print_r($list_data);
        include_once FILE_PATH(IViewMemberConstant::REGISTRATION_ACTIVITY_TEMP_LIST_USER_ADD_LIST_VIEW_INDEX);
    }

    public function createUserData($activity) {
        $registrationId = $_POST['registration_id'];
        $db = new Database();
        $modelActivity = new TransactionActivity();
        $masterNoidType = new MasterNoIdType();
        $masterReligion = new MasterReligion();
        $masterProvince=  new MasterProvince();
        $masterCollege = new MasterCollege();
        $masterStudyProgram = new MasterStudyProgram();

        $masterGovernmentClassification = new MasterGovernmentClassification();

        $data_gender = [
            array("id" => "M", "label" => lang("general.male")),
            array("id" => "F", "label" => lang("general.female")),
        ];
        $data_marital_status = [
            array("id" => "N", "label" => "Belum Menikah"),
            array("id" => "Y", "label" => "Menikah"),
        ];
        $data_reg_detail = array();
        if (isset($_POST['registration_detail_id'])) {
            $regDetail = new TransactionRegistrationDetails();
            $data_reg_detail = $db->selectByID($regDetail, $regDetail->getId() . equalToIgnoreCase($_POST['registration_detail_id']));
        }
        $data_noid_type = getLov($masterNoidType);
//        $data_study_program = getLov($masterStudyProgram);
        $data_religion = getLov($masterReligion);
        $data_province = getLov($masterProvince);
//        $data_college = getLov($masterCollege);
        $data_government_class = getLov($masterGovernmentClassification);
        $data_activity = $db->selectByID($modelActivity, $modelActivity->getId() . EQUAL . $activity);
        include_once FILE_PATH(IViewMemberConstant::REGISTRATION_ACTIVITY_TEMP_LIST_USER_CREATE_VIEW_INDEX);
    }

    public function saveUserData($activity) {
        $participant_name = $_POST['participant_name'];
        $noidType = $_POST['noidType'];
        $idNumber = $_POST['idNumber'];
        $front_degree = $_POST['front_degree'];
        $behind_degree = $_POST['behind_degree'];
        $place_of_birth = $_POST['place_of_birth'];
        $date_of_birth = $_POST['date_of_birth'];
        $religion = $_POST['religion'];
        $gender = $_POST['gender'];
        $marital_status = $_POST['marital_status'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $fax = $_POST['fax'];
        $address = $_POST['address'];
        $zip_code = $_POST['zip_code'];
        $government_classification = $_POST['government_classification'];
        $json_occupation = $_POST['json_occupation'];
        $degree = $_POST['degree'];
        $college_name = $_POST['college-name'];
        $college = $_POST['college'];
        $faculity = $_POST['faculity'];
        $study_program_name = $_POST['study_program-name'];
        $study_program = $_POST['study_program'];
        $graduation_year = $_POST['graduation_year'];
        $registration_id = $_POST['registration_id'];
        
        $province = $_POST['province'];
        $city = $_POST['city'];
        $district = $_POST['district'];
        $village = $_POST['village'];
        /* foreach ($_POST as $key => $value) {
          echo "&#36;" . $key . " = &#36;_POST['" . $key . "'];<br/>";
          }
         * 
         */
        $transactionRegistrationDetails = new TransactionRegistrationDetails();
        $db = new Database();
        $db->connect();
        if (isset($_POST['registration_detail_id'])) {
            $registrationDetailId = $_POST['registration_detail_id'];
            $db->update($transactionRegistrationDetails->getEntity(), array(
                $transactionRegistrationDetails->getRegistrationId() => $registration_id,
                $transactionRegistrationDetails->getProvinceId() => $province,
                $transactionRegistrationDetails->getCityId() => $city,
                $transactionRegistrationDetails->getDistrictId() => $district,
                $transactionRegistrationDetails->getVillageId() => $village,
                $transactionRegistrationDetails->getName() => $participant_name,
                $transactionRegistrationDetails->getIdNumber() => $idNumber,
                $transactionRegistrationDetails->getNoidTypeId() => $noidType,
                $transactionRegistrationDetails->getFrontDegree() => $front_degree,
                $transactionRegistrationDetails->getBehindDegree() => $behind_degree,
                $transactionRegistrationDetails->getPob() => $place_of_birth,
                $transactionRegistrationDetails->getDob() => $date_of_birth,
                $transactionRegistrationDetails->getReligionId() => $religion,
                $transactionRegistrationDetails->getGender() => $gender,
                $transactionRegistrationDetails->getMaritalStatus() => $marital_status,
                $transactionRegistrationDetails->getEmail() => $email,
                $transactionRegistrationDetails->getPhoneNumber() => $telephone,
                $transactionRegistrationDetails->getFax() => $fax,
                $transactionRegistrationDetails->getAddress() => $address,
                $transactionRegistrationDetails->getZipCode() => $zip_code,
                $transactionRegistrationDetails->getGovernmentClassificationId() => $government_classification,
                $transactionRegistrationDetails->getJsonOccupation() => $json_occupation,
                $transactionRegistrationDetails->getDegree() => $degree,
                $transactionRegistrationDetails->getCollege() => $college_name,
                $transactionRegistrationDetails->getCollegeId() => $college,
                $transactionRegistrationDetails->getFaculity() => $faculity,
                $transactionRegistrationDetails->getStudyProgram() => $study_program_name,
                $transactionRegistrationDetails->getStudyProgramId() => $study_program,
                $transactionRegistrationDetails->getGraduationYear() => $graduation_year,
                $transactionRegistrationDetails->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                $transactionRegistrationDetails->getModifiedByUsername() => $_SESSION[SESSION_USERNAME_GUEST],
                $transactionRegistrationDetails->getStatus() => null,
                    ), $transactionRegistrationDetails->getId() . equalToIgnoreCase($registrationDetailId));
            $rs_update_reg_detail = $db->getResult();
            if (is_numeric($rs_update_reg_detail[0]) == 1) {
                echo resultPageMsg('success', lang('general.title_update_success'), lang('general.message_update_success'));
                echo toastAlert('success', lang('general.title_update_success'), lang('general.message_update_success'));
            } else {
                echo resultPageMsg('danger', lang('general.title_update_error'), lang('general.message_update_error'));
                echo toastAlert('error', lang('general.title_update_error'), lang('general.message_update_error'));
            }
        } else {

            $db->insert($transactionRegistrationDetails->getEntity(), array(
                $transactionRegistrationDetails->getRegistrationId() => $registration_id,
                $transactionRegistrationDetails->getProvinceId() => $province,
                $transactionRegistrationDetails->getCityId() => $city,
                $transactionRegistrationDetails->getDistrictId() => $district,
                $transactionRegistrationDetails->getVillageId() => $village,
                $transactionRegistrationDetails->getCode() => $idNumber,
                $transactionRegistrationDetails->getName() => $participant_name,
                $transactionRegistrationDetails->getIdNumber() => $idNumber,
                $transactionRegistrationDetails->getNoidTypeId() => $noidType,
                $transactionRegistrationDetails->getFrontDegree() => $front_degree,
                $transactionRegistrationDetails->getBehindDegree() => $behind_degree,
                $transactionRegistrationDetails->getPob() => $place_of_birth,
                $transactionRegistrationDetails->getDob() => $date_of_birth,
                $transactionRegistrationDetails->getReligionId() => $religion,
                $transactionRegistrationDetails->getGender() => $gender,
                $transactionRegistrationDetails->getMaritalStatus() => $marital_status,
                $transactionRegistrationDetails->getEmail() => $email,
                $transactionRegistrationDetails->getPhoneNumber() => $telephone,
                $transactionRegistrationDetails->getFax() => $fax,
                $transactionRegistrationDetails->getAddress() => $address,
                $transactionRegistrationDetails->getZipCode() => $zip_code,
                $transactionRegistrationDetails->getGovernmentClassificationId() => $government_classification,
                $transactionRegistrationDetails->getJsonOccupation() => $json_occupation,
                $transactionRegistrationDetails->getDegree() => $degree,
                $transactionRegistrationDetails->getCollege() => $college_name,
                $transactionRegistrationDetails->getCollegeId() => $college,
                $transactionRegistrationDetails->getFaculity() => $faculity,
                $transactionRegistrationDetails->getStudyProgram() => $study_program_name,
                $transactionRegistrationDetails->getStudyProgramId() => $study_program,
                $transactionRegistrationDetails->getGraduationYear() => $graduation_year,
                $transactionRegistrationDetails->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                $transactionRegistrationDetails->getCreatedByUsername() => $_SESSION[SESSION_USERNAME_GUEST],
                $transactionRegistrationDetails->getStatus() => null,
            ));
            $rs_insert_reg_detail = $db->getResult();
            if (is_numeric($rs_insert_reg_detail[0])) {
                $linkRegistration = new LinkRegistration();
                $db->insert($linkRegistration->getEntity(), array(
                    $linkRegistration->getActivityId() => $activity,
                    $linkRegistration->getRegistrationDetailsId() => $rs_insert_reg_detail[0],
                    $linkRegistration->getRegistrationId() => $registration_id,
                    $linkRegistration->getStatus() => null,
                    $linkRegistration->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                    $linkRegistration->getCreatedBy() => $_SESSION[SESSION_USERNAME_GUEST],
                ));
                $rs_insert_link_reg = $db->getResult();
                if (is_numeric($rs_insert_link_reg[0])) {
                    $masterApproval = new MasterApproval();
                    $masterApprovalCategory = new MasterApprovalCategory();
                    $dataApprovalCategory = $db->selectByID($masterApprovalCategory, $masterApprovalCategory->getCode() . equalToIgnoreCase('REGISTRATION-DETAILS'));
                    $codeApproval = createRandomBooking();
                    $db->insert($masterApproval->getEntity(), array(
                        $masterApproval->getCode() => $idNumber . "-" . $codeApproval,
                        $masterApproval->getName() => $idNumber,
                        $masterApproval->getDescription() => "Registration Details dengan Nomor ID : " . $idNumber,
                        $masterApproval->getApprovalCategoryId() => $dataApprovalCategory[0][$masterApprovalCategory->getId()],
                        $masterApproval->getApprovalDetailId() => $rs_insert_link_reg[0],
                        $masterApproval->getStatus() => null,
                        $masterApproval->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                        $masterApproval->getCreatedByUsername() => $_SESSION[SESSION_USERNAME_GUEST],
                    ));
                    $rs_insert_approval = $db->getResult();
                    if (is_numeric($rs_insert_approval[0])) {
                        echo postAjaxPagination();
                        echo resultPageMsg('success', lang('general.title_insert_success'), lang('general.message_insert_success'));
                        echo toastAlert('success', lang('general.title_insert_success'), lang('general.message_insert_success'));
                    } else {
                        echo resultPageMsg('danger', lang('general.title_insert_error'), lang('general.message_insert_error'));
                        echo toastAlert('error', lang('general.title_insert_error'), lang('general.message_insert_error'));
                        $db->delete($transactionRegistrationDetails->getEntity(), $transactionRegistrationDetails->getId() . equalToIgnoreCase($rs_insert_reg_detail[0]));
                        $db->delete($linkRegistration->getEntity(), $linkRegistration->getId() . equalToIgnoreCase($rs_insert_link_reg[0]));
                    }
                } else {
                    echo resultPageMsg('danger', lang('general.title_insert_error'), lang('general.message_insert_error'));
                    echo toastAlert('error', lang('general.title_insert_error'), lang('general.message_insert_error'));
                    $db->delete($transactionRegistrationDetails->getEntity(), $transactionRegistrationDetails->getId() . equalToIgnoreCase($rs_insert_reg_detail[0]));
                }
            } else {
                echo resultPageMsg('danger', lang('general.title_insert_error'), lang('general.message_insert_error'));
                echo toastAlert('error', lang('general.title_insert_error'), lang('general.message_insert_error'));
            }
        }
    }

    public function listUserData($activity) {
        $registrationId = $_GET['registration_id'];
        $transactionRegistration = new TransactionRegistration();
        $linkRegistration = new LinkRegistration();
        $transactionRegistrationDetails = new TransactionRegistrationDetails();

//        echo 'tes';
        $Form = new Form();
        $Datatable = new DataTable();
        $Button = new Button();
        $db = new Database();
        $dt_link_reg = $db->selectByID($linkRegistration, $linkRegistration->getRegistrationId() . equalToIgnoreCase($registrationId)
                . " AND " . $linkRegistration->getActivityId() . equalToIgnoreCase($activity)
                . " AND " . $linkRegistration->getRegistrationDetailsId() . "!=NULL");
//        print_r($dt_link_reg);
//        $group = new SecurityGroup();
        $data = new TransactionRegistrationDetails();
//        $userMain = new MasterUserMain();
        if ($_POST['per_page'] == "") {
            $Datatable->per_page = 5;
        } else {
            $Datatable->per_page = $_POST['per_page'];
        }
        $Datatable->urlDeleteCollection(false);
        $Datatable->searchFilter(array("idNumber" => lang("member.no_id")));
        $Datatable->current_page = $_POST['current_page'];
        if ($_POST['current_page'] == '') {
            $Datatable->current_page = 1;
        }
        $search = $_POST['search_pagination'];
        if ($_POST['search_by'] == '') {
//            $search = $data->getEntity() . ".start_activity LIKE  '%" . $search . "%'";
        } else if ($_POST['search_by'] == 'null') {
//            $search = $data->getEntity() . ".start_activity LIKE  '%" . $search . "%'";
        } else {
            if (!empty($data->search($_POST['search_by']))) {
                $search = $data->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search . "%'";
            }
        }

        $whereList = $linkRegistration->getEntity() . DOT . $linkRegistration->getRegistrationDetailsId() . EQUAL . $transactionRegistrationDetails->getEntity() . DOT . $transactionRegistrationDetails->getId() . ""
                . " AND " . $linkRegistration->getEntity() . DOT . $linkRegistration->getActivityId() . equalToIgnoreCase($activity)
                . " AND " . $linkRegistration->getEntity() . DOT . $linkRegistration->getRegistrationId() . equalToIgnoreCase($registrationId)
                . "" . $search;
//        $Datatable->debug(true);
        $list_data = $Datatable->select_pagination($linkRegistration, $linkRegistration->getEntity(), $whereList, array($transactionRegistrationDetails->getEntity()), null, null, ""
                . $data->getEntity() . DOT . "*,"
                . $linkRegistration->getEntity() . DOT . $linkRegistration->getStatus() . " as status_user"
                , null);
//        print_r($list_data);

        $user = new SecurityUser();
        $userProfile = new SecurityUserProfile();
        $userMain = new MasterUserMain();



        $modelActivity = new TransactionActivity();
        $data_activity = $db->selectByID($modelActivity, $modelActivity->getId() . EQUAL . $activity);
        include_once FILE_PATH(IViewMemberConstant::REGISTRATION_ACTIVITY_TEMP_LIST_USER_VIEW_INDEX);
    }

    public function approved() {
        $id = $_POST['id'];
        $db = new Database();
        $waitingList = new MasterWaitingList();
        $user = new SecurityUser();
        $userProfile = new SecurityUserProfile();
        $userMain = new MasterUserMain();
        $masterApproval = new MasterApproval();


        $rs_user = $db->selectByID($user, $user->getCode() . "='" . $_SESSION[SESSION_USERNAME_GUEST] . "'");
        $rs_user_profile = $db->selectByID($userProfile, $userProfile->getUserId() . "='" . $rs_user[0][$user->getId()] . "'");
        $rs_user_main = $db->selectByID($userMain, $userMain->getUserProfileId() . "='" . $rs_user_profile[0][$userProfile->getId()] . "'");

        $rs_waiting_list = $db->selectByID($waitingList, $waitingList->getActivityId() . "='" . $id . "' AND " . $waitingList->getUserMainId() . EQUAL . "'" . $rs_user_main[0][$userMain->getId()] . "'");
        if (!empty($rs_waiting_list)) {
            echo toastAlert('error', lang('general.title_update_error'), "Data Ini Sudah di approve oleh user ini.");
        } else {
            if (!empty($rs_user_main)) {
                $db->connect();
                $db->insert($waitingList->getEntity(), array(
                    $waitingList->getCode() => createRandomBooking(),
                    $waitingList->getActivityId() => $id,
                    $waitingList->getUserMainId() => $rs_user_main[0][$userMain->getId()],
                    $waitingList->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                    $waitingList->getCreatedByUsername() => $_SESSION[SESSION_USERNAME_GUEST],
                ));
                $result = $db->getResult();


                if (is_numeric($result[0])) {
                    $code_approval = createRandomBooking();
                    $db->insert($masterApproval->getEntity(), array(
                        $masterApproval->getCode() => $code_approval,
                        $masterApproval->getName() => $code_approval . '-' . $_SESSION[SESSION_USERNAME_GUEST],
                        $masterApproval->getApprovalCategoryId() => 3,
                        $masterApproval->getApprovalDetailId() => $result[0],
                        $masterApproval->getStatus() => null,
                        $masterApproval->getCreatedByUsername() => $_SESSION[SESSION_USERNAME_GUEST],
                        $masterApproval->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                    ));
                    $result2 = $db->getResult();
                    if (is_numeric($result2[0])) {
                        echo toastAlert('success', lang('general.title_update_success'), lang('general.message_update_success'));
                    } else {
                        $db->delete($waitingList->getEntity(), $waitingList->getId() . EQUAL . $result[0]);
                        echo toastAlert('error', lang('general.title_update_error'), lang('general.message_update_error'));
                    }
                } else {
                    echo toastAlert('error', lang('general.title_update_error'), lang('general.message_update_error'));
                }
            } else {
                echo toastAlert('error', lang('general.title_update_error'), lang('general.message_update_error'));
            }
        }
        echo '<div id="pageListActivity">';
        echo '<script>$(function () {postAjaxPaginationManual(\'pageListActivity\');});</script>';
        echo '</div>';
    }

}

