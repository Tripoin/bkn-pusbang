<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Model;

/**
 * Description of MasterAnswerType
 *
 * @author sfandrianah
 */
use app\Model\GeneralAuditrail;

class MasterAnswerType extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('mst_answer_type');
    }
    
    protected $answerCategoryId = 'answer_category_id';

    public function getAnswerCategoryId() {
        return $this->answerCategoryId;
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
