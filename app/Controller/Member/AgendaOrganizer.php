<?php

namespace app\Controller\Member;

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
use app\Model\SecurityRole;
use app\Model\TransactionActivity;
use app\Model\TransactionActivityDetails;
use app\Constant\IURLMemberConstant;
use app\Constant\IViewMemberConstant;
use app\Model\MasterApproval;
use app\Model\MasterApprovalCategory;
use app\Model\MasterWaitingList;
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
use app\Model\MasterGovernmentClassification;
use app\Model\SecurityUserProfile;
use app\Model\SecurityUser;
use app\Model\SecurityGroup;
use app\Util\Form;
use app\Util\DataTable;
use app\Util\Database;
use app\Util\Button;

class AgendaOrganizer {

    //put your code here
    public $modelSubject;
    public $data_subject;
    public $data_curriculum;
    public $data_user;
    public $search_filter;

    public function __construct() {
        $this->search_filter = array("code" => lang('general.code'), "name" => lang('general.name'));
    }

    public function index() {
        setTitle(' | ' . lang('member.agenda_organizer'));
        include_once FILE_PATH(IViewMemberConstant::AGENDA_ORGANIZER_VIEW_INDEX);
    }

    public function listData() {
        $Form = new Form();
        $Datatable = new DataTable();
        $Button = new Button();
        $db = new Database();
//        $group = new SecurityGroup();
        $data = new TransactionActivity();
        $userAssignment = new MasterUserAssignment();
        $secRole = new SecurityRole();
//        $userMain = new MasterUserMain();
        if ($_POST['per_page'] == "") {
            $Datatable->per_page = 10;
        } else {
            $Datatable->per_page = $_POST['per_page'];
        }
        $Datatable->urlDeleteCollection(false);
        $Datatable->searchFilter(array("start_activity" => lang("member.year")));
        $Datatable->current_page = $_POST['current_page'];
        if ($_POST['current_page'] == '') {
            $Datatable->current_page = 1;
        }
        $search = $_POST['search_pagination'];
        if ($_POST['search_by'] == '') {
            $search = $data->getEntity() . ".start_activity LIKE  '%" . $search . "%'";
        } else if ($_POST['search_by'] == 'null') {
            $search = $data->getEntity() . ".start_activity LIKE  '%" . $search . "%'";
        } else {
            $search = $data->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search . "%'";
        }

        $userMember = getUserMember()["mst_user_main"];

        $whereList =
            $userAssignment->getEntity() . "." . $userAssignment->getActivity_id() . EQUAL . $data->getEntity() . "." . $data->getId() . " AND " .
            $userAssignment->getEntity() . "." . $userAssignment->getRoleId() . EQUAL . $secRole->getEntity() . "." . $secRole->getId() . " AND " .
            $userAssignment->getEntity() . "." . $userAssignment->getUser_main_id() . EQUAL . $userMember["id"] . " AND " .
            $secRole->getEntity()        . "." . $secRole->getCode() . equalToIgnoreCase("ORGANIZER");
        $whereList = $whereList . " AND " . $search;

        $list_data = $Datatable->select_pagination($data, $data->getEntity(), $whereList, array($userAssignment->getEntity(), $secRole->getEntity()),
            null, null, $data->getEntity().'.*', null);


        $user = new SecurityUser();
        $userProfile = new SecurityUserProfile();
        $userMain = new MasterUserMain();


        $rs_user = $db->selectByID($user, $user->getCode() . "='" . $_SESSION[SESSION_USERNAME_GUEST] . "'");
        $rs_user_profile = $db->selectByID($userProfile, $userProfile->getUserId() . "='" . $rs_user[0][$user->getId()] . "'");
        $rs_user_main = $db->selectByID($userMain, $userMain->getUserProfileId() . "='" . $rs_user_profile[0][$userProfile->getId()] . "'");


        include_once FILE_PATH(IViewMemberConstant::AGENDA_ORGANIZER_LIST_VIEW_INDEX);
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
//        $Datatable->urlDeleteCollection($this->urlDeleteCollection);
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

//        echo $Datatable->search;

        $whereList = $data->getEntity() . "." . $data->getActivity_id() . EQUAL . $activity . " AND " .
                $userMain->getEntity() . "." . $userMain->getId() . EQUAL . $data->getUser_main_id() . $search;

        $list_data = $Datatable->select_pagination($data, $data->getEntity(), $whereList, $userMain->getEntity(), $userMain->getEntity(), null, ""
                . $data->getEntity() . "." . $data->getId() . " as id,"
                . $userMain->getEntity() . "." . $userMain->getCode() . " as code,"
                . $data->getEntity() . "." . $data->getDescription() . " as description,"
                . $userMain->getEntity() . "." . $userMain->getName() . " as name", $data->getEntity() . "." . $data->getId());

        include_once FILE_PATH(IViewMemberConstant::AGENDA_ORGANIZER_VIEW . '/assignment/list.html.php');
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
//        $Datatable->urlDeleteCollection($this->urlDeleteCollection);
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
            if (!in_array($_POST['search_by'], array_keys($this->search_filter))) {
                $_POST['search_by'] = 'code';
            }
            $search = " AND " . $userMain->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search . "%'";
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

        $modelActivity = new TransactionActivity();
        $data_activity = $db->selectByID($modelActivity, $modelActivity->getId() . EQUAL . $activity);

//        print_r($list_data);
        include_once FILE_PATH(IViewMemberConstant::AGENDA_ORGANIZER_VIEW . '/peserta/list.html.php');
    }

