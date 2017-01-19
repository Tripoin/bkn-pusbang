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

namespace app\Controller\Security;

use app\Controller\Base\Controller;
use app\Model\SecurityGroup;
use app\Constant\IURLConstant;
use app\Constant\IViewConstant;

class Group extends Controller {

    //put your code here

    public function __construct() {


        $this->modelData = new SecurityGroup();
        $this->setTitle(lang('security.group'));
        $this->setBreadCrumb(array(lang('security.security') => "", lang('security.security') => URL()));
        $this->search_filter = array("code" => lang('general.code'), "name" => lang('general.name'));
        $this->indexUrl = IURLConstant::GROUP_INDEX_URL;
        $this->viewPath = IViewConstant::GROUP_VIEW_INDEX;
        $this->setAutoCrud();
    }

}
