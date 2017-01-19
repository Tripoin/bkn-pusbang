<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of POSTING -> POST_ASSIGN
 * @email : sfandrianah2@gmail.com
 * @author Syahrial Fandrianah
 * @FRAMEWORK NATIVE ADMIN TEMPLATE V.1.0
 */

namespace app\Controller\Posting;

use app\Controller\Base\Controller;
use app\Model\SecurityFunction;
use app\Model\SecurityFunctionAssignment;
use app\Model\MasterPostFunction;
use app\Model\MasterPost;
use app\Constant\IURLConstant;
use app\Constant\IViewConstant;
use app\Util\Form;
use app\Util\DataTable;
use app\Util\Button;
use app\Util\Database;

class PostingAssignment extends Controller {

    //put your code here
    public $admin_theme_url = '';

    public function __construct() {

        $this->admin_theme_url = getAdminTheme();

        $sfa = new SecurityFunctionAssignment();
        $sf = new SecurityFunction();
        $this->modelData = $sf;
        $this->search_list = $sf->getEntity();

        $this->select_entity = $sf->getEntity().".*";
        $this->setTitle(lang('posting.title_post_assign'));
        $this->setBreadCrumb(array(lang('posting.title_posting') => "", lang('posting.title_post_assign') => FULLURL()));
        $this->where_list = $sf->getEntity() . "." . $sf->getId() . EQUAL . $sfa->getEntity() . "." . $sfa->getFunctionId() . ""
                . " AND " . $sfa->getGroupId() . EQUAL . "1";
        $this->join_list = $sfa->getEntity();
        $this->search_filter = array("code" => lang('general.code'), "name" => lang('general.name'));
        $this->setViewURL();
        $this->setViewPath();
    }

    /*
      public function listData() {

      parent::listData();
      }
     */

    public function setViewURL() {
        setCreateURL(URL($this->admin_theme_url . IURLConstant::POST_ASSIGN_CREATE_URL));
        setDatatableURL(URL($this->admin_theme_url . IURLConstant::POST_ASSIGN_LIST_URL));
        $this->editUrl = URL($this->admin_theme_url . IURLConstant::POST_ASSIGN_EDIT_URL);
        $this->deleteUrl = URL($this->admin_theme_url . IURLConstant::POST_ASSIGN_DELETE_URL);
        $this->insertUrl = URL($this->admin_theme_url . IURLConstant::POST_ASSIGN_SAVE_URL);
        $this->updateUrl = URL($this->admin_theme_url . IURLConstant::POST_ASSIGN_UPDATE_URL);
        $this->urlDeleteCollection = URL($this->admin_theme_url . IURLConstant::POST_ASSIGN_DELETE_COLLECTION_URL);
    }

    public function setViewPath() {
//        $this->viewIndex = IViewConstant::POST_ASSIGN_VIEW_INDEX; //buka jika tidak menggunakan template crud index
        $this->viewList = IViewConstant::POST_ASSIGN_VIEW_LIST;
        $this->viewCreate = IViewConstant::POST_ASSIGN_VIEW_CREATE;
        $this->viewEdit = IViewConstant::POST_ASSIGN_VIEW_EDIT;
    }

    public function listPostByFunction($Datatable, $mpf, $masterPost, $type) {
        $Form = new Form();
//        $Datatable = new DataTable();
        $Button = new Button();
        $db = new Database();
//        $group = new SecurityGroup();
//        $mpf = new MasterPostFunction();
//        $masterPost = new MasterPost();
        if ($_POST['per_page'] == "") {
            $_POST['per_page'] = 5;
        }
        $Datatable->urlDeleteCollection($this->urlDeleteCollection);
//        $search = $_POST['search_pagination'];
//        echo $mpf->getPost().'.code>';
        $this->search_filter = array("code" => lang('general.code'), "title" => lang('posting.title'));
        $Datatable->searchFilter($this->search_filter);
        if ($type == 1) {

            $search = $_POST['search_pagination'];
            if ($_POST['search_by'] == '') {
                $_POST['search'] = 'post.code>' . $search;
            } else if ($_POST['search_by'] == 'null') {
                $_POST['search'] = 'post.code>' . $search;
            } else {
                $_POST['search'] = 'post.' . $_POST['search_by'] . '>' . $search;
            }
            $id = $_POST['id'];
            $where = $mpf->getEntity() . "." . $mpf->getPostId() . EQUAL . $masterPost->getEntity() . "." . $masterPost->getId() . ""
                    . " AND " . $mpf->getEntity() . "." . $mpf->getFunctionId() . EQUAL . $id;

            $join = $masterPost->getEntity();
            $list_data = $Datatable->select_pagination($mpf, $mpf->getEntity(), $where, $join, null, null);
            LOGGER($list_data);
        } else {
//            $sl_post = $db->s;
//            $this->search_filter = array("code" => lang('general.code'), "title" => lang('general.name'));
//            $Datatable->searchFilter($this->search_filter);
            $search = $_POST['search_pagination'];
            if ($_POST['search_by'] == '') {
                $_POST['search'] = 'code>' . $search;
            } else if ($_POST['search_by'] == 'null') {
                $_POST['search'] = 'code>' . $search;
            } else {
                $_POST['search'] = '' . $_POST['search_by'] . '>' . $search;
            }
            $id = $_POST['id'];
            $l_post = '';
            $rs_post_all = $db->selectByID($mpf, $mpf->getFunctionId() . EQUAL . $id);
            foreach ($rs_post_all as $val_post) {
                $l_post .= $val_post[$mpf->getPostId()] . ",";
            }
            $l_post = rtrim($l_post, ',');
            if (empty($l_post)) {
                $where = '';
            } else {
                $where = $mpf->getPost()->getId() . " NOT IN (" . $l_post . ") ";
            }

//            
//            print_r($where);
            /*
              $where = $mpf->getEntity() . "." . $mpf->getPost()->getId() . EQUAL . $masterPost->getEntity() . "." . $masterPost->getId() . ""
              . " AND " . $mpf->getEntity() . "." . $mpf->getFunction()->getId() . NOTEQUAL . $id;
             * 
             */
            $list_data = $Datatable->select_pagination($mpf->getPost(), $mpf->getPost()->getEntity(), $where, null, null, null);
//            print_r($list_data);
        }



        return $list_data;
    }

