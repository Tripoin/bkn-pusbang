<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Model;

/**
 * Description of MasterPostLanguage
 *
 * @author sfandrianah
 */
use app\Model\GeneralAuditrail;

class TransactionRegistrationDetails extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('trx_registration_details');
    }
    
    public $email = 'email';
    public $phoneNumber = 'phone_number';
    public $fax = 'fax';
    public $gender = 'gender';
    public $religionId = 'religion_id';
    public $maritalStatus = 'marital_status';
    public $dob = 'dob';
    public $pob = 'pob';
    public $address = 'address';
    public $villageId = 'village_id';
    public $districtId = 'district_id';
    public $cityId = 'city_id';
    public $provinceId = 'province_id';
    public $zipCode = 'zip_code';
    public $frontDegree = 'front_degree';
    public $behindDegree = 'behind_degree';
    public $idNumber = 'id_number';
    public $noidTypeId = 'noid_type_id';
    public $jsonOccupation = 'json_occupation';
    public $participantTypeId = 'participant_type_id';
    public $governmentClassificationId = 'government_classification_id';
    public $degree = 'degree';
    public $college = 'college';
    public $collegeId = 'college_id';
    public $faculity = 'faculity';
    public $studyProgram = 'study_program';
    public $studyProgramId = 'study_program_id';
    public $graduationYear = 'graduation_year';
    public $isCreated = 'is_created';
    public $userId = 'user_id';
    public $isApproved = 'is_approved';
    public $approvedBy = 'approved_by';
    public $approvedOn = 'approved_on';
    public $approvedMessage = 'approved_message';
    
    public function search($key) {
        if(isset($this->$key)){
            return $this->$key;
        } else {
            return "";
        }
        
    }
    
    function setData($data) {
        $array_data = array();
        foreach ($data as $key => $value) {
            $array_data[$this->$key] = $value;
        }
        return $array_data;
    }
    function getEmail() {
        return $this->email;
    }

    function getPhoneNumber() {
        return $this->phoneNumber;
    }

    function getFax() {
        return $this->fax;
    }

    function getGender() {
        return $this->gender;
    }

    function getReligionId() {
        return $this->religionId;
    }

    function getMaritalStatus() {
        return $this->maritalStatus;
    }

    function getDob() {
        return $this->dob;
    }

    function getPob() {
        return $this->pob;
    }

    function getAddress() {
        return $this->address;
    }

    function getVillageId() {
        return $this->villageId;
    }

    function getDistrictId() {
        return $this->districtId;
    }

    function getCityId() {
        return $this->cityId;
    }

    function getProvinceId() {
        return $this->provinceId;
    }

    function getZipCode() {
        return $this->zipCode;
    }

    function getFrontDegree() {
        return $this->frontDegree;
    }

    function getBehindDegree() {
        return $this->behindDegree;
    }

    function getIdNumber() {
        return $this->idNumber;
    }

    function getNoidTypeId() {
        return $this->noidTypeId;
    }

    function getJsonOccupation() {
        return $this->jsonOccupation;
    }

    function getParticipantTypeId() {
        return $this->participantTypeId;
    }

    function getGovernmentClassificationId() {
        return $this->governmentClassificationId;
    }

    function getDegree() {
        return $this->degree;
    }

    function getCollege() {
        return $this->college;
    }

    function getCollegeId() {
        return $this->collegeId;
    }

    function getFaculity() {
        return $this->faculity;
    }

    function getStudyProgram() {
        return $this->studyProgram;
    }

    function getStudyProgramId() {
        return $this->studyProgramId;
    }

    function getGraduationYear() {
        return $this->graduationYear;
    }

    function getIsCreated() {
        return $this->isCreated;
    }

    function getUserId() {
        return $this->userId;
    }

    function getIsApproved() {
        return $this->isApproved;
    }

    function getApprovedBy() {
        return $this->approvedBy;
    }

    function getApprovedOn() {
        return $this->approvedOn;
    }

    function getApprovedMessage() {
        return $this->approvedMessage;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
    }

    function setFax($fax) {
        $this->fax = $fax;
    }

    function setGender($gender) {
        $this->gender = $gender;
    }

    function setReligionId($religionId) {
        $this->religionId = $religionId;
    }

    function setMaritalStatus($maritalStatus) {
        $this->maritalStatus = $maritalStatus;
    }

    function setDob($dob) {
        $this->dob = $dob;
    }

    function setPob($pob) {
        $this->pob = $pob;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setVillageId($villageId) {
        $this->villageId = $villageId;
    }

    function setDistrictId($districtId) {
        $this->districtId = $districtId;
    }

    function setCityId($cityId) {
        $this->cityId = $cityId;
    }

    function setProvinceId($provinceId) {
        $this->provinceId = $provinceId;
    }

    function setZipCode($zipCode) {
        $this->zipCode = $zipCode;
    }

    function setFrontDegree($frontDegree) {
        $this->frontDegree = $frontDegree;
    }

    function setBehindDegree($behindDegree) {
        $this->behindDegree = $behindDegree;
    }

    function setIdNumber($idNumber) {
        $this->idNumber = $idNumber;
    }

    function setNoidTypeId($noidTypeId) {
        $this->noidTypeId = $noidTypeId;
    }

    function setJsonOccupation($jsonOccupation) {
        $this->jsonOccupation = $jsonOccupation;
    }

    function setParticipantTypeId($participantTypeId) {
        $this->participantTypeId = $participantTypeId;
    }

    function setGovernmentClassificationId($governmentClassificationId) {
        $this->governmentClassificationId = $governmentClassificationId;
    }

    function setDegree($degree) {
        $this->degree = $degree;
    }

    function setCollege($college) {
        $this->college = $college;
    }

    function setCollegeId($collegeId) {
        $this->collegeId = $collegeId;
    }

    function setFaculity($faculity) {
        $this->faculity = $faculity;
    }

    function setStudyProgram($studyProgram) {
        $this->studyProgram = $studyProgram;
    }

    function setStudyProgramId($studyProgramId) {
        $this->studyProgramId = $studyProgramId;
    }

    function setGraduationYear($graduationYear) {
        $this->graduationYear = $graduationYear;
    }

    function setIsCreated($isCreated) {
        $this->isCreated = $isCreated;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setIsApproved($isApproved) {
        $this->isApproved = $isApproved;
    }

    function setApprovedBy($approvedBy) {
        $this->approvedBy = $approvedBy;
    }

    function setApprovedOn($approvedOn) {
        $this->approvedOn = $approvedOn;
    }

    function setApprovedMessage($approvedMessage) {
        $this->approvedMessage = $approvedMessage;
    }


}
