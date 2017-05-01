<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controller\Member;

use app\Constant\IViewMemberConstant;
use app\Model\TransactionRegistrationDetails;
use app\Model\LinkRegistration;
use app\Model\TransactionRegistration;
use app\Model\MasterReligion;
use app\Model\MasterProvince;
use app\Model\MasterCity;
use app\Model\MasterDistrict;
use app\Model\MasterVillage;
use app\Model\MasterGovernmentClassification;
use app\Model\MasterCollege;
use app\Model\MasterStudyProgram;
use app\Model\MasterNoIdType;
use app\Model\SecurityUser;
use app\Model\SecurityUserProfile;
use app\Util\Form;
use app\Util\DataTable;
use app\Util\Button;
use app\Util\Database;

/**
 * Description of ListParticipant
 *
 * @author sfandrianah
 */
class ListParticipant {

    //put your code here
    public $data_religion;
    public $data_province;
    public $data_city;
    public $data_district;
    public $data_village;
    public $data_government_classification;
    public $data_college;
    public $data_study_program;

    public function index() {
        setTitle(' | ' . lang('member.list_participant'));
        include_once FILE_PATH(IViewMemberConstant::LIST_PARTICIPANT_VIEW_INDEX);
    }

    public function update() {
        $id = $_POST['id'];
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
        $db->update($transactionRegistrationDetails->getEntity(), array(
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
                ), $transactionRegistrationDetails->getId() . equalToIgnoreCase($id));
        $rs_update_reg_detail = $db->getResult();
//        print_r($rs_update_reg_detail);
        if (is_numeric($rs_update_reg_detail[0]) == 1) {
            echo resultPageMsg('success', lang('general.title_update_success'), lang('general.message_update_success'));
            echo toastAlert('success', lang('general.title_update_success'), lang('general.message_update_success'));
        } else {
            echo resultPageMsg('danger', lang('general.title_update_error'), lang('general.message_update_error'));
            echo toastAlert('error', lang('general.title_update_error'), lang('general.message_update_error'));
        }
    }

    public function edit() {
        $id = $_POST['id'];
        $db = new Database();
        $masterNoidType = new MasterNoIdType();
        $masterReligion = new MasterReligion();
        $masterProvince = new MasterProvince();
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
        $regDetail = new TransactionRegistrationDetails();
        $data_reg_detail = $db->selectByID($regDetail, $regDetail->getId() . equalToIgnoreCase($id));
        $data_noid_type = getLov($masterNoidType);
//        $data_study_program = getLov($masterStudyProgram);
        $data_religion = getLov($masterReligion);
        $data_province = getLov($masterProvince);
//        $data_college = getLov($masterCollege);
        $data_government_class = getLov($masterGovernmentClassification);
        include_once FILE_PATH(IViewMemberConstant::LIST_PARTICIPANT_EDIT_VIEW_INDEX);
    }

    public function view() {
        $id = $_POST['id'];
        $transactionRegistrationDetails = new TransactionRegistrationDetails();
        $masterReligion = new MasterReligion();
        $masterProvince = new MasterProvince();
        $masterCity = new MasterCity();
        $masterDistrict = new MasterDistrict();
        $masterVillage = new MasterVillage();
        $masterGovernmentClassification = new MasterGovernmentClassification();
//        $masterCollege = new MasterCollege();
//        $masterStudyProgram = new MasterStudyProgram();
        $db = new Database();

        $data = $db->selectByID($transactionRegistrationDetails, $transactionRegistrationDetails->getId() . equalToIgnoreCase($id));

        $this->data_religion = getLov($masterReligion, $masterReligion->getId() . equalToIgnoreCase($data[0][$transactionRegistrationDetails->getReligionId()]));
        $this->data_province = getLov($masterProvince, $masterProvince->getId() . equalToIgnoreCase($data[0][$transactionRegistrationDetails->getProvinceId()]));
        $this->data_city = getLov($masterCity, $masterCity->getId() . equalToIgnoreCase($data[0][$transactionRegistrationDetails->getCityId()]));
        $this->data_district = getLov($masterDistrict, $masterDistrict->getId() . equalToIgnoreCase($data[0][$transactionRegistrationDetails->getDistrictId()]));
        $this->data_village = getLov($masterVillage, $masterVillage->getId() . equalToIgnoreCase($data[0][$transactionRegistrationDetails->getVillageId()]));
        $this->data_government_classification = getLov($masterGovernmentClassification, $masterGovernmentClassification->getId() . equalToIgnoreCase($data[0][$transactionRegistrationDetails->getGovernmentClassificationId()]));
//        $this->data_college = getLov($masterCollege,$masterCollege->getId().equalToIgnoreCase($data[0][$transactionRegistrationDetails->getCollegeId()]));
//        $this->data_study_program = getLov($masterStudyProgram,$masterStudyProgram->getId().equalToIgnoreCase($data[0][$transactionRegistrationDetails->getStudyProgramId()]));
//        print_r($this->data_village);
//        print_r($this->data_religion);
//        print_r($data);
        include_once FILE_PATH(IViewMemberConstant::LIST_PARTICIPANT_VIEW_VIEW_INDEX);
    }

