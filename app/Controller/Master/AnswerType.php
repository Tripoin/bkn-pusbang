<?php
/**
 * Created by PhpStorm.
 * User: Dayat
 * Date: 07/02/2017
 * Time: 1:49
 */

namespace app\Controller\Master;


use app\Constant\IRestURLConstant;
use app\Constant\IURLConstant;
use app\Constant\IViewConstant;
use app\Controller\Base\ControllerRestUI;

class AnswerType extends ControllerRestUI
{
    public $data_parent = array();

    public function __construct(){
        $this->restURL = IRestURLConstant::MASTER . SLASH . IRestURLConstant::ANSWER_TYPE;
        $this->setTitle(lang('master.answer_type'));
        $this->setBreadCrumb(array(lang('master.master') => "", lang('master.answer_type') => FULLURL()));
        $this->search_filter = array("code" => lang('general.code'), "name" => lang('general.name'));
        $this->indexUrl = IURLConstant::MASTER_ANSWER_TYPE_INDEX_URL;
        $this->viewPath = IViewConstant::MASTER_ANSWER_TYPE_VIEW_INDEX;
        $this->setAutoCrud();
        parent::__construct();
    }

    public function create(){
        $this->data_parent = getRestLov(IRestURLConstant::MASTER . SLASH . IRestURLConstant::ANSWER_CATEGORY);
        parent::create();
    }

    public function edit(){
        $this->data_parent = getRestLov(IRestURLConstant::MASTER . SLASH . IRestURLConstant::ANSWER_CATEGORY);
        parent::edit();
    }

}