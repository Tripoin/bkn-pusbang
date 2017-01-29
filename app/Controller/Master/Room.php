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
use App\Util\RestClient\TripoinRestClient;

class Room extends ControllerRestUI{
    //put your code here
    public $data_facility=array();
    public function __construct() {
        $this->restURL = IRestURLConstant::MASTER.SLASH.IRestURLConstant::ROOM;
        $this->setTitle(lang('master.room'));
        $this->setBreadCrumb(array(lang('master.master') => "", lang('master.room') => FULLURL()));
        $this->search_filter = array("code" => lang('general.code'), "name" => lang('general.name'));
        $this->indexUrl = IURLConstant::MASTER_ROOM_INDEX_URL;
        $this->viewPath = IViewConstant::MASTER_ROOM_VIEW_INDEX;
        $this->setAutoCrud();
    }
    
    public function create() {
        $tripoinRestClient = new TripoinRestClient();
        $url = $this->url_api . IRestURLConstant::MASTER.SLASH.IRestURLConstant::FACILITY . SLASH . IRestCommandConstant::COMMAND_STRING . EQUAL . IRestCommandConstant::SELECT_LOV;
        $result = $tripoinRestClient->doGET($url, array());
        $this->data_facility = json_decode($result->getBody);
        parent::create();
    }
    public function edit() {
        $tripoinRestClient = new TripoinRestClient();
        $url = $this->url_api . IRestURLConstant::MASTER.SLASH.IRestURLConstant::FACILITY . SLASH . IRestCommandConstant::COMMAND_STRING . EQUAL . IRestCommandConstant::SELECT_LOV;
        $result = $tripoinRestClient->doGET($url, array());
        $this->data_facility = json_decode($result->getBody);
        parent::edit();
    }
}
