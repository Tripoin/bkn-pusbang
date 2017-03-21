<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Model;

/**
 * Description of TransactionActivityDetails
 *
 * @author sfandrianah
 */
use app\Model\GeneralAuditrail;

class TransactionActivityDetails extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('trx_activity_details');
    }

    public $activityId = 'activity_id';
    public $materialName = 'material_name';
    public $curriculumId = 'curriculum_id';
    public $userMainId = 'user_main_id';
    public $userMainName = 'user_main_name';
    public $generation = 'generation';
    public $location = 'location';
    public $startTime = 'start_time';
    public $endTime = 'end_time';
    public $duration = 'duration';
    public $unitId = 'unit_id';

    function getUserMainName() {
        return $this->userMainName;
    }

    function setUserMainName($userMainName) {
        $this->userMainName = $userMainName;
    }

    function getActivityId() {
        return $this->activityId;
    }

    function getMaterialName() {
        return $this->materialName;
    }

    function getCurriculumId() {
        return $this->curriculumId;
    }

    function getUserMainId() {
        return $this->userMainId;
    }

    function getGeneration() {
        return $this->generation;
    }

    function getLocation() {
        return $this->location;
    }

    function getStartTime() {
        return $this->startTime;
    }

    function getEndTime() {
        return $this->endTime;
    }

    function getDuration() {
        return $this->duration;
    }

    function getUnitId() {
        return $this->unitId;
    }

    function setActivityId($activityId) {
        $this->activityId = $activityId;
    }

    function setMaterialName($materialName) {
        $this->materialName = $materialName;
    }

    function setCurriculumId($curriculumId) {
        $this->curriculumId = $curriculumId;
    }

    function setUserMainId($userMainId) {
        $this->userMainId = $userMainId;
    }

    function setGeneration($generation) {
        $this->generation = $generation;
    }

    function setLocation($location) {
        $this->location = $location;
    }

    function setStartTime($startTime) {
        $this->startTime = $startTime;
    }

    function setEndTime($endTime) {
        $this->endTime = $endTime;
    }

    function setDuration($duration) {
        $this->duration = $duration;
    }

    function setUnitId($unitId) {
        $this->unitId = $unitId;
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
