<?php

/**
 * Description of Posting -> Posting
 * @email : sfandrianah2@gmail.com
 * @author Syahrial Fandrianah
 * @FRAMEWORK NATIVE ADMIN TEMPLATE V.1.0
 */

namespace app\Controller\Posting;

use app\Controller\Base\Controller;
use app\Model\MasterAuthor;
use app\Model\MasterPost;
use app\Model\MasterPostLanguage;
use app\Constant\IURLConstant;
use app\Constant\IViewConstant;
use app\Model\SecurityUser;
use app\Model\MasterLanguage;
use app\Util\Database;

class Posting extends Controller {

    //put your code here
    public $data_author = '';
    public $data_lang = '';
    public $lang = '';
    public $masterPostLang = '';
    public $dataMasterPostLang = '';
    public $db = '';
    public $path_upload = '';
    public $admin_theme_url = '';

    public function __construct() {
        $this->admin_theme_url = getAdminTheme();

        $this->modelData = new MasterPost();
        $this->setTitle(lang('posting.title_post'));
        $this->setBreadCrumb(array(lang('posting.title_posting') => "", lang('posting.title_post') => URL()));
        $this->search_filter = array("code" => lang('posting.code'), "title" => lang('posting.title'));
        $this->orderBy = $this->modelData->getCreatedOn() . " DESC, " . $this->modelData->getModifiedOn() . " DESC";
        $this->setViewURL();
        $this->setViewPath();

        $author = new MasterAuthor();
        $db = new Database();

        $this->lang = new MasterLanguage();

        $rs_author = $db->selectByID($author);
        $c_author = convertJsonCombobox($rs_author, $author->getId(), $author->getName());

        $this->data_lang = $db->selectByID($this->lang);
        $this->data_author = $c_author;
        $this->path_upload = 'contents/images/post/';
    }

    public function setViewURL() {
        setCreateURL(URL($this->admin_theme_url . IURLConstant::POST_CREATE_URL));
        setDatatableURL(URL($this->admin_theme_url . IURLConstant::POST_LIST_URL));
        $this->editUrl = URL($this->admin_theme_url . IURLConstant::POST_EDIT_URL);
        $this->deleteUrl = URL($this->admin_theme_url . IURLConstant::POST_DELETE_URL);
        $this->insertUrl = URL($this->admin_theme_url . IURLConstant::POST_SAVE_URL);
        $this->updateUrl = URL($this->admin_theme_url . IURLConstant::POST_UPDATE_URL);
        $this->urlDeleteCollection = URL($this->admin_theme_url . IURLConstant::POST_DELETE_COLLECTION_URL);
    }

    public function setViewPath() {
//        $this->viewIndex = IViewConstant::POST_VIEW_INDEX; //buka jika tidak menggunakan template crud index
        $this->viewList = IViewConstant::POST_VIEW_LIST;
        $this->viewCreate = IViewConstant::POST_VIEW_CREATE;
        $this->viewEdit = IViewConstant::POST_VIEW_EDIT;
    }

    public function edit() {
        $this->masterPostLang = new MasterPostLanguage();
        $this->db = new Database();

        parent::edit();
    }

    public function delete() {
        $db = new Database();
        $masterPostLanguage = new MasterPostLanguage();
        $db->connect();
        $id = $_POST['id'];
        $get_data = $db->delete($masterPostLanguage->getEntity(), $masterPostLanguage->getPost()->getId() . EQUAL . $id);
//        print_r($get_data);
        if ($get_data == 1) {
            parent::delete();
        }
    }

