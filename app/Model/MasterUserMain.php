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

class MasterUserMain extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('mst_user_main');
    }

    public $user_profile_id = 'user_profile_id';
    public $front_degree = 'front_degree';
    public $behind_degree = 'behind_degree';
    public $participantTypeId = 'participant_type_id';
    public $workingUnitId = 'working_unit_id';
    public $idNumber = 'id_number';
    public $userProfileId = 'user_profile_id';
    public $governmentClassificationId = 'government_classification_id';
    public $jsonOccupation = 'json_occupation';
    public $degree = 'degree';
    public $college = 'college';
    public $faculty = 'faculty';
    public $studyProgram = 'study_program';
    public $graduationYear = 'graduation_year';

    function getGraduationYear() {
        return $this->graduationYear;
    }

    function setGraduationYear($graduationYear) {
        $this->graduationYear = $graduationYear;
    }

    function getFaculty() {
        return $this->faculty;
    }

    function setFaculty($faculty) {
        $this->faculty = $faculty;
    }

    function getStudyProgram() {
        return $this->studyProgram;
    }

    function setStudyProgram($studyProgram) {
        $this->studyProgram = $studyProgram;
    }

    function getCollege() {
        return $this->college;
    }

    function setCollege($college) {
        $this->college = $college;
    }

    function getDegree() {
        return $this->degree;
    }

    function setDegree($degree) {
        $this->degree = $degree;
    }

    function getJsonOccupation() {
        return $this->jsonOccupation;
    }

    function setJsonOccupation($jsonOccupation) {
        $this->jsonOccupation = $jsonOccupation;
    }

    function getGovernmentClassificationId() {
        return $this->governmentClassificationId;
    }

    function setGovernmentClassificationId($governmentClassificationId) {
        $this->governmentClassificationId = $governmentClassificationId;
    }

    function getUserProfileId() {
        return $this->userProfileId;
    }

    function setUserProfileId($userProfileId) {
        $this->userProfileId = $userProfileId;
    }

    function getIdNumber() {
        return $this->idNumber;
    }

    function setIdNumber($idNumber) {
        $this->idNumber = $idNumber;
    }

    function getWorkingUnitId() {
        return $this->workingUnitId;
    }

    function setWorkingUnitId($workingUnitId) {
        $this->workingUnitId = $workingUnitId;
    }

    function getParticipantTypeId() {
        return $this->participantTypeId;
    }

    function setParticipantTypeId($participantTypeId) {
        $this->participantTypeId = $participantTypeId;
    }

    function getFront_degree() {
        return $this->front_degree;
    }

    function setFront_degree($front_degree) {
        $this->front_degree = $front_degree;
    }

    function getBehind_degree() {
        return $this->behind_degree;
    }

    function setBehind_degree($behind_degree) {
        $this->behind_degree = $behind_degree;
    }

    function getUser_profile_id() {
        return $this->user_profile_id;
    }

    function setUser_profile_id($user_profile_id) {
        $this->user_profile_id = $user_profile_id;
    }

    public function search($key) {
        if (isset($this->$key)) {
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

}
