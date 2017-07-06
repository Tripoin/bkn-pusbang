<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Model;

/**
 * Description of MasterQuestionSelected
 *
 * @author sfandrianah
 */
use app\Model\GeneralAuditrail;

class MasterQuestionSelected extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('mst_question_selected');
    }

    protected $questionId = 'question_id';
    protected $questionReviewId = 'question_review_id';

    public function getQuestionId() {
        return $this->questionId;
    }

    public function getQuestionReviewId() {
        return $this->questionReviewId;
    }

    public function setQuestionId($questionId) {
        $this->questionId = $questionId;
    }

    public function setQuestionReviewId($questionReviewId) {
        $this->questionReviewId = $questionReviewId;
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
