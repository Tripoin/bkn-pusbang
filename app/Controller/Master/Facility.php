<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controller\Master;

/**
 * Description of Room
 *
 * @author sfandrianah
 */
use app\Controller\Base\ControllerRestUI;
use app\Constant\IURLConstant;
use app\Constant\IViewConstant;
use app\Constant\IRestURLConstant;

class Facility extends ControllerRestUI {

    //put your code here
    public function __construct() {
//        echo $_SESSION[SESSION_ADMIN_AUTHORIZATION];
        $this->restURL = IRestURLConstant::MASTER . SLASH . IRestURLConstant::FACILITY;
//        print_r(IRestURLConstant::MASTER);
        $this->orderBy = array('name' => "asc");
        $this->setTitle(lang('master.facility'));
        $this->setBreadCrumb(array(lang('master.master') => "", lang('master.facility') => FULLURL()));
        $this->search_filter = array("code" => lang('general.code'), "name" => lang('general.name'));
        $this->indexUrl = IURLConstant::MASTER_FACILITY_INDEX_URL;
        $this->viewPath = IViewConstant::MASTER_FACILITY_VIEW_INDEX;
        $this->setAutoCrud();
        parent::__construct();
    }

}
