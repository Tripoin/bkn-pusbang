<?php

//include './class/Master.php';

namespace app\Model;

use app\Model\SecurityFunction;
use app\Model\SecurityGroup;
use app\Model\Auditrail;

class SecurityFunctionAssignment extends Auditrail {

    private $filename = 'function_assignment';
    private $entity = 'sec_function_assignment';
    private $id = 'id';
    private $code = 'code';
    private $functionId = 'function_id';
//    $function = new SecurityFunction();
    private $functionAssignmentOrder = 'assignment_order';
    private $groupId = 'group_id';
//    private $group = 'group_id';
    private $actionType = 'action_type';

    public function __construct() {
        /*foreach ($this as $key => $value) {
            if ($value != $this->entity) {
                $this->$key = $this->entity . DOT . $value;
            }
        }*/
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

    function setFunctionId($functionId) {
        $this->functionId = $functionId;
    }

    public function getGroup() {
        return new SecurityGroup();
    }

    public function SecurityFunctionAssignment() {
        return $this->entity;
    }

    function getFunction() {
        return new SecurityFunction();
//        return $this->function;
    }

    function setFunction($function) {
        $this->function = $function;
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

    function getGroupId() {
        return $this->groupId;
    }

    function setGroupId($groupId) {
        $this->groupId = $groupId;
    }

    function getActionType() {
        return $this->actionType;
    }

    function setActionType($actionType) {
        $this->actionType = $actionType;
    }

    function getEntity() {
        return $this->entity;
    }

    function setEntity($entity) {
        $this->entity = $entity;
    }

    function getFunctionAssignmentOrder() {
        return $this->functionAssignmentOrder;
    }

    function setFunctionAssignmentOrder($functionAssignmentOrder) {
        $this->functionAssignmentOrder = $functionAssignmentOrder;
    }

}
