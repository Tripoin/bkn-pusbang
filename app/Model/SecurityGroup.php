<?php

namespace app\Model;

use app\Model\Auditrail;

class SecurityGroup extends Auditrail {

    private $filename = 'group';
    private $entity = 'sec_group';
    private $id = 'id';
    private $code = 'code';
    private $name = 'name';

//    private $firstMenu = 'first_menu';

    public function __construct() {
        
    }

    public function GroupEntity() {
        return $this->entity;
    }

    function getFilename() {
        return $this->filename;
    }

    function setFilename($filename) {
        $this->filename = $filename;
    }

    function getEntity() {
        return $this->entity;
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

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }
    
    public function search($key) {
        return $this->$key;
//        parent::search($key);
    }
    
    function setData($data) {
        $array_data = array();
        foreach ($data as $key => $value) {
            $array_data[$this->$key] = $value;
        }
        return $array_data;
    }

}