    public function view($activity) {
        $Form = new Form();
        $Datatable = new DataTable();
        $Button = new Button();
        $db = new Database();
//        $group = new SecurityGroup();

        $masterApproval = new MasterApproval();
        $masterApprovalCategory = new MasterApprovalCategory();
        $transactionActivity = new TransactionActivity();
        $transactionActivityDetails = new TransactionActivityDetails();
        $masterWaitingList = new MasterWaitingList();

        if ($_POST['per_page'] == "") {
            $Datatable->per_page = 10;
        } else {
            $Datatable->per_page = $_POST['per_page'];
        }

//        }
//        $Datatable->urlDeleteCollection($this->urlDeleteCollection);
        $Datatable->searchFilter($this->search_filter);
        $Datatable->current_page = $_POST['current_page'];
        if ($_POST['current_page'] == '') {
            $Datatable->current_page = 1;
        }
        $search = $_POST['search_pagination'];
        if ($_POST['search_by'] == '') {
            $search = " AND " . $masterApproval->getEntity() . ".code LIKE  '%" . $search . "%'";
        } else if ($_POST['search_by'] == 'null') {
            $search = " AND " . $masterApproval->getEntity() . ".code LIKE  '%" . $search . "%'";
        } else {
            if (!in_array($_POST['search_by'], array_keys($this->search_filter))) {
                $_POST['search_by'] = 'code';
            }
            $search = " AND " . $masterApproval->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search . "%'";
        }
//$Datatable->debug(true);
//        echo $Datatable->search;

        $whereList = $masterApproval->getEntity() . "." . $masterApproval->getApprovalCategoryId() . EQUAL . "3" . " AND " .
                $masterWaitingList->getEntity() . DOT . $masterWaitingList->getId() . EQUAL . $masterApproval->getEntity() . "." . $masterApproval->getApprovalDetailId() . " AND " .
                $masterApproval->getEntity() . "." . $masterApproval->getApprovalCategoryId() . EQUAL . $masterApprovalCategory->getEntity() . DOT . $masterApprovalCategory->getId() . " AND " .
                $masterWaitingList->getActivityId() . EQUAL . $activity .
                $search . " GROUP BY " . $masterWaitingList->getEntity() . "." . $masterWaitingList->getActivityId();

        $list_data = $Datatable->select_pagination($masterApproval, $masterApproval->getEntity(), $whereList, array($masterWaitingList->getEntity(), $masterApprovalCategory->getEntity()), $masterWaitingList->getEntity(), null, ""
                . $masterApproval->getEntity() . "." . $masterApproval->getId() . ","
                . $masterWaitingList->getEntity() . "." . $masterWaitingList->getId() . " as waiting_list_id,"
                . $masterApproval->getEntity() . "." . $masterApproval->getCode() . ","
                . $masterApprovalCategory->getEntity() . "." . $masterApprovalCategory->getName() . ","
                . $masterApproval->getEntity() . "." . $masterApproval->getCreatedByUsername() . ","
                . $masterApproval->getEntity() . "." . $masterApproval->getStatus() . ","
                . $masterWaitingList->getEntity() . "." . $masterWaitingList->getUserMainId() . ","
                . $masterApproval->getEntity() . "." . $masterApproval->getCreatedOn() . "", $masterWaitingList->getEntity() . "." . $masterWaitingList->getActivityId());

//        print_r($list_data);
        $modelActivity = new TransactionActivity();
        $data_activity = $db->selectByID($modelActivity, $modelActivity->getId() . EQUAL . $activity);

//        print_r($list_data);
        include_once FILE_PATH(IViewMemberConstant::AGENDA_ORGANIZER_VIEW . '/approval/list.html.php');
    }

