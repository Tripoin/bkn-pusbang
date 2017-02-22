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

namespace app\Controller\Documentation;

use app\Controller\Base\Controller;
use app\Model\MasterDocumentation;
use app\Constant\IURLConstant;
use app\Constant\IViewConstant;

//use app\Util\Form;

class Documentation extends Controller {

    //put your code here

    public function __construct() {
        $this->modelData = new MasterDocumentation();
        $this->setTitle(lang('master.documentation'));
        $this->setBreadCrumb(array(lang('master.master') => "", lang('master.documentation') => URL()));
        $this->search_filter = array("code" => lang('general.code'), "name" => lang('general.name'));
        $this->indexUrl = IURLConstant::DOCUMENTATION_INDEX_URL;
        $this->unsetAutoData = array('description');
//        $this->issetAutoData = array('documentation_image_url'=>lang('general.documentation_image_url'));
        $this->autoData = true;
        $this->setAutoCrud();


        parent::__construct();
    }

    public function edit() {
        $this->getData($_POST['id']);
        $this->setChangevalueNewEdit(array(
            $this->modelData->getDocumentation_image_url() => Form()->value($this->get_data['documentation_image_url'])->id('documentation_image_url')->title('Image Url')->getInputMedia(),
        ));
        parent::edit();
    }

    public function create() {
        $this->setChangevalueNewEdit(array(
            $this->modelData->getDocumentation_image_url() => Form()->id('documentation_image_url')->title('Image Url')->getInputMedia(),
        ));
        parent::create();
    }

}
