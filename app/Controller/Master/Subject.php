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
use app\Controller\Base\Controller;
use app\Constant\IURLConstant;
use app\Constant\IViewConstant;
use app\Constant\IRestURLConstant;
use app\Constant\IRestCommandConstant;
use app\Model\MasterMaterialSubject;
use app\Model\MasterUnit;
use app\Model\LinkSubjectRequirements;
use app\Model\MasterUserAssignment;
use app\Model\MasterUserMain;
use app\Model\MasterCategoryAssess;
use app\Model\MasterBudgetType;
use app\Model\LinkCurriculumAssess;
use app\Model\LinkTrainerAssess;
use app\Model\LinkSubjectAssess;
use app\Util\Button;
use app\Util\Database;
use app\Util\Form;
use app\Util\RestClient\TripoinRestClient;
use app\Model\MasterSubject;
use app\Model\MasterCurriculum;
use app\Model\MasterSubjectRequirements;
use app\Util\DataTable;

class Subject extends ControllerRestUI {

    //put your code here
    public $budget_types = array();
    public $data_subject = array();
    public $subject_requirements = array();
    public $subject_parents = array();

    public function __construct() {
//        modalHide();
        $this->admin_theme_url = getAdminTheme();
//        $masterSubject = new MasterSubject();
//        $this->modelData = $masterSubject;
        $this->restURL = IRestURLConstant::MASTER . SLASH . IRestURLConstant::SUBJECT;
        $this->setTitle(lang('master.subject'));
        $this->setBreadCrumb(array(lang('master.master') => "", lang('master.subject') => FULLURL()));
        $this->search_filter = array("code" => lang('general.code'), "name" => lang('general.name'));
        $this->indexUrl = IURLConstant::MASTER_SUBJECT_INDEX_URL;
        $this->viewPath = IViewConstant::MASTER_SUBJECT_VIEW_INDEX;
        $this->setAutoCrud();
//        $this->data_subject = valueComboBoxParent($masterSubject->getEntity(), $masterSubject->getId(), $masterSubject->getName(), $masterSubject->getParentId());
//        print_r($this->data_subject);
        parent::__construct();
    }

    public function index() {
        parent::index();
    }

    public function listData() {

        parent::listData();
    }

