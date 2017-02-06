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

class TransactionRegistration extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('trx_registration');
    }
    
    public $delegationName = 'delegation_name';
    public $delegationEmail = 'delegation_email';
    public $delegationPhoneNumber = 'delegation_phone_number';
    public $delegationFax = 'delegation_fax';
    public $delegationAddress = 'delegation_address';
    public $villageId = 'village_id';
    public $districtId = 'district_id';
    public $cityId = 'city_id';
    public $provinceId = 'province_id';
    public $participantTypeId = 'participant_type_id';
    public $workingUnitId = 'working_unit_id';
    public $messageTitle = 'message_title';
    public $messageContent = 'message_content';
    public $userId = 'user_id';
    public $isApproved = 'is_approved';
    public $approvedMessage = 'approved_message';
    
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

    function getDelegationName() {
        return $this->delegationName;
    }

    function getDelegationEmail() {
        return $this->delegationEmail;
    }

    function getDelegationPhoneNumber() {
        return $this->delegationPhoneNumber;
    }

    function getDelegationFax() {
        return $this->delegationFax;
    }

    function getDelegationAddress() {
        return $this->delegationAddress;
    }

    function getVillageId() {
        return $this->villageId;
    }

    function getDistrictId() {
        return $this->districtId;
    }

    function getCityId() {
        return $this->cityId;
    }

    function getProvinceId() {
        return $this->provinceId;
    }

    function getParticipantTypeId() {
        return $this->participantTypeId;
    }

    function getWorkingUnitId() {
        return $this->workingUnitId;
    }

    function getMessageTitle() {
        return $this->messageTitle;
    }

    function getMessageContent() {
        return $this->messageContent;
    }

    function getUserId() {
        return $this->userId;
    }

    function getIsApproved() {
        return $this->isApproved;
    }

    function getApprovedMessage() {
        return $this->approvedMessage;
    }

    function setDelegationName($delegationName) {
        $this->delegationName = $delegationName;
    }

    function setDelegationEmail($delegationEmail) {
        $this->delegationEmail = $delegationEmail;
    }

    function setDelegationPhoneNumber($delegationPhoneNumber) {
        $this->delegationPhoneNumber = $delegationPhoneNumber;
    }

    function setDelegationFax($delegationFax) {
        $this->delegationFax = $delegationFax;
    }

    function setDelegationAddress($delegationAddress) {
        $this->delegationAddress = $delegationAddress;
    }

    function setVillageId($villageId) {
        $this->villageId = $villageId;
    }

    function setDistrictId($districtId) {
        $this->districtId = $districtId;
    }

    function setCityId($cityId) {
        $this->cityId = $cityId;
    }

    function setProvinceId($provinceId) {
        $this->provinceId = $provinceId;
    }

    function setParticipantTypeId($participantTypeId) {
        $this->participantTypeId = $participantTypeId;
    }

    function setWorkingUnitId($workingUnitId) {
        $this->workingUnitId = $workingUnitId;
    }

    function setMessageTitle($messageTitle) {
        $this->messageTitle = $messageTitle;
    }

    function setMessageContent($messageContent) {
        $this->messageContent = $messageContent;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setIsApproved($isApproved) {
        $this->isApproved = $isApproved;
    }

    function setApprovedMessage($approvedMessage) {
        $this->approvedMessage = $approvedMessage;
    }




}
