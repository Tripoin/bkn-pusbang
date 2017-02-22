<?php

/**
 * Description of MasterPost
 *
 * @author sfandrianah
 */

namespace app\Model;

use app\Model\Auditrail;
use app\Model\SecurityFunction;
use app\Model\MasterPost;

class MasterPostFunction {

    private $filename = 'master-post-function';
    private $entity = 'link_post_function';
    private $postId = 'post_id';
    private $post = 'id';
    private $functionId = 'function_id';
    private $function = 'id';

    function getPostId() {
        return $this->postId;
    }

    function getFunctionId() {
        return $this->functionId;
    }

    function setPostId($postId) {
        $this->postId = $postId;
    }

    function setFunctionId($functionId) {
        $this->functionId = $functionId;
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

    function getFunction() {
        return new SecurityFunction();
//        return $this->function;
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

    function setFunction($function) {
        $this->function = $function;
    }

}
