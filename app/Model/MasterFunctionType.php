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

class MasterFunctionType extends GeneralAuditrail {
    //put your code here
    public function __construct() {
        $this->setFilename('function-type');
        $this->setEntity('mst_function_type');
    }
}
