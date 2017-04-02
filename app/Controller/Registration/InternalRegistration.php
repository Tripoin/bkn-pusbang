<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InternalRegistration
 *
 * @author sfandrianah
 */

namespace app\Controller\Registration;

use app\Controller\Base\Controller;
use app\Util\Database;
use app\Model\SecurityGroup;
use app\Model\SecurityUser;
use app\Model\SecurityUserProfile;
use app\Model\MasterUserMain;
use app\Model\MasterAddress;
use app\Model\MasterContact;
use app\Constant\IURLConstant;
use app\Constant\IViewConstant;

class InternalRegistration extends Controller {

    //put your code here

    public function __construct() {
        $this->modelData = new SecurityUser();
        $this->setTitle(lang('general.registration_internal'));
        $this->setBreadCrumb(array(lang('member.registration') => "", lang('general.registration_internal') => FULLURL()));
        $this->search_filter = array("code" => lang('general.code'), "name" => lang('general.name'));
        $this->indexUrl = IURLConstant::REGISTRATION_INTERNAL_INDEX_URL;
        $this->viewPath = IViewConstant::REGISTRATION_INTERNAL_VIEW_INDEX;
        $this->unsetAutoData = array('description');
//        $this->autoData = true;
        $this->setAutoCrud();
        parent::__construct();
    }

    public function listData() {
        $securityUserProfile = new SecurityUserProfile();
        $masterUserMain = new MasterUserMain();
        $securityUser = new SecurityUser();
//        $securityGroup = new SecurityGroup();
//        $db = new Database();
//        $this->search_filter = $securityUser->getCode();
//        $rs_group = 

        $this->where_list = $securityUserProfile->getEntity() . DOT . $securityUserProfile->getUserId() . EQUAL . $securityUser->getEntity() . DOT . $securityUser->getId()
                . " AND " . $masterUserMain->getEntity() . DOT . $masterUserMain->getUserProfileId() . EQUAL . $securityUserProfile->getEntity() . DOT . $securityUserProfile->getId()
                . " AND " . $securityUser->getEntity() . DOT . $securityUser->getGroupId() . equalToIgnoreCase(4)
        ;
        $this->join_list = array($securityUserProfile->getEntity(), $masterUserMain->getEntity());
        $this->select_entity = $securityUser->getEntity() . DOT . $securityUser->getId() . ','
                . $masterUserMain->getEntity() . DOT . $masterUserMain->getIdNumber() . ' as code,'
                . $securityUserProfile->getEntity() . DOT . $securityUserProfile->getName()
        ;
        $search = $_POST['search_pagination'];
        if ($_POST['search_by'] == '') {
            $this->search_datatable = $masterUserMain->getEntity() . DOT . $masterUserMain->getIdNumber() . '>' . $search;
        } else if ($_POST['search_by'] == 'null') {
            $this->search_datatable = $masterUserMain->getEntity() . DOT . $masterUserMain->getIdNumber() . '>' . $search;
        } else {
            if ($_POST['search_by'] == 'code') {
                $this->search_datatable = $masterUserMain->getEntity() . DOT . $masterUserMain->getIdNumber() . '>' . $search;
            } else if ($_POST['search_by'] == 'name') {
                $this->search_datatable = $securityUserProfile->getEntity() . DOT . $securityUserProfile->getName() . '>' . $search;
            } else {
                $this->search_datatable = $_POST['search_by'] . '>' . $search;
            }
        }
        parent::listData();
    }

