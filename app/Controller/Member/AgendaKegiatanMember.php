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
//        $userMain = new MasterUserMain();
        if ($_POST['per_page'] == "") {
            $Datatable->per_page = 5;
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

//        echo $Datatable->search;

        $whereList = $search;

        $list_data = $Datatable->select_pagination($data, $data->getEntity(), $whereList, null, null, null, null
                , null);
//        print_r($list_data);
        include_once FILE_PATH(IViewMemberConstant::ACTIVITY_LIST_VIEW_INDEX);
    }
    
    public function view(){
        $id = $_POST['id'];
        $db = new Database();
        $activityDetails = new TransactionActivityDetails();
        $activity = new TransactionActivity();
        $data_activity = $db->selectByID($activity, $activity->getId().EQUAL.$id);
        $data_activity_details = $db->selectByID($activityDetails, $activityDetails->getActivityId().EQUAL.$id);
//        print_r($data_activity_details);
        include_once FILE_PATH(IViewMemberConstant::ACTIVITY_VIEW_VIEW_INDEX);
    }
}
