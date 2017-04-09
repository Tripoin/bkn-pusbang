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
use app\Model\MasterMaterialSubject;
use app\Model\MasterUnit;
use app\Model\MasterUserAssignment;
use app\Model\MasterUserMain;
use app\Util\Button;
use app\Util\Database;
use app\Util\Form;
use app\Util\RestClient\TripoinRestClient;
use app\Model\MasterSubject;
use app\Model\MasterCurriculum;
use app\Util\DataTable;

class Subject extends ControllerRestUI {

    //put your code here
    public $budget_types= array();
    public $subject_requirements= array();
    public $subject_parents= array();

    public function __construct() {
//        modalHide();
        $this->admin_theme_url = getAdminTheme();
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

    public function createSubject($subjectId,$materialSubjectId){
        $Form = new Form();
        $db = new Database();
        $db->connect();
        $masterCurriculum = new MasterCurriculum();


        $db->insert($masterCurriculum->getEntity(), array(
            $masterCurriculum->getCode() => $_GET['code'],
            $masterCurriculum->getName() => $_GET['name'],
            $masterCurriculum->getSubjectId()=>$subjectId,
            $masterCurriculum->getMaterialSubjectId()=>$materialSubjectId

        ));
        $result = $db->getResult();
        if (is_numeric($result[0])) {
            echo toastAlert('success', 'Add Panitia Success', 'Data Has been Added Successfully');
        } else {
            echo toastAlert('error', 'Add Panitia Error', 'Data Has been Added Failed');
        }
//        print_r($db->getResult());
        echo '<script>$(function(){$(\'#myModal_self\').modal(\'hide\');postAjaxPagination();});</script>';
    }

    public function getMaterialSubjectBySubjectIdAndMaterialSubjectId($subjectId,$MaterialSubjectId){
        $db = new Database();
        $db->connect();
        $submitedCurriculum =  $db->selectByID($masterCurriculum,$masterCurriculum->getMaterialSubjectId(). "='" . $materialSubjectId.
            " AND'. $masterCurriculum->getSubjectId(). '='. $subjectId .");
    return $submitedCurriculum;
    }

    public function subjectList($subjectId){
        $Form = new Form();
        $Datatable = new DataTable();
        $Button = new Button();
        $db = new Database();
//       $group = new SecurityGroup();
        $data = new MasterMaterialSubject();

        $Datatable->per_page = 5;



//        }
        $Datatable->urlDeleteCollection($this->urlDeleteCollection);
        $Datatable->searchFilter(array(
                "code" => lang('general.code'),
                "name" => lang('general.name'))
        );



//        echo $Datatable->search;


        $list_data = $Datatable->select_pagination($data, $data->getEntity(),'');

//        echo modalHide();

        include_once FILE_PATH(IViewConstant::MASTER_SUBJECT_VIEW_INDEX . '/curriculum/new.html.php');
    }

    public function curriculums($subjectId) {
//        $Datatable = new DataTable();
//        $db = new Database();
//        $db->connect();
//        $curriculums=array();
//        $masterCurriculum =new MasterCurriculum();
//
//        $curriculums = $db->selectByID($masterCurriculum,$masterCurriculum->getSubjectId(). "='" . $subjectId. "'");
//
//
//        if ($_POST['per_page'] == "") {
//            $Datatable->per_page = 5;
//        } else {
//            $Datatable->per_page = $_POST['per_page'];
//        }
//        $Datatable->urlDeleteCollection($this->urlDeleteCollection);
//        $Datatable->searchFilter($this->search_filter);
//        $Datatable->current_page = $_POST['current_page'];
//        if ($_POST['current_page'] == '') {
//            $Datatable->current_page = 1;
//        }
//        $search = $_POST['search_pagination'];
//        if ($_POST['search_by'] == '') {
//            $search = " AND " . $masterCurriculum->getEntity() . ".code LIKE  '%" . $search . "%'";
//        } else if ($_POST['search_by'] == 'null') {
//            $search = " AND " . $masterCurriculum->getEntity() . ".code LIKE  '%" . $search . "%'";
//        } else {
//            $search = " AND " . $masterCurriculum->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search . "%'";
//        }
//
//        $list_data = $Datatable->select_pagination($masterCurriculum,$masterCurriculum->getEntity(),
//            $masterCurriculum->getSubjectId().EQUAL.$subjectId.$search AND );
        $Form = new Form();
        $Datatable = new DataTable();
        $Button = new Button();
        $db = new Database();
//        $group = new SecurityGroup();
        $data = new MasterCurriculum();
        $masterMaterialSubject = new MasterMaterialSubject();
        $masterUnit = new MasterUnit();
        if ($_POST['per_page'] == "") {
            $Datatable->per_page = 5;
        } else {
            $Datatable->per_page = $_POST['per_page'];
        }

//        }
        $Datatable->urlDeleteCollection($this->urlDeleteCollection);
        $Datatable->searchFilter(array(
                "code" => lang('general.code'),
                "name" => lang('general.name'),
            )
        );
//        $Datatable->se
        $Datatable->current_page = $_POST['current_page'];
        if ($_POST['current_page'] == '') {
            $Datatable->current_page = 1;
        }
//        echo $_POST['search_by'];
        $search = $_POST['search_pagination'];
        if ($_POST['search_by'] == '') {

        } else if ($_POST['search_by'] == 'null') {

        } else {
            $sr = $masterMaterialSubject->search($_POST['search_by']);
            if (!empty($sr)) {
                $search = " AND " . $data->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search . "%'";
            }
        }

//        echo $Datatable->search;
        $joins = array($masterMaterialSubject->getEntity(), $masterUnit->getEntity());
        $whereList = $data->getEntity() . DOT . $data->getMaterialSubjectId() . EQUAL . $masterMaterialSubject->getEntity() . DOT . $masterMaterialSubject->getId()
            . " AND " . $data->getEntity() . DOT . $data->getSubjectId() . EQUAL . $subjectId
            . " AND " .$masterUnit->getEntity() . DOT . $masterUnit->getId() . EQUAL .  $masterMaterialSubject->getEntity() . DOT . $masterMaterialSubject->getUnitId()
            . $search;

        $list_data = $Datatable->select_pagination($data, $data->getEntity(), $whereList, $joins, $masterMaterialSubject->getEntity(), null, ""
            . $masterMaterialSubject->getEntity() . "." . $masterMaterialSubject->getId() . " as id,"
            . $masterMaterialSubject->getEntity() . "." . $masterMaterialSubject->getCode() . " as code,"
            . $masterMaterialSubject->getEntity() . "." . $masterMaterialSubject->getName() . " as name,"
            . $masterMaterialSubject->getEntity() . "." . $masterMaterialSubject->getDuration() . " as duration,"
            . $masterUnit->getEntity() . "."  . $masterUnit->getName() . " as unitName"
          ,  $masterMaterialSubject->getEntity() . "." . $masterMaterialSubject->getId());

        include_once FILE_PATH(IViewConstant::MASTER_SUBJECT_VIEW_INDEX . '/curriculum/list.html.php');

    }
    public function create() {
        $this->getSubjectRequirements();
        $this->getBudgetTypes();
        $this->getSubjectParents();
        parent::create();
    }

    public function edit() {
        $this->getSubjectRequirements();
        $this->getBudgetTypes();
        $this->getSubjectParents();
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

    public function getSubjectParents(){
        $db = new Database();
        $db->connect();
        $masterSubject = new MasterSubject();


        $this->subject_parents = $db->selectByID($masterSubject,$masterSubject->getIsChild(). "='" . '0'. "'");

    }

    public function save(){
        $db = new Database();
        $db->connect();
        $masterSubject = new MasterSubject();
        $dataType = $_POST['data_type'];
        $subjectCode = $_POST['subject_code'];
        $subjectName = $_POST['subject_name'];
        $subjectParents = $_POST['subject_parents'];
        $budgetTypeId =  null;
        $budgetAmount =  null;
        $location = null;
        $subjectDescription = null;
        $isChild = 0;
        if(strcasecmp($dataType, 'child') == 0){

            $budgetAmount =  $_POST['budget_amount'];
            $location = $_POST['location'];
            $budgetTypeId =  $_POST['budget_type_id'];
            $subjectDescription = $_POST['subject_description'];
            $isChild            = 1;
        }
        $db->insert($masterSubject->getEntity(), array(
            $masterSubject->getCode() => $subjectCode,
            $masterSubject->getName() => $subjectName,
            $masterSubject->getParentId()=>$subjectParents,
            $masterSubject->getBudgetTypeId() => $budgetTypeId,
            $masterSubject->getSubjectAmount() =>  $budgetAmount,
            $masterSubject->getLocation() => $location,
            $masterSubject->getDescription() => $subjectDescription,
            $masterSubject->getIsChild()    => $isChild
        ));
        $rs = $db->getResult();
        if (is_numeric($rs[0])) {
            echo toastAlert("success", lang('general.title_insert_success'), lang('general.message_insert_success'));
            echo '<script>$(function(){postAjaxPagination()});</script>';
        } else {
            echo toastAlert("error", lang('general.title_insert_error'), lang('general.message_insert_error'));
            echo resultPageMsg('danger', lang('general.title_insert_error'), $rs[0]);
        }


    }



}
