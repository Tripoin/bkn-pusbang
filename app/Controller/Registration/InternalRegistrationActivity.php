<?php

namespace app\Controller\Registration;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InternalRegistrationActivity
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
use app\Model\SecurityRole;
use app\Model\SecurityUserProfile;
use app\Model\SecurityUser;
use app\Model\SecurityGroup;
use app\Util\Form;
use app\Util\DataTable;
use app\Util\Database;
use app\Util\Button;

class InternalRegistrationActivity extends Controller {

    //put your code here
    public $modelSubject;
    public $data_subject;
    public $data_curriculum;
    public $data_user;
    public $data_years;

    public function __construct() {
        $this->admin_theme_url = getAdminTheme();
        $this->modelData = new TransactionActivity();
        $this->setTitle(lang('general.registration_internal_activity'));
        $this->setBreadCrumb(array(lang('member.registration') => "", lang('general.registration_internal_activity') => FULLURL()));
        $this->search_filter = array(
            "subjectName" => lang('transaction.type'),
            "startActivity" => lang('transaction.excecution_time'),
            "quota" => lang('transaction.number_of_participants')
        );
        $this->orderBy = $this->modelData->getId() . " DESC ";
        $this->indexUrl = IURLConstant::REGISTRATION_INTERNAL_ACTIVITY_INDEX_URL;
        $this->viewPath = IViewConstant::REGISTRATION_INTERNAL_ACTIVITY_VIEW_INDEX;
        $this->unsetAutoData = array('description');
        $this->autoData = false;
        $this->setAutoCrud();
        parent::__construct();
    }

    public function dataYears($plus) {
        $array = array();
        $StaringDate = date('Y-m-d');
        for ($no = 0; $no <= $plus; $no++) {
            $oneYearOn = date("Y", strtotime(date("Y-m-d", strtotime($StaringDate)) . " +" . $no . " year"));
//            echo $oneYearOn;
            $array[] = array("id" => $oneYearOn, "label" => $oneYearOn);
        }
        return $array;
    }

    public function listAssignment($activity) {
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
            $sr = $userMain->search($_POST['search_by']);
            if (!empty($sr)) {
                $search = " AND " . $userMain->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search . "%'";
            }
        }

//        echo $Datatable->search;

        $whereList = $data->getEntity() . DOT . $data->getUser_main_id() . EQUAL . $userMain->getEntity() . DOT . $userMain->getId()
                . " AND " . $data->getEntity() . "." . $data->getRoleId() . EQUAL . 1
                . " AND " . $data->getEntity() . "." . $data->getActivity_id() . EQUAL . $activity
                . " AND " . $userMain->getEntity() . "." . $userMain->getId() . EQUAL . $data->getUser_main_id()
                . $search;

        $list_data = $Datatable->select_pagination($data, $data->getEntity(), $whereList, $userMain->getEntity(), $userMain->getEntity(), null, ""
                . $data->getEntity() . "." . $data->getId() . " as id,"
                . $userMain->getEntity() . "." . $userMain->getCode() . " as code,"
                . $data->getEntity() . "." . $data->getDescription() . " as description,"
                . $userMain->getEntity() . "." . $userMain->getName() . " as name", $data->getEntity() . "." . $data->getId());
//        print_r($list_data);
        include_once FILE_PATH(IViewConstant::REGISTRATION_INTERNAL_ACTIVITY_VIEW_INDEX . '/assignment/list.html.php');
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
        $securityRole = new SecurityRole();


        $data_role = $db->selectByID($securityRole, $securityRole->getCode() . equalToIgnoreCase('PARTICIPANT'));
        $whereList = $data->getEntity() . "." . $data->getUser_main_id() . EQUAL . $userMain->getEntity() . DOT . $userMain->getId()
                . " AND " . $data->getEntity() . "." . $data->getActivity_id() . EQUAL . $activity
                . " AND " . $data->getEntity() . "." . $data->getRoleId() . EQUAL . $data_role[0][$securityRole->getId()]
                . " AND " . $userMain->getEntity() . "." . $userMain->getId() . EQUAL . $data->getUser_main_id()
                . $search;

