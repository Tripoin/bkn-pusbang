<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Model;

use app\Model\Auditrail;

/**
 * Description of MemberPost
 *
 * @author sfandrianah
 */
class MemberPost extends Auditrail {

    //put your code here

    private $filename = 'member-post';
    private $entity = 'mst_member_post';
    private $id = 'member_post_id';
    private $date = 'member_post_date';
    private $code = 'member_post_code';
    private $name = 'member_post_name';
    private $title = 'member_post_title';
    private $subtitle = 'member_post_subtitle';
    private $content = 'member_post_content';
    private $img = 'member_post_img';
    private $type = 'member_post_type';
//    private $createdByUsername = 'created_by_username';

    function getFilename() {
        return $this->filename;
    }

    function getEntity() {
        return $this->entity;
    }

    function getId() {
        return $this->id;
    }

    function getDate() {
        return $this->date;
    }

    function getCode() {
        return $this->code;
    }

    function getName() {
        return $this->name;
    }
    
    public function search($key) {
        return $this->$key;
    }

    

    function getSubtitle() {
        return $this->subtitle;
    }

    function getTitle() {
        return $this->title;
    }

    function getImg() {
        return $this->img;
    }

    function getType() {
        return $this->type;
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

    function setDate($date) {
        $this->date = $date;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setSubtitle($subtitle) {
        $this->subtitle = $subtitle;
    }


    function setImg($img) {
        $this->img = $img;
    }

    function setType($type) {
        $this->type = $type;
    }
    function getContent() {
        return $this->content;
    }

    function setContent($content) {
        $this->content = $content;
    }




}
