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
use app\Model\MasterCity;
use app\Constant\IURLConstant;
use app\Constant\IViewConstant;

class City extends Controller{

    //put your code here

    public function __construct() {
        $this->modelData = new MasterCity();
        $this->setTitle('City');
        $this->setBreadCrumb(array(lang('security.security') => "", lang('security.security') => URL()));
        $this->search_filter = array("code" => lang('general.code'), "name" => lang('general.name'));
        $this->indexUrl = IURLConstant::MASTER_CITY_INDEX_URL;
        $this->unsetAutoData = array('description');
        $this->autoData = true;
        $this->setAutoCrud();
        parent::__construct();
    }

}
