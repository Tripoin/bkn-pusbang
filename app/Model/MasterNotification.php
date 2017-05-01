<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Model;

/**
 * Description of MasterNotification
 *
 * @author sfandrianah
 */
use app\Model\GeneralAuditrail;

class MasterNotification extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('mst_notification');
    }

    protected $title = 'notification_title';
    protected $message = 'notification_message';
    protected $to = 'to_user_profile_id';
    protected $from = 'from_user_profile_id';
    protected $date = 'notification_date';
    protected $read = 'notification_read';

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

    public function search($key) {
        if(isset($this->$key)){
            return $this->$key;
        } else {
            return "";
        }
        
    }

    function setData($data) {
        $array_data = array();
        foreach ($data as $key => $value) {
            $array_data[$this->$key] = $value;
        }
        return $array_data;
    }

}
