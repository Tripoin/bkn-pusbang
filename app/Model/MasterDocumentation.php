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

class MasterDocumentation extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('mst_documentation');
    }
    
    private $activity_id = 'activity_id';
    private $documentation_image_url = 'documentation_image_url';
    
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

    function getActivity_id() {
        return $this->activity_id;
    }

    function setActivity_id($activity_id) {
        $this->activity_id = $activity_id;
    }

    function getDocumentation_image_url() {
        return $this->documentation_image_url;
    }

    function setDocumentation_image_url($documentation_image_url) {
        $this->documentation_image_url = $documentation_image_url;
    }





}
