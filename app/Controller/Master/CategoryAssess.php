<?php
/**
 * Created by PhpStorm.
 * User: Dayat
 * Date: 02/02/2017
 * Time: 0:20
 */

namespace app\Controller\Master;


use app\Constant\IRestURLConstant;
use app\Constant\IURLConstant;
use app\Constant\IViewConstant;
use app\Controller\Base\ControllerRestUI;

class CategoryAssess extends ControllerRestUI
{
    public $data_parent = array();

    public function __construct(){
        $this->restURL = IRestURLConstant::MASTER . SLASH . IRestURLConstant::CATEGORY_ASSESS;
        $this->setTitle(lang('master.category_assess'));
        $this->setBreadCrumb(array(lang('master.master') => "", lang('master.category_assess') => FULLURL()));
        $this->search_filter = array("code" => lang('general.code'), "name" => lang('general.name'));
        $this->indexUrl = IURLConstant::MASTER_CATEGORY_ASSESS_INDEX_URL;
        $this->viewPath = IViewConstant::MASTER_CATEGORY_ASSESS_VIEW_INDEX;
        $this->setAutoCrud();
        parent::__construct();
    }

    public function create(){
        $this->data_parent = getRestLov(IRestURLConstant::MASTER . SLASH . IRestURLConstant::CATEGORY_ASSESS);
        parent::create();
    }

    public function edit(){
        $this->data_parent = getRestLov(IRestURLConstant::MASTER . SLASH . IRestURLConstant::CATEGORY_ASSESS);
        parent::edit();
    }

    public function update(){
        if($_POST['parent_id']==""){
            $_POST['parent_id'] = null;
        }
        parent::update();
    }
}