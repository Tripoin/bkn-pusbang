<?php

namespace app\Controller\Transaction;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AgendaKegiatan
 *
 * @author sfandrianah
 */
use app\Controller\Base\Controller;
use app\Model\TransactionActivity;
use app\Model\TransactionActivityDetails;
use app\Constant\IURLConstant;
use app\Constant\IViewConstant;
use app\Model\MasterParticipantType;
use app\Model\MasterWorkingUnit;
use app\Model\MasterGovernmentAgencies;
use app\Model\MasterUserAssignment;
use app\Model\MasterUserMain;
use app\Model\MasterCurriculum;
use app\Model\MasterSubject;
use app\Model\MasterReligion;
use app\Model\MasterContact;
use app\Model\MasterAddress;
use app\Model\MasterProvince;
use app\Model\MasterCity;
use app\Model\MasterDistrict;
use app\Model\MasterVillage;
use app\Model\MasterBudgetType;
use app\Model\MasterGovernmentClassification;
use app\Model\SecurityUserProfile;
use app\Model\SecurityUser;
use app\Model\SecurityGroup;
use app\Util\Form;
use app\Util\DataTable;
use app\Util\Database;
use app\Util\Button;

class AgendaKegiatan extends Controller {

    //put your code here
    public $modelSubject;
    public $data_subject;
    public $data_curriculum;
    public $data_user;

    public function __construct() {
        $this->admin_theme_url = getAdminTheme();
        $this->modelData = new TransactionActivity();
        $this->setTitle(lang('transaction.agenda_subject'));
        $this->setBreadCrumb(array(lang('transaction.agenda_subject') => "", lang('transaction.agenda_subject') => FULLURL()));
        $this->search_filter = array(
            "subjectName" => lang('transaction.type'),
            "startActivity" => lang('transaction.excecution_time'),
            "quota" => lang('transaction.number_of_participants')
        );
        $this->orderBy = $this->modelData->getCreatedOn() . " DESC ";
        $this->indexUrl = IURLConstant::AGENDA_KEGIATAN_INDEX_URL;
        $this->viewPath = IViewConstant::AGENDA_KEGIATAN_VIEW_INDEX;
        $this->unsetAutoData = array('description');
        $this->autoData = false;
        $this->setAutoCrud();
        parent::__construct();
    }

    public function create() {
        $masterSubject = new MasterSubject();
        $this->data_subject = valueComboBoxParent($masterSubject->getEntity(), $masterSubject->getId(), $masterSubject->getName(), $masterSubject->getParentId(), $masterSubject->getIsChild() . equalToIgnoreCase(1));
        parent::create();
    }

    public function edit() {
        $masterSubject = new MasterSubject();
        $this->data_subject = valueComboBoxParent($masterSubject->getEntity(), $masterSubject->getId(), $masterSubject->getName(), $masterSubject->getParentId());
        parent::edit();
    }

    public function save() {
        $db = new Database();
        $subjectId = $_POST['subjectId'];
        $startActivity = $_POST['startActivity'];
        $endActivity = $_POST['endActivity'];
        $generation = $_POST['generation'];
        $quota = $_POST['quota'];
        $description = $_POST['description'];


//        $group = new SecurityGroup();
        $data = new TransactionActivity();
        $db->connect();

        $subject = new MasterSubject();
        $masterBudgetType = new MasterBudgetType();
        $data_subject = $db->selectByID($subject, $subject->getId() . EQUAL . $subjectId);
        $data_subject_cbx = valueComboBoxParent($subject->getEntity(), $subject->getId(), $subject->getName(), $subject->getParentId(), $subject->getId() . equalToIgnoreCase($subjectId));
        $data_budget_type = $db->selectByID($masterBudgetType, $masterBudgetType->getId() . EQUAL . $data_subject[0][$subject->getBudgetTypeId()]);
        $year = date('Y', strtotime($startActivity));
        $data_insert = array(
            $data->getCode() => createRandomBooking(),
            $data->getName() => $data_subject_cbx[0]['label'],
            $data->getSubjectName() => $data_subject_cbx[0]['label'],
            $data->getSubjectId() => $data_subject_cbx[0]['id'],
            $data->getStartActivity() => $startActivity,
            $data->getEndActivity() => $endActivity,
            $data->getGeneration() => $generation,
            $data->getQuota() => $quota,
            $data->getYearActivity() => $year,
            $data->getBudgetTypeName() => $data_budget_type[0][$masterBudgetType->getName()],
            $data->getDescription() => $description,
            $data->getStatus() => NULL,
            $data->getCreatedByUsername() => $_SESSION[SESSION_ADMIN_USERNAME],
            $data->getCreatedOn() =>  date(DATE_FORMAT_PHP_DEFAULT),
        );
//        $datas = $data->setData($data);
        $db->insert($data->getEntity(), $data_insert);
        $rs = $db->getResult();
        if (is_numeric($rs[0])) {
            echo toastAlert("success", lang('general.title_insert_success'), lang('general.message_insert_success'));
            echo '<script>$(function(){postAjaxPagination()});</script>';
        } else {
            echo toastAlert("error", lang('general.title_insert_error'), lang('general.message_insert_error'));
            echo resultPageMsg('danger', lang('general.title_insert_error'), $rs[0]);
        }
    }