    public function save() {
        $db = new Database();
        $mp = new MasterPost();
        $db->connect();
        $thumbnail = $_FILES['thumbnail'];
        $image = $_FILES['image'];

        $code = $_POST['code'];
        $authors = $_POST['author'];
        $cek_code = $db->selectByID($mp, $mp->getCode() . "='" . $code . "'");
        if (!empty($cek_code)) {
            $ex_code = explode("_", $cek_code[0][$mp->getCode()]);
            if (isset($ex_code[1])) {
                $cal_code = doubleval($ex_code[1]) + 1;
                $code = $cal_code;
            } else {
                $code = $ex_code[0] . '_1';
            }
        }
//        $requiredMessage = 'Please Input Field';


        $temporary = explode(".", $thumbnail['name']);
        $temporary_img = explode(".", $image['name']);
        $path = FILE_PATH(DIR_WEB . $this->path_upload);
        $upload_thumbnail = uploadFileImg($thumbnail, 'thumbnail-' . $temporary[0] . '-' . date('Ymdhis'), $path);
        $return_upload = false;
        if ($upload_thumbnail['result'] == 1) {
            $upload_image = uploadFileImg($image, 'image-' . $temporary_img[0] . '-' . date('Ymdhis'), $path);
            if ($upload_image['result'] == 1) {
                $return_upload = true;
            } else {
                echo resultPageMsg('danger', lang('general.upload_img_error'), $upload_thumbnail['message']);
                $return_upload = false;
            }
        } else {
            echo resultPageMsg('danger', lang('general.upload_img_error'), $upload_thumbnail['message']);
            $return_upload = false;
        }
        $no_image = 0;
        if (isset($_POST['no_image'])) {
            if ($_POST['no_image'] == 'true') {
                $no_image = 1;
                $return_upload = true;
            }
        }
        if ($return_upload == true) {
            $author = new MasterAuthor();
            $masterPost = new MasterPost();
            $user = new SecurityUser();

            /*      $rs_author = $db->selectByID($author, $author->getCode() . "='" . $authors . "'");
              //                $rs_user = $db->selectByID($user, $user->getCode() . "='" . $_SESSION[SESSION_USERNAME] . "'");
              if (empty($rs_author)) {
              echo resultPageMsg('danger', lang('general.title_insert_error'), lang('general.message_insert_error'));
              } else {
             * 
             */

            $title = $_POST['title_id'];
            $subtitle = $_POST['subtitle_id'];
            $desc = $_POST['description_id'];
            $db->insert($masterPost->getEntity(), array(
                $masterPost->getCode() => $code,
                $masterPost->getTitle() => $title,
                $masterPost->getSubtitle() => $subtitle,
                $masterPost->getThumbnail() => $upload_thumbnail['file_name'],
                $masterPost->getImg() => $upload_image['file_name'],
                $masterPost->getAuthorId() => $authors,
//                    $masterPost->getAuthorCode() => $rs_author[0][$author->getCode()],
//                    $masterPost->getAuthorName() => $rs_author[0][$author->getName()],
                $masterPost->getContent() => htmlentities($desc),
                $masterPost->getStatus() => 1,
                $masterPost->getCreatedByUsername() => $_SESSION[SESSION_USERNAME],
                $masterPost->getCreatedOn() => date('Y-m-d h:i:s'),
                $masterPost->getPostStatus() => 'draft',
                $masterPost->getCommentEnable() => 0,
                $masterPost->getReadCount() => 0,
                $masterPost->getNoImg() => $no_image,
            ));
            $rs_post = $db->getResult();
            if (is_numeric($rs_post[0])) {
                $all_language = $_POST['all_language'];
                if (!empty($all_language)) {
                    $masterPostLang = new MasterPostLanguage();
                    $ex_all_language = explode(',', $all_language);
                    $masterLang = new MasterLanguage();
                    foreach ($ex_all_language as $value_lang) {
                        $title_lang = $_POST['title_' . $value_lang];
                        $subtitle_lang = $_POST['subtitle_' . $value_lang];
                        $desc_lang = $_POST['description_' . $value_lang];
                        
                        $getLang = $db->selectByID($masterLang, $masterLang->getCode()."='".$value_lang."'");
                        $db->insert($masterPostLang->getEntity(), array(
                            $masterPostLang->getPostId() => $rs_post[0],
                            $masterPostLang->getCode() => $rs_post[0] . $value_lang,
                            $masterPostLang->getPost()->getTitle() => $title_lang,
                            $masterPostLang->getPost()->getSubtitle() => $subtitle_lang,
                            $masterPostLang->getLanguageId() => $getLang[0][$masterLang->getId()],
                            $masterPostLang->getPost()->getContent() => htmlentities($desc_lang),
                        ));
                    }
                }
                echo toastAlert("success", lang('general.title_insert_success'), lang('general.message_insert_success'));
                echo '<script>$(function(){postAjaxPagination()});</script>';
            } else {
                echo resultPageMsg('danger', lang('general.title_insert_error'), $rs_post[0]);
//                }
            }
        }
    }

