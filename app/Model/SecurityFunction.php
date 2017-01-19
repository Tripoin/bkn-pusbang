<?php

namespace app\Model;

use app\Model\Auditrail;

class SecurityFunction extends Auditrail {

    private $filename = 'sec-function';
    private $entity = 'sec_function';
    private $id = 'id';
    private $code = 'code';
    private $name = 'name';
    private $url = 'url';
    private $order = 'function_order';
    private $level = 'level';
    private $parent = 'parent_id';
    private $actionParameter = 'action_parameter_id';
    private $typeUrl = 'url_type_id';
    private $style = 'style';
    private $typeId = 'function_type_id';

    public function __construct() {
        /*foreach ($this as $key => $value) {
            if ($value != $this->entity) {
                $this->$key = $this->entity . DOT . $value;
            }
        }*/
    }

    function getTypeUrl() {
        return $this->typeUrl;
    }

    function setTypeUrl($typeUrl) {
        $this->typeUrl = $typeUrl;
    }

    public function setParent(Array $properties = array()) {
        foreach ($properties as $key => $value) {
            $this->{$key} = $value;
        }
    }

    function getParent() {
        return $this->parent;
    }

    public function SecurityFunction() {
        
    }

    function getEntity() {
        return $this->entity;
    }

    function setEntity($entity) {
        $this->entity = $entity;
    }

    function getFilename() {
        return $this->filename;
    }

    function setFilename($filename) {
        $this->filename = $filename;
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getActionParameter() {
        return $this->actionParameter;
    }

    function setActionParameter($actionParameter) {
        $this->actionParameter = $actionParameter;
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

    function getUrl() {
        return $this->url;
    }

    function getOrder() {
        return $this->order;
    }

    function getLevel() {
        return $this->level;
    }

    function setUrl($url) {
        $this->url = $url;
    }

    function setOrder($order) {
        $this->order = $order;
    }

    function setLevel($level) {
        $this->level = $level;
    }

    function getStyle() {
        return $this->style;
    }

    function setStyle($style) {
        $this->style = $style;
    }

    function getType() {
//        return $this->type;
    }

    function getTypeId() {
        return $this->typeId;
    }

    function setTypeId($typeId) {
        $this->typeId = $typeId;
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
