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

class LinkRegistration {

    //put your code here
    public function __construct() {
    }

    public $entity = 'link_registration';
    public $registrationId = 'registration_id';
    public $attachmentParticipantId = 'attachment_participant_id';
    public $attachmentLetterId = 'attachment_letter_id';
    public $subjectId = 'activity_id';
    public $registrationDetailsId = 'registration_details_id';

    function getEntity() {
        return $this->entity;
    }

    function getRegistrationId() {
        return $this->registrationId;
    }

    function getAttachmentParticipantId() {
        return $this->attachmentParticipantId;
    }

    function getAttachmentLetterId() {
        return $this->attachmentLetterId;
    }

    function getSubjectId() {
        return $this->subjectId;
    }

    function getRegistrationDetailsId() {
        return $this->registrationDetailsId;
    }

    function setEntity($entity) {
        $this->entity = $entity;
    }

    function setRegistrationId($registrationId) {
        $this->registrationId = $registrationId;
    }

    function setAttachmentParticipantId($attachmentParticipantId) {
        $this->attachmentParticipantId = $attachmentParticipantId;
    }

    function setAttachmentLetterId($attachmentLetterId) {
        $this->attachmentLetterId = $attachmentLetterId;
    }

    function setSubjectId($subjectId) {
        $this->subjectId = $subjectId;
    }

    function setRegistrationDetailsId($registrationDetailsId) {
        $this->registrationDetailsId = $registrationDetailsId;
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
