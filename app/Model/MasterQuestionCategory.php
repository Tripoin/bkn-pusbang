<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Model;

/**
 * Description of MasterQuestionCategory
 *
 * @author sfandrianah
 */
use app\Model\GeneralAuditrail;

class MasterQuestionCategory extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('mst_question_category');
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
