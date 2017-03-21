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
//use app\Model\Auditrail;
class Notification  {
    //put your code here
    private $filename = 'notification';
    private $entity = 'mst_notification';
    private $id = 'notification_id';
    private $code = 'notification_code';
    private $title = 'notification_title';
    private $message = 'notification_message';
    private $to = 'notification_to';
    private $from = 'notification_from';
    private $date = 'notification_date';
    private $read = 'notification_read';
    private $status = 'status';
    
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

    function getTitle() {
        return $this->title;
    }

    function getMessage() {
        return $this->message;
    }

    function getTo() {
        return $this->to;
    }

    function getFrom() {
        return $this->from;
    }

    function getDate() {
        return $this->date;
    }

    function getRead() {
        return $this->read;
    }

    function getStatus() {
        return $this->status;
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

    function setTitle($title) {
        $this->title = $title;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function setTo($to) {
        $this->to = $to;
    }

    function setFrom($from) {
        $this->from = $from;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setRead($read) {
        $this->read = $read;
    }

    function setStatus($status) {
        $this->status = $status;
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
