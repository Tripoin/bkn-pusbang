<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Model;

/**
 * Description of TransactionEvaluationDetails
 *
 * @author sfandrianah
 */
use app\Model\GeneralAuditrail;

class TransactionEvaluationDetails extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('trx_evaluation_details');
    }
    
    private $evaluationId = 'evaluation_id';
    private $categoryAssessId = 'category_assess_id';
    private $value= 'value';
    private $evaluatedBy = 'evaluated_by';
    private $evaluatedOn = 'evaluated_on';
    
    public function getEvaluationId() {
        return $this->evaluationId;
    }

    public function getCategoryAssessId() {
        return $this->categoryAssessId;
    }

    public function getValue() {
        return $this->value;
    }

    public function getEvaluatedBy() {
        return $this->evaluatedBy;
    }

    public function getEvaluatedOn() {
        return $this->evaluatedOn;
    }

    public function setEvaluationId($evaluationId) {
        $this->evaluationId = $evaluationId;
    }

    public function setCategoryAssessId($categoryAssessId) {
        $this->categoryAssessId = $categoryAssessId;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function setEvaluatedBy($evaluatedBy) {
        $this->evaluatedBy = $evaluatedBy;
    }

    public function setEvaluatedOn($evaluatedOn) {
        $this->evaluatedOn = $evaluatedOn;
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
