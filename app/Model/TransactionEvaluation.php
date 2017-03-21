<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Model;

/**
 * Description of TransactionEvaluation
 *
 * @author sfandrianah
 */
use app\Model\GeneralAuditrail;

class TransactionEvaluation extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('trx_evaluation');
    }
    
    private $activityDetailsId = 'activity_details_id';
    private $userAssignmentId = 'user_assignment_id';
    private $value = 'value';
    private $rateValue = 'rate_value';
    
    public function getActivityDetailsId() {
        return $this->activityDetailsId;
    }

    public function getUserAssignmentId() {
        return $this->userAssignmentId;
    }

    public function getValue() {
        return $this->value;
    }

    public function getRateValue() {
        return $this->rateValue;
    }

    public function setActivityDetailsId($activityDetailsId) {
        $this->activityDetailsId = $activityDetailsId;
    }

    public function setUserAssignmentId($userAssignmentId) {
        $this->userAssignmentId = $userAssignmentId;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function setRateValue($rateValue) {
        $this->rateValue = $rateValue;
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
