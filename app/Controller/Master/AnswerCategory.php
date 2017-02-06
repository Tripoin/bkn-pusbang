<?php
/**
 * Created by PhpStorm.
 * User: Dayat
 * Date: 01/02/2017
 * Time: 19:46
 */

namespace app\Controller\Master;


use app\Constant\IRestURLConstant;
use app\Constant\IURLConstant;
use app\Constant\IViewConstant;
use app\Controller\Base\ControllerRestUI;
use app\Constant\IRestCommandConstant;
use App\Util\RestClient\TripoinRestClient;

class AnswerCategory extends ControllerRestUI
{

    public function __construct(){
        $this->restURL = IRestURLConstant::MASTER . SLASH. IRestURLConstant::ANSWER_CATEGORY;
        $this->setTitle(lang('master.answer_category'));
        $this->setBreadCrumb(array(lang('master.master') => "", lang('master.answer_category') => FULLURL()));
        $this->search_filter = array("code" => lang('general.code'), "name" => lang('general.name'));
        $this->indexUrl = IURLConstant::MASTER_ANSWER_CATEGORY_INDEX_URL;
        $this->setAutoCrud();
        $this->autoData = true;
        parent::__construct();
    }

    public function listData() {
        $this->unsetAutoData = array('description');
        parent::listData();
    }
}