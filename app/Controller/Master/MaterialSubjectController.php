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
use app\Model\MasterMaterialSubject;
use app\Constant\IURLConstant;
use app\Constant\IViewConstant;
use app\Model\MasterUnit;

class MaterialSubjectController extends Controller {

    //put your code here
    public $data_tipe_material = array();
    public $data_unit = array();

    public function __construct() {
        $this->modelData = new MasterMaterialSubject();
        $this->setTitle(lang('master.material_subject'));
        $this->setBreadCrumb(array(lang('master.master') => "", lang('master.material_subject') => FULLURL()));
        $this->search_filter = array("code" => lang('general.code'), "name" => lang('general.name'));
        $this->indexUrl = IURLConstant::MASTER_MATERIAL_SUBJECT_INDEX_URL;
        $this->viewPath = IViewConstant::MASTER_MATERIAL_SUBJECT_VIEW_INDEX;
        $this->setAutoCrud();
        parent::__construct();
    }
    
    public function save() {
        if(!isset($_POST['isMaterial'])){
            $_POST['isMaterial'] = 0;
        }
        parent::save();
    }
    
    public function update() {
        if(!isset($_POST['isMaterial'])){
            $_POST['isMaterial'] = 0;
        }
        parent::update();
    }

    public function create() {
        $masterUnit = new MasterUnit();

        $this->data_tipe_material = array(
            array("id" => "1", "label" => lang('general.non_material'))
        );
        $this->data_unit = getLov($masterUnit);
        parent::create();
    }
    
    public function edit() {
        $masterUnit = new MasterUnit();

        $this->data_tipe_material = array(
            array("id" => "1", "label" => lang('general.non_material'))
        );
        $this->data_unit = getLov($masterUnit);
        parent::edit();
    }

}
