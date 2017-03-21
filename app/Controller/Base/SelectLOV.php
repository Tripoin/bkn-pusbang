<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controller\Base;

/**
 * Description of SelectLOV
 *
 * @author sfandrianah
 */

use app\Model\MasterCollege;
use app\Model\MasterStudyProgram;
use app\Controller\Base\ControllerLOV;

class SelectLOV extends ControllerLOV {

    public function __construct() {
        $this->setDataLOV(array(
            'college' => new MasterCollege(),
            'study_program' => new MasterStudyProgram()
        ));
    }

    //put your code here
}