    public function deleteSubjectList($subjectId) {
        $Form = new Form();
        $db = new Database();
        $db->connect();
        $masterCurriculum = new MasterCurriculum();
        $masterSubject = new MasterSubject();
        $masterMaterialSubject = new MasterMaterialSubject();

        $db->delete($masterCurriculum->getEntity(), $masterCurriculum->getId() . equalToIgnoreCase($_POST['id']));
        $result = $db->getResult();
        if (is_numeric($result[0]) == 1) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function createSubjectList($subjectId) {
        $Form = new Form();
        $db = new Database();
        $db->connect();
        $masterCurriculum = new MasterCurriculum();
        $masterSubject = new MasterSubject();
        $masterMaterialSubject = new MasterMaterialSubject();

//        $data_subject = $db->selectByID($masterSubject, $masterSubject->getId() . equalToIgnoreCase($subjectId));
        $data_material_subject = $db->selectByID($masterMaterialSubject, $masterMaterialSubject->getId() . equalToIgnoreCase($_POST['id']));
        if (isset($_POST['id_edit'])) {
            $db->update($masterCurriculum->getEntity(), array(
                $masterCurriculum->getCode() => createRandomBooking(),
                $masterCurriculum->getName() => $data_material_subject[0][$masterMaterialSubject->getName()],
                $masterCurriculum->getSubjectId() => $subjectId,
                $masterCurriculum->getMaterialSubjectId() => $data_material_subject[0][$masterMaterialSubject->getId()],
                $masterCurriculum->getDescription() => $data_material_subject[0][$masterMaterialSubject->getName()],
                $masterCurriculum->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                $masterCurriculum->getCreatedByUsername() => $_SESSION[SESSION_USERNAME],
                    ), $masterCurriculum->getId() . equalToIgnoreCase($_POST['id_edit'])
                    . " AND " . $masterCurriculum->getSubjectId() . equalToIgnoreCase($subjectId));
            $result = $db->getResult();
            if (is_numeric($result[0]) == 1) {
                echo toastAlert('success', 'Add Curriculum Success', 'Data Has been Added Successfully');
            } else {
                echo toastAlert('error', 'Add Curriculum Error', 'Data Has been Added Failed');
            }
        } else {
            $db->insert($masterCurriculum->getEntity(), array(
                $masterCurriculum->getCode() => createRandomBooking(),
                $masterCurriculum->getName() => $data_material_subject[0][$masterMaterialSubject->getName()],
                $masterCurriculum->getSubjectId() => $subjectId,
                $masterCurriculum->getMaterialSubjectId() => $data_material_subject[0][$masterMaterialSubject->getId()],
                $masterCurriculum->getDescription() => $data_material_subject[0][$masterMaterialSubject->getName()],
                $masterCurriculum->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                $masterCurriculum->getCreatedByUsername() => $_SESSION[SESSION_USERNAME],
            ));
            $result = $db->getResult();
            if (is_numeric($result[0])) {
                echo toastAlert('success', 'Add Curriculum Success', 'Data Has been Added Successfully');
            } else {
                echo toastAlert('error', 'Add Curriculum Error', 'Data Has been Added Failed');
            }
        }
        echo '<script>$(function(){$(\'#myModal_self\').modal(\'hide\');postAjaxPagination();});</script>';
    }

    public function editSubject($subjectId) {
        $Form = new Form();
        $Datatable = new DataTable();
        $Button = new Button();
        $db = new Database();
//       $group = new SecurityGroup();
        $data = new MasterMaterialSubject();

        $Datatable->per_page = 5;
        $Datatable->urlDeleteCollection($this->urlDeleteCollection);
        $Datatable->searchFilter(array(
            "code" => lang('general.code'),
            "name" => lang('general.name'))
        );
        $list_data = $Datatable->select_pagination($data, $data->getEntity(), '');
        include_once FILE_PATH(IViewConstant::MASTER_SUBJECT_VIEW_INDEX . '/curriculum/edit.html.php');
    }

    public function getMaterialSubjectBySubjectIdAndMaterialSubjectId($subjectId, $MaterialSubjectId) {
        $db = new Database();
        $db->connect();
        $submitedCurriculum = $db->selectByID($masterCurriculum, $masterCurriculum->getMaterialSubjectId() . "='" . $materialSubjectId .
                " AND'. $masterCurriculum->getSubjectId(). '='. $subjectId .");
        return $submitedCurriculum;
    }

    public function newEditSubjectList($subjectId) {
        include_once FILE_PATH(IViewConstant::MASTER_SUBJECT_VIEW_INDEX . '/curriculum/pagination-new-edit.html.php');
    }

    public function subjectList($subjectId) {
        $Form = new Form();
        $Datatable = new DataTable();
        $Button = new Button();
        $db = new Database();
//       $group = new SecurityGroup();
        $data = new MasterMaterialSubject();

        if ($_POST['per_page'] == "") {
            $Datatable->per_page = 10;
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
            $sr = $data->search($_POST['search_by']);
            if (!empty($sr)) {
                $search = " AND " . $data->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search . "%'";
            }
        }
        
        $str_query_not_in_data = "";
        if (isset($_POST['material_subject_id'])) {
//            echo 'masuk';
            $str_query_not_in_data =  $data->getEntity() . DOT . $data->getId() . " NOT IN (" . $_POST['material_subject_id'] . ")";
        }

        $list_data = $Datatable->select_pagination($data, $data->getEntity(), $str_query_not_in_data.$search);
        include_once FILE_PATH(IViewConstant::MASTER_SUBJECT_VIEW_INDEX . '/curriculum/new-edit.html.php');
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
        $masterCurriculum = new MasterCurriculum();
        $masterMaterialSubject = new MasterMaterialSubject();
        $masterUnit = new MasterUnit();
        if ($_POST['per_page'] == "") {
            $Datatable->per_page = 10;
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
//        echo 'masuk';
        $joins = array($masterMaterialSubject->getEntity());
        $whereList = $data->getEntity() . DOT . $data->getMaterialSubjectId() . EQUAL . $masterMaterialSubject->getEntity() . DOT . $masterMaterialSubject->getId()
                . " AND " . $data->getEntity() . DOT . $data->getSubjectId() . EQUAL . $subjectId
//                . " AND " . $masterUnit->getEntity() . DOT . $masterUnit->getId() . EQUAL . $masterMaterialSubject->getEntity() . DOT . $masterMaterialSubject->getUnitId()
                . $search;
//        $Datatable->debug(true);
        $list_data = $Datatable->select_pagination($data, $data->getEntity(), $whereList, $joins, $masterMaterialSubject->getEntity(), null, ""
                . $masterMaterialSubject->getEntity() . "." . $masterMaterialSubject->getId() . " as id,"
                . $masterMaterialSubject->getEntity() . "." . $masterMaterialSubject->getCode() . " as code,"
                . $masterMaterialSubject->getEntity() . "." . $masterMaterialSubject->getName() . " as name,"
                . $data->getEntity() . "." . $data->getId() . " as curriculum_id,"
                . $masterMaterialSubject->getEntity() . "." . $masterMaterialSubject->getId() . " as material_subject_id,"
                . $masterMaterialSubject->getEntity() . "." . $masterMaterialSubject->getDuration() . " as duration,"
                . $masterMaterialSubject->getEntity() . "." . $masterMaterialSubject->getUnitId() . " as unit_id"
//                . $masterUnit->getEntity() . "." . $masterUnit->getName() . " as unitName"
                , $masterMaterialSubject->getEntity() . "." . $masterMaterialSubject->getId());
//        print_r($list_data);
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

    public function getSubjectRequirements() {
        /* $url = URL_REST . IRestCommandConstant::API . SLASH . IRestCommandConstant::VERSI . SLASH;
          $tripoinRestClient = new TripoinRestClient();
          $data_sr = $tripoinRestClient->doGET($url . IRestURLConstant::MASTER . SLASH . IRestURLConstant::SUBJECT_REQUIREMENTS . SLASH . IRestCommandConstant::COMMAND_STRING . EQUAL . IRestCommandConstant::SELECT_ALL_DATA, array(), array());
          $this->subject_requirements = $data_sr->getBody;
         * 
         */
        $masterSubjectRequirements = new MasterSubjectRequirements();
        $this->subject_requirements = getLov($masterSubjectRequirements);
    }

    public function getBudgetTypes() {
//        $this->budget_types = getRestLov(IRestURLConstant::MASTER . SLASH . IRestURLConstant::BUDGET_TYPE);
        $masterBudgetType = new MasterBudgetType();
        $this->budget_types = getLov($masterBudgetType);
    }

    public function getSubjectParents() {
        $db = new Database();
        $db->connect();
        $masterSubject = new MasterSubject();


        $this->subject_parents = $db->selectByID($masterSubject, $masterSubject->getIsChild() . "='" . '0' . "'");
    }

    public function save() {
        $db = new Database();
        $db->connect();
        $masterSubject = new MasterSubject();
        $dataType = $_POST['data_type'];
        $subjectCode = $_POST['subject_code'];
        $subjectName = $_POST['subject_name'];
        if ($_POST['subject_parents'] == "") {
            $subjectParents = null;
        } else {
            $subjectParents = $_POST['subject_parents'];
        }
        $budgetTypeId = null;
        $budgetAmount = null;
        $location = null;
        $subjectDescription = null;
        $isChild = 0;
        if (strcasecmp($dataType, 'child') == 0) {
            $budgetAmount = $_POST['budget_amount'];
            $location = $_POST['location'];
            $budgetTypeId = $_POST['budget_type_id'];
            $subjectDescription = $_POST['subject_description'];
            $isChild = 1;
        } else {
//            $isChild = 0;
        }
        $db->insert($masterSubject->getEntity(), array(
            $masterSubject->getCode() => $subjectCode,
            $masterSubject->getName() => $subjectName,
            $masterSubject->getParentId() => $subjectParents,
            $masterSubject->getBudgetTypeId() => $budgetTypeId,
            $masterSubject->getSubjectAmount() => $budgetAmount,
            $masterSubject->getLocation() => $location,
            $masterSubject->getDescription() => $subjectDescription,
            $masterSubject->getIsChild() => $isChild
        ));
        $rs = $db->getResult();
        if (is_numeric($rs[0])) {
            $linkSubjectRequirements = new LinkSubjectRequirements();
            $resultReq = true;
            $rs_link = array();
            $subjectRequirements = $_POST['subject_requirements'];
            foreach ($subjectRequirements as $valueSR) {
                if ($resultReq == true) {
                    $db->insert($linkSubjectRequirements->getEntity(), array(
                        $linkSubjectRequirements->getSubjectId() => $rs[0],
                        $linkSubjectRequirements->getSubjectRequirementsId() => $valueSR,
                    ));
                    $rs_link = $db->getResult();
                    if (!is_numeric($rs_link[0])) {
                        $resultReq = false;
                    }
                }
            }
            if ($resultReq == true) {
                echo toastAlert("success", lang('general.title_insert_success'), lang('general.message_insert_success'));
                echo postAjaxPagination();
            } else {
                echo toastAlert("error", lang('general.title_insert_error'), lang('general.message_insert_error'));
                echo postAjaxPagination();
            }
        } else {
            echo toastAlert("error", lang('general.title_insert_error'), lang('general.message_insert_error'));
            echo resultPageMsg('danger', lang('general.title_insert_error'), $rs[0]);
        }
    }

    public function update() {
//        print_r($_POST['subject_requirements']);
        $db = new Database();
        $db->connect();
        $masterSubject = new MasterSubject();
        $dataType = $_POST['data_type'];
        $subjectCode = $_POST['subject_code'];
        $subjectName = $_POST['subject_name'];
        if ($_POST['subject_parents'] == "") {
            $subjectParents = null;
        } else {
            $subjectParents = $_POST['subject_parents'];
        }
        $budgetTypeId = null;
        $budgetAmount = null;
        $location = null;
        $subjectDescription = null;
        $isChild = 0;
        if (strcasecmp($dataType, 'child') == 0) {
            $budgetAmount = $_POST['budget_amount'];
            $location = $_POST['location'];
            $budgetTypeId = $_POST['budget_type_id'];
            $subjectDescription = $_POST['subject_description'];
            $isChild = 1;
        } else {
//            $isChild = 0;
        }
        $id = $_POST['id'];
        $db->update($masterSubject->getEntity(), array(
            $masterSubject->getCode() => $subjectCode,
            $masterSubject->getName() => $subjectName,
            $masterSubject->getParentId() => $subjectParents,
            $masterSubject->getBudgetTypeId() => $budgetTypeId,
            $masterSubject->getSubjectAmount() => $budgetAmount,
            $masterSubject->getLocation() => $location,
            $masterSubject->getDescription() => $subjectDescription,
            $masterSubject->getIsChild() => $isChild
                ), $masterSubject->getId() . equalToIgnoreCase($id));
        $rs = $db->getResult();
        if (is_numeric($rs[0]) == 1) {
            $linkSubjectRequirements = new LinkSubjectRequirements();
            $resultReq = true;
            $rs_link = array();
            $subjectRequirements = $_POST['subject_requirements'];
            $db->delete($linkSubjectRequirements->getEntity(), $linkSubjectRequirements->getSubjectId() . equalToIgnoreCase($id));
            $rs_delete_sr = $db->getResult();
            foreach ($subjectRequirements as $valueSR) {
                if ($resultReq == true) {
                    /*        $cekSR = $db->selectByID($linkSubjectRequirements, $linkSubjectRequirements->getSubjectId() . equalToIgnoreCase($id)
                      . " AND " . $linkSubjectRequirements->getSubjectRequirementsId() . equalToIgnoreCase($valueSR));
                      if (count($cekSR) == 0) {
                     * 
                     */
                    $db->insert($linkSubjectRequirements->getEntity(), array(
                        $linkSubjectRequirements->getSubjectId() => $id,
                        $linkSubjectRequirements->getSubjectRequirementsId() => $valueSR,
                    ));
                    $rs_link = $db->getResult();
                    if (!is_numeric($rs_link[0])) {
                        $resultReq = false;
                    }
                    /*     } else {
                      $db->update($linkSubjectRequirements->getEntity(), array(
                      $linkSubjectRequirements->getSubjectId() => $id,
                      $linkSubjectRequirements->getSubjectRequirementsId() => $valueSR,
                      ), $linkSubjectRequirements->getSubjectId() . equalToIgnoreCase($id)
                      . " AND " . $linkSubjectRequirements->getSubjectRequirementsId() . equalToIgnoreCase($valueSR));
                      $rs_link = $db->getResult();
                      if (is_numeric($rs_link[0]) != 1) {
                      $resultReq = false;
                      }
                      }
                     * 
                     */
                }
            }
            if ($resultReq == true) {
                echo toastAlert("success", lang('general.title_update_success'), lang('general.message_update_success'));
                echo postAjaxPagination();
            } else {
                echo toastAlert("error", lang('general.title_update_error'), lang('general.message_update_error'));
                echo resultPageMsg('danger', lang('general.title_update_error'), $rs_link[0]);
//                echo postAjaxPagination();
            }
        } else {
            echo toastAlert("error", lang('general.title_update_error'), lang('general.message_update_error'));
            echo resultPageMsg('danger', lang('general.title_update_error'), $rs[0]);
        }
    }

    public function aspekPenilaianPeserta($subjectId) {
        include_once FILE_PATH(IViewConstant::MASTER_SUBJECT_VIEW_INDEX . '/curriculum/aspek-penilaian-peserta/index.html.php');
    }

    public function aspekPenilaianWidyaiswara($subjectId) {
        include_once FILE_PATH(IViewConstant::MASTER_SUBJECT_VIEW_INDEX . '/curriculum/aspek-penilaian-widyaiswara/index.html.php');
    }

    public function saveAspekPenilaianPeserta($subjectId) {
//         print_r($_POST);
        if (empty($_POST['rightBox'])) {
            echo toastAlert("error", lang('general.title_update_success'), lang('general.please_fill_out_field') . " " . lang('general.aspects_to_be_assessed'));
            echo resultPageMsg('danger', lang('general.title_update_success'), lang('general.please_fill_out_field') . " " . lang('general.aspects_to_be_assessed'));
        } else {
            $curriculum_id = $_POST['curriculum_id'];
            $result = true;
            $db = new Database();
            $linkCurriculumAssess = new LinkCurriculumAssess();
            $expRightBox = explode(',', $_POST['rightBox']);
            foreach ($expRightBox as $value) {
                if ($result == true) {
                    $check_data = $db->selectByID($linkCurriculumAssess, $linkCurriculumAssess->getCurriculumId() . equalToIgnoreCase($curriculum_id)
                            . " AND " . $linkCurriculumAssess->getCategoryAssessId() . equalToIgnoreCase($value));
                    if (!empty($check_data)) {
                        $db->delete($linkCurriculumAssess->getEntity(), $linkCurriculumAssess->getCurriculumId() . equalToIgnoreCase($curriculum_id)
                                . " AND " . $linkCurriculumAssess->getCategoryAssessId() . equalToIgnoreCase($value));
                        $resultDelete = $db->getResult();
                        if (is_numeric($resultDelete[0]) != 1) {
                            $result = false;
                        }
                    }
                    if ($result == true) {
                        $db->insert($linkCurriculumAssess->getEntity(), array(
                            $linkCurriculumAssess->getCurriculumId() => $curriculum_id,
                            $linkCurriculumAssess->getCategoryAssessId() => $value,
                                )
                        );
                        $resultUpdate = $db->getResult();
                        if (!is_numeric($resultUpdate[0])) {
                            $result = false;
                        }
                    }
                }
//                print_r($check_data);
            }
            if ($result == true) {
                echo toastAlert("success", lang('general.title_update_success'), lang('general.message_update_success'));
                echo resultPageMsg('success', lang('general.title_update_success'), lang('general.message_update_success'));
            } else {
                echo toastAlert("error", lang('general.title_update_error'), lang('general.message_update_error'));
                echo resultPageMsg('danger', lang('general.title_update_error'), lang('general.message_update_error'));
            }
        }
    }

    public function saveAspekPenilaianWidyaiswara($subjectId) {
//         print_r($_POST);
        if (empty($_POST['rightBox'])) {
            echo toastAlert("error", lang('general.title_update_success'), lang('general.please_fill_out_field') . " " . lang('general.aspects_to_be_assessed'));
            echo resultPageMsg('danger', lang('general.title_update_success'), lang('general.please_fill_out_field') . " " . lang('general.aspects_to_be_assessed'));
        } else {
            $curriculum_id = $_POST['curriculum_id'];
            $result = true;
            $db = new Database();
            $linkTrainerAssess = new LinkTrainerAssess();
            $expRightBox = explode(',', $_POST['rightBox']);
            foreach ($expRightBox as $value) {
                if ($result == true) {
                    $check_data = $db->selectByID($linkTrainerAssess, $linkTrainerAssess->getCurriculumId() . equalToIgnoreCase($curriculum_id)
                            . " AND " . $linkTrainerAssess->getCategoryAssessId() . equalToIgnoreCase($value));
                    if (!empty($check_data)) {
                        $db->delete($linkTrainerAssess->getEntity(), $linkTrainerAssess->getCurriculumId() . equalToIgnoreCase($curriculum_id)
                                . " AND " . $linkTrainerAssess->getCategoryAssessId() . equalToIgnoreCase($value));
                        $resultDelete = $db->getResult();
                        if (is_numeric($resultDelete[0]) != 1) {
                            $result = false;
                        }
                    }
                    if ($result == true) {
                        $db->insert($linkTrainerAssess->getEntity(), array(
                            $linkTrainerAssess->getCurriculumId() => $curriculum_id,
                            $linkTrainerAssess->getCategoryAssessId() => $value,
                                )
                        );
                        $resultUpdate = $db->getResult();
                        if (!is_numeric($resultUpdate[0])) {
                            $result = false;
                        }
                    }
                }
//                print_r($check_data);
            }
            if ($result == true) {
                echo toastAlert("success", lang('general.title_update_success'), lang('general.message_update_success'));
                echo resultPageMsg('success', lang('general.title_update_success'), lang('general.message_update_success'));
            } else {
                echo toastAlert("error", lang('general.title_update_error'), lang('general.message_update_error'));
                echo resultPageMsg('danger', lang('general.title_update_error'), lang('general.message_update_error'));
            }
        }
    }

    public function assessmentPoints($subjectId) {
        $Form = new Form();
        $Datatable = new DataTable();
        $Button = new Button();
        $db = new Database();
//        $group = new SecurityGroup();
//        $data = new LinkSubjectAssess();

        $linkSubjectAssess = new LinkSubjectAssess();
        $masterCategoryAssess = new MasterCategoryAssess();
        if ($_POST['per_page'] == "") {
            $Datatable->per_page = 10;
        } else {
            $Datatable->per_page = $_POST['per_page'];
        }

//        }
        $Datatable->urlDeleteCollection($this->urlDeleteCollection);
        $Datatable->searchFilter(array(
            "name" => lang('master.field_description'),
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
            $sr = $masterCategoryAssess->search($_POST['search_by']);
            if (!empty($sr)) {
                $search = " AND " . $masterCategoryAssess->getEntity() . DOT . $_POST['search_by'] . " LIKE  '%" . $search . "%'";
            }
        }

//        echo $Datatable->search;
//        echo 'masuk';
        $joins = array($masterCategoryAssess->getEntity());
        $whereList = $linkSubjectAssess->getEntity() . DOT . $linkSubjectAssess->getCategoryAssessId() . EQUAL . $masterCategoryAssess->getEntity() . DOT . $masterCategoryAssess->getId()
                . " AND " . $linkSubjectAssess->getEntity() . DOT . $linkSubjectAssess->getSubjectId() . EQUAL . $subjectId
                . $search;
//        $Datatable->debug(true);
        $list_data = $Datatable->select_pagination($linkSubjectAssess, $linkSubjectAssess->getEntity(), $whereList, $joins, $masterCategoryAssess->getEntity(), null, ""
                . $masterCategoryAssess->getEntity() . "." . $masterCategoryAssess->getId() . " as category_assess_id,"
                . $linkSubjectAssess->getEntity() . "." . $linkSubjectAssess->getCategoryAssessParentId() . " as category_assess_parent_id,"
                . $masterCategoryAssess->getEntity() . "." . $masterCategoryAssess->getName() . " as category_assess_name"
                , $masterCategoryAssess->getEntity() . "." . $masterCategoryAssess->getId());
//        print_r($list_data);
        include_once FILE_PATH(IViewConstant::MASTER_SUBJECT_VIEW_INDEX . '/assessment-points/list.html.php');
    }

    public function newEditAssessmentPoints($subjectId) {
        include_once FILE_PATH(IViewConstant::MASTER_SUBJECT_VIEW_INDEX . '/assessment-points/pagination-new-edit.html.php');
    }

    public function listAssessmentPoints($subjectId) {
        $Form = new Form();
        $Datatable = new DataTable();
        $Button = new Button();
        $db = new Database();
//       $group = new SecurityGroup();
        $data = new MasterCategoryAssess();

        if ($_POST['per_page'] == "") {
            $Datatable->per_page = 10;
        } else {
            $Datatable->per_page = $_POST['per_page'];
        }

//        }
        $Datatable->urlDeleteCollection($this->urlDeleteCollection);
        $Datatable->searchFilter(array(
            "name" => lang('master.field_description'),
                )
        );
//        echo $_POST['id_edit'];
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
            $sr = $data->search($_POST['search_by']);
            if (!empty($sr)) {
                $search = " AND " . $data->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search . "%'";
            }
        }
        $str_query_not_in_data = "";
        if (isset($_POST['id_edit'])) {
            $str_query_not_in_data = " AND " . $data->getEntity() . DOT . $data->getId() . " NOT IN (" . $_POST['id_edit'] . ")";
        }

        $where = $data->getEntity() . DOT . $data->getParentId() . equalToIgnoreCase(1)
                . $str_query_not_in_data;

        $list_data = $Datatable->select_pagination($data, $data->getEntity(), $where . $search);
        include_once FILE_PATH(IViewConstant::MASTER_SUBJECT_VIEW_INDEX . '/assessment-points/new-edit.html.php');
    }

    public function createAssessmentPoints($subjectId) {
        $Form = new Form();
        $db = new Database();
        $db->connect();
        $linkSubjectAssess = new LinkSubjectAssess();
        $masterCategoryAssess = new MasterCategoryAssess();

        $data_category_assess = $db->selectByID($masterCategoryAssess, $masterCategoryAssess->getId() . equalToIgnoreCase($_POST['id']));
        if (isset($_POST['id_edit'])) {
            if (!empty($data_category_assess)) {
                $db->update($linkSubjectAssess->getEntity(), array(
                    $linkSubjectAssess->getCategoryAssessId() => $data_category_assess[0][$masterCategoryAssess->getId()],
                    $linkSubjectAssess->getCategoryAssessParentId() => $data_category_assess[0][$masterCategoryAssess->getParentId()],
                    $linkSubjectAssess->getSubjectId() => $subjectId,
                        ), $linkSubjectAssess->getCategoryAssessId() . equalToIgnoreCase($_POST['id_edit'])
                        . " AND " . $linkSubjectAssess->getSubjectId() . equalToIgnoreCase($subjectId));
                $result = $db->getResult();
                if (is_numeric($result[0]) == 1) {
                    echo toastAlert('success', 'Add Assessment Points Success', 'Data Has been Added Successfully');
                } else {
                    echo toastAlert('error', 'Add Assessment Points Error', 'Data Has been Added Failed');
                }
            } else {
                echo toastAlert('error', 'Add Assessment Points Error', 'Data Has been Added Failed');
            }
        } else {
            $db->insert($linkSubjectAssess->getEntity(), array(
                $linkSubjectAssess->getCategoryAssessId() => $data_category_assess[0][$masterCategoryAssess->getId()],
                $linkSubjectAssess->getCategoryAssessParentId() => $data_category_assess[0][$masterCategoryAssess->getParentId()],
                $linkSubjectAssess->getSubjectId() => $subjectId,
            ));
            $result = $db->getResult();
            if (is_numeric($result[0])) {
                echo toastAlert('success', 'Add Assessment Points Success', 'Data Has been Added Successfully');
            } else {
                echo toastAlert('error', 'Add Assessment Points Error', 'Data Has been Added Failed');
            }
        }
        echo '<script>$(function(){$(\'#myModal_self\').modal(\'hide\');postAjaxPagination();});</script>';
    }

    public function deleteAssessmentPoints($subjectId) {
        $db = new Database();
        $db->connect();
        $linkSubjectAssess = new LinkSubjectAssess();

        $db->delete($linkSubjectAssess->getEntity(), $linkSubjectAssess->getSubjectId() . equalToIgnoreCase($subjectId)
                . " AND " . $linkSubjectAssess->getCategoryAssessId() . equalToIgnoreCase($_POST['id']));
        $result = $db->getResult();
        if (is_numeric($result[0]) == 1) {
            echo 1;
        } else {
            echo 0;
        }
    }

}