    public function listData() {
//        echo 'tes';
        $Form = new Form();
        $Datatable = new DataTable();
        $Button = new Button();
        $db = new Database();
//        $group = new SecurityGroup();
        $linkRegistration = new LinkRegistration();
        $transactionRegistration = new TransactionRegistration();
        $transactionRegistrationDetails = new TransactionRegistrationDetails();
//        $userMain = new MasterUserMain();
        if ($_POST['per_page'] == "") {
            $Datatable->per_page = 10;
        } else {
            $Datatable->per_page = $_POST['per_page'];
        }
        $Datatable->urlDeleteCollection(false);

        $Datatable->searchFilter(array("code" => lang("general.code")));
        $Datatable->current_page = $_POST['current_page'];
        if ($_POST['current_page'] == '') {
            $Datatable->current_page = 1;
        }
        $search = $_POST['search_pagination'];
        if ($_POST['search_by'] == '') {
            $search = $transactionRegistrationDetails->getEntity() . ".code LIKE  '%" . $search . "%'";
        } else if ($_POST['search_by'] == 'null') {
            $search = $transactionRegistrationDetails->getEntity() . ".code LIKE  '%" . $search . "%'";
        } else {
            if (!empty($transactionRegistrationDetails->search($_POST['search_by']))) {
                $search = $transactionRegistrationDetails->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search . "%'";
            }
        }

        $securityUser = new SecurityUser();
        $rs_user = $db->selectByID($securityUser, $securityUser->getCode() . equalToIgnoreCase($_SESSION[SESSION_USERNAME_GUEST]));

        $rs_registration = $db->selectByID($transactionRegistration, $transactionRegistration->getUserId() . equalToIgnoreCase($rs_user[0][$securityUser->getId()]));
//        print_r($rs_user);
        $whereList = $transactionRegistrationDetails->getEntity() . DOT . $transactionRegistrationDetails->getRegistrationId() . EQUAL . $transactionRegistration->getEntity() . DOT . $transactionRegistration->getId()
                . " AND " . $transactionRegistrationDetails->getEntity() . DOT . $transactionRegistrationDetails->getRegistrationId() . equalToIgnoreCase($rs_registration[0][$transactionRegistration->getId()]);
        $list_data = $Datatable->select_pagination($transactionRegistrationDetails, $transactionRegistrationDetails->getEntity(), $whereList, array($transactionRegistration->getEntity()), null, null, $transactionRegistrationDetails->getEntity() . DOT . $transactionRegistrationDetails->getId() . " as id,"
                . $transactionRegistrationDetails->getEntity() . DOT . $transactionRegistrationDetails->getName() . " as name,"
                . $transactionRegistrationDetails->getEntity() . DOT . $transactionRegistrationDetails->getFrontDegree() . " as front_degree,"
                . $transactionRegistrationDetails->getEntity() . DOT . $transactionRegistrationDetails->getUserId() . " as user_id,"
                . $transactionRegistrationDetails->getEntity() . DOT . $transactionRegistrationDetails->getBehindDegree() . " as behind_degree"
        );
//        print_r($list_data);
//        print_r($rs_registration);

        include_once FILE_PATH(IViewMemberConstant::LIST_PARTICIPANT_LIST_VIEW_INDEX);
    }

