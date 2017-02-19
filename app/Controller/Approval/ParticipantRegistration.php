<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Approval -> ParticipantRegistration
 * @email : sfandrianah2@gmail.com
 * @author Syahrial Fandrianah
 * @FRAMEWORK NATIVE ADMIN TEMPLATE V.1.0
 */

namespace app\Controller\Approval;

use app\Controller\Base\Controller;
use app\Model\MasterApproval;
use app\Model\MasterApprovalCategory;
use app\Constant\IURLConstant;
use app\Constant\IViewConstant;
use app\Util\Form;
use app\Util\DataTable;
use app\Util\Database;
use app\Util\Button;

//use app\Util\Form;

class ParticipantRegistration extends Controller {

    //put your code here

    public function __construct() {
        $this->modelData = new MasterApproval();
        $this->setTitle(lang('approval.approval_participant_registration'));
        $this->setBreadCrumb(array(lang('approval.approval') => "", lang('approval.approval_participant_registration') => URL()));
        $this->search_filter = array(
            "code" => lang('general.code'),
            "created_by" => lang('approval.user')
        );
        $this->indexUrl = IURLConstant::APPROVAL_PARTICIPANT_REGISTRATION_INDEX_URL;
        $this->viewPath = IViewConstant::APPROVAL_PARTICIPANT_REGISTRATION_VIEW_INDEX;
        $this->setAutoCrud();
        parent::__construct();
    }

    public function listData() {
        $Form = new Form();
        $Datatable = new DataTable();
        $Button = new Button();
        $db = new Database();
//        $group = new SecurityGroup();
        $data = $this->modelData;
        $masterApproval = new MasterApproval();
        $masterApprovalCategory = new MasterApprovalCategory();
        if ($_POST['per_page'] == "") {
            $Datatable->per_page = 5;
        } else {
            $Datatable->per_page = $_POST['per_page'];
        }

//        }
        $Datatable->urlDeleteCollection($this->urlDeleteCollection);
        $Datatable->searchFilter($this->search_filter);
        $Datatable->createButton(FALSE);
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
            $search = " AND " . $masterApproval->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search . "%'";
        }

//        echo $Datatable->search;

        $whereList = $masterApprovalCategory->getEntity() . DOT . $masterApprovalCategory->getId() . EQUAL . $masterApproval->getEntity().DOT.$masterApproval->getApprovalCategoryId() . $search;

        $list_data = $Datatable->select_pagination($masterApproval, $masterApproval->getEntity(), $whereList, $masterApprovalCategory->getEntity(), $masterApprovalCategory->getEntity(), $this->orderBy, ""
                . $masterApproval->getEntity() . DOT . $masterApproval->getId() . " as id,"
                . $masterApproval->getEntity() . DOT . $masterApproval->getCode() . " as code,"
                . $masterApproval->getEntity() . DOT . $masterApproval->getCreatedByUsername() . " as username,"
                . $masterApproval->getEntity() . DOT . $masterApproval->getCreatedOn() . " as created_on,"
                . $masterApproval->getEntity() . DOT . $masterApproval->getIsExecuted() . " as excecuted,"
                . $masterApproval->getEntity() . DOT . $masterApproval->getStatus() . " as status,"
                . $masterApprovalCategory->getEntity() . "." . $masterApprovalCategory->getName() . " as approval_category_name", $masterApproval->getEntity() . "." . $masterApproval->getId());
//        print_r($list_data);
        include_once FILE_PATH($this->viewList);
    }

    public function edit() {
        parent::edit();
    }

    public function create() {
        $this->setChangevalueNewEdit(array(
            $this->modelData->getImg() => Form()->id('img')->title('Image Url')->getInputMedia(),
        ));
        parent::create();
    }

}