        $list_data = $Datatable->select_pagination($data, $data->getEntity(), $whereList, $userMain->getEntity(), $userMain->getEntity(), null, ""
                . $data->getEntity() . "." . $data->getId() . " as id,"
                . $userMain->getEntity() . "." . $userMain->getId() . " as user_main_id,"
                . $userMain->getEntity() . "." . $userMain->getCode() . " as code,"
                . $data->getEntity() . "." . $data->getDescription() . " as description,"
                . $userMain->getEntity() . "." . $userMain->getName() . " as name", $data->getEntity() . "." . $data->getId());
//        print_r($list_data);
        include_once FILE_PATH(IViewConstant::REGISTRATION_INTERNAL_ACTIVITY_VIEW_INDEX . '/peserta/list.html.php');
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
        include_once FILE_PATH(IViewConstant::REGISTRATION_INTERNAL_ACTIVITY_VIEW_INDEX . '/peserta/view.html.php');
    }

    public function createAssignment($activity) {
        $Form = new Form();
        $id = 0;
        include_once FILE_PATH(IViewConstant::REGISTRATION_INTERNAL_ACTIVITY_VIEW_INDEX . '/assignment/create.html.php');
    }

    public function editAssignment($activity) {
        $Form = new Form();
        $id = $_POST['id'];
        include_once FILE_PATH(IViewConstant::REGISTRATION_INTERNAL_ACTIVITY_VIEW_INDEX . '/assignment/create.html.php');
    }

    public function listUserAssignment($activity) {
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
        include_once FILE_PATH(IViewConstant::REGISTRATION_INTERNAL_ACTIVITY_VIEW_INDEX . '/assignment/list-user.html.php');
    }

    public function saveAssignment($activity) {
        $data = new MasterUserAssignment();
        $masterUserMain = new MasterUserMain();
        $db = new Database();
        $securityRole = new SecurityRole();


        $data_role = $db->selectByID($securityRole, $securityRole->getCode() . equalToIgnoreCase('PARTICIPANT'));
        $data_user_main = $db->selectByID($masterUserMain, $masterUserMain->getId() . equalToIgnoreCase($_POST['id']));
        $db->connect();
        $db->insert($data->getEntity(), array(
            $data->getCode() => createRandomBooking(),
            $data->getName() => $data_user_main[0][$masterUserMain->getName()],
            $data->getActivity_id() => $activity,
            $data->getRoleId() => $data_role[0][$securityRole->getId()],
            $data->getUser_main_id() => $_POST['id'],
            $data->getDescription() => 'Hadir',
            $data->getStatus() => 1,
            $data->getCreatedByUsername() => $_SESSION[SESSION_ADMIN_USERNAME],
            $data->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT)
        ));
        $result = $db->getResult();
        if (is_numeric($result[0])) {
            echo toastAlert('success', 'Add Peserta Success', 'Data Has been Added Successfully');
        } else {
            echo toastAlert('error', 'Add Peserta Error', 'Data Has been Added Failed');
        }
//        print_r($db->getResult());
        echo '<script>$(function(){$(\'#myModal_self\').modal(\'hide\');postAjaxPagination();});</script>';
    }

    public function updateAssignment($activity) {
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
            echo toastAlert('success', 'Update Peserta Success', 'Data Has been Update Successfully');
        } else {
            echo toastAlert('error', 'Update Peserta Error', 'Data Has been Update Failed');
        }
//        print_r($db->getResult());
        echo '<script>$(function(){$(\'#myModal_self\').modal(\'hide\');postAjaxPagination();});</script>';
    }

    public function deleteAssignment() {
        $id = $_POST['id'];
        $Form = new Form();
        $db = new Database();
        $data = new MasterUserAssignment();
        $db->connect();
        $get_data = $db->delete($data->getEntity(), $data->getId() . EQUAL . $id);
        echo $get_data;
    }

    public function deleteCollectionAssignment() {
        $id = $_POST['id'];
        $Form = new Form();
        $db = new Database();
        $data = new MasterUserAssignment();
        $db->connect();
        $where = $data->getId() . " IN (" . $id . ")";
        $delete_data = $db->delete($data->getEntity(), $where);
        echo $delete_data;
    }

    public function listData() {
        $this->modelSubject = new MasterSubject();
        $sr = $this->modelSubject->search($_POST['search_by']);
        if (empty($sr)) {
            $_POST['search_by'] = "";
            $_POST['search_pagination'] = "";
        }
        parent::listData();
    }

}
