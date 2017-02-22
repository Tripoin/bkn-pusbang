<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controller\Base;

/**
 * Description of ControllerMember
 *
 * @author sfandrianah
 */
use app\Util\Database;
use app\Util\Form;
use app\Util\DataTable;
use app\Model\SecurityUser;
use app\Constant\MemberConstant;
use app\Model\SecurityFunction;
use app\Model\SecurityFunctionAssignment;

class ControllerMember {

    public $title = '';
    public $title_edit = '';
    public $title_create = '';
    public $index_path = '';
    public $new_path = '';
    public $list_path = '';
    public $edit_path = '';
    public $view_path = '';
    public $index_url = '';
    public $list_url = '';
    public $create_url = '';
    public $view_url = '';
    public $edit_url = '';
    public $update_url = '';
    public $delete_url = '';
    public $save_url = '';
    public $list_search_by = array();
    public $create_button = true;
    public $view_button = true;
    public $delete_button = true;
    public $edit_button = true;
    public $list_all = true;
    public $type_member_post = '';
    public $upload_path_member = 'uploads/member/';
    public $model;
    public $get_menu = '';

    //put your code here

    public function __construct($member) {
        $this->model = new $member;
        $this->index_path = MemberConstant::POST_INDEX_PATH;
        $this->list_path = MemberConstant::POST_LIST_PATH;
        $this->view_path = MemberConstant::POST_VIEW_PATH;
        $this->edit_path = MemberConstant::POST_EDIT_PATH;
        $this->new_path = MemberConstant::POST_CREATE_PATH;

        $db = new Database();
        $db->connect();
        $menu_now = getActiveMenuMember();
        $sf = new SecurityFunction();
        $sfa = new SecurityFunctionAssignment();
//        echo $menu_now;
        $rm = $db->selectByID($sf, $sf->getCode() . "='" . $menu_now . "'");

        $this->get_menu = $db->selectByID($sfa, $sfa->getFunction()->getId() . EQUAL . $rm[0][$sf->getId()] . " AND " . $sfa->getGroup()->getId() . EQUAL . $_SESSION[SESSION_GROUP]);
        $sfa = new SecurityFunctionAssignment();
        $create = strpos($this->get_menu[0][$sfa->getActionType()], ACTION_TYPE_CREATE);
        $view = strpos($this->get_menu[0][$sfa->getActionType()], ACTION_TYPE_VIEW);
        $edit = strpos($this->get_menu[0][$sfa->getActionType()], ACTION_TYPE_EDIT);
        $delete = strpos($this->get_menu[0][$sfa->getActionType()], ACTION_TYPE_DELETE);
        $list_all = strpos($this->get_menu[0][$sfa->getActionType()], ACTION_TYPE_LIST_ALL);
//        print_r($pos);


        if ($create === false) {
            $this->create_button = false;
        }

        if ($view === false) {
            $this->view_button = false;
        }

        if ($edit === false) {
            $this->edit_button = false;
        }

        if ($delete === false) {
            $this->delete_button = false;
        }

        if ($delete === false) {
            $this->delete_button = false;
        }
        if ($list_all === false) {
            $this->list_all = false;
        }
    }

    public function index() {
        $Form = new Form();
        setTitle(' | ' . $this->title);
        include_once FILE_PATH($this->index_path);
    }

    public function lists() {
        $Form = new Form();
        $db = new Database();
        $memberPost = $this->model;

        /*
          $db->connect();
          $db->select($memberPost->getEntity(), "*", null, $memberPost->getTitle() . " LIKE '%" . $this->search . "%' AND " .
          $memberPost->getCreatedByUsername() . "='" . $_SESSION[SESSION_USERNAME] . "'", null, $this->from . ',' . $this->to);
         */
        $dtable = new DataTable();
//        if($_POST)
        
        if (isset($_POST['search'])) {
            $sr = $_POST['search'];
//            $_POST['search'] = 'title>' . $sr;
            $dtable->search = $_POST['search_by'].'>'.$sr;
        }
        $dtable->per_page = 6;
        

//        echo $as_menu[0][$sfa->getActionType()];
//        print_r($rm);
//        echo $_SESSION[SESSION_GROUP];


        if ($this->list_all === false) {
//            $this->create_button = false;
            $this->list_search_by = array("title" => lang("member.title"));
            $pagination = $dtable->select_pagination($memberPost, $memberPost->getEntity(), $memberPost->getCreatedByUsername() . "='" . $_SESSION[SESSION_USERNAME] . "'" . ' AND ' . $memberPost->getType() . '=' . $this->type_member_post);
        } else {
            $this->list_search_by = array("title" => lang("member.title"), "createdByUsername" => "Author");
            $pagination = $dtable->select_pagination($memberPost, $memberPost->getEntity(), $memberPost->getType() . '=' . $this->type_member_post);
        }
//        echo json_encode($pagination);
        $list_gallery = $pagination['item'];


//        print_r($list_gallery);
        include_once FILE_PATH($this->list_path);
    }

