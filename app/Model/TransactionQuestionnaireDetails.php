<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Model;

/**
 * Description of TransactionQuestionnaireDetails
 *
 * @author sfandrianah
 */
use app\Model\GeneralAuditrail;

class TransactionQuestionnaireDetails extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('trx_questionnaire_details');
    }

    protected $questionId = 'question_id';
    protected $jsonAnswer = 'json_answer';
    protected $questionnaireId = 'questionnaire_id';

    public function getQuestionId() {
        return $this->questionId;
    }

    public function getJsonAnswer() {
        return $this->jsonAnswer;
    }

    public function getQuestionnaireId() {
        return $this->questionnaireId;
    }

    public function setQuestionId($questionId) {
        $this->questionId = $questionId;
    }

    public function setJsonAnswer($jsonAnswer) {
        $this->jsonAnswer = $jsonAnswer;
    }

    public function setQuestionnaireId($questionnaireId) {
        $this->questionnaireId = $questionnaireId;
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