    public function upload() {
        $transactionRegistrationDetails = new TransactionRegistrationDetails();
        $transactionRegistration = new TransactionRegistration();
        $db = new Database();
        $db->connect();

        $securityUser = new SecurityUser();
        $masterNoIdType = new MasterNoIdType();
        $masterReligion = new MasterReligion();
//    $masterUserAssignment = new MasterUserAssignment();
        $user = checkUserLogin();
        $data_user = $db->selectByID($securityUser, $securityUser->getCode() . equalToIgnoreCase($user[SESSION_USERNAME_GUEST]));
        $data_registration = $db->selectByID($transactionRegistration, $transactionRegistration->getUserId() . equalToIgnoreCase($data_user[0][$securityUser->getId()]));

        if (!empty($data_registration)) {
            if (isset($_FILES['upload_participant'])) {
                $uploads = $_FILES['upload_participant'];
                $reArray = reArrayFiles($uploads);
                $upload = uploadFileImg($reArray[0], $reArray[0]['name'] . '-' . createRandomBooking(), FILE_PATH('uploads/member/' . $_SESSION[SESSION_USERNAME_GUEST] . '/'), array('csv', 'csv'), array('text/csv', 'application/vnd.ms-excel'));
                if ($upload['result'] == 1) {
                    $row = 1;
                    if (($handle = fopen(FILE_PATH('uploads/member/' . $_SESSION[SESSION_USERNAME_GUEST] . '/' . $upload['file_name']), 'r')) !== FALSE) {
                        $result_set = true;
                        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                            $num = count($data);
//                            echo $num;
                            if ($num == 11) {
                                if ($result_set = true) {
                                    $data_noIdType = $db->selectByID($masterNoIdType, $masterNoIdType->getName() . equalToIgnoreCase(strtoupper($data[2])));
                                    $id_idNumber = null;
                                    if (empty($data_noIdType)) {
                                        $db->insert($masterNoIdType->getEntity(), array(
                                            $masterNoIdType->getCode() => strtoupper($data[2]),
                                            $masterNoIdType->getName() => strtoupper($data[2]),
                                            $masterNoIdType->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                                            $masterNoIdType->getCreatedByUsername() => $_SESSION[SESSION_USERNAME_GUEST],
                                            $masterNoIdType->getStatus() => null,
                                                )
                                        );
                                        $rs_insert_noIdType = $db->getResult();
                                        if (is_numeric($rs_insert_noIdType[0])) {
                                            $id_idNumber = $rs_insert_noIdType[0];
                                        }
                                    } else {
                                        $id_idNumber = $data_noIdType[0][$masterNoIdType->getId()];
                                    }
                                    
                                    $data_religion = $db->selectByID($masterReligion, 
                                            $masterReligion->getName() . equalToIgnoreCase(strtoupper($data[7])));
                                    $id_religion = null;
                                    if (empty($data_religion)) {
                                        $db->insert($masterReligion->getEntity(), array(
                                            $masterReligion->getCode() => strtoupper($data[7]),
                                            $masterReligion->getName() => strtoupper($data[7]),
                                            $masterReligion->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                                            $masterReligion->getCreatedByUsername() => $_SESSION[SESSION_USERNAME_GUEST],
                                            $masterReligion->getStatus() => null,
                                                )
                                        );
                                        $rs_insert_religion = $db->getResult();
                                        if (is_numeric($rs_insert_religion[0])) {
                                            $id_religion = $rs_insert_religion[0];
                                        }
                                    } else {
                                        $id_religion = $data_religion[0][$masterReligion->getId()];
                                    }
                                    $gender = "";
                                    if($data[9] == "L"){
                                        $gender = "M";
                                    }
                                    
                                    if($data[9] == "P"){
                                        $gender = "F";
                                    }
                                    $db->insert($transactionRegistrationDetails->getEntity(), array(
                                        $transactionRegistrationDetails->getRegistrationId() => $data_registration[0][$transactionRegistration->getId()],
                                        $transactionRegistrationDetails->getCode() => $data[1],
                                        $transactionRegistrationDetails->getName() => $data[0],
                                        $transactionRegistrationDetails->getIdNumber() => $data[1],
                                        $transactionRegistrationDetails->getNoidTypeId() => $id_idNumber,
                                        $transactionRegistrationDetails->getFrontDegree() => $data[3],
                                        $transactionRegistrationDetails->getBehindDegree() => $data[4],
                                        $transactionRegistrationDetails->getPob() => $data[5],
                                        $transactionRegistrationDetails->getDob() => $data[6],
                                        $transactionRegistrationDetails->getEmail() => $data[8],
                                        $transactionRegistrationDetails->getReligionId() => $id_religion,
                                        $transactionRegistrationDetails->getGender() => $gender,
                                        $transactionRegistrationDetails->getPhoneNumber() => $data[10],
                                        $transactionRegistrationDetails->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                                        $transactionRegistrationDetails->getCreatedByUsername() => $_SESSION[SESSION_USERNAME_GUEST],
                                        $transactionRegistrationDetails->getStatus() => null,
                                            )
                                    );
                                    $rs_insert_reg_detail = $db->getResult();
                                    if (!is_numeric($rs_insert_reg_detail[0])) {
                                        $result_set = false;
                                    }
                                }
                            } else {
                                echo resultPageMsg('danger', 'Insert Error', 'The data format does not match, please look at the example data');
                            }
                        }
                        fclose($handle);
                        if($result_set == true){
                            echo postAjaxPaginationManual('pageListParticipant');
                        } else {
                            echo resultPageMsg('danger', lang('general.title_insert_error'), lang('general.message_insert_error'));
                        }
                    }
                } else {
                    echo resultPageMsg('danger', 'Upload Error', 'Format file must be csv');
                }
            }
        }
    }

}
