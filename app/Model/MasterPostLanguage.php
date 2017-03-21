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
use app\Model\MasterPost;

class MasterPostLanguage {

    //put your code here
    private $filename = 'master-post-language';
    private $entity = 'mst_post_language';
    private $postId = 'post_id';
    private $code = 'code';
    private $name = 'name';
    private $title = 'post_title';
    private $subtitle = 'post_subtitle';
    private $content = 'post_content';
    private $languageId = 'language_id';
    private $language = 'language';

    function getPostId() {
        return $this->postId;
    }

    function setPostId($postId) {
        $this->postId = $postId;
    }

    function getCode() {
        return $this->code;
    }
    
    function getName() {
        return $this->name;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function setName($name) {
        $this->name = $name;
    }

    function getLanguageId() {
        return $this->languageId;
    }

    function setLanguageId($languageId) {
        $this->languageId = $languageId;
    }

    function getTitle() {
        return $this->title;
    }

    function getSubtitle() {
        return $this->subtitle;
    }

    function getContent() {
        return $this->content;
    }

    function getLanguage() {
        return $this->language;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setSubtitle($subtitle) {
        $this->subtitle = $subtitle;
    }

    function setContent($content) {
        $this->content = $content;
    }

    function setLanguage($language) {
        $this->language = $language;
    }

    function getFilename() {
        return $this->filename;
    }

    function getEntity() {
        return $this->entity;
    }

    function getPost() {
        return new MasterPost();
//        return $this->post;
    }

    function setFilename($filename) {
        $this->filename = $filename;
    }

    function setEntity($entity) {
        $this->entity = $entity;
    }

    function setPost($post) {
        $this->post = $post;
    }

}
