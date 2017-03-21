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

class MasterContact extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('mst_contact');
    }
    
    protected $email1 = 'email_1';
    protected $email2 = 'email_2';
    protected $phoneNumber1 = 'phone_number_1';
    protected $phoneNumber2 = 'phone_number_2';
    protected $fax = 'fax';
    
    function getEmail1() {
        return $this->email1;
    }

    function getEmail2() {
        return $this->email2;
    }

    function getPhoneNumber1() {
        return $this->phoneNumber1;
    }

    function getPhoneNumber2() {
        return $this->phoneNumber2;
    }

    function getFax() {
        return $this->fax;
    }

    function setEmail1($email1) {
        $this->email1 = $email1;
    }

    function setEmail2($email2) {
        $this->email2 = $email2;
    }

    function setPhoneNumber1($phoneNumber1) {
        $this->phoneNumber1 = $phoneNumber1;
    }

    function setPhoneNumber2($phoneNumber2) {
        $this->phoneNumber2 = $phoneNumber2;
    }

    function setFax($fax) {
        $this->fax = $fax;
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
