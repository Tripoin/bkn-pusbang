<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controller\Base;

/**
 * Description of Controller
 *
 * @author sfandrianah
 */
use app\Util\Form;
use app\Util\DataTable;
use app\Util\Database;
use app\Util\Button;
use app\Constant\IViewConstant;
use app\Constant\IRestCommandConstant;
use app\Controller\Base\IController;
use app\Util\RestClient\TripoinRestClient;
use app\Model\Auditrail;

abstract class ControllerRestUI implements IController {

    //put your code here

    public $indexUrl = '';
    public $editUrl = '';
    public $deleteUrl = '';
    public $updateUrl = '';
    public $insertUrl = '';
    public $viewIndex = IViewConstant::CRUD_VIEW_INDEX;
    public $viewPath = '';
    public $viewList = '';
    public $viewCreate = '';
    public $viewEdit = '';
    public $urlDeleteCollection = '';
    public $search_by = '';
    public $select_entity = null;
    public $search_filter = array();
    public $where_list = null;
    public $search_list = null;
    public $join_list = null;
    public $modelData;
    public $orderBy = null;
    public $per_page = 10;
    public $auditrail = true;
    public $restURL = '';
    public $url_api;
    public $autoData = false;
    public $listAutoData = array();
    public $unsetAutoData = array();
    public $issetAutoData = array();
    public $result = '';
    public $list_parameter = false;
    public $param_body = array();

    public function __construct() {
        if (empty($this->search_filter)) {
            $this->search_filter = array(
                "code" => lang('general.code'),
                "name" => lang('general.name')
            );
        }
        $this->url_api = URL_REST . IRestCommandConstant::API . SLASH . IRestCommandConstant::VERSI . SLASH;
    }

    function listWithParameter($value = false) {
        $this->list_parameter = $value;
    }

    public function setBreadCrumb($breadcrumb = array()) {
        setBreadCrumb($breadcrumb);
    }

    public function setTitle($title) {
        setTitle($title);
        setTitleBody($title);
    }

    public function setSubtitle($subtitle) {
        setSubtitleBody($subtitle);
    }

    public function index() {
        $Form = new Form();
        $Datatable = new DataTable();
        $data = $this->modelData;

//        $group = new SecurityGroup();
        include_once FILE_PATH($this->viewIndex);
    }

    public function save() {
        $this->url_api = URL_REST . IRestCommandConstant::API . SLASH . IRestCommandConstant::VERSI . SLASH;
        $tripoinRestClient = new TripoinRestClient();
        $url = $this->url_api . $this->restURL . SLASH . IRestCommandConstant::COMMAND_STRING . EQUAL . IRestCommandConstant::INSERT_SINGLE_DATA;
        $result = $tripoinRestClient->doPOST($url, array(), array(), $_POST);
        //        print_r(json_decode($result->getBody));
        if (is_numeric(json_decode($result->getBody)) > 0) {
            echo toastAlert("success", lang('general.title_insert_success'), lang('general.message_insert_success'));
            echo '<script>$(function(){postAjaxPagination()});</script>';
        } else {
//            echo toastAlert("error", lang('general.title_insert_error'), lang('general.message_insert_error'));
            echo toastAlert("error", lang('general.title_insert_error'), lang('error.' . json_decode($result->getBody)));
            echo '<script>$(function(){postAjaxPagination()});</script>';
//            echo resultPageMsg('danger', lang('general.title_insert_error'), $rs[0]);
        }
    }

    public function update() {
        $this->url_api = URL_REST . IRestCommandConstant::API . SLASH . IRestCommandConstant::VERSI . SLASH;
//        print_r($db->getResult());
        $tripoinRestClient = new TripoinRestClient();
        $url = $this->url_api . $this->restURL . SLASH . IRestCommandConstant::COMMAND_STRING . EQUAL . IRestCommandConstant::UPDATE_SINGLE_DATA;
        $result = $tripoinRestClient->doPut($url, array(), array(), $_POST);

        if (is_numeric(json_decode($result->getBody)) > 0) {
            echo toastAlert("success", lang('general.title_update_success'), lang('general.message_update_success'));
            echo '<script>$(function(){postAjaxPagination()});</script>';
        } else {
//            echo toastAlert("error", lang('general.title_update_error'), lang('general.message_update_error'));
            echo toastAlert("error", lang('general.title_insert_error'), lang('error.' . json_decode($result->getBody)));
        }
    }

