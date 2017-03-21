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

class MasterAddress extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('mst_address');
    }

    protected $villageId = 'village_id';
    protected $districtId = 'district_id';
    protected $cityId = 'city_id';
    protected $provinceId = 'province_id';
    protected $zipCode = 'zip_code';
    
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

    function getVillageId() {
        return $this->villageId;
    }

    function getDistrictId() {
        return $this->districtId;
    }

    function getCityId() {
        return $this->cityId;
    }

    function getProvinceId() {
        return $this->provinceId;
    }

    function setVillageId($villageId) {
        $this->villageId = $villageId;
    }

    function setDistrictId($districtId) {
        $this->districtId = $districtId;
    }

    function setCityId($cityId) {
        $this->cityId = $cityId;
    }

    function setProvinceId($provinceId) {
        $this->provinceId = $provinceId;
    }
    function getZipCode() {
        return $this->zipCode;
    }

    function setZipCode($zipCode) {
        $this->zipCode = $zipCode;
    }






}
