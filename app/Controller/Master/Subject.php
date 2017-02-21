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
 * @author fadhilprm
 */
use app\Controller\Base\ControllerRestUI;
use app\Constant\IURLConstant;
use app\Constant\IViewConstant;
use app\Constant\IRestURLConstant;
use app\Constant\IRestCommandConstant;
use app\Util\RestClient\TripoinRestClient;

class Subject extends ControllerRestUI {

    //put your code here
    public $budget_types= array();
    public $subject_requirements= array();
    public function __construct() {
        $this->restURL = IRestURLConstant::MASTER . SLASH . IRestURLConstant::SUBJECT;
        $this->setTitle(lang('master.subject'));
        $this->setBreadCrumb(array(lang('master.master') => "", lang('master.subject') => FULLURL()));
        $this->search_filter = array("code" => lang('general.code'), "name" => lang('general.name'));
        $this->indexUrl = IURLConstant::MASTER_SUBJECT_INDEX_URL;
        $this->viewPath = IViewConstant::MASTER_SUBJECT_VIEW_INDEX;
        $this->setAutoCrud();
        parent::__construct();
    }
    
    public function index() {
        parent::index();
    }
    public function listData() {

        parent::listData();
    }

    public function create() {
        $this->getSubjectRequirements();
        $this->getBudgetTypes();
        parent::create();
    }

    public function edit() {
        $this->getSubjectRequirements();
        $this->getBudgetTypes();
        parent::edit();
    }

    public function getSubjectRequirements(){
        $url = URL_REST . IRestCommandConstant::API . SLASH . IRestCommandConstant::VERSI . SLASH ;
        $tripoinRestClient = new TripoinRestClient();
        $data_sr = $tripoinRestClient->doGET($url.IRestURLConstant::MASTER . SLASH . IRestURLConstant::SUBJECT_REQUIREMENTS.SLASH.IRestCommandConstant::COMMAND_STRING . EQUAL . IRestCommandConstant::SELECT_ALL_DATA,
            array(),
            array());
        $this->subject_requirements = $data_sr->getBody;
    }
    public function getBudgetTypes(){
        $this->budget_types = getRestLov(IRestURLConstant::MASTER . SLASH . IRestURLConstant::BUDGET_TYPE);
    }

}
