<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Model;

/**
 * Description of TransactionSurveyDetails
 *
 * @author sfandrianah
 */
use app\Model\GeneralAuditrail;

class TransactionSurveyDetails extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('trx_survey_details');
    }
    
    private $surveyId = 'survey_id';
    private $evaluationId = 'evaluation_id';
    private $categoryAssessId = 'category_assess_id';
    private $value= 'value';
    private $evaluatedBy = 'surveyed_by';
    private $evaluatedOn = 'surveyed_on';
    
    function getSurveyId() {
        return $this->surveyId;
    }

    function setSurveyId($surveyId) {
        $this->surveyId = $surveyId;
    }

        
    public function getEvaluationId() {
        return $this->evaluationId;
    }

    public function getCategoryAssessId() {
        return $this->categoryAssessId;
    }

    public function getValue() {
        return $this->value;
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
    
    function getEvaluatedBy() {
        return $this->evaluatedBy;
    }

    function getEvaluatedOn() {
        return $this->evaluatedOn;
    }

    function setEvaluatedBy($evaluatedBy) {
        $this->evaluatedBy = $evaluatedBy;
    }

    function setEvaluatedOn($evaluatedOn) {
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
