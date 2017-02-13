<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Model;

/**
 * Description of MasterPostLanguage
 *
 * @author sfandrianah
 */
use app\Model\GeneralAuditrail;

class MasterUserMain extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('mst_user_main');
    }

    public $user_profile_id = 'user_profile_id';
    public $front_degree = 'front_degree';
    public $behind_degree = 'behind_degree';

    
    function getFront_degree() {
        return $this->front_degree;
    }

    function setFront_degree($front_degree) {
        $this->front_degree = $front_degree;
    }

    
    function getBehind_degree() {
        return $this->behind_degree;
    }

    function setBehind_degree($behind_degree) {
        $this->behind_degree = $behind_degree;
    }

        function getUser_profile_id() {
        return $this->user_profile_id;
    }

    function setUser_profile_id($user_profile_id) {
        $this->user_profile_id = $user_profile_id;
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
