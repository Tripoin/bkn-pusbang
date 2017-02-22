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

class MasterDistrict extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('mst_district');
    }
    
    public $city_id = 'city_id';
    
    function getCity_id() {
        return $this->city_id;
    }

    function setCity_id($city_id) {
        $this->city_id = $city_id;
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
