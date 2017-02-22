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
use app\Model\MasterSubject;
use app\Model\MasterCurriculum;
use app\Util\DataTable;

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
        $dataTable = new DataTable();
        $masterSubject = new MasterSubject();
        $masterCurriculum = new MasterCurriculum();
        $result = $dataTable->select_pagination($masterCurriculum,$masterCurriculum->getEntity(),$masterCurriculum->getSubjectId().EQUAL.ONE);
        parent::listData();
    }

    public function listCurriculum($subjectId) {
        $Datatable = new DataTable();
        $masterSubject = new MasterSubject();
        $masterCurriculum = new MasterCurriculum();

        if ($_POST['per_page'] == "") {
            $Datatable->per_page = 5;
        } else {
            $Datatable->per_page = $_POST['per_page'];
        }

//        }
        $Datatable->urlDeleteCollection($this->urlDeleteCollection);
        $Datatable->searchFilter($this->search_filter);
        $Datatable->current_page = $_POST['current_page'];
        if ($_POST['current_page'] == '') {
            $Datatable->current_page = 1;
        }
        $search = $_POST['search_pagination'];
        if ($_POST['search_by'] == '') {
            $search = " AND " . $masterCurriculum->getEntity() . ".code LIKE  '%" . $search . "%'";
        } else if ($_POST['search_by'] == 'null') {
            $search = " AND " . $masterCurriculum->getEntity() . ".code LIKE  '%" . $search . "%'";
        } else {
            $search = " AND " . $masterCurriculum->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search . "%'";
        }
        $list_data = $Datatable->select_pagination($masterCurriculum,$masterCurriculum->getEntity(),
            $masterCurriculum->getSubjectId().EQUAL.$subjectId.$search);

        include_once FILE_PATH(IViewConstant::MASTER_SUBJECT_VIEW_INDEX . '/curriculum/list.html.php');

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
