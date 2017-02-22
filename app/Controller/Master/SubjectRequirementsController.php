<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SECURITY -> GROUP
 * @email : sfandrianah2@gmail.com
 * @author Syahrial Fandrianah
 * @FRAMEWORK NATIVE ADMIN TEMPLATE V.1.0
 */

namespace app\Controller\Master;

use app\Controller\Base\Controller;
use app\Model\MasterSubjectRequirements;
use app\Constant\IURLConstant;
use app\Constant\IViewConstant;

class SubjectRequirementsController extends Controller{

    //put your code here

    public function __construct() {
        $this->modelData = new MasterSubjectRequirements();
        $this->setTitle(lang('master.subject_requirements'));
        $this->setBreadCrumb(array(lang('master.master') => "", lang('master.subject_requirements') => URL()));
        $this->search_filter = array("code" => lang('general.code'), "name" => lang('general.name'));
        $this->indexUrl = IURLConstant::MASTER_SUBJECT_REQUIREMENTS_INDEX_URL;
        $this->unsetAutoData = array('description');
        $this->autoData = true;
        $this->setAutoCrud();
        parent::__construct();
    }

}
