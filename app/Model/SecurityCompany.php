<?php

namespace app\Model;

use app\Model\GeneralAuditrail;

class SecurityCompany extends GeneralAuditrail {

    public $addressId = 'address_id';
    public $contactId = 'contact_id';

    public function __construct() {
        $this->setEntity('sec_company');
    }

    function getAddressId() {
        return $this->addressId;
    }

    function setAddressId($addressId) {
        $this->addressId = $addressId;
    }
        
    function getContactId() {
        return $this->contactId;
    }

    function setContactId($contactId) {
        $this->contactId = $contactId;
    }

    public function search($key) {
//        parent::search($key);
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
