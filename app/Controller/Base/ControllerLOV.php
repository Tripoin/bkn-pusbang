<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controller\Base;

/**
 * Description of ControllerLOV
 *
 * @author sfandrianah
 */
use app\Constant\IViewConstant;
use app\Util\Form;
use app\Util\Button;
use app\Util\DataTable;

abstract class ControllerLOV {
    //put your code here
    
    public $dataLOV=array();
    
    public function setDataLOV($dataLOV){
        $this->dataLOV = $dataLOV;
    }
    
    public function index() {
        $dataLOV = $this->dataLOV;
        if (isset($_POST['search'])) {
            if(in_array($_POST['search'], array_keys($dataLOV))){
                $this->searchData($dataLOV[$_POST['search']]);
            }
        } else {
            $this->indexPage();
        }
    }
    
    public function indexPage() {
        $name = $_POST['name'];
        include_once FILE_PATH(IViewConstant::CRUD_LOV_VIEW_INDEX);
    }

    public function searchData($table) {
        $Form = new Form();
        $Datatable = new DataTable();
        $Button = new Button();
        $data = $table;
        if ($_POST['per_page'] == "") {
            $Datatable->per_page = 10;
        } else {
            $Datatable->per_page = $_POST['per_page'];
        }
        $Datatable->urlDeleteCollection(false);
        $Datatable->searchFilter(array("code" => lang("general.code"), "name" => lang("general.name")));
        $Datatable->current_page = $_POST['current_page'];
        if ($_POST['current_page'] == '') {
            $Datatable->current_page = 1;
        }
        $search = $_POST['search_pagination'];
        if ($_POST['search_by'] == '') {
            $search = $data->getEntity() . ".code LIKE  '%" . $search . "%'";
        } else if ($_POST['search_by'] == 'null') {
            $search = $data->getEntity() . ".code LIKE  '%" . $search . "%'";
        } else {
//            if (!empty($data->search($_POST['search_by']))) {
            $search = $data->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search . "%'";
//            }
        }
        $whereList = $search;
        $list_data = $Datatable->select_pagination($data, $data->getEntity(), $whereList, null, null, null, null
                , null);
        $searchData = $_POST['search'];
        include_once FILE_PATH(IViewConstant::CRUD_LOV_LIST_VIEW_INDEX);
    }

}
