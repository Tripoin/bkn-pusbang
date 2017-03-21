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

class MasterWorkingUnit extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('mst_working_unit');
    }

    public $government_agency_id = 'government_agencies_id';
    public $address_id = 'address_id';
    public $contact_id = 'contact_id';
    function getGovernment_agency_id() {
        return $this->government_agency_id;
    }

    function getAddress_id() {
        return $this->address_id;
    }

    function getContact_id() {
        return $this->contact_id;
    }

    function setGovernment_agency_id($government_agency_id) {
        $this->government_agency_id = $government_agency_id;
    }

    function setAddress_id($address_id) {
        $this->address_id = $address_id;
    }

    function setContact_id($contact_id) {
        $this->contact_id = $contact_id;
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