    public function listData() {
        $this->url_api = URL_REST . IRestCommandConstant::API . SLASH . IRestCommandConstant::VERSI . SLASH;
        $Form = new Form();
        $Datatable = new DataTable();
        $Button = new Button();
        $db = new Database();
//        $group = new SecurityGroup();
        $data = $this->modelData;
//        if ($_POST['per_page'] == "") {
        if ($_POST['per_page'] == "") {
            $Datatable->per_page = $this->per_page;
        } else {
            $Datatable->per_page = $_POST['per_page'];
        }

//        }
        $Datatable->urlDeleteCollection($this->urlDeleteCollection);
//        $search = $_POST['search_pagination'];
        $Datatable->searchFilter($this->search_filter);
        $Datatable->current_page = $_POST['current_page'];
        if ($_POST['current_page'] == '') {
            $Datatable->current_page = 1;
        }
        $search = $_POST['search_pagination'];
        if ($_POST['search_by'] == '') {
            $Datatable->search = 'code>' . $search;
        } else if ($_POST['search_by'] == 'null') {
            $Datatable->search = 'code>' . $search;
        } else {
            $Datatable->search = $_POST['search_by'] . '>' . $search;
        }
        if (getActionType(ACTION_TYPE_CREATE) != true) {
            $Datatable->createButton(false);
        }
//echo $this->url_api . $this->restURL;
//        print_r($testLogin);
        $sorting = array();
        if (!empty($this->orderBy)) {
            $sorting = array(key($this->orderBy) => $this->orderBy[key($this->orderBy)]);
        }
        $list_data = $Datatable->select_pagination_rest($this->url_api . $this->restURL, $this->param_body, $sorting);
//        print_r($list_data);
        $this->result = $Datatable->getResult();
//        print_r($Datatable->getResult());
        if ($this->autoData == true) {
            $this->listAutoData = $this->unsetDataModel($list_data['item']);
            include_once FILE_PATH(IViewConstant::CRUD_LIST_VIEW_INDEX);
        } else {
            include_once FILE_PATH($this->viewList);
        }
        echo '<script>$(function(){$(\'#form-search\').show()});</script>';
    }

    public function issetAutoDataModel($data = array()) {
        if (isset($_SESSION[SESSION_ADMIN_AUTO_DATA])) {
            $setarray = $_SESSION[SESSION_ADMIN_AUTO_DATA];
            if (is_array($setarray)) {
                $setarray = array_merge($setarray, $data);
            }

            $_SESSION[SESSION_ADMIN_AUTO_DATA] = $setarray;
        }
    }

    public function unsetDataModel($data) {
//        print_r($data);
        $_SESSION[SESSION_ADMIN_AUTO_DATA] = array();
        $auditrail = new Auditrail();
//        print_r($auditrail);
        $createdOn = $auditrail->getCreatedOn();
        $createdBy = $auditrail->getCreatedByUsername();
        $modifiedOn = $auditrail->getModifiedOn();
        $modifiedBy = $auditrail->getModifiedByUsername();
        $status = $auditrail->getStatus();
        foreach (array_keys($data) as $key) {
//            echo $data[$key]['created_on'];
            unset($data[$key]->$createdOn);
            unset($data[$key]->$createdBy);
            unset($data[$key]->$modifiedOn);
            unset($data[$key]->$modifiedBy);
            unset($data[$key]->$status);
        }
//        print_r(array_keys((array) $data[0]));

        if (empty($data)) {
            return array();
        } else {

            $_SESSION[SESSION_ADMIN_AUTO_DATA] = array_keys((array) $data[0]);
            return array_keys((array) $data[0]);
        }
    }

