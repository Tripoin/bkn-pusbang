<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Model;

/**
 * Description of MasterQuestionnaireReview
 *
 * @author sfandrianah
 */
use app\Model\GeneralAuditrail;

class MasterQuestionnaireReview extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('mst_questionnaire_review');
    }
    
    protected $questionnaireStart = 'questionnaire_start';
    protected $questionnaireEnd = 'questionnaire_end';
    protected $questionnaireYear = 'questionnaire_year';
    protected $jsonReview = 'json_review';
    
    public function getQuestionnaireStart() {
        return $this->questionnaireStart;
    }

    public function getQuestionnaireEnd() {
        return $this->questionnaireEnd;
    }

    public function getQuestionnaireYear() {
        return $this->questionnaireYear;
    }

    public function getJsonReview() {
        return $this->jsonReview;
    }

    public function setQuestionnaireStart($questionnaireStart) {
        $this->questionnaireStart = $questionnaireStart;
    }

    public function setQuestionnaireEnd($questionnaireEnd) {
        $this->questionnaireEnd = $questionnaireEnd;
    }

    public function setQuestionnaireYear($questionnaireYear) {
        $this->questionnaireYear = $questionnaireYear;
    }

    public function setJsonReview($jsonReview) {
        $this->jsonReview = $jsonReview;
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