    public function approveData($activity_id) {
        $id = $_POST['id'];
        $userMainId = $_POST['user_main_id'];
        $masterWaitingList = new MasterWaitingList();
        $masterApproval = new MasterApproval();
        $masterUserAssignment = new MasterUserAssignment();
        $db = new Database();
        $db->connect();
        $db->update($masterWaitingList->getEntity(), array(
            $masterWaitingList->getApprovedBy() => $_SESSION[SESSION_USERNAME_GUEST],
            $masterWaitingList->getIsApproved() => 1,
            $masterWaitingList->getApprovedOn() =>  date(DATE_FORMAT_PHP_DEFAULT),
                ), $masterWaitingList->getId() . EQUAL . $id);
        $result = $db->getResult();
        if ($result[0] == 1) {
            $db->update($masterApproval->getEntity(), array(
                $masterApproval->getStatus() => 1,
                $masterApproval->getModifiedByUsername() => $_SESSION[SESSION_USERNAME_GUEST],
                $masterApproval->getModifiedOn() =>  date(DATE_FORMAT_PHP_DEFAULT),
                    ), $masterApproval->getApprovalDetailId() . EQUAL . $id . " AND " . $masterApproval->getApprovalCategoryId() . EQUAL . "3");
//            echo $db->getSql();
            $result_2 = $db->getResult();
//            print_r($result_2);
            if ($result_2[0] == 1) {
                $code_user_assignment = createRandomBooking();
                $db->insert($masterUserAssignment->getEntity(), array(
                    $masterUserAssignment->getCode() => $code_user_assignment,
                    $masterUserAssignment->getName() => $code_user_assignment . '-' . $_SESSION[SESSION_USERNAME_GUEST],
                    $masterUserAssignment->getUser_main_id() => $userMainId,
                    $masterUserAssignment->getActivity_id() => $activity_id,
                    $masterUserAssignment->getCreatedByUsername() => $_SESSION[SESSION_USERNAME_GUEST],
                    $masterUserAssignment->getCreatedOn() =>  date(DATE_FORMAT_PHP_DEFAULT),
                ));
                $result_3 = $db->getResult();
                if (is_numeric($result_3[0])) {
                    echo toastAlert('success', lang('general.title_approved_success'), lang('general.message_approved_success'));
                    echo '<script>$(function () {viewAgendaOrganizer(\'' . $activity_id . '\');});</script>';
                } else {
                    $db->update($masterApproval->getEntity(), array(
                        $masterApproval->getStatus() => null,
                        $masterApproval->getModifiedByUsername() => null,
                        $masterApproval->getModifiedOn() => null,
                            ), $masterApproval->getApprovalDetailId() . EQUAL . $id . " AND " . $masterApproval->getApprovalCategoryId() . EQUAL . "3");
                    echo toastAlert('error', lang('general.title_approved_error'), lang('general.message_approved_error'));
                    echo '<script>$(function () {postAjaxEdit(\'' . URL(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/view/' . $activity_id . '/detail') . '\',\'id=' . $userMainId . '&waiting_list_id=' . $id . '\');});</script>';
                }
            } else {
                echo toastAlert('error', lang('general.title_approved_error'), lang('general.message_approved_error'));
                echo '<script>$(function () {postAjaxEdit(\'' . URL(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/view/' . $activity_id . '/detail') . '\',\'id=' . $userMainId . '&waiting_list_id=' . $id . '\');});</script>';
            }
        } else {
            echo toastAlert('error', lang('general.title_approved_error'), lang('general.message_approved_error'));
            echo '<script>$(function () {postAjaxEdit(\'' . URL(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/view/' . $activity_id . '/detail') . '\',\'id=' . $userMainId . '&waiting_list_id=' . $id . '\');});</script>';
        }
    }

    public function rejectData($activity_id) {
        $id = $_POST['id'];
        $userMainId = $_POST['user_main_id'];
        $message = $_POST['message'];
        $masterWaitingList = new MasterWaitingList();
        $masterApproval = new MasterApproval();
//        $masterUserAssignment = new MasterUserAssignment();
        $db = new Database();
        $db->connect();
        $db->update($masterWaitingList->getEntity(), array(
            $masterWaitingList->getApprovedBy() => $_SESSION[SESSION_USERNAME_GUEST],
            $masterWaitingList->getIsApproved() => 0,
            $masterWaitingList->getApprovedMessage() => $message,
            $masterWaitingList->getApprovedOn() =>  date(DATE_FORMAT_PHP_DEFAULT),
                ), $masterWaitingList->getId() . EQUAL . $id);
        $result = $db->getResult();
        if ($result[0] == 1) {
            $db->update($masterApproval->getEntity(), array(
                $masterApproval->getStatus() => 0,
                $masterApproval->getModifiedByUsername() => $_SESSION[SESSION_USERNAME_GUEST],
                $masterApproval->getModifiedOn() =>  date(DATE_FORMAT_PHP_DEFAULT),
                    ), $masterApproval->getApprovalDetailId() . EQUAL . $id . " AND " . $masterApproval->getApprovalCategoryId() . EQUAL . "3");
//            echo $db->getSql();
            $result_2 = $db->getResult();
//            print_r($result_2);
            if ($result_2[0] == 1) {
                echo toastAlert('success', lang('general.title_rejected_success'), lang('general.message_rejected_success'));
                echo '<script>$(function () {$(\'#myModal_self\').modal(\'hide\');viewAgendaOrganizer(\'' . $activity_id . '\');});</script>';
            } else {
                echo toastAlert('error', lang('general.title_rejected_error'), lang('general.message_rejected_error'));
                echo '<script>$(function () {postAjaxEdit(\'' . URL(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/view/' . $activity_id . '/detail') . '\',\'id=' . $userMainId . '&waiting_list_id=' . $id . '\');});</script>';
            }
        } else {
            echo toastAlert('error', lang('general.title_rejected_error'), lang('general.message_rejected_error'));
            echo '<script>$(function () {postAjaxEdit(\'' . URL(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/view/' . $activity_id . '/detail') . '\',\'id=' . $userMainId . '&waiting_list_id=' . $id . '\');});</script>';
        }
    }

    public function rejectDetail($activity_id) {
        echo '<form role="form" id="form-message-reject" class="signup" action="#" onsubmit="return false;" method="POST" novalidate="novalidate">';
        echo Form()->id('message')->title(lang('member.rejection_notes'))->placeholder('Tulis Alasan Penolakan')->textarea();
        echo Button()->icon('fa fa-times')
                ->setClass('btn btn-warning')
                ->alertBtnMsg(lang('member.yes'))
                ->alertMsg(lang('member.notif_rejected_candidates'))
                ->alertTitle(lang('general.reject'))
                ->onClick('postAjaxByAlertFormManual(this,\'' . URL(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/view/' . $activity_id . '/reject') . '\',\'form-message-reject\',\'id=' . $_POST['id'] . '&user_main_id=' . $_POST['user_main_id'] . '\')')
                ->label(lang('general.reject'))->buttonManual();
        echo '</form>';

        echo '<script>$(function(){$(\'#modal-title-self\').html(\'' . lang('member.detail_approved_reject_candidates') . " | " . lang('member.rejection_notes') . '\')});</script>';
    }

    public function detailApproval($activity_id) {
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
//        print_r($dt_activity);
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
        include_once FILE_PATH(IViewMemberConstant::AGENDA_ORGANIZER_VIEW . '/approval/view.html.php');
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
        include_once FILE_PATH(IViewMemberConstant::AGENDA_ORGANIZER_VIEW . '/peserta/view.html.php');
    }

    public function createPanitia($activity) {
        $Form = new Form();
        $id = 0;
        include_once FILE_PATH(IViewMemberConstant::AGENDA_ORGANIZER_VIEW . '/assignment/create.html.php');
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
        $userAssignment = new MasterUserAssignment();
        $whereList = ""
            . $userMain->getEntity() . "." . $userMain->getUser_profile_id() . EQUAL . $userProfile->getEntity() . "." . $userProfile->getId() . " AND "
            . $userProfile->getEntity() . "." . $userProfile->getUserId() . EQUAL . $user->getEntity() . "." . $user->getId() . " AND "
            . $user->getEntity() . "." . $user->getGroupId() . EQUAL . $group->getEntity() . "." . $group->getId() . " AND "
            . $group->getEntity() . "." . $group->getCode() . EQUAL . "'INTERNAL'";
        $db->connect();
        $db->select($userMain->getEntity(), $userMain->getEntity() . "." . $userMain->getId() . "," . $userProfile->getEntity() . "." . $userProfile->getName(),
            array(
                $user->getEntity(),
                $userProfile->getEntity(),
                $group->getEntity()
            ),
            $whereList);
        $rs_user = $db->getResult();

        $this->data_user = convertJsonCombobox($rs_user, $userMain->getId(), $userProfile->getName());
        include_once FILE_PATH(IViewMemberConstant::AGENDA_ORGANIZER_VIEW . '/details/create.html.php');
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
        $db->select($userMain->getEntity(), $userMain->getEntity() . "." . $userMain->getId() . "," . $userProfile->getEntity() . "." . $userProfile->getName(),
            array(
                $user->getEntity(),
                $userProfile->getEntity(),
                $group->getEntity()
            ),
            $whereList);
        $rs_user = $db->getResult();

        $get_data = $db->selectByID($activityDetails, $activityDetails->getId() . EQUAL . $id);

        $this->data_user = convertJsonCombobox($rs_user, $userMain->getId(), $userProfile->getName());
        include_once FILE_PATH(IViewMemberConstant::AGENDA_ORGANIZER_VIEW . '/details/create.html.php');
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
            $Datatable->per_page = 10;
        } else {
            $Datatable->per_page = $_POST['per_page'];
        }

//        }
//        $Datatable->urlDeleteCollection($this->urlDeleteCollection);
        $arrayFilter = array("code" => lang('general.code'), "name" => lang('general.name'));
        $Datatable->searchFilter($arrayFilter);
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
//            print_r(array_keys($arrayFilter));
            if (!in_array($_POST['search_by'], array_keys($arrayFilter))) {
                $_POST['search_by'] = 'code';
            }
            $search = " AND " . $activityDetails->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search . "%'";
        }

//        echo $Datatable->search;
        $whereList = $activityDetails->getEntity() . "." . $activityDetails->getActivityId() . EQUAL . $activity . " AND " .
                $activityModel->getEntity() . "." . $activityModel->getId() . EQUAL . $activityDetails->getEntity() . "." . $activityDetails->getActivityId() . $search;
//    $Datatable->debug(true);
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

//        print_r($list_data);
        $modelActivity = new TransactionActivity();
        $data_activity = $db->selectByID($modelActivity, $modelActivity->getId() . EQUAL . $activity);
        include_once FILE_PATH(IViewMemberConstant::AGENDA_ORGANIZER_VIEW . '/details/list.html.php');
    }

    public function editPanitia($activity) {
        $Form = new Form();
        $id = $_POST['id'];
        include_once FILE_PATH(IViewMemberConstant::AGENDA_ORGANIZER_VIEW . '/assignment/create.html.php');
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
//        $Datatable->urlDeleteCollection($this->urlDeleteCollection);
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
        include_once FILE_PATH(IViewMemberConstant::AGENDA_ORGANIZER_VIEW . '/assignment/list-user.html.php');
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

}