    public function update() {
//        print_r($_FILES);
        $thumbnail = $_FILES['thumbnail'];
        $image = $_FILES['image'];

        $idPost = $_POST['id_post'];
//        $noImg = $_POST['no_image'];
        $code = $_POST['code'];
        $authors = $_POST['author'];
        $temporary = explode(".", $thumbnail['name']);
        $temporary_img = explode(".", $image['name']);
        $path = FILE_PATH(DIR_WEB . $this->path_upload);
        $upload_thumbnail = uploadFileImg($thumbnail, 'thumbnail-' . $temporary[0] . '-' . date('Ymdhis'), $path);
        $upload_image = uploadFileImg($image, 'image-' . $temporary_img[0] . '-' . date('Ymdhis'), $path);

        $author = new MasterAuthor();
        $masterPost = new MasterPost();
        $user = new SecurityUser();

        $db = new Database();
        $db->connect();

        $rs_post = $db->selectByID($masterPost, $masterPost->getId() . "='" . $idPost . "'");
        if ($upload_thumbnail['result'] == 1) {
            $file_name_thumbnail = $upload_thumbnail['file_name'];
        } else {
            $file_name_thumbnail = $rs_post[0][$masterPost->getThumbnail()];
        }

        if ($upload_image['result'] == 1) {
            $file_name_image = $upload_image['file_name'];
        } else {
            $file_name_image = $rs_post[0][$masterPost->getImg()];
        }

        $rs_author = $db->selectByID($author, $author->getId() . "='" . $authors . "'");
//                $rs_user = $db->selectByID($user, $user->getCode() . "='" . $_SESSION[SESSION_USERNAME] . "'");
        if (empty($rs_author)) {
            echo resultPageMsg('danger', lang('general.title_update_error'), lang('general.message_update_error'));
        } else {
            $title = $_POST['title_id'];
            $subtitle = $_POST['subtitle_id'];
            $desc = $_POST['description_id'];
            $no_image = 0;
            if (isset($_POST['no_image'])) {
                if ($_POST['no_image'] == 'true') {
                    $no_image = 1;
                }
            }
            $db->update($masterPost->getEntity(), array(
                $masterPost->getCode() => $code,
                $masterPost->getTitle() => $title,
                $masterPost->getSubtitle() => $subtitle,
                $masterPost->getThumbnail() => $file_name_thumbnail,
                $masterPost->getImg() => $file_name_image,
                $masterPost->getAuthorId() => $authors,
//                $masterPost->getAuthorCode() => $rs_author[0][$author->getCode()],
//                $masterPost->getAuthorName() => $rs_author[0][$author->getName()],
                $masterPost->getContent() => htmlentities($desc),
                $masterPost->getStatus() => 1,
                $masterPost->getModifiedByUsername() => $_SESSION[SESSION_USERNAME],
                $masterPost->getModifiedOn() => date('Y-m-d h:i:s'),
                $masterPost->getPostStatus() => 'published',
                $masterPost->getCommentEnable() => 0,
                $masterPost->getReadCount() => 0,
                $masterPost->getNoImg() => $no_image,
                    ), $masterPost->getId() . EQUAL . $idPost);
            $rs_post = $db->getResult();
            if (is_numeric($rs_post[0])) {
                $all_language = $_POST['all_language'];
                if (!empty($all_language)) {
                    $masterPostLang = new MasterPostLanguage();
                    $masterLang = new MasterLanguage();
                    $ex_all_language = explode(',', $all_language);
                    foreach ($ex_all_language as $value_lang) {

                        $title_lang = $_POST['title_' . $value_lang];
                        $subtitle_lang = $_POST['subtitle_' . $value_lang];
                        $desc_lang = $_POST['description_' . $value_lang];
                        
                        $getLang = $db->selectByID($masterLang, $masterLang->getCode()."='".$value_lang."'");
                        $dt_mstPostLang = $db->selectByID($masterPostLang, $masterPostLang->getPostId() . EQUAL . $idPost
                                . " AND " . $masterPostLang->getLanguageId() . "='" . $getLang[0][$masterLang->getId()] . "'");
                        
                        
                        if (empty($dt_mstPostLang)) {
                            $db->insert($masterPostLang->getEntity(), array(
                                $masterPostLang->getPostId() => $idPost,
                                $masterPostLang->getCode() => $idPost . $value_lang,
                                $masterPostLang->getPost()->getTitle() => $title_lang,
                                $masterPostLang->getPost()->getSubtitle() => $subtitle_lang,
                                $masterPostLang->getLanguageId() => $getLang[0][$masterLang->getId()],
                                $masterPostLang->getPost()->getContent() => htmlentities($desc_lang),
                            ));
                            $rs_insert_lang = $db->getResult();
                            LOGGER($db->getSql());
                            LOGGER($rs_insert_lang);
                        } else {
                            $db->update($masterPostLang->getEntity(), array(
                                $masterPostLang->getPostId() => $idPost,
                                $masterPostLang->getPost()->getTitle() => $title_lang,
                                $masterPostLang->getPost()->getSubtitle() => $subtitle_lang,
                                $masterPostLang->getLanguageId() => $getLang[0][$masterLang->getId()],
                                $masterPostLang->getPost()->getContent() => htmlentities($desc_lang),
                                    ), $masterPostLang->getPostId() . EQUAL . $idPost
                                    . " AND " . $masterPostLang->getLanguageId() . EQUAL . "'" . $getLang[0][$masterLang->getId()] . "'");
                        }
                    }
                }
                echo toastAlert("success", lang('general.title_update_success'), lang('general.message_update_success'));
                echo '<script>$(function(){postAjaxPagination()});</script>';
            } else {
                echo resultPageMsg('danger', lang('general.title_update_error'), $rs_post[0]);
            }
        }

//        parent::update();
    }

}
