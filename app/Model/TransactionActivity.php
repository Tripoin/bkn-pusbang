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

class TransactionActivity extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('trx_activity');
    }
    
    public $subjectName = 'subject_name';
    public $subjectCategoryName = 'subject_category_name';
    public $subjectTypeName = 'subject_type_name';
    public $generation = 'generation';
    public $location = 'location';
    public $startActivity = 'start_activity';
    public $endActivity = 'end_activity';
    public $yearActivity = 'year_activity';
    public $duration = 'duration';
    public $unitId = 'unit_id';
    
    public function search($key) {
        return $this->$key;
    }
    
    function setData($data) {
        $array_data = array();
        foreach ($data as $key => $value) {
            $array_data[$this->$key] = $value;
        }
        return $array_data;
    }

    function getSubjectName() {
        return $this->subjectName;
    }

    function getSubjectCategoryName() {
        return $this->subjectCategoryName;
    }

    function getSubjectTypeName() {
        return $this->subjectTypeName;
    }

    function getGeneration() {
        return $this->generation;
    }

    function getLocation() {
        return $this->location;
    }

    function getStartActivity() {
        return $this->startActivity;
    }

    function getEndActivity() {
        return $this->endActivity;
    }

    function getYearActivity() {
        return $this->yearActivity;
    }

    function getDuration() {
        return $this->duration;
    }

    function getUnitId() {
        return $this->unitId;
    }

    function setSubjectName($subjectName) {
        $this->subjectName = $subjectName;
    }

    function setSubjectCategoryName($subjectCategoryName) {
        $this->subjectCategoryName = $subjectCategoryName;
    }

    function setSubjectTypeName($subjectTypeName) {
        $this->subjectTypeName = $subjectTypeName;
    }

    function setGeneration($generation) {
        $this->generation = $generation;
    }

    function setLocation($location) {
        $this->location = $location;
    }

    function setStartActivity($startActivity) {
        $this->startActivity = $startActivity;
    }

    function setEndActivity($endActivity) {
        $this->endActivity = $endActivity;
    }

    function setYearActivity($yearActivity) {
        $this->yearActivity = $yearActivity;
    }

    function setDuration($duration) {
        $this->duration = $duration;
    }

    function setUnitId($unitId) {
        $this->unitId = $unitId;
    }


}
