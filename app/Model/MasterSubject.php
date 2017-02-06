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

class MasterSubject extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('mst_subject');
    }

    public $budgetTypeId = 'budget_type_id';
    public $subjectAmount = 'subject_amount';
    public $location = 'location';
    public $necessaryDescription = 'necessary_description';
    public $parentId = 'parent_id';

    function getBudgetTypeId() {
        return $this->budgetTypeId;
    }

    function getSubjectAmount() {
        return $this->subjectAmount;
    }

    function getLocation() {
        return $this->location;
    }

    function getNecessaryDescription() {
        return $this->necessaryDescription;
    }

    function getParentId() {
        return $this->parentId;
    }

    function setBudgetTypeId($budgetTypeId) {
        $this->budgetTypeId = $budgetTypeId;
    }

    function setSubjectAmount($subjectAmount) {
        $this->subjectAmount = $subjectAmount;
    }

    function setLocation($location) {
        $this->location = $location;
    }

    function setNecessaryDescription($necessaryDescription) {
        $this->necessaryDescription = $necessaryDescription;
    }

    function setParentId($parentId) {
        $this->parentId = $parentId;
    }

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

}
