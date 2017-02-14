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

class MasterCurriculum extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('mst_curriculum');
    }

    public $subjectId = 'subject_id';
    public $materialSubjectId = 'material_subject_id';
    
    function getSubjectId() {
        return $this->subjectId;
    }

    function getMaterialSubjectId() {
        return $this->materialSubjectId;
    }

    function setSubjectId($subjectId) {
        $this->subjectId = $subjectId;
    }

    function setMaterialSubjectId($materialSubjectId) {
        $this->materialSubjectId = $materialSubjectId;
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
