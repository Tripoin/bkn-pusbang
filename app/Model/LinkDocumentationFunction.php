<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Model;

/**
 * Description of LinkDocumentationFunction
 *
 * @author sfandrianah
 */
class LinkDocumentationFunction {

    //put your code here
    public function __construct() {
        
    }

    protected $entity = 'link_documentation_function';
    protected $documentationId = 'documentation_id';
    protected $functionId = 'function_id';
    
    function getEntity() {
        return $this->entity;
    }

    function getDocumentationId() {
        return $this->documentationId;
    }

    function getFunctionId() {
        return $this->functionId;
    }

    function setEntity($entity) {
        $this->entity = $entity;
    }

    function setDocumentationId($documentationId) {
        $this->documentationId = $documentationId;
    }

    function setFunctionId($functionId) {
        $this->functionId = $functionId;
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
