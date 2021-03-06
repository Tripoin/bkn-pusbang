<?php

namespace app\Model;

use app\Model\GeneralAuditrail;
use app\Model\SecurityUser;

class SecurityUserProfile extends GeneralAuditrail {

//    private $filename = 'user_profile';
//    private $entity = 'security_user_profile';


    public $fullname = 'fullname';
    public $birthdate = 'dob';
    public $place = 'pob';
    public $email = 'email';
    public $group = 'group_id';
    public $userId = 'user_id';
    public $gender = 'gender';
    public $religi = 'religion';
    public $religionId = 'religion_id';
    public $address = 'address';
    public $addressId = 'address_id';
    public $marriage = 'marrital_status';
    public $telp = 'telp';
    public $contactId = 'contact_id';
    public $pathimage = 'profile_image';
    public $province = 'province_id';
    public $city = 'city_id';
    public $district = 'district_id';
    public $village = 'village_id';

    public function __construct() {
        $this->setEntity('sec_user_profile');
    }

    function getAddressId() {
        return $this->addressId;
    }

    function setAddressId($addressId) {
        $this->addressId = $addressId;
    }

    function getReligionId() {
        return $this->religionId;
    }

    function setReligionId($religionId) {
        $this->religionId = $religionId;
    }

    function getContactId() {
        return $this->contactId;
    }

    function setContactId($contactId) {
        $this->contactId = $contactId;
    }

    function getUserId() {
        return $this->userId;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    public function getUser() {
        return new SecurityUser();
    }

    function getFullname() {
        return $this->fullname;
    }

    function getBirthdate() {
        return $this->birthdate;
    }

    function getPlace() {
        return $this->place;
    }

    function getEmail() {
        return $this->email;
    }

    function getGroup() {
        return $this->group;
    }

    function getGender() {
        return $this->gender;
    }

    function getReligi() {
        return $this->religi;
    }

    function getAddress() {
        return $this->address;
    }

    function getMarriage() {
        return $this->marriage;
    }

    function getTelp() {
        return $this->telp;
    }

    function getPathimage() {
        return $this->pathimage;
    }

    function getProvince() {
        return $this->province;
    }

    function getCity() {
        return $this->city;
    }

    function getDistrict() {
        return $this->district;
    }

    function getVillage() {
        return $this->village;
    }

    function setFullname($fullname) {
        $this->fullname = $fullname;
    }

    function setBirthdate($birthdate) {
        $this->birthdate = $birthdate;
    }

    function setPlace($place) {
        $this->place = $place;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setGroup($group) {
        $this->group = $group;
    }

    function setGender($gender) {
        $this->gender = $gender;
    }

    function setReligi($religi) {
        $this->religi = $religi;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setMarriage($marriage) {
        $this->marriage = $marriage;
    }

    function setTelp($telp) {
        $this->telp = $telp;
    }

    function setPathimage($pathimage) {
        $this->pathimage = $pathimage;
    }

    function setProvince($province) {
        $this->province = $province;
    }

    function setCity($city) {
        $this->city = $city;
    }

    function setDistrict($district) {
        $this->district = $district;
    }

    function setVillage($village) {
        $this->village = $village;
    }

    public function search($key) {
//        parent::search($key);
        if (isset($this->$key)) {
            return $this->$key;
        } else {
            return "";
        }
    }

    function setData($data) {
        $array_data = array();
//        unset($_POST['fullname'])
        foreach ($data as $key => $value) {
            $array_data[$this->$key] = $value;
        }
        return $array_data;
    }

}
