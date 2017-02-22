<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Model;

/**
 * Description of GeneralAuditrail
 *
 * @author sfandrianah
 */
use app\Model\Auditrail;

class GeneralAuditrail extends Auditrail {

    //put your code here
    protected $filename = 'default';
    protected $entity = 'default';
    protected $id = 'id';
    protected $code = 'code';
    protected $name = 'name';
    

    public function __construct() {
        
    }

    
    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

        function getFilename() {
        return $this->filename;
    }

    function getEntity() {
        return $this->entity;
    }

    function setFilename($filename) {
        $this->filename = $filename;
    }

    function setEntity($entity) {
        $this->entity = $entity;
    }

    function getCode() {
        return $this->code;
    }

    function getName() {
        return $this->name;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function setName($name) {
        $this->name = $name;
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
