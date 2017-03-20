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
use app\Model\MasterSlider;
use app\Constant\IURLConstant;
use app\Constant\IViewConstant;
use app\Util\DatabaseReport;

//use app\Util\Form;

class Slider extends Controller {

    //put your code here

    public function __construct() {
        $this->modelData = new MasterSlider();
        $this->setTitle(lang('master.slider'));
        $this->setBreadCrumb(array(lang('master.master') => "", lang('master.slider') => URL()));
        $this->search_filter = array("code" => lang('general.code'), "name" => lang('general.name'));
        $this->indexUrl = IURLConstant::MASTER_SLIDER_INDEX_URL;
        $this->unsetAutoData = array('description');
        $this->autoData = true;
        $this->setAutoCrud();


        parent::__construct();
    }
    public function listData() {
        /*
         $dbReport = new DatabaseReport();
         
        $dbReport->connect();
        $dbReport->insert($this->modelData->getEntity(), array(
            $this->modelData->getCode()=>  createRandomBooking(),
        ));
        $rs = $dbReport->getResult();
         * 
         */
//        print_r($dbReport->getResult());
//        $report = $dbReport->selectByID($this->modelData);
//        print_r($report);
        parent::listData();
    }

    public function edit() {
        $this->getData($_POST['id']);
        $this->setChangevalueNewEdit(array(
            $this->modelData->getImg() => Form()->value($this->get_data['img'])->id('img')->title('Image Url')->getInputMedia(),
        ));
        parent::edit();
    }

    public function create() {
        $this->setChangevalueNewEdit(array(
            $this->modelData->getImg() => Form()->id('img')->title('Image Url')->getInputMedia(),
        ));
        parent::create();
    }

}
