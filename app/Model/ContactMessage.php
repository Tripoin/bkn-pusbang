<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Model;

/**
 * Description of ContactMessage
 *
 * @author sfandrianah
 */
use app\Model\Auditrail;
class ContactMessage extends Auditrail{
    //put your code here
    private $filename = 'contactMessage';
    private $entity = 'mst_contact_message';
    private $id = 'contact_message_id';
    private $code = 'contact_message_code';
    private $guestName = 'contact_message_guest_name';
    private $guestMail = 'contact_message_guest_email';
    private $subject = 'contact_message_subject';
    private $content = 'contact_message_content';
    
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

    function getGuestName() {
        return $this->guestName;
    }

    function getGuestMail() {
        return $this->guestMail;
    }

    function getSubject() {
        return $this->subject;
    }

    function getContent() {
        return $this->content;
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

    function setGuestName($guestName) {
        $this->guestName = $guestName;
    }

    function setGuestMail($guestMail) {
        $this->guestMail = $guestMail;
    }

    function setSubject($subject) {
        $this->subject = $subject;
    }

    function setContent($content) {
        $this->content = $content;
    }


    
}
