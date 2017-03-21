<?php
/**
 * Description of MasterPost
 *
 * @author sfandrianah
 */
namespace app\Model;
use app\Model\Auditrail;
use app\Model\SecurityFunction;
class MasterPost extends Auditrail {

    private $filename = 'master-post';
    private $entity = 'mst_post';
    private $id = 'id';
    private $code = 'code';
    private $title = 'post_title';
    private $subtitle = 'post_subtitle';
    private $content = 'post_content';
    private $thumbnail = 'post_url_thumbnail';
    private $img = 'post_url_image';
    private $function = 'function_id';
    private $publishOn = 'publish_on';
    private $postStatus = 'post_status';
    private $postFeatured = 'post_featured';
    private $authorId = 'author_id';
    private $authorCode = 'author_code';
    private $authorName = 'author_name';
    private $readCount = 'read_count';
    private $commentEnable = 'post_comment_enable';
    private $language = 'language';
    private $noImg = 'is_image';
    
    function getAuthorId() {
        return $this->authorId;
    }

    function setAuthorId($authorId) {
        $this->authorId = $authorId;
    }

        
    function getNoImg() {
        return $this->noImg;
    }

    function setNoImg($noImg) {
        $this->noImg = $noImg;
    }

    
    function getAuthorCode() {
        return $this->authorCode;
    }

    function getAuthorName() {
        return $this->authorName;
    }

    function getReadCount() {
        return $this->readCount;
    }

    function getCommentEnable() {
        return $this->commentEnable;
    }

    function getLanguage() {
        return $this->language;
    }

    function setAuthorCode($authorCode) {
        $this->authorCode = $authorCode;
    }

    function setAuthorName($authorName) {
        $this->authorName = $authorName;
    }

    function setReadCount($readCount) {
        $this->readCount = $readCount;
    }

    function setCommentEnable($commentEnable) {
        $this->commentEnable = $commentEnable;
    }

    function setLanguage($language) {
        $this->language = $language;
    }

        function getPostFeatured() {
        return $this->postFeatured;
    }

    function setPostFeatured($postFeatured) {
        $this->postFeatured = $postFeatured;
    }

        function getPostStatus() {
        return $this->postStatus;
    }

    function setPostStatus($postStatus) {
        $this->postStatus = $postStatus;
    }

        
    function getPublishOn() {
        return $this->publishOn;
    }

    function setPublishOn($publishOn) {
        $this->publishOn = $publishOn;
    }

        function getThumbnail() {
        return $this->thumbnail;
    }
    function getSubtitle() {
        return $this->subtitle;
    }

    function setSubtitle($subtitle) {
        $this->subtitle = $subtitle;
    }

    
    function getImg() {
        return $this->img;
    }

    function setThumbnail($thumbnail) {
        $this->thumbnail = $thumbnail;
    }

    function setImg($img) {
        $this->img = $img;
    }

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

    function setTitle($title) {
        $this->title = $title;
    }

    function setContent($content) {
        $this->content = $content;
    }
    function getFunction() {
        return new SecurityFunction();
//        return $this->function;
    }

    function setFunction($function) {
        $this->function = $function;
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