    public function update() {
        $db = new Database();
        $id = $_POST['id'];
        $subjectId = $_POST['subjectId'];
        $startActivity = $_POST['startActivity'];
        $endActivity = $_POST['endActivity'];
        $quota = $_POST['quota'];
        $generation = $_POST['generation'];
        $description = $_POST['description'];

//        $group = new SecurityGroup();
        $data = new TransactionActivity();
        $db->connect();

        $subject = new MasterSubject();
        $masterBudgetType = new MasterBudgetType();
        $data_subject = $db->selectByID($subject, $subject->getId() . EQUAL . $subjectId);
        $data_subject_cbx = valueComboBoxParent($subject->getEntity(), $subject->getId(), $subject->getName(), $subject->getParentId(), $subject->getId() . equalToIgnoreCase($subjectId));
        $data_budget_type = $db->selectByID($masterBudgetType, $masterBudgetType->getId() . EQUAL . $data_subject[0][$subject->getBudgetTypeId()]);
        $year = date('Y', strtotime($startActivity));
        $data_insert = array(
            $data->getName() => $data_subject_cbx[0]['label'],
            $data->getSubjectName() => $data_subject_cbx[0]['label'],
            $data->getSubjectId() => $data_subject_cbx[0]['id'],
            $data->getStartActivity() => $startActivity,
            $data->getEndActivity() => $endActivity,
            $data->getGeneration() => $generation,
            $data->getBudgetTypeName() => $data_budget_type[0][$masterBudgetType->getName()],
            $data->getQuota() => $quota,
            $data->getDescription() => $description,
            $data->getYearActivity() => $year,
            $data->getModifiedByUsername() => $_SESSION[SESSION_ADMIN_USERNAME],
            $data->getModifiedOn() =>  date(DATE_FORMAT_PHP_DEFAULT),
        );
//        $datas = $data->setData($data);
        $db->update($data->getEntity(), $data_insert, $data->getId() . EQUAL . $id);
        if ($db->getResult()[0] == 1) {
            echo toastAlert("success", lang('general.title_update_success'), lang('general.message_update_success'));
            echo '<script>$(function(){postAjaxPagination()});</script>';
        } else {
            echo toastAlert("error", lang('general.title_update_error'), lang('general.message_update_error') . '<br/>' .
                    json_encode($db->getResult()));
        }
    }

    public function listPanitia($activity) {
        $Form = new Form();
        $Datatable = new DataTable();
        $Button = new Button();
        $db = new Database();
//        $group = new SecurityGroup();
        $data = new MasterUserAssignment();
        $userMain = new MasterUserMain();
        if ($_POST['per_page'] == "") {
            $Datatable->per_page = 5;
        } else {
            $Datatable->per_page = $_POST['per_page'];
        }

//        }
        $Datatable->urlDeleteCollection($this->urlDeleteCollection);
        $Datatable->searchFilter(array("name" => lang('general.name')));
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
            $sr = $userMain->search($_POST['search_by']);
            if (!empty($sr)) {
                $search = " AND " . $userMain->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search . "%'";
            }
        }

//        echo $Datatable->search;

        $whereList = $data->getEntity() . "." . $data->getActivity_id() . EQUAL . $activity . " AND " .
                $userMain->getEntity() . "." . $userMain->getId() . EQUAL . $data->getUser_main_id() . $search;

