<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Model;

/**
 * Description of MasterFunctionType
 *
 * @author sfandrianah
 */
use app\Model\GeneralAuditrail;

class MasterSlider extends GeneralAuditrail {
    //put your code here
    public function __construct() {
        $this->setFilename('slider');
        $this->setEntity('mst_slider');
    }
    
    private $title = 'title';
    private $subtitle = 'subtitle';
    private $img = 'img';
    private $link = 'link';
    private $textButton = 'text_button';
    
    
    function getTextButton() {
        return $this->textButton;
    }

    function setTextButton($textButton) {
        $this->textButton = $textButton;
    }

        function getTitle() {
        return $this->title;
    }

    function getSubtitle() {
        return $this->subtitle;
    }

    function getImg() {
        return $this->img;
    }

    function getLink() {
        return $this->link;
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

    function setLink($link) {
        $this->link = $link;
    }


}

