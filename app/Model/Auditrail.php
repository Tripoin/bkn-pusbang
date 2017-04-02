<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Model;

/**
 * Description of Auditrail
 *
 * @author sfandrianah
 */
abstract class Auditrail {
    //put your code here
    protected $status = 'status';
    protected $createdByUsername = 'created_by';
    protected $createdById = 'created_by_id';
    protected $createdByIp = 'created_by_ip';
    protected $createdOn = 'created_on';
    protected $modifiedByUsername = 'modified_by';
    protected $modifiedById = 'modified_by_id';
    protected $modifiedByIp = 'modified_by_ip';
    protected $modifiedOn = 'modified_on';
    protected $description = 'description';
    
    function getDescription() {
        return $this->description;
    }

    function setDescription($description) {
        $this->description = $description;
    }

        
    function getStatus() {
        return $this->status;
    }

    function getCreatedByUsername() {
        return $this->createdByUsername;
    }

    function getCreatedById() {
        return $this->createdById;
    }

    function getCreatedOn() {
        return $this->createdOn;
    }
    
    function getCreatedByIp() {
        return $this->createdByIp;
    }

    function getModifiedByIp() {
        return $this->modifiedByIp;
    }

    function setCreatedByIp($createdByIp) {
        $this->createdByIp = $createdByIp;
    }

    function setModifiedByIp($modifiedByIp) {
        $this->modifiedByIp = $modifiedByIp;
    }

    
    function getModifiedByUsername() {
        return $this->modifiedByUsername;
    }

    function getModifiedById() {
        return $this->modifiedById;
    }

    function getModifiedOn() {
        return $this->modifiedOn;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setCreatedByUsername($createdByUsername) {
        $this->createdByUsername = $createdByUsername;
    }

    function setCreatedById($createdById) {
        $this->createdById = $createdById;
    }

    function setCreatedOn($createdOn) {
        $this->createdOn = $createdOn;
    }

    function setModifiedByUsername($modifiedByUsername) {
        $this->modifiedByUsername = $modifiedByUsername;
    }

    function setModifiedById($modifiedById) {
        $this->modifiedById = $modifiedById;
    }

    function setModifiedOn($modifiedOn) {
        $this->modifiedOn = $modifiedOn;
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
    
    public function toArray() {
        $vars = get_object_vars ( $this );
        $array = array ();
        foreach ( $vars as $key => $value ) {
            $array [ltrim ( $key, '_' )] = $value;
        }
        return $array;
    }

}
