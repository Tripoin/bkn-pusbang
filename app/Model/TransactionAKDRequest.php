<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Model;

/**
 * Description of TransactionAKDRequest
 *
 * @author sfandrianah
 */
use app\Model\GeneralAuditrail;

class TransactionAKDRequest extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('trx_akd_request');
    }

    protected $requestCode = 'request_code';
    protected $email = 'email';
    protected $isActived = 'is_actived';
    protected $expiredDate = 'expired_date';
    protected $participantName = 'participant_name';
    protected $agencyName = 'agency_name';
    protected $occupationName = 'occupation_name';
    protected $idNumber = 'id_number';
    protected $noidTypeId = 'noid_type_id';
    protected $questionnaireId = 'questionnaire_id';

    public function getQuestionnaireId() {
        return $this->questionnaireId;
    }

    public function setQuestionnaireId($questionnaireId) {
        $this->questionnaireId = $questionnaireId;
    }

    function getIdNumber() {
        return $this->idNumber;
    }

    function getNoidTypeId() {
        return $this->noidTypeId;
    }

    function setIdNumber($idNumber) {
        $this->idNumber = $idNumber;
    }

    function setNoidTypeId($noidTypeId) {
        $this->noidTypeId = $noidTypeId;
    }

    function getParticipantName() {
        return $this->participantName;
    }

    function getAgencyName() {
        return $this->agencyName;
    }

    function getOccupationName() {
        return $this->occupationName;
    }

    function setParticipantName($participantName) {
        $this->participantName = $participantName;
    }

    function setAgencyName($agencyName) {
        $this->agencyName = $agencyName;
    }

    function setOccupationName($occupationName) {
        $this->occupationName = $occupationName;
    }

    function getExpiredDate() {
        return $this->expiredDate;
    }

    function setExpiredDate($expiredDate) {
        $this->expiredDate = $expiredDate;
    }

    function getRequestCode() {
        return $this->requestCode;
    }

    function getEmail() {
        return $this->email;
    }

    function getIsActived() {
        return $this->isActived;
    }

    function setRequestCode($requestCode) {
        $this->requestCode = $requestCode;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setIsActived($isActived) {
        $this->isActived = $isActived;
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
