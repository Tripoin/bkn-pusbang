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
class MasterVideoSeminar  {
    //put your code here
    private $filename = 'video_seminar';
    private $entity = 'mst_video_seminar';
    private $id = 'video_seminar_id';
    private $code = 'video_seminar_code';
    private $title = 'video_seminar_title';
    private $message = 'video_seminar_message';
    private $to = 'video_seminar_to';
    private $from = 'video_seminar_from';
    private $date = 'video_seminar_date';
    private $read = 'video_seminar_read';
    private $urlVideo = 'video_seminar_url_video';
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

    function getUrlVideo() {
        return $this->urlVideo;
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

    function setUrlVideo($urlVideo) {
        $this->urlVideo = $urlVideo;
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
