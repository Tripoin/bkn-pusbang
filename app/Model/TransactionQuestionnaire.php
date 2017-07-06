<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Model;

/**
 * Description of TransactionQuestionnaire
 *
 * @author sfandrianah
 */
use app\Model\GeneralAuditrail;

class TransactionQuestionnaire extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('trx_questionnaire');
    }

    protected $levelQuestionnaireId = 'level_questionnaire_id';
    protected $questionnaireStart = 'questionnaire_start';
    protected $questionnaireEnd = 'questionnaire_end';
    protected $questionnaireYear = 'questionnaire_year';

    public function getLevelQuestionnaireId() {
        return $this->levelQuestionnaireId;
    }

    public function getQuestionnaireStart() {
        return $this->questionnaireStart;
    }

    public function getQuestionnaireEnd() {
        return $this->questionnaireEnd;
    }

    public function getQuestionnaireYear() {
        return $this->questionnaireYear;
    }

    public function setLevelQuestionnaireId($levelQuestionnaireId) {
        $this->levelQuestionnaireId = $levelQuestionnaireId;
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
