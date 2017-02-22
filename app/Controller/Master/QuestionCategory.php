<?php
/**
 * Created by PhpStorm.
 * User: Dayat
 * Date: 07/02/2017
 * Time: 0:57
 */

namespace app\Controller\Master;


use app\Constant\IRestURLConstant;
use app\Constant\IURLConstant;
use app\Controller\Base\ControllerRestUI;

class QuestionCategory extends ControllerRestUI
{
    public function __construct(){
        $this->restURL = IRestURLConstant::MASTER . SLASH . IRestURLConstant::QUESTION_CATEGORY;
        $this->orderBy = array('name' => "asc");
        $this->setTitle(lang('master.question_category'));
        $this->setBreadCrumb(array(lang('master.master') => "", lang('master.question_category') => FULLURL()));
        $this->search_filter = array("code" => lang('general.code'), "name" => lang('general.name'));
        $this->indexUrl = IURLConstant::MASTER_QUESTION_CATEGORY_INDEX_URL;
        $this->setAutoCrud();
        $this->autoData = true;
        parent::__construct();
    }

    public function listData() {
        //$this->unsetAutoData = array('description');
        parent::listData();
    }
}