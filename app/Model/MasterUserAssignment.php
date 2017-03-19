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

class MasterUserAssignment extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('mst_user_assignment');
    }

    public $user_main_id = 'user_main_id';
    public $activity_id = 'activity_id';
    public $role_id = 'role_id';
    public $is_passed_activity = 'is_passed_activity';
    public $assignment_letter_id = 'assignment_letter_id';
    public $certificate_id = 'certificate_id';

    public function getAssignmentLetterId() {
        return $this->assignment_letter_id;
    }

    public function setAssignmentLetterId($assignment_letter_id) {
        $this->assignment_letter_id = $assignment_letter_id;
    }

    public function getCertificateId() {
        return $this->certificate_id;
    }

    public function setCertificateId($certificate_id) {
        $this->certificate_id = $certificate_id;
    }

    public function getIsPassedActivity() {
        return $this->is_passed_activity;
    }

    public function setIsPassedActivity($is_passed_activity) {
        $this->is_passed_activity = $is_passed_activity;
    }

    public function getRoleId() {
        return $this->role_id;
    }

    public function setRoleId($role_id) {
        $this->role_id = $role_id;
    }

    function getActivity_id() {
        return $this->activity_id;
    }

    function setActivity_id($activity_id) {
        $this->activity_id = $activity_id;
    }

    function getUser_main_id() {
        return $this->user_main_id;
    }

    function setUser_main_id($user_main_id) {
        $this->user_main_id = $user_main_id;
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
