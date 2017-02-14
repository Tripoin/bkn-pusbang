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
use app\Model\MasterUserAssignment;
use app\Model\MasterUserMain;
use app\Model\MasterCurriculum;
use app\Model\MasterSubject;
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
        $this->search_filter = array("code" => lang('general.code'), "name" => lang('general.name'));
        $this->indexUrl = IURLConstant::AGENDA_KEGIATAN_INDEX_URL;
        $this->viewPath = IViewConstant::AGENDA_KEGIATAN_VIEW_INDEX;
        $this->unsetAutoData = array('description');
        $this->autoData = false;
        $this->setAutoCrud();
        parent::__construct();
    }

    public function create() {
        $masterSubject = new MasterSubject();
        $this->data_subject = valueComboBoxParent($masterSubject->getEntity(), $masterSubject->getId(), $masterSubject->getName(), $masterSubject->getParentId());
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
        $quota = $_POST['quota'];

//        $group = new SecurityGroup();
        $data = new TransactionActivity();
        $db->connect();
        $db->createAuditrail();

        $subject = new MasterSubject();
        $data_subject = $db->selectByID($subject, $subject->getId() . EQUAL . $subjectId);

        $data_insert = array(
            $data->getCode() => createRandomBooking(),
            $data->getSubjectName() => $data_subject[0][$subject->getName()],
            $data->getSubjectId() => $data_subject[0][$subject->getId()],
            $data->getStartActivity() => $startActivity,
            $data->getEndActivity() => $endActivity,
            $data->getQuota() => $quota,
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

//        $group = new SecurityGroup();
        $data = new TransactionActivity();
        $db->connect();
        $db->updateAuditrail();

        $subject = new MasterSubject();
        $data_subject = $db->selectByID($subject, $subject->getId() . EQUAL . $subjectId);

        $data_insert = array(
            $data->getSubjectName() => $data_subject[0][$subject->getName()],
            $data->getSubjectId() => $data_subject[0][$subject->getId()],
            $data->getStartActivity() => $startActivity,
            $data->getEndActivity() => $endActivity,
            $data->getQuota() => $quota,
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
        $Datatable->searchFilter($this->search_filter);
        $Datatable->current_page = $_POST['current_page'];
        if ($_POST['current_page'] == '') {
            $Datatable->current_page = 1;
        }
        $search = $_POST['search_pagination'];
        if ($_POST['search_by'] == '') {
            $search = " AND " . $userMain->getEntity() . ".code LIKE  '%" . $search . "%'";
        } else if ($_POST['search_by'] == 'null') {
            $search = " AND " . $userMain->getEntity() . ".code LIKE  '%" . $search . "%'";
        } else {
            $search = " AND " . $userMain->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search . "%'";
        }
        $db->select($data->getEntity(), $data->getId(), array(),$data->getActivity_id().EQUAL.$activity);
        $rs_user = $db->getResult();
        print_r($rs_user);
//        echo $Datatable->search;
        
        $whereList = $data->getEntity() . "." . $data->getActivity_id() . EQUAL . $activity . " AND " .
                $userMain->getEntity() . "." . $userMain->getId() . EQUAL . $data->getUser_main_id() . $search;

        $list_data = $Datatable->select_pagination($data, $data->getEntity(), $whereList, $userMain->getEntity(), $userMain->getEntity(), $this->orderBy, ""
                . $data->getEntity() . "." . $data->getId() . " as id,"
                . $userMain->getEntity() . "." . $userMain->getCode() . " as code,"
                . $data->getEntity() . "." . $data->getDescription() . " as description,"
                . $userMain->getEntity() . "." . $userMain->getName() . " as name", $data->getEntity() . "." . $data->getId());

        include_once FILE_PATH(IViewConstant::AGENDA_KEGIATAN_VIEW_INDEX . '/assignment/list.html.php');
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
        
        $get_data = $db->selectByID($activityDetails, $activityDetails->getId().EQUAL.$id);
        
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

//        }
        $Datatable->urlDeleteCollection($this->urlDeleteCollection);
        $Datatable->searchFilter($this->search_filter);
        $Datatable->current_page = $_POST['current_page'];
        if ($_POST['current_page'] == '') {
            $Datatable->current_page = 1;
        }
        $search = $_POST['search_pagination'];
        if ($_POST['search_by'] == '') {
            $search = " AND " . $activityDetails->getEntity() . ".code LIKE  '%" . $search . "%'";
        } else if ($_POST['search_by'] == 'null') {
            $search = " AND " . $activityDetails->getEntity() . ".code LIKE  '%" . $search . "%'";
        } else {
            $search = " AND " . $activityDetails->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search . "%'";
        }

//        echo $Datatable->search;
        $whereList = $activityDetails->getEntity() . "." . $activityDetails->getActivityId() . EQUAL . $activity . " AND " .
                $activityModel->getEntity() . "." . $activityModel->getId() . EQUAL . $activityDetails->getEntity() . "." . $activityDetails->getActivityId() . $search;

        $list_data = $Datatable->select_pagination($activityDetails, $activityDetails->getEntity(), $whereList, $activityModel->getEntity(), $activityModel->getEntity(), $this->orderBy, ""
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
        $search = $_POST['search_pagination'];
        if ($_POST['search_by'] == '') {
            $search = " AND " . $userMain->getEntity() . ".name LIKE  '%" . $search . "%'";
        } else if ($_POST['search_by'] == 'null') {
            $search = " AND " . $userMain->getEntity() . ".name LIKE  '%" . $search . "%'";
        } else {
            $search = " AND " . $userMain->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search . "%'";
        }

//        echo $Datatable->search;
        $whereList = ""
                . $userMain->getEntity() . "." . $userMain->getUser_profile_id() . EQUAL . $userProfile->getEntity() . "." . $userProfile->getId() . " AND "
                . $userProfile->getEntity() . "." . $userProfile->getUserId() . EQUAL . $user->getEntity() . "." . $user->getId() . " AND "
                . $user->getEntity() . "." . $user->getGroupId() . EQUAL . $group->getEntity() . "." . $group->getId() . " AND "
                . $group->getEntity() . "." . $group->getCode() . EQUAL . "'INTERNAL'"
                . "" . $search;
//        $Datatable->debug(true);
        $list_data = $Datatable->select_pagination($userMain, $userMain->getEntity(), $whereList, array($user->getEntity(), $userProfile->getEntity(), $group->getEntity()), "", $this->orderBy, ""
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
        $db->insert($data->getEntity(), array(
            $data->getCode() => createRandomBooking(),
            $data->getActivityId() => $activity,
            $data->getStartTime() => $date . " " . $startActivity,
            $data->getEndTime() => $date . " " . $endActivity,
            $data->getCurriculumId() => $curriculumId,
            $data->getMaterialName() => $rs_cur[0][$curriculumModel->getName()],
            $data->getDuration() => $lesson_time,
            $data->getUserMainId() => $trainer,
            $data->getUserMainName() => $rs_user[0][$userProfile->getName()],
            $data->getDescription() => 'Hadir',
        ));
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
        $db->update($data->getEntity(), array(
            $data->getCode() => createRandomBooking(),
            $data->getActivityId() => $activity,
            $data->getStartTime() => $date . " " . $startActivity,
            $data->getEndTime() => $date . " " . $endActivity,
            $data->getCurriculumId() => $curriculumId,
            $data->getMaterialName() => $rs_cur[0][$curriculumModel->getName()],
            $data->getDuration() => $lesson_time,
            $data->getUserMainId() => $trainer,
            $data->getUserMainName() => $rs_user[0][$userProfile->getName()],
            $data->getDescription() => 'Hadir',
                ), $data->getId() . EQUAL . $id);
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