        $list_data = $Datatable->select_pagination($data, $data->getEntity(), $whereList, $userMain->getEntity(), $userMain->getEntity(), null, ""
                . $data->getEntity() . "." . $data->getId() . " as id,"
                . $userMain->getEntity() . "." . $userMain->getCode() . " as code,"
                . $data->getEntity() . "." . $data->getDescription() . " as description,"
                . $userMain->getEntity() . "." . $userMain->getName() . " as name", $data->getEntity() . "." . $data->getId());
//        print_r($list_data);
        include_once FILE_PATH(IViewConstant::AGENDA_KEGIATAN_VIEW_INDEX . '/assignment/list.html.php');
    }

    public function listPeserta($activity) {
        $Form = new Form();
        $Datatable = new DataTable();
        $Button = new Button();
        $db = new Database();
//        $group = new SecurityGroup();
        $data = new MasterUserAssignment();
        $userMain = new MasterUserMain();
        if ($_POST['per_page'] == "") {
            $Datatable->per_page = 5;
        } else {
            $Datatable->per_page = $_POST['per_page'];
        }

//        }
        $Datatable->urlDeleteCollection($this->urlDeleteCollection);
        $Datatable->searchFilter(array(
            "code" => lang('transaction.no_id'),
            "name" => lang('general.name'))
        );
        $Datatable->current_page = $_POST['current_page'];
        if ($_POST['current_page'] == '') {
            $Datatable->current_page = 1;
        }
        $search_pagination = $_POST['search_pagination'];
        $search = '';
        if ($_POST['search_by'] == '') {
            
        } else if ($_POST['search_by'] == 'null') {
            
        } else {
            $sr = $userMain->search($_POST['search_by']);
            if (!empty($sr)) {
                $search = " AND " . $userMain->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search_pagination . "%'";
            }
        }

//        echo $Datatable->search;

        $whereList = $data->getEntity() . "." . $data->getActivity_id() . EQUAL . $activity . " AND " .
                $userMain->getEntity() . "." . $userMain->getId() . EQUAL . $data->getUser_main_id() . $search;

        $list_data = $Datatable->select_pagination($data, $data->getEntity(), $whereList, $userMain->getEntity(), $userMain->getEntity(), null, ""
                . $data->getEntity() . "." . $data->getId() . " as id,"
                . $userMain->getEntity() . "." . $userMain->getId() . " as user_main_id,"
                . $userMain->getEntity() . "." . $userMain->getCode() . " as code,"
                . $data->getEntity() . "." . $data->getDescription() . " as description,"
                . $userMain->getEntity() . "." . $userMain->getName() . " as name", $data->getEntity() . "." . $data->getId());
//        print_r($list_data);
        include_once FILE_PATH(IViewConstant::AGENDA_KEGIATAN_VIEW_INDEX . '/peserta/list.html.php');
    }

    public function viewPeserta($activity_id) {
        $Form = new Form();
        $id = $_POST['id'];
        $db = new Database();
        $m_act = new TransactionActivity();
        $m_user_assign = new MasterUserAssignment();
        $m_user_main = new MasterUserMain();
        $m_participant_type = new MasterParticipantType();
        $m_working_unit = new MasterWorkingUnit();
        $m_gov_agencies = new MasterGovernmentAgencies();
        $user = new SecurityUser();
        $userProfile = new SecurityUserProfile();
        $masterReligion = new MasterReligion();
        $masterContact = new MasterContact();
        $masterAddress = new MasterAddress();
        $masterProvince = new MasterProvince();
        $masterCity = new MasterCity();
        $masterDistrict = new MasterDistrict();
        $masterVillage = new MasterVillage();
        $mGovClass = new MasterGovernmentClassification();



        $dt_activity = $db->selectByID($m_act, $m_act->getId() . EQUAL . $activity_id);

        $dt_user_main = $db->selectByID($m_user_main, $m_user_main->getId() . EQUAL . $id);

        $dt_participant_type = $db->selectByID($m_participant_type, $m_participant_type->getId() . EQUAL . $dt_user_main[0][$m_user_main->getParticipantTypeId()]);

        $dt_working_unit = $db->selectByID($m_working_unit, $m_working_unit->getId() . EQUAL . $dt_user_main[0][$m_user_main->getWorkingUnitId()]);

        $dt_gov_agencies = $db->selectByID($m_gov_agencies, $m_gov_agencies->getId() . EQUAL . $dt_working_unit[0][$m_working_unit->getGovernment_agency_id()]);

        $dt_user_profile = $db->selectByID($userProfile, $userProfile->getId() . EQUAL . $dt_user_main[0][$m_user_main->getUserProfileId()]);
        $dt_religion = $db->selectByID($masterReligion, $masterReligion->getId() . EQUAL . $dt_user_profile[0][$userProfile->getReligionId()]);
        $dt_contact = $db->selectByID($masterContact, $masterContact->getId() . EQUAL . $dt_user_profile[0][$userProfile->getContactId()]);
        $dt_address = $db->selectByID($masterAddress, $masterAddress->getId() . EQUAL . $dt_user_profile[0][$userProfile->getAddressId()]);
        $dt_province = $db->selectByID($masterProvince, $masterProvince->getId() . EQUAL . $dt_address[0][$masterAddress->getProvinceId()]);
        $dt_city = $db->selectByID($masterCity, $masterCity->getId() . EQUAL . $dt_address[0][$masterAddress->getCityId()]);
        $dt_district = $db->selectByID($masterDistrict, $masterDistrict->getId() . EQUAL . $dt_address[0][$masterAddress->getDistrictId()]);
        $dt_village = $db->selectByID($masterVillage, $masterVillage->getId() . EQUAL . $dt_address[0][$masterAddress->getVillageId()]);

        $dt_gov_class = $db->selectByID($mGovClass, $mGovClass->getId() . EQUAL . $dt_user_main[0][$m_user_main->getGovernmentClassificationId()]);
//        MasterGovernmentClassification
//        print_r($dt_user_profile);
        include_once FILE_PATH(IViewConstant::AGENDA_KEGIATAN_VIEW_INDEX . '/peserta/view.html.php');
    }

    public function createPanitia($activity) {
        $Form = new Form();
        $id = 0;
        include_once FILE_PATH(IViewConstant::AGENDA_KEGIATAN_VIEW_INDEX . '/assignment/create.html.php');
    }

    public function createDetails($activity) {
        $db = new Database();
        $Form = new Form();
        $id = 0;

        $masterCurriculum = new MasterCurriculum();
        $rs_cur = $db->selectByID($masterCurriculum);
        $this->data_curriculum = convertJsonCombobox($rs_cur, $masterCurriculum->getId(), $masterCurriculum->getName());

        $userMain = new MasterUserMain();
        $user = new SecurityUser();
        $userProfile = new SecurityUserProfile();
        $group = new SecurityGroup();
        $whereList = ""
                . $userMain->getEntity() . "." . $userMain->getUser_profile_id() . EQUAL . $userProfile->getEntity() . "." . $userProfile->getId() . " AND "
                . $userProfile->getEntity() . "." . $userProfile->getUserId() . EQUAL . $user->getEntity() . "." . $user->getId() . " AND "
                . $user->getEntity() . "." . $user->getGroupId() . EQUAL . $group->getEntity() . "." . $group->getId() . " AND "
                . $group->getEntity() . "." . $group->getCode() . EQUAL . "'INTERNAL'";
        $db->connect();
        $db->select($userMain->getEntity(), $userMain->getEntity() . "." . $userMain->getId() . "," . $userProfile->getEntity() . "." . $userProfile->getName(), array(
            $user->getEntity(),
            $userProfile->getEntity(),
            $group->getEntity(),
                ), $whereList);
        $rs_user = $db->getResult();
//        print_r($rs_user);
        $this->data_user = convertJsonCombobox($rs_user, $userMain->getId(), $userProfile->getName());
        include_once FILE_PATH(IViewConstant::AGENDA_KEGIATAN_VIEW_INDEX . '/details/create.html.php');
    }

    public function editDetails($activity) {
        $db = new Database();
        $Form = new Form();
        $id = $_POST['id'];

        $activityDetails = new TransactionActivityDetails();
        $masterCurriculum = new MasterCurriculum();
        $rs_cur = $db->selectByID($masterCurriculum);
        $this->data_curriculum = convertJsonCombobox($rs_cur, $masterCurriculum->getId(), $masterCurriculum->getName());

        $userMain = new MasterUserMain();
        $user = new SecurityUser();
        $userProfile = new SecurityUserProfile();
        $group = new SecurityGroup();
        $whereList = ""
                . $userMain->getEntity() . "." . $userMain->getUser_profile_id() . EQUAL . $userProfile->getEntity() . "." . $userProfile->getId() . " AND "
                . $userProfile->getEntity() . "." . $userProfile->getUserId() . EQUAL . $user->getEntity() . "." . $user->getId() . " AND "
                . $user->getEntity() . "." . $user->getGroupId() . EQUAL . $group->getEntity() . "." . $group->getId() . " AND "
                . $group->getEntity() . "." . $group->getCode() . EQUAL . "'INTERNAL'";
        $db->connect();
        $db->select($userMain->getEntity(), $userMain->getEntity() . "." . $userMain->getId() . "," . $userProfile->getEntity() . "." . $userProfile->getName(), array(
            $user->getEntity(),
            $userProfile->getEntity(),
            $group->getEntity(),
                ), $whereList);
        $rs_user = $db->getResult();
//        print_r($rs_user);

        $get_data = $db->selectByID($activityDetails, $activityDetails->getId() . EQUAL . $id);

//        print_r($get_data);
        $this->data_user = convertJsonCombobox($rs_user, $userMain->getId(), $userProfile->getName());
        include_once FILE_PATH(IViewConstant::AGENDA_KEGIATAN_VIEW_INDEX . '/details/create.html.php');
    }

    public function listDetails($activity) {
        $Form = new Form();
        $Datatable = new DataTable();
        $Button = new Button();
        $db = new Database();
//        $group = new SecurityGroup();

        $data = new MasterUserAssignment();
        $activityModel = new TransactionActivity();
        $activityDetails = new TransactionActivityDetails();
        $userMain = new MasterUserMain();
        if ($_POST['per_page'] == "") {
            $Datatable->per_page = 5;
        } else {
            $Datatable->per_page = $_POST['per_page'];
        }

        $Datatable->current_page = $_POST['current_page'];
        if ($_POST['current_page'] == '') {
            $Datatable->current_page = 1;
        }

        $Datatable->urlDeleteCollection($this->urlDeleteCollection);
        $Datatable->searchFilter(array(
            "startTime" => lang('transaction.day/date'),
            "materialName" => lang('transaction.material')
        ));
        $Datatable->current_page = $_POST['current_page'];
        if ($_POST['current_page'] == '') {
            $Datatable->current_page = 1;
        }
        $search_pagination = $_POST['search_pagination'];
        $search = '';
        if ($_POST['search_by'] == '') {
            
        } else if ($_POST['search_by'] == 'null') {
            
        } else {
            $sr = $activityDetails->search($_POST['search_by']);
            if (!empty($sr)) {
                $search = " AND " . $activityDetails->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search_pagination . "%'";
            }
        }

//        echo $Datatable->search;
        $whereList = $activityDetails->getEntity() . "." . $activityDetails->getActivityId() . EQUAL . $activity . " AND " .
                $activityModel->getEntity() . "." . $activityModel->getId() . EQUAL . $activityDetails->getEntity() . "." . $activityDetails->getActivityId() . $search;

        $list_data = $Datatable->select_pagination($activityDetails, $activityDetails->getEntity(), $whereList, $activityModel->getEntity(), $activityModel->getEntity(), null, ""
                . $activityDetails->getEntity() . "." . $activityDetails->getId() . " as id,"
                . $activityDetails->getEntity() . "." . $activityDetails->getCode() . " as code,"
                . $activityDetails->getEntity() . "." . $activityDetails->getStartTime() . ","
                . $activityDetails->getEntity() . "." . $activityDetails->getEndTime() . ","
                . $activityDetails->getEntity() . "." . $activityDetails->getDuration() . ","
                . $activityDetails->getEntity() . "." . $activityDetails->getMaterialName() . ","
                . $activityDetails->getEntity() . "." . $activityDetails->getUserMainId() . ","
                . $activityDetails->getEntity() . "." . $activityDetails->getUserMainName() . ","
                . $activityDetails->getEntity() . "." . $activityDetails->getDescription() . " as description,"
                . $activityDetails->getEntity() . "." . $activityDetails->getName() . " as name", $activityDetails->getEntity() . "." . $activityDetails->getId());

        include_once FILE_PATH(IViewConstant::AGENDA_KEGIATAN_VIEW_INDEX . '/details/list.html.php');
    }

    public function editPanitia($activity) {
        $Form = new Form();
        $id = $_POST['id'];
        include_once FILE_PATH(IViewConstant::AGENDA_KEGIATAN_VIEW_INDEX . '/assignment/create.html.php');
    }

    public function listUserPanitia($activity) {
        $Datatable = new DataTable();
        $Button = new Button();
        $db = new Database();
//        $group = new SecurityGroup();
        $data = new MasterUserAssignment();
        $userMain = new MasterUserMain();
        $user = new SecurityUser();
        $userProfile = new SecurityUserProfile();
        $group = new SecurityGroup();
        if ($_POST['per_page'] == "") {
            $Datatable->per_page = 5;
        } else {
            $Datatable->per_page = $_POST['per_page'];
        }

//        }
        $Datatable->urlDeleteCollection($this->urlDeleteCollection);
        $Datatable->searchFilter(array("name" => "Name"));
        $Datatable->current_page = $_POST['current_page'];
        if ($_POST['current_page'] == '') {
            $Datatable->current_page = 1;
        }
        $search_pagination = $_POST['search_pagination'];
        $search = '';
        if ($_POST['search_by'] == '') {
            
        } else if ($_POST['search_by'] == 'null') {
            
        } else {
            $sr = $userMain->search($_POST['search_by']);
            if (!empty($sr)) {
                $search = " AND " . $userMain->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search_pagination . "%'";
            }
        }

//        echo $Datatable->search;
        $db->connect();
        $db->select($data->getEntity(), $data->getUser_main_id(), array(), $data->getActivity_id() . EQUAL . $activity);
        $rs_user = $db->getResult();
        $list_user = "";
        foreach ($rs_user as $value) {
            $list_user .= $value[$data->getUser_main_id()] . ",";
        }
        $list_users = rtrim($list_user, ",");
        $where_by_user = "";
        if ($list_users != "") {
            $where_by_user = " AND " . $userMain->getEntity() . "." . $userMain->getId() . " NOT IN (" . $list_users . ")";
        }
//        print_r($rs_user);
        $whereList = ""
                . $userMain->getEntity() . "." . $userMain->getUser_profile_id() . EQUAL . $userProfile->getEntity() . "." . $userProfile->getId() . " AND "
                . $userProfile->getEntity() . "." . $userProfile->getUserId() . EQUAL . $user->getEntity() . "." . $user->getId() . " AND "
                . $user->getEntity() . "." . $user->getGroupId() . EQUAL . $group->getEntity() . "." . $group->getId() . " AND "
                . $group->getEntity() . "." . $group->getCode() . EQUAL . "'INTERNAL' "
                . "" . $where_by_user
                . "" . $search;
//        $Datatable->debug(true);
        $list_data = $Datatable->select_pagination($userMain, $userMain->getEntity(), $whereList, array($user->getEntity(), $userProfile->getEntity(), $group->getEntity()), "", null, ""
                . $userMain->getEntity() . "." . $userMain->getId() . " as id,"
                . $userProfile->getEntity() . "." . $userProfile->getName() . " as name,"
                . $userMain->getEntity() . "." . $userMain->getFront_degree() . " as front_degree,"
                . $userProfile->getEntity() . "." . $userProfile->getName() . " as fullname,"
                . $userMain->getEntity() . "." . $userMain->getBehind_degree() . " as behind_degree", null);
        $id = 0;
        if (isset($_POST['id'])) {
            if ($_POST['id'] != 0) {
                $id = $_POST['id'];
            }
        }
        include_once FILE_PATH(IViewConstant::AGENDA_KEGIATAN_VIEW_INDEX . '/assignment/list-user.html.php');
    }

    public function saveDetails($activity) {
        $trainer = $_POST['trainer'];
        $startActivity = $_POST['startActivity'];
        $endActivity = $_POST['endActivity'];
        $curriculumId = $_POST['curriculum'];
        $lesson_time = $_POST['lesson_time'];
        $date = $_POST['date'];

        $data = new TransactionActivityDetails();

        $db = new Database();
        $db->connect();


        $userMain = new MasterUserMain();
        $user = new SecurityUser();
        $userProfile = new SecurityUserProfile();
        $group = new SecurityGroup();
        $curriculumModel = new MasterCurriculum();
        $whereList = ""
                . $userMain->getEntity() . "." . $userMain->getUser_profile_id() . EQUAL . $userProfile->getEntity() . "." . $userProfile->getId() . " AND "
                . $userProfile->getEntity() . "." . $userProfile->getUserId() . EQUAL . $user->getEntity() . "." . $user->getId() . " AND "
                . $user->getEntity() . "." . $user->getGroupId() . EQUAL . $group->getEntity() . "." . $group->getId() . " AND "
                . $group->getEntity() . "." . $group->getCode() . EQUAL . "'INTERNAL' AND "
                . $userMain->getEntity() . "." . $userMain->getId() . EQUAL . $trainer;
        $db->connect();
        $db->select($userMain->getEntity(), $userMain->getEntity() . "." . $userMain->getId() . "," . $userProfile->getEntity() . "." . $userProfile->getName(), array(
            $user->getEntity(),
            $userProfile->getEntity(),
            $group->getEntity(),
                ), $whereList);
        $rs_user = $db->getResult();


        $rs_cur = $db->selectByID($curriculumModel, $curriculumModel->getId() . EQUAL . $curriculumId);


        $ar_dt = array(
            $data->getCode() => createRandomBooking(),
            $data->getActivityId() => $activity,
            $data->getStartTime() => $date . " " . $startActivity,
            $data->getEndTime() => $date . " " . $endActivity,
            $data->getDuration() => $lesson_time,
            $data->getDescription() => 'Hadir',
        );

        $ar_dt_cr = array();
        if ($curriculumId != "") {
            $ar_dt_cr = array(
                $data->getCurriculumId() => $curriculumId,
                $data->getMaterialName() => $rs_cur[0][$curriculumModel->getName()],
            );
        } else {
            $curriculumName = $_POST['curriculum_name'];
            $ar_dt_cr = array(
                $data->getCurriculumId() => null,
                $data->getMaterialName() => $curriculumName,
            );
        }

        $ar_dt_trainer = array();
        if ($trainer != "") {

            $ar_dt_trainer = array(
                $data->getUserMainId() => $trainer,
                $data->getUserMainName() => $rs_user[0][$userProfile->getName()],
            );
        } else {
            $trainerName = $_POST['trainer_name'];
            $ar_dt_trainer = array(
                $data->getUserMainId() => null,
                $data->getUserMainName() => $trainerName,
            );
        }

        $db->insert($data->getEntity(), array_merge($ar_dt, $ar_dt_cr, $ar_dt_trainer));
        $result = $db->getResult();
        if (is_numeric($result[0])) {
            echo toastAlert('success', 'Add Activity Details Success', 'Data Has been Added Successfully');
        } else {
            echo toastAlert('error', 'Add Activity Details Error', 'Data Has been Added Failed');
        }
//        print_r($db->getResult());
        echo '<script>$(function(){$(\'#myModal_self\').modal(\'hide\');postAjaxPagination();});</script>';
    }

    public function updateDetails($activity) {
        $id = $_POST['id'];
        $trainer = $_POST['trainer'];
        $startActivity = $_POST['startActivity'];
        $endActivity = $_POST['endActivity'];
        $curriculumId = $_POST['curriculum'];
        $lesson_time = $_POST['lesson_time'];
        $date = $_POST['date'];

        $data = new TransactionActivityDetails();

        $db = new Database();
        $db->connect();


        $userMain = new MasterUserMain();
        $user = new SecurityUser();
        $userProfile = new SecurityUserProfile();
        $group = new SecurityGroup();
        $curriculumModel = new MasterCurriculum();
        $whereList = ""
                . $userMain->getEntity() . "." . $userMain->getUser_profile_id() . EQUAL . $userProfile->getEntity() . "." . $userProfile->getId() . " AND "
                . $userProfile->getEntity() . "." . $userProfile->getUserId() . EQUAL . $user->getEntity() . "." . $user->getId() . " AND "
                . $user->getEntity() . "." . $user->getGroupId() . EQUAL . $group->getEntity() . "." . $group->getId() . " AND "
                . $group->getEntity() . "." . $group->getCode() . EQUAL . "'INTERNAL' AND "
                . $userMain->getEntity() . "." . $userMain->getId() . EQUAL . $trainer;
        $db->connect();
        $db->select($userMain->getEntity(), $userMain->getEntity() . "." . $userMain->getId() . "," . $userProfile->getEntity() . "." . $userProfile->getName(), array(
            $user->getEntity(),
            $userProfile->getEntity(),
            $group->getEntity(),
                ), $whereList);
        $rs_user = $db->getResult();


        $rs_cur = $db->selectByID($curriculumModel, $curriculumModel->getId() . EQUAL . $curriculumId);

        $ar_dt = array(
            $data->getActivityId() => $activity,
            $data->getStartTime() => $date . " " . $startActivity,
            $data->getEndTime() => $date . " " . $endActivity,
            $data->getDuration() => $lesson_time,
            $data->getDescription() => 'Hadir',
        );

        $ar_dt_cr = array();
        if ($curriculumId != "") {
            $ar_dt_cr = array(
                $data->getCurriculumId() => $curriculumId,
                $data->getMaterialName() => $rs_cur[0][$curriculumModel->getName()],
            );
        } else {
            $curriculumName = $_POST['curriculum_name'];
            $ar_dt_cr = array(
                $data->getCurriculumId() => null,
                $data->getMaterialName() => $curriculumName,
            );
        }

        $ar_dt_trainer = array();
        if ($trainer != "") {

            $ar_dt_trainer = array(
                $data->getUserMainId() => $trainer,
                $data->getUserMainName() => $rs_user[0][$userProfile->getName()],
            );
        } else {
            $trainerName = $_POST['trainer_name'];
            $ar_dt_trainer = array(
                $data->getUserMainId() => null,
                $data->getUserMainName() => $trainerName,
            );
        }

        $db->update($data->getEntity(), array_merge($ar_dt, $ar_dt_cr, $ar_dt_trainer), $data->getId() . EQUAL . $id);
        $result = $db->getResult();
        if ($result[0] == 1) {
            echo toastAlert('success', 'Update Activity Details Success', 'Data Has been Update Successfully');
        } else {
            echo toastAlert('error', 'Update Activity Details Error', 'Data Has been Update Failed');
        }
//        print_r($db->getResult());
        echo '<script>$(function(){$(\'#myModal_self\').modal(\'hide\');postAjaxPagination();});</script>';
    }

    public function savePanitia($activity) {
        $data = new MasterUserAssignment();
        $db = new Database();
        $db->connect();
        $db->insert($data->getEntity(), array(
            $data->getCode() => createRandomBooking(),
            $data->getActivity_id() => $activity,
            $data->getUser_main_id() => $_POST['id'],
            $data->getDescription() => 'Hadir',
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

    public function updatePanitia($activity) {
        $id = $_POST['id_panitia'];
        $data = new MasterUserAssignment();
        $db = new Database();
        $db->connect();
        $db->update($data->getEntity(), array(
            $data->getCode() => createRandomBooking(),
            $data->getActivity_id() => $activity,
            $data->getUser_main_id() => $_POST['id'],
            $data->getDescription() => 'Hadir',
                ), $data->getId() . EQUAL . $id);
        $result = $db->getResult();
        if ($result[0] == 1) {
            echo toastAlert('success', 'Update Panitia Success', 'Data Has been Update Successfully');
        } else {
            echo toastAlert('error', 'Update Panitia Error', 'Data Has been Update Failed');
        }
//        print_r($db->getResult());
        echo '<script>$(function(){$(\'#myModal_self\').modal(\'hide\');postAjaxPagination();});</script>';
    }

    public function deletePanitia() {
        $id = $_POST['id'];
        $Form = new Form();
        $db = new Database();
        $data = new MasterUserAssignment();
        $db->connect();
        $get_data = $db->delete($data->getEntity(), $data->getId() . EQUAL . $id);
        echo $get_data;
    }

    public function deleteCollectionPanitia() {
        $id = $_POST['id'];
        $Form = new Form();
        $db = new Database();
        $data = new MasterUserAssignment();
        $db->connect();
        $where = $data->getId() . " IN (" . $id . ")";
        $delete_data = $db->delete($data->getEntity(), $where);
        echo $delete_data;
    }

    public function deleteDetails() {
        $id = $_POST['id'];
        $Form = new Form();
        $db = new Database();
        $data = new TransactionActivityDetails();
        $db->connect();
        $get_data = $db->delete($data->getEntity(), $data->getId() . EQUAL . $id);
        echo $get_data;
    }

    public function deleteCollectionDetails() {
        $id = $_POST['id'];
        $Form = new Form();
        $db = new Database();
        $data = new TransactionActivityDetails();
        $db->connect();
        $where = $data->getId() . " IN (" . $id . ")";
        $delete_data = $db->delete($data->getEntity(), $where);
        echo $delete_data;
    }

    public function listData() {
        $this->modelSubject = new MasterSubject();
        parent::listData();
    }

}
