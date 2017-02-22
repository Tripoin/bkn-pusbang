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
use app\Model\GeneralAuditrail;

class MasterMaterialSubject extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('mst_material_subject');
    }
    
    public $isMaterial = 'is_material';
    public $authorName = 'author_name';
    public $copyrightDate = 'copyright_date';
    public $duration = 'duration';
    public $unitId = 'unit_id';
    function getIsMaterial() {
        return $this->isMaterial;
    }

    function getAuthorName() {
        return $this->authorName;
    }

    function getCopyrightDate() {
        return $this->copyrightDate;
    }

    function getDuration() {
        return $this->duration;
    }

    function getUnitId() {
        return $this->unitId;
    }

    function setIsMaterial($isMaterial) {
        $this->isMaterial = $isMaterial;
    }

    function setAuthorName($authorName) {
        $this->authorName = $authorName;
    }

    function setCopyrightDate($copyrightDate) {
        $this->copyrightDate = $copyrightDate;
    }

    function setDuration($duration) {
        $this->duration = $duration;
    }

    function setUnitId($unitId) {
        $this->unitId = $unitId;
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