    public function create() {
        $Form = new Form();
        if ($this->autoData == true) {
            include_once FILE_PATH(IViewConstant::CRUD_NEW_VIEW_INDEX);
        } else {
            include_once FILE_PATH($this->viewCreate);
        }
        echo '<script>$(function(){$(\'#form-search\').hide()});</script>';
    }

    public function edit() {
        $this->url_api = URL_REST . IRestCommandConstant::API . SLASH . IRestCommandConstant::VERSI . SLASH;
        $id = $_POST['id'];
        $Form = new Form();
        $Button = new Button();
        $tripoinRestClient = new TripoinRestClient();
        $url = $this->url_api . $this->restURL . SLASH . IRestCommandConstant::COMMAND_STRING . EQUAL . IRestCommandConstant::FIND_SINGLE_DATA_BY_ID;
        $result = $tripoinRestClient->doPOST($url, array(), array(), $id);
//        $db->connect();
//        $get_data = $db->selectByID($data, $data->getId() . EQUAL . $id);
//        print_r($result);
        $get_data = json_decode($result->getBody);
//        print_r($get_data);
        if ($this->autoData == true) {
            include_once FILE_PATH(IViewConstant::CRUD_EDIT_VIEW_INDEX);
        } else {
            include_once FILE_PATH($this->viewEdit);
        }
        echo '<script>$(function(){$(\'#form-search\').hide()});</script>';
    }

    public function delete() {
        $this->url_api = URL_REST . IRestCommandConstant::API . SLASH . IRestCommandConstant::VERSI . SLASH;
        $id = $_POST['id'];
        $Form = new Form();
        /*  $db = new Database();
          //        $group = new SecurityGroup();
          $data = $this->modelData;
          $db->connect();
          $get_data = $db->delete($data->getEntity(), $data->getId() . EQUAL . $id);
          echo $get_data;
         */
        $tripoinRestClient = new TripoinRestClient();
        $url = $this->url_api . $this->restURL . SLASH . IRestCommandConstant::COMMAND_STRING . EQUAL . IRestCommandConstant::DELETE_SINGLE_DATA;
        $result = $tripoinRestClient->doDelete($url, array(), array(), $id);

        if (is_numeric(json_decode($result->getBody)) > 0) {
//            echo json_decode($result->getBody);
            echo 1;
        } else {
            echo 0;
        }

//        print_r($get_group);
    }

    public function deleteCollection() {
        $id = $_POST['id'];
        $Form = new Form();
        $tripoinRestClient = new TripoinRestClient();
        $url = $this->url_api . $this->restURL . SLASH . IRestCommandConstant::COMMAND_STRING . EQUAL . IRestCommandConstant::DELETE_COLLECTION;
        $result = $tripoinRestClient->doDelete($url, array(), array(), $id);

        if (is_numeric(json_decode($result->getBody)) > 0) {
//            echo json_decode($result->getBody);
            echo 1;
        } else {
            echo 0;
        }
    }

    public function setAutoCrud() {
        $this->autoViewURL();
        $this->autoViewPath();
    }

    public function autoViewURL() {
        setCreateURL(URL(getAdminTheme() . $this->indexUrl . '/create'));
        setDatatableURL(URL(getAdminTheme() . $this->indexUrl . '/list'));
        $this->editUrl = URL(getAdminTheme() . $this->indexUrl . '/edit');
        $this->deleteUrl = URL(getAdminTheme() . $this->indexUrl . '/delete');
        $this->insertUrl = URL(getAdminTheme() . $this->indexUrl . '/save');
        $this->updateUrl = URL(getAdminTheme() . $this->indexUrl . '/update');
        $this->urlDeleteCollection = URL(getAdminTheme() . $this->indexUrl . '/deleteCollection');
    }

    public function autoViewPath() {
        $this->viewList = $this->viewPath . '/list.html.php';
        $this->viewCreate = $this->viewPath . '/new.html.php';
        $this->viewEdit = $this->viewPath . '/edit.html.php';
    }

}