    public function listPost() {
        $Form = new Form();
        $Datatable = new DataTable();
        $Button = new Button();
        $mpf = new MasterPostFunction();
        $masterPost = new MasterPost();

        $list_data = $this->listPostByFunction($Datatable, $mpf, $masterPost, 1);
        include_once FILE_PATH(IViewConstant::POST_ASSIGN_VIEW_LIST_POST);
    }

    public function createPostAssign() {
        $Form = new Form();
        $Datatable = new DataTable();
        $Button = new Button();
        $mpf = new MasterPostFunction();
        $masterPost = new MasterPost();
        include_once FILE_PATH(IViewConstant::POST_ASSIGN_VIEW_CREATE_POST_ASSIGN);
    }

    public function deletePostAssign() {
        $db = new Database();
        $mp = new MasterPost();
        $mpf = new MasterPostFunction();
        $id_post = $_POST['id_post'];
        $id_function = $_POST['id_function'];
        $db->connect();
        $db->delete($mpf->getEntity(), $mpf->getFunction()->getId() . EQUAL . $id_function . " AND "
                . $mpf->getPost()->getId() . EQUAL . $id_post);
        $rs_delete = $db->getResult();
//        print_r($rs_delete);
        if ($rs_delete[0] == 1) {
            $db->update($mp->getEntity(), array(
                $mp->getPostStatus() => 'draft',
                $mp->getModifiedByUsername() => date('Y-m-d h:i:s'),
                    ), $mp->getId() . EQUAL . $id_post);
            $up_post = $db->getResult();
            if ($up_post[0] == 1) {
                echo 1;
            } else {
                echo 0;
            }

//            echo toastAlert('success', 'Add Posting Assignment Berhasil', 'Add Posting Assignment Berhasil');
        } else {
            echo 0;
//            echo toastAlert('error', 'Add Posting Assignment Gagal', 'Add Posting Assignment Gagal '.$rs_delete[0]);
        }
    }

    public function addPostAssign() {
        $db = new Database();
        $mpf = new MasterPostFunction();
        $mp = new MasterPost();
        $id_post = $_POST['id_post'];
        $id_function = $_POST['id_function'];
        $db->connect();
        $db->insert($mpf->getEntity(), array(
            $mpf->getFunctionId() => $id_function,
            $mpf->getPostId() => $id_post,
        ));
        $rs_insert = $db->getResult();
        if (is_numeric($rs_insert[0])) {
            $db->update($mp->getEntity(), array(
                $mp->getPostStatus() => 'published',
                $mp->getPublishOn() => date('Y-m-d h:i:s'),
                $mp->getModifiedByUsername() => date('Y-m-d h:i:s')
                    ), $mp->getId() . EQUAL . $id_post);
            $up_post = $db->getResult();
            if ($up_post[0] == 1) {
                echo toastAlert('success', 'Add Posting Assignment Berhasil', 'Add Posting Assignment Berhasil');
            } else {
                echo toastAlert('error', 'Add Posting Assignment Gagal', 'Add Posting Assignment Gagal');
            }
        } else {
            echo toastAlert('error', 'Add Posting Assignment Gagal', 'Add Posting Assignment Gagal');
        }
        echo '<script>$(function(){$(\'#myModal_self\').modal(\'hide\');postAjaxPaginationManual(\'bodyPageManual\');});</script>';
    }

    public function listPostAssign() {
        $Form = new Form();
        $Datatable = new DataTable();
        $Button = new Button();
        $mpf = new MasterPostFunction();
        $masterPost = new MasterPost();
        $list_data = $this->listPostByFunction($Datatable, $mpf, $masterPost, 2);
//        echo 'tes';
        include_once FILE_PATH(IViewConstant::POST_ASSIGN_VIEW_LIST_POST_ASSIGN);
    }

    public function viewPostAssign() {
//        $Form = new Form();
//        $Datatable = new DataTable();
//        $Button = new Button();
//        $mpf = new MasterPostFunction();
        $masterPost = new MasterPost();
//        $list_data = $this->listPostByFunction($Datatable, $mpf, $masterPost, 2);
//        echo 'tes';
        $db = new Database();
        $data = $db->selectByID($masterPost, $masterPost->getId() . EQUAL . $_POST['id_post']);
//        print_r($data);
        if (!empty($data)) {
            include_once FILE_PATH(IViewConstant::POST_ASSIGN_VIEW_VIEW_POST_ASSIGN);
        }
    }

}