    public function create() {

        $Form = new Form();
        include_once FILE_PATH($this->new_path);
    }

    public function edit() {
        $Form = new Form();
        $db = new Database();
        $memberPost = $this->model;
        $db->connect();
        if ($this->edit_button == true) {
//            $db->select($memberPost->getEntity(), "*", null, $memberPost->getId() . "=" . $_POST['id'] . " AND " . $memberPost->getCreatedByUsername() . "='" . $_SESSION[SESSION_USERNAME] . "'");
            $db->select($memberPost->getEntity(), "*", null, $memberPost->getId() . "=" . $_POST['id']);
            $select_gallery = $db->getResult();
            if (empty($select_gallery)) {
                echo toastAlert('error', 'Open Gallery Failed', $select_gallery[0]);
            } else {
                $sg = $select_gallery[0];
//            print_r($sg);
//            echo toastAlert('error', 'Open Gallery Failed', $select_gallery[0]);
                include_once FILE_PATH($this->edit_path);
            }
        }
    }

    public function view() {
        $Form = new Form();
//        setTitle(' | ' . lang('member.gallery_title_edit'));
        $db = new Database();
        $memberPost = $this->model;
        $db->connect();
        if ($this->view_button == true) {
//            $db->select($memberPost->getEntity(), "*", null, $memberPost->getId() . "=" . $_POST['id'] . " AND " . $memberPost->getCreatedByUsername() . "='" . $_SESSION[SESSION_USERNAME] . "'");
            $db->select($memberPost->getEntity(), "*", null, $memberPost->getId() . "=" . $_POST['id']);
            $select_gallery = $db->getResult();
            if (empty($select_gallery)) {
                echo toastAlert('error', 'Open Gallery Failed', $select_gallery[0]);
            } else {
                $sg = $select_gallery[0];
//            print_r($sg);
//            echo toastAlert('error', 'Open Gallery Failed', $select_gallery[0]);
//                $path = $this->upload_path_member . $_SESSION[SESSION_USERNAME] . '/';
                $path = $this->upload_path_member . $sg[$memberPost->getCreatedByUsername()] . '/';
                include_once FILE_PATH($this->view_path);
            }
        }
    }

