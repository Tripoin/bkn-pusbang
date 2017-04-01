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
use app\Model\MasterUserAssignment;
use app\Model\SecurityRole;
use app\Model\TransactionActivity;
use app\Model\TransactionActivityDetails;
use app\Util\DataTable;
use app\Util\Database;
use app\Util\Button;
use app\Util\Form;

class AgendaKegiatanMember {
    //put your code here
    public function index() {
//        setActiveMenuMember('userprofile,changepassword');
        setTitle(' | ' . lang('member.agenda_activity'));
        include_once FILE_PATH(IViewMemberConstant::ACTIVITY_VIEW_INDEX);
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
        if ($_POST['per_page'] == "") {
            $Datatable->per_page = 10;
        } else {
            $Datatable->per_page = $_POST['per_page'];
        }
        $Datatable->urlDeleteCollection(false);
        $Datatable->searchFilter(array("start_activity"=>lang("member.year")));
        $Datatable->current_page = $_POST['current_page'];
        if ($_POST['current_page'] == '') {
            $Datatable->current_page = 1;
        }

        $search = $_POST['search_pagination'];
        if ($_POST['search_by'] == '') {
            $search = "  " . $data->getEntity() . ".start_activity LIKE  '%" . $search . "%'";
        } else if ($_POST['search_by'] == 'null') {
            $search = "  " . $data->getEntity() . ".start_activity LIKE  '%" . $search . "%'";
        } else {
            $search = "  " . $data->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search . "%'";
        }

        $userMember = getUserMember()["mst_user_main"];

        $whereList =
            $userAssignment->getEntity() . "." . $userAssignment->getActivity_id() . EQUAL . $data->getEntity() . "." . $data->getId() . " AND " .
            $userAssignment->getEntity() . "." . $userAssignment->getRoleId() . EQUAL . $secRole->getEntity() . "." . $secRole->getId() . " AND " .
            $userAssignment->getEntity() . "." . $userAssignment->getUser_main_id() . EQUAL . $userMember["id"] . " AND " .
            $secRole->getEntity()        . "." . $secRole->getCode() . equalToIgnoreCase("PARTICIPANT");
        $whereList = $whereList . " AND " . $search;

        $list_data = $Datatable->select_pagination($data, $data->getEntity(), $whereList, array($userAssignment->getEntity(), $secRole->getEntity()),
            null, null, $data->getEntity().'.*', null);
        //print_r($list_data);
        include_once FILE_PATH(IViewMemberConstant::ACTIVITY_LIST_VIEW_INDEX);
    }
    
    public function view(){
        $id = $_POST['id'];
        $db = new Database();
        $activityDetails = new TransactionActivityDetails();
        $activity = new TransactionActivity();
        $data_activity = $db->selectByID($activity, $activity->getId().EQUAL.$id);
        $data_activity_details = $db->selectByID($activityDetails, $activityDetails->getActivityId().EQUAL.$id);

        include_once FILE_PATH(IViewMemberConstant::ACTIVITY_VIEW_VIEW_INDEX);
    }
}