    public function save() {
//        print_r($_POST);
//        foreach ($_POST as $key => $value) {
//            echo '$' . $key . ' = $_POST[\'' . $key . '\']; <br/>';
//        }

        $participant_name = $_POST['participant_name'];
        $idNumber = $_POST['idNumber'];
        $noidType = $_POST['noidType'];
        $frontDegree = $_POST['front_degree'];
        $behindDegree = $_POST['behind_degree'];
        $placeOfBirth = $_POST['place_of_birth'];
        $dateOfBirth = $_POST['date_of_birth'];
        $religion = $_POST['religion'];
        $gender = $_POST['gender'];
        $maritalStatus = $_POST['marital_status'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $fax = $_POST['fax'];
        $address = $_POST['address'];
        $province = $_POST['province'];
        $city = $_POST['city'];
        $district = $_POST['district'];
        $village = $_POST['village'];
        $zipCode = $_POST['zip_code'];
        $government_classification = $_POST['government_classification'];
        $jsonOccupation = $_POST['json_occupation'];
        $degree = $_POST['degree'];
        $collegeName = $_POST['college-name'];
        $college = $_POST['college'];
        $faculity = $_POST['faculity'];
        $studyProgramName = $_POST['study_program-name'];
        $studyProgram = $_POST['study_program'];
        $graduationYear = $_POST['graduation_year'];
        $workingUnit = $_POST['working_unit'];

        $db = new Database();
        $db->connect();

        




        $result = true;
//        echo 'sukses';
        $password = password_hash($idNumber, PASSWORD_BCRYPT);

        $securityUser = new SecurityUser();
        $securityUser->setCode($idNumber);
        $securityUser->setName($participant_name);
        $securityUser->setDescription($idNumber . '-' . $participant_name);
        $securityUser->setPassword($password);
        $securityUser->setGroupId(4);
        $securityUser->setEmail($email);
        $securityUser->setStatus(1);
        $securityUser->setCreatedOn(date(DATE_FORMAT_PHP_DEFAULT));
        $securityUser->setCreatedByUsername($_SESSION[SESSION_ADMIN_USERNAME]);
//        print_r($securityUser->data());
        $db->insert($securityUser->getEntity(), $securityUser->data());
        $rs_insert_user = $db->getResult();
        if (!is_numeric($rs_insert_user[0])) {
            $result = false;
        } else {
            $masterAddress = new MasterAddress();
            $masterAddress->setCode(createRandomBooking());
            $masterAddress->setName($address);
            $masterAddress->setProvinceId($province);
            $masterAddress->setCityId($city);
            $masterAddress->setDistrictId($district);
            $masterAddress->setVillageId($village);
            $masterAddress->setZipCode($zipCode);
            $masterAddress->setDescription($address);
            $masterAddress->setStatus(1);
            $masterAddress->setCreatedOn(date(DATE_FORMAT_PHP_DEFAULT));
            $masterAddress->setCreatedByUsername($_SESSION[SESSION_ADMIN_USERNAME]);
            $db->insert($masterAddress->getEntity(), $masterAddress->data());
            $rs_insert_address = $db->getResult();
            if (!is_numeric($rs_insert_address[0])) {
                $this->rollBackSecurityUser($rs_insert_user[0]);
                $result = false;
            } else {
                $masterContact = new MasterContact();
                $masterContact->setCode(createRandomBooking());
                $masterContact->setName($participant_name);
                $masterContact->setEmail1($email);
                $masterContact->setPhoneNumber1($telephone);
                $masterContact->setFax($fax);
                $masterContact->setDescription($participant_name);
                $masterContact->setStatus(1);
                $masterContact->setCreatedOn(date(DATE_FORMAT_PHP_DEFAULT));
                $masterContact->setCreatedByUsername($_SESSION[SESSION_ADMIN_USERNAME]);
                $db->insert($masterContact->getEntity(), $masterContact->data());
                $rs_insert_contact = $db->getResult();
                if (!is_numeric($rs_insert_contact[0])) {
                    $this->rollBackSecurityUser($rs_insert_user[0]);
                    $this->rollBackMasterAddress($rs_insert_address[0]);
                    $result = false;
                } else {
                    $securityUserProfile = new SecurityUserProfile();
                    $securityUserProfile->setCode($idNumber);
                    $securityUserProfile->setName($participant_name);
                    $securityUserProfile->setUserId($rs_insert_user[0]);
                    $securityUserProfile->setBirthdate($dateOfBirth);
                    $securityUserProfile->setPlace($placeOfBirth);
                    $securityUserProfile->setGender($gender);
                    $securityUserProfile->setReligionId($religion);
                    $securityUserProfile->setMarriage($maritalStatus);
                    $securityUserProfile->setContactId($rs_insert_contact[0]);
                    $securityUserProfile->setAddressId($rs_insert_address[0]);
                    $securityUserProfile->setDescription($participant_name);
                    $securityUserProfile->setStatus(1);
                    $securityUserProfile->setCreatedOn(date(DATE_FORMAT_PHP_DEFAULT));
                    $securityUserProfile->setCreatedByUsername($_SESSION[SESSION_ADMIN_USERNAME]);
                    $db->insert($securityUserProfile->getEntity(), $securityUserProfile->data());
                    $rs_insert_user_profile = $db->getResult();
                    if (!is_numeric($rs_insert_user_profile[0])) {
                        $this->rollBackSecurityUser($rs_insert_user[0]);
                        $this->rollBackMasterContact($rs_insert_contact[0]);
                        $this->rollBackMasterAddress($rs_insert_address[0]);
                        $result = false;
                    } else {
                        $masterUserMain = new MasterUserMain();
                        $masterUserMain->setCode($idNumber);
                        $masterUserMain->setName($participant_name);
                        $masterUserMain->setUserProfileId($rs_insert_user_profile[0]);
                        $masterUserMain->setFront_degree($frontDegree);
                        $masterUserMain->setBehind_degree($behindDegree);
                        $masterUserMain->setIdNumber($idNumber);
                        $masterUserMain->setNoIdTypeId($noidType);
                        $masterUserMain->setJsonOccupation($jsonOccupation);
                        $masterUserMain->setParticipantTypeId(2);
                        $masterUserMain->setWorkingUnitId($workingUnit);
                        $masterUserMain->setGovernmentClassificationId($government_classification);
                        $masterUserMain->setDegree($degree);
                        $masterUserMain->setCollege($collegeName);
                        $masterUserMain->setCollegeId($college);
                        $masterUserMain->setFaculty($faculity);
                        $masterUserMain->setStudyProgram($studyProgramName);
                        $masterUserMain->setStudyProgramId($studyProgram);
                        $masterUserMain->setGraduationYear($graduationYear);
                        $masterUserMain->setDescription($participant_name);
                        $masterUserMain->setStatus(1);
                        $masterUserMain->setCreatedOn(date(DATE_FORMAT_PHP_DEFAULT));
                        $masterUserMain->setCreatedByUsername($_SESSION[SESSION_ADMIN_USERNAME]);
                        $db->insert($masterUserMain->getEntity(), $masterUserMain->data());
                        $rs_insert_user_main = $db->getResult();
                        if (!is_numeric($rs_insert_user_main[0])) {
                            $this->rollBackSecurityUser($rs_insert_user[0]);
                            $this->rollBackMasterContact($rs_insert_contact[0]);
                            $this->rollBackMasterAddress($rs_insert_address[0]);
                            $result = false;
                        }
                    }
                }
            }
        }

        if ($result == true) {
            echo toastAlert('success', lang('general.title_insert_success'), lang('general.message_insert_success'));
            echo resultPageMsg('success', lang('general.title_insert_success'), lang('general.message_insert_success'));
            echo postAjaxPagination();
        } else {
            echo toastAlert('error', lang('general.title_insert_error'), lang('general.message_insert_error'));
            echo resultPageMsg('danger', lang('general.title_insert_error'), json_encode($rs_insert_user[0]));
        }
//        parent::save();
    }

    public function rollBackSecurityUser($id) {
        $db = new Database();
        $db->connect();
        $securityUser = new SecurityUser();
        $db->delete($securityUser->getEntity(), $securityUser->getId() . equalToIgnoreCase($id));
    }

    public function rollBackMasterContact($id) {
        $db = new Database();
        $db->connect();
        $MasterContact = new MasterContact();
        $db->delete($MasterContact->getEntity(), $MasterContact->getId() . equalToIgnoreCase($id));
    }

    public function rollBackMasterAddress($id) {
        $db = new Database();
        $db->connect();
        $MasterAddress = new MasterAddress();
        $db->delete($MasterAddress->getEntity(), $MasterAddress->getId() . equalToIgnoreCase($id));
    }

}
