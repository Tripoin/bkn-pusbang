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
    public $zipCode = 'zip_code';
    public $participantTypeId = 'participant_type_id';
    public $governmentAgencies = 'government_agencies_name';
    public $workingUnitName = 'working_unit_name';
    public $workingUnitId = 'working_unit_id';
    public $wuPhoneNumber = 'wu_phone_number';
    public $wuFax = 'wu_fax';
    public $wuAddress = 'wu_address';
    public $wuVillageId = 'wu_village_id';
    public $wuDistrictId = 'wu_district_id';
    public $wuCityId = 'wu_city_id';
    public $wuProvinceId = 'wu_province_id';
    public $wuZipCode = 'wu_zip_code';
    public $messageTitle = 'message_title';
    public $messageContent = 'message_content';
    public $userId = 'user_id';
    public $isApproved = 'is_approved';
    public $approvedBy = 'approved_by';
    public $approvedOn = 'approved_on';
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
    function getApprovedBy() {
        return $this->approvedBy;
    }

    function getApprovedOn() {
        return $this->approvedOn;
    }

    function setApprovedBy($approvedBy) {
        $this->approvedBy = $approvedBy;
    }

    function setApprovedOn($approvedOn) {
        $this->approvedOn = $approvedOn;
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
    function getWorkingUnitName() {
        return $this->workingUnitName;
    }

    function setWorkingUnitName($workingUnitName) {
        $this->workingUnitName = $workingUnitName;
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

    function getZipCode()
    {
        return $this->zipCode;
    }

    function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    function setParticipantTypeId($participantTypeId) {
        $this->participantTypeId = $participantTypeId;
    }

    function getGovernmentAgencies()
    {
        return $this->governmentAgencies;
    }

    function setGovernmentAgencies($governmentAgencies)
    {
        $this->governmentAgencies = $governmentAgencies;
    }

    function getWuPhoneNumber()
    {
        return $this->wuPhoneNumber;
    }

    function setWuPhoneNumber($wuPhoneNumber)
    {
        $this->wuPhoneNumber = $wuPhoneNumber;
    }

    function getWuFax()
    {
        return $this->wuFax;
    }

    function setWuFax($wuFax)
    {
        $this->wuFax = $wuFax;
    }

    function getWuAddress()
    {
        return $this->wuAddress;
    }

    function setWuAddress($wuAddress)
    {
        $this->wuAddress = $wuAddress;
    }

    function getWuVillageId()
    {
        return $this->wuVillageId;
    }

    function setWuVillageId($wuVillageId)
    {
        $this->wuVillageId = $wuVillageId;
    }

    function getWuDistrictId()
    {
        return $this->wuDistrictId;
    }

    function setWuDistrictId($wuDistrictId)
    {
        $this->wuDistrictId = $wuDistrictId;
    }

    function getWuCityId()
    {
        return $this->wuCityId;
    }

    function setWuCityId($wuCityId)
    {
        $this->wuCityId = $wuCityId;
    }

    function getWuProvinceId()
    {
        return $this->wuProvinceId;
    }

    function setWuProvinceId($wuProvinceId)
    {
        $this->wuProvinceId = $wuProvinceId;
    }

    function getWuZipCode()
    {
        return $this->wuZipCode;
    }

    function setWuZipCode($wuZipCode)
    {
        $this->wuZipCode = $wuZipCode;
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
