<?php

/**
 * Description of MasterPost
 *
 * @author sfandrianah
 */

namespace app\Model;

use app\Model\Auditrail;

//use app\Model\SecurityFunction;
//use app\Model\MasterPost;
class Confirm extends Auditrail {

    private $filename = 'confirm';
    private $entity = 'trx_confirm';
    private $id = 'confirm_id';
    private $code = 'confirm_code';
    private $email = 'confirm_email';
    private $bankTo = 'confirm_bank_to';
    private $bankSender = 'confirm_bank_sender';
    private $noAccount = 'confirm_no_account';
    private $senderName = 'confirm_sender_name';
    private $transferDate = 'confirm_transfer_date';
    private $transferAmount = 'confirm_transfer_amount';
    private $uploadImg = 'confirm_upload_img';
    private $notes = 'confirm_notes';
    private $confirmStatus = 'confirm_status';
    private $confirmType = 'confirm_type';

    function getFilename() {
        return $this->filename;
    }

    function getEntity() {
        return $this->entity;
    }

    function getId() {
        return $this->id;
    }

    function getCode() {
        return $this->code;
    }

    function getEmail() {
        return $this->email;
    }

    function getBankTo() {
        return $this->bankTo;
    }

    function getBankSender() {
        return $this->bankSender;
    }

    function getNoAccount() {
        return $this->noAccount;
    }

    function getSenderName() {
        return $this->senderName;
    }

    function getTransferDate() {
        return $this->transferDate;
    }

    function getTransferAmount() {
        return $this->transferAmount;
    }

    function getUploadImg() {
        return $this->uploadImg;
    }

    function getNotes() {
        return $this->notes;
    }

    function getConfirmStatus() {
        return $this->confirmStatus;
    }

    function getConfirmType() {
        return $this->confirmType;
    }

    function setFilename($filename) {
        $this->filename = $filename;
    }

    function setEntity($entity) {
        $this->entity = $entity;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setBankTo($bankTo) {
        $this->bankTo = $bankTo;
    }

    function setBankSender($bankSender) {
        $this->bankSender = $bankSender;
    }

    function setNoAccount($noAccount) {
        $this->noAccount = $noAccount;
    }

    function setSenderName($senderName) {
        $this->senderName = $senderName;
    }

    function setTransferDate($transferDate) {
        $this->transferDate = $transferDate;
    }

    function setTransferAmount($transferAmount) {
        $this->transferAmount = $transferAmount;
    }

    function setUploadImg($uploadImg) {
        $this->uploadImg = $uploadImg;
    }

    function setNotes($notes) {
        $this->notes = $notes;
    }

    function setConfirmStatus($confirmStatus) {
        $this->confirmStatus = $confirmStatus;
    }

    function setConfirmType($confirmType) {
        $this->confirmType = $confirmType;
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
