<?php
/**
 * Description of MasterPost
 *
 * @author sfandrianah
 */
namespace app\Model;

class SecurityFunctionLanguage {

    private $filename = 'function_language';
    private $entity = 'sec_function_language';
    private $functionId = 'function_id';
    private $code = 'code';
    private $name = 'name';
    private $languageId = 'language_id';
    private $id = 'id';
    
    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

        
    function getCode() {
        return $this->code;
    }

    function setCode($code) {
        $this->code = $code;
    }

        
    function getFunctionId() {
        return $this->functionId;
    }

    function getLanguageId() {
        return $this->languageId;
    }

    function setFunctionId($functionId) {
        $this->functionId = $functionId;
    }

    function setLanguageId($languageId) {
        $this->languageId = $languageId;
    }

        function getFilename() {
        return $this->filename;
    }

    function getEntity() {
        return $this->entity;
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
    function setName($name) {
        $this->name = $name;
    }




}
