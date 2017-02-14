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
use app\Constant\IRestCommandConstant;
use app\Util\RestClient\TripoinRestClient;

class Subject extends ControllerRestUI {

    //put your code here
    public $data_facility = array();

    public function __construct() {
        $this->restURL = IRestURLConstant::MASTER . SLASH . IRestURLConstant::SUBJECT;
        $this->setTitle(lang('master.subject'));
        $this->setBreadCrumb(array(lang('master.master') => "", lang('master.subject') => FULLURL()));
        $this->search_filter = array("code" => lang('general.code'), "name" => lang('general.name'));
        $this->indexUrl = IURLConstant::MASTER_SUBJECT_INDEX_URL;
        $this->viewPath = IViewConstant::MASTER_SUBJECT_VIEW_INDEX;
        $this->setAutoCrud();
        parent::__construct();
//        print_r($this->result);
    }
    
    public function index() {
//        $this->listWithParameter(true);
        parent::index();
    }
    public function listData() {
        /*
        $this->param_body = array(
            "filter_key" => 'code',
            "filter_value" => $_POST['code'],
        );
         * 
         */
        parent::listData();
    }

    public function create() {
        $this->data_facility = getRestLov(IRestURLConstant::MASTER . SLASH . IRestURLConstant::FACILITY);
        parent::create();
    }

    public function edit() {
        $this->data_facility = getRestLov(IRestURLConstant::MASTER . SLASH . IRestURLConstant::FACILITY);
        parent::edit();
    }

}
