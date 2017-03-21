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

class MasterWaitingList extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('mst_waiting_list');
    }
    
    public $userMainId = 'user_main_id';
    public $activityId = 'activity_id';
    public $isApproved = 'is_approved';
    public $approvedMessage = 'approved_message';
    public $approvedBy = 'approved_by';
    public $approvedOn = 'approved_on';
    
    function getUserMainId() {
        return $this->userMainId;
    }

    function getActivityId() {
        return $this->activityId;
    }

    function getIsApproved() {
        return $this->isApproved;
    }

    function getApprovedMessage() {
        return $this->approvedMessage;
    }

    function getApprovedBy() {
        return $this->approvedBy;
    }

    function getApprovedOn() {
        return $this->approvedOn;
    }

    function setUserMainId($userMainId) {
        $this->userMainId = $userMainId;
    }

    function setActivityId($activityId) {
        $this->activityId = $activityId;
    }

    function setIsApproved($isApproved) {
        $this->isApproved = $isApproved;
    }

    function setApprovedMessage($approvedMessage) {
        $this->approvedMessage = $approvedMessage;
    }

    function setApprovedBy($approvedBy) {
        $this->approvedBy = $approvedBy;
    }

    function setApprovedOn($approvedOn) {
        $this->approvedOn = $approvedOn;
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
