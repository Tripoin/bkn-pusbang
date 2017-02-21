<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controller\Member;

/**
 * Description of AgendaKegiatanMember
 *
 * @author sfandrianah
 */
use app\Constant\IViewMemberConstant;
use app\Model\TransactionActivity;
use app\Model\TransactionActivityDetails;
use app\Model\SecurityUser;
use app\Model\SecurityUserProfile;
use app\Model\MasterUserMain;
use app\Model\MasterApproval;
use app\Model\MasterWaitingList;
use app\Util\DataTable;
use app\Util\Database;
use app\Util\Button;
use app\Util\Form;

class RegistrationActivity {

    //put your code here
    public function index() {
//        setActiveMenuMember('userprofile,changepassword');
        setTitle(' | ' . lang('member.registration_activity'));
        include_once FILE_PATH(IViewMemberConstant::REGISTRATION_ACTIVITY_VIEW_INDEX);
    }

    public function listData() {
        $Form = new Form();
        $Datatable = new DataTable();
        $Button = new Button();
        $db = new Database();
//        $group = new SecurityGroup();
        $data = new TransactionActivity();
//        $userMain = new MasterUserMain();
        if ($_POST['per_page'] == "") {
            $Datatable->per_page = 5;
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

        $whereList = $search;
        $list_data = $Datatable->select_pagination($data, $data->getEntity(), $whereList, null, null, null, null
                , null);


        $user = new SecurityUser();
        $userProfile = new SecurityUserProfile();
        $userMain = new MasterUserMain();


        $rs_user = $db->selectByID($user, $user->getCode() . "='" . $_SESSION[SESSION_USERNAME_GUEST] . "'");
        $rs_user_profile = $db->selectByID($userProfile, $userProfile->getUserId() . "='" . $rs_user[0][$user->getId()] . "'");
        $rs_user_main = $db->selectByID($userMain, $userMain->getUserProfileId() . "='" . $rs_user_profile[0][$userProfile->getId()] . "'");


        include_once FILE_PATH(IViewMemberConstant::REGISTRATION_ACTIVITY_LIST_VIEW_INDEX);
    }

    public function approved() {
        $id = $_POST['id'];
        $db = new Database();
        $waitingList = new MasterWaitingList();
        $user = new SecurityUser();
        $userProfile = new SecurityUserProfile();
        $userMain = new MasterUserMain();
        $masterApproval = new MasterApproval();


        $rs_user = $db->selectByID($user, $user->getCode() . "='" . $_SESSION[SESSION_USERNAME_GUEST] . "'");
        $rs_user_profile = $db->selectByID($userProfile, $userProfile->getUserId() . "='" . $rs_user[0][$user->getId()] . "'");
        $rs_user_main = $db->selectByID($userMain, $userMain->getUserProfileId() . "='" . $rs_user_profile[0][$userProfile->getId()] . "'");

        $rs_waiting_list = $db->selectByID($waitingList, $waitingList->getActivityId() . "='" . $id . "' AND " . $waitingList->getUserMainId() . EQUAL . "'" . $rs_user_main[0][$userMain->getId()] . "'");
        if (!empty($rs_waiting_list)) {
            echo toastAlert('error', lang('general.title_update_error'), "Data Ini Sudah di approve oleh user ini.");
        } else {
            if (!empty($rs_user_main)) {
                $db->connect();
                $db->insert($waitingList->getEntity(), array(
                    $waitingList->getCode() => createRandomBooking(),
                    $waitingList->getActivityId() => $id,
                    $waitingList->getUserMainId() => $rs_user_main[0][$userMain->getId()],
                    $waitingList->getCreatedOn() => date('Y-m-d h:i:s'),
                    $waitingList->getCreatedByUsername() => $_SESSION[SESSION_USERNAME_GUEST],
                ));
                $result = $db->getResult();


                if (is_numeric($result[0])) {
                    $code_approval = createRandomBooking();
                    $db->insert($masterApproval->getEntity(), array(
                        $masterApproval->getCode() => $code_approval,
                        $masterApproval->getName() => $code_approval.'-'.$_SESSION[SESSION_USERNAME_GUEST],
                        $masterApproval->getApprovalCategoryId() => 3,
                        $masterApproval->getApprovalDetailId() => $result[0],
                        $masterApproval->getStatus() => null,
                        $masterApproval->getCreatedByUsername() => $_SESSION[SESSION_USERNAME_GUEST],
                        $masterApproval->getCreatedOn() => date('Y-m-d h:i:s'),
                    ));
                    $result2 = $db->getResult();
                    if (is_numeric($result2[0])) {
                        echo toastAlert('success', lang('general.title_update_success'), lang('general.message_update_success'));
                    } else {
                        $db->delete($waitingList->getEntity(), $waitingList->getId().EQUAL.$result[0]);
                        echo toastAlert('error', lang('general.title_update_error'), lang('general.message_update_error'));
                    }
                } else {
                    echo toastAlert('error', lang('general.title_update_error'), lang('general.message_update_error'));
                }
            } else {
                echo toastAlert('error', lang('general.title_update_error'), lang('general.message_update_error'));
            }
        }
        echo '<div id="pageListActivity">';
        echo '<script>$(function () {postAjaxPaginationManual(\'pageListActivity\');});</script>';
        echo '</div>';
    }

}
