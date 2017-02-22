<?php
/**
 * Description of MasterPost
 *
 * @author sfandrianah
 */
namespace app\Model;

class SecurityLanguage {

    private $filename = 'language';
    private $entity = 'security_language';
    private $id = 'language_id';
    private $code = 'language_code';
    private $name = 'language_name';
    
    function getFilename() {
        return $this->filename;
    }

    function getEntity() {
        return $this->entity;
    }

    function getId() {
        return $this->id;
    }

    function getCode() {
        return $this->code;
    }

    function getName() {
        return $this->name;
    }

    function setFilename($filename) {
        $this->filename = $filename;
    }

    function setEntity($entity) {
        $this->entity = $entity;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function setName($name) {
        $this->name = $name;
    }


}
