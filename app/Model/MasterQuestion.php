<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Model;

/**
 * Description of MasterQuestion
 *
 * @author sfandrianah
 */
use app\Model\GeneralAuditrail;

class MasterQuestion extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('mst_question');
    }

    protected $questionCategoryId = 'question_category_id';
    protected $questionDetails = 'question_details';
    protected $jsonQuestion = 'json_question';
    protected $answerCategoryId = 'answer_category_id';
    public function getQuestionCategoryId() {
        return $this->questionCategoryId;
    }

    public function getQuestionDetails() {
        return $this->questionDetails;
    }

    public function getJsonQuestion() {
        return $this->jsonQuestion;
    }

    public function getAnswerCategoryId() {
        return $this->answerCategoryId;
    }

    public function setQuestionCategoryId($questionCategoryId) {
        $this->questionCategoryId = $questionCategoryId;
    }

    public function setQuestionDetails($questionDetails) {
        $this->questionDetails = $questionDetails;
    }

    public function setJsonQuestion($jsonQuestion) {
        $this->jsonQuestion = $jsonQuestion;
    }

    public function setAnswerCategoryId($answerCategoryId) {
        $this->answerCategoryId = $answerCategoryId;
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