    public function save() {
        $title = $_POST['title'];
        $subtitle = $_POST['subtitle'];
        $date = $_POST['date'];
        $uploadImg = $_FILES['upload_image'];
        $content = $_POST['description'];
        $random = createRandomBooking();
        $path = $this->upload_path_member . $_SESSION[SESSION_USERNAME] . '/';
        $upload = uploadImage($uploadImg, $path, $uploadImg["name"][0] . '-' . $random . '-' . date('Ymdhis'));
        $exp_up = explode(",", $upload);

        if ($exp_up[0] == 1) {
            $db = new Database();
            $memberPost = $this->model;
            $user = new SecurityUser();
            $select_user = $db->selectByID($user, $user->getCode() . "='" . $_SESSION[SESSION_USERNAME] . "'");
            if (!empty($select_user)) {
                $db->connect();
                /* $db->sql("INSERT INTO " . $memberPost->getEntity() . " (
                  `" . $memberPost->getCode() . "`,`" . $memberPost->getName() . "`,
                  `" . $memberPost->getTitle() . "`,`" . $memberPost->getSubtitle() . "`,
                  `" . $memberPost->getDate() . "`,`" . $memberPost->getImg() . "`,
                  `" . $memberPost->getContent() . "`,`" . $memberPost->getType() . "`,
                  `" . $memberPost->getStatus() . "`,`" . $memberPost->getCreatedById() . "`,
                  `" . $memberPost->getCreatedByUsername() . "`,`" . $memberPost->getCreatedOn() . "`
                  ) VALUES (

                  )"); */
//                htmlspecialchars($string);
                $content2 = htmlentities($content);
                if (!empty($content2)) {
                    $db->insert($memberPost->getEntity(), array(
                        $memberPost->getCode() => $random,
                        $memberPost->getName() => $title,
                        $memberPost->getTitle() => $title,
                        $memberPost->getSubtitle() => $subtitle,
                        $memberPost->getDate() => $date,
                        $memberPost->getImg() => $exp_up[1],
                        $memberPost->getContent() => $content2,
                        $memberPost->getType() => $this->type_member_post,
                        $memberPost->getStatus() => 1,
                        $memberPost->getCreatedById() => $select_user[0][$user->getId()],
                        $memberPost->getCreatedByUsername() => $_SESSION[SESSION_USERNAME],
                        $memberPost->getCreatedOn() => date('Y-m-d h:i:s'),
                        $memberPost->getCreatedByIp() => getClientIp(),
                    ));
                    $rs_post = $db->getResult();
                    if (is_numeric($rs_post[0])) {
                        echo '1,';
//                        echo '1,' . lang('general.title_insert_success') . ',' . lang('general.message_insert_success') . ',';
                        echo toastAlert("success", lang('general.title_insert_success'), lang('general.message_insert_success'));
                        echo '<script>
                            $(function(){';
                        echo "ajaxGetPage('" . URL($this->list_url) . "', 'pageMember');";
                        echo '});
                            </script>
                        ';
                    } else {
                        echo '0,' . lang('general.message_insert_error') . "Error Save Data";
                    }
                } else {
                    unlink($path . $exp_up[1]);
//                    $this->save();
                    echo '0,' . lang('general.message_insert_error') . " Content Empty";
                }
            } else {
                echo '0,' . lang('general.message_insert_error') . "Error Select User";
            }
        } else {
            echo $upload;
        }
//        echo error_get_last();
    }

    public function update() {
        $db = new Database();
        $memberPost = $this->model;
        $user = new SecurityUser();

        $id = $_POST['id'];
        $title = $_POST['title'];
        $subtitle = $_POST['subtitle'];
        $date = $_POST['date'];
        $uploadImg = $_FILES['upload_image'];
        $content = $_POST['description'];


        $select_member_post = $db->selectByID($memberPost, $memberPost->getId() . "='" . $id . "'");

        $upImg = '';
        $rs_up = 0;
        if ($uploadImg["name"][0] != "") {
            $random = createRandomBooking();
            $path = $this->upload_path_member . $_SESSION[SESSION_USERNAME] . '/';
            $upload = uploadImage($uploadImg, $path, $uploadImg["name"][0] . '-' . $random . '-' . date('Ymdhis'));
            $exp_up = explode(",", $upload);
            $upImg = $exp_up[1];
            $rs_up = $exp_up[0];
        } else {
            $upImg = $uploadImg["name"][0];
            $rs_up = 1;
        }

        if ($rs_up == 1) {

            $select_user = $db->selectByID($user, $user->getCode() . "='" . $_SESSION[SESSION_USERNAME] . "'");
            if (!empty($select_user)) {
                $db->connect();
                $content2 = htmlentities($content);
                if (!empty($content2)) {
                    $db->update($memberPost->getEntity(), array(
                        $memberPost->getCode() => $select_member_post[0][$memberPost->getCode()],
                        $memberPost->getName() => $title,
                        $memberPost->getTitle() => $title,
                        $memberPost->getSubtitle() => $subtitle,
                        $memberPost->getDate() => $date,
                        $memberPost->getImg() => $upImg,
                        $memberPost->getContent() => $content2,
                        $memberPost->getType() => $this->type_member_post,
                        $memberPost->getStatus() => 1,
                        $memberPost->getModifiedById() => $select_user[0][$user->getId()],
                        $memberPost->getModifiedByUsername() => $_SESSION[SESSION_USERNAME],
                        $memberPost->getModifiedOn() => date('Y-m-d h:i:s'),
                        $memberPost->getModifiedByIp() => getClientIp(),
                            ), $memberPost->getId() . "=" . $id);
                    $rs_post = $db->getResult();
                    if (is_numeric($rs_post[0])) {
                        echo '1,';
//                        echo '1,' . lang('general.title_insert_success') . ',' . lang('general.message_insert_success') . ',';
                        echo toastAlert("success", lang('general.title_update_success'), lang('general.message_update_success'));
                        echo '<script>
                            $(function(){';
                        echo "ajaxGetPage('" . URL($this->list_url) . "', 'pageMember');";
                        echo '});
                            </script>
                        ';
                    } else {
                        echo '0,' . lang('general.message_update_error') . "Error Save Data";
                    }
                } else {
                    unlink($path . $upImg[1]);
//                    $this->save();
                    echo '0,' . lang('general.message_update_error') . " Content Empty";
                }
            } else {
                echo '0,' . lang('general.message_update_error') . "Error Select User";
            }
        } else {
            echo $upload;
        }
//        echo error_get_last();
    }

    public function delete() {
        $id = $_POST['id'];
        $db = new Database();
        $memberPost = $this->model;
        $db->connect();
        $db->delete($memberPost->getEntity(), $memberPost->getId() . "=" . $id);
        $result = $db->getResult();
//        print_r($result);
        if ($result[0] == 1) {
//            echo '1,';
//                        echo '1,' . lang('general.title_insert_success') . ',' . lang('general.message_insert_success') . ',';
            echo toastAlert("success", lang('general.title_delete_success'), lang('general.message_delete_success'));
            echo '<script>
                    $(function(){';
            echo "ajaxGetPage('" . URL($this->list_url) . "', 'pageMember');";
            echo '});
                </script>';
        } else {
            echo '0,' . lang('general.title_delete_error') . ',' . lang('general.message_delete_error');
        }
    }

}
