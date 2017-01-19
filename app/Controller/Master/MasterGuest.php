<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controller\Master;

/**
 * Description of User
 *
 * @author sfandrianah
 */
use app\Util\Form;
use app\Util\Database;
use app\Model\MasterPost;
use app\Model\MasterPostLanguage;
use app\Model\MasterPostFunction;
use app\Model\SecurityFunction;
use app\Model\SecurityFunctionAssignment;

class MasterGuest {

    //put your code here

    public function page() {
        $sf = new SecurityFunction();
        $mpf = new MasterPostFunction();
        $mpl = new MasterPostLanguage;
        $mp = new MasterPost();
//        $db->select("mst_product");
//        $list_product = $db->getResult();
        $functionId = $_POST['function_id_now'];
//        echo $functionId;
        $db = new Database();
        $db->connect();
        $db->select($mpf->getEntity(), "*", array($mp->getEntity(), $sf->getEntity()), ""
                . $mpf->getEntity() . DOT . $mpf->getPost()->getId() . EQUAL . $mp->getEntity() . DOT . $mp->getId() . " AND "
                . $mpf->getEntity() . DOT . $mpf->getFunction()->getId() . EQUAL . $sf->getEntity() . DOT . $sf->getId() . " AND "
                . $mp->getEntity() . DOT . $mp->getPostStatus() . EQUAL . "'published'" . " AND "
                . $mpf->getEntity() . DOT . $mpf->getFunction()->getId() . EQUAL . $functionId);
        $list_post_function = $db->getResult();
//        echo 'masuk';
//        
        if (!empty($list_post_function)) {
//            print_r($rs_post);
            if (isset($_SESSION[LANGUAGE_SESSION])) {
                $mp_lang = $db->selectByID($mpl, $mpl->getLanguage() . "='" . $_SESSION[LANGUAGE_SESSION] . "'"
                        . " AND " . $mpl->getPost()->getId() . "=" . $list_post_function[0][$mp->getId()]);
            }

            $breadcrumb = array(URL($list_post_function[0][$mpf->getFunction()->getUrl()]) => $list_post_function[0][$mpf->getFunction()->getName()]);
            include_once FILE_PATH('view/page/global/master-guest-one-page.html.php');
        } else {
            include_once FILE_PATH(PAGE_404);
        }
    }

    public function pageTwoColumn() {
        $mpf = new MasterPostFunction();
        $mp = new MasterPost();
        $sf = new SecurityFunction();
        $mpl = new MasterPostLanguage;
//        $db->select("mst_product");
//        $list_product = $db->getResult();
        $functionId = $_POST['function_id_now'];
//        echo $functionId;
        $db = new Database();
        $db->connect();
//        $mpf->getFunction()->getId();
        $db->select($mpf->getEntity(), "*", array($mp->getEntity(), $sf->getEntity()), ""
                . $mpf->getEntity() . DOT . $mpf->getPost()->getId() . EQUAL . $mp->getEntity() . DOT . $mp->getId() . " AND "
                . $mpf->getEntity() . DOT . $mpf->getFunction()->getId() . EQUAL . $sf->getEntity() . DOT . $sf->getId() . " AND "
                . $mp->getEntity() . DOT . $mp->getPostStatus() . EQUAL . "'published'" . " AND "
                . $mpf->getEntity() . DOT . $mpf->getFunction()->getId() . EQUAL . $functionId);
        $list_post_function = $db->getResult();

        $get_menu_parent = $db->selectByID($sf, $sf->getId() . EQUAL . $list_post_function[0][$sf->getParent()]);

        $trim_parent_url = ltrim($get_menu_parent[0][$sf->getUrl()], "#");

        if (!empty($list_post_function)) {
            if (isset($_SESSION[LANGUAGE_SESSION])) {
                $mp_lang = $db->selectByID($mpl, $mpl->getLanguage() . "='" . $_SESSION[LANGUAGE_SESSION] . "'"
                        . " AND " . $mpl->getPost()->getId() . "=" . $list_post_function[0][$mp->getId()]);
            }
            include_once FILE_PATH('view/page/global/master-guest-two-column.html.php');
        } else {
            include_once FILE_PATH(PAGE_404);
        }
    }

    public function pageListPosting() {
        $mpf = new MasterPostFunction();
        $mp = new MasterPost();
        $sf = new SecurityFunction();
        $mpl = new MasterPostLanguage;
//        $db->select("mst_product");
//        $list_product = $db->getResult();
        $functionId = $_POST['function_id_now'];
//        echo $functionId;
        $monthyears = '';
        if (isset($_POST['month']) && isset($_POST['years'])) {
            $month = $_POST['month'];
            $years = $_POST['years'];
            if ($month != 0 && $years != 0) {
                $monthyears = " AND MONTH(" . $mpf->getPost()->getEntity() . DOT . $mpf->getPost()->getPublishOn() . ")" . EQUAL . $month;
                $monthyears .= " AND YEAR(" . $mpf->getPost()->getEntity() . DOT . $mpf->getPost()->getPublishOn() . ")" . EQUAL . $years;
            }
        }
        $db = new Database();
        $db->connect();
        $db->select($mpf->getEntity(), "*", array($mp->getEntity(), $sf->getEntity()), ""
                . $mpf->getEntity() . DOT . $mpf->getPost()->getId() . EQUAL . $mp->getEntity() . DOT . $mp->getId() . " AND "
                . $mpf->getEntity() . DOT . $mpf->getFunction()->getId() . EQUAL . $sf->getEntity() . DOT . $sf->getId() . " AND "
                . $mp->getEntity() . DOT . $mp->getPostStatus() . EQUAL . "'published'" . " AND "
                . $mpf->getEntity() . DOT . $mpf->getFunction()->getId() . EQUAL . $functionId . $monthyears);
        $list_post_function = $db->getResult();

        $get_menu_parent = $db->selectByID($sf, $sf->getId() . EQUAL . $list_post_function[0][$sf->getParent()]);

        $trim_parent_url = ltrim($get_menu_parent[0][$sf->getUrl()], "#");

        if (!empty($list_post_function)) {

            if (isset($_POST['month']) && isset($_POST['years'])) {
                include_once FILE_PATH('view/page/global/list-post/list-post-search.html.php');
            } else {
                include_once FILE_PATH('view/page/global/list-post/master-guest-list-post.html.php');
            }
        } else {
            include_once FILE_PATH(PAGE_404);
        }
    }

    public function pageOnePost() {
//        echo '<script>window.alert(\'tes\')</script>';
        $sf = new SecurityFunction();
        $mpf = new MasterPostFunction();
        $mp = new MasterPost();
        $mpl = new MasterPostLanguage;
//        $db->select("mst_product");
//        $list_product = $db->getResult();
        $postId = $_POST['post_id_now'];
//        echo $postId;
        $db = new Database();
        $db->connect();
        /* $db->select($mpf->getEntity(), "*", array($mp->getEntity(), $sf->getEntity()), ""
          . $mpf->getEntity() . DOT . $mpf->getPost()->getId() . EQUAL . $mp->getEntity() . DOT . $mp->getId() . " AND "
          . $mpf->getEntity() . DOT . $mpf->getFunction()->getId() . EQUAL . $sf->getEntity() . DOT . $sf->getId() . " AND "
          . $mpf->getEntity() . DOT . $mpf->getFunction()->getId() . EQUAL . $functionId);
         * *
         */
        $list_post_function = $db->selectByID($mp, $mp->getId() . "='" . $postId . "'");
//        $list_post_function = $db->getResult();
//        print_r($list_post_function);
        if (!empty($list_post_function)) {
//            print_r($rs_post);
            $str_replace_url = str_replace(URL(), "", FULLURL());
            $split_url_now = explode('/', $str_replace_url);
            $split_url_now_end = end($split_url_now);
            $replace_split_url_now = str_replace('/' . $split_url_now_end, '', $str_replace_url);
//            echo $replace_split_url_now;
            $list_function = $db->selectByID($sf, $sf->getUrl() . "='" . $replace_split_url_now . "'");

            $list_function_parent = $db->selectByID($sf, $sf->getId() . "='" . $list_function[0][$sf->getParent()] . "'");
            if (empty($list_function_parent)) {
                $breadcrumb = array(
                    URL($list_function[0][$sf->getUrl()]) => $list_function[0][$sf->getName()],
                    FULLURL() => $list_post_function[0][$mp->getTitle()]
                );
            } else {
                $breadcrumb = array(
                    URL($list_function_parent[0][$sf->getUrl()]) => $list_function_parent[0][$sf->getName()],
                    URL($list_function[0][$sf->getUrl()]) => $list_function[0][$sf->getName()],
                    FULLURL() => $list_post_function[0][$mp->getTitle()]
                );
            }
            if (isset($_SESSION[LANGUAGE_SESSION])) {
                $mp_lang = $db->selectByID($mpl, $mpl->getLanguage() . "='" . $_SESSION[LANGUAGE_SESSION] . "'"
                        . " AND " . $mpl->getPost()->getId() . "=" . $list_post_function[0][$mp->getId()]);
            }
            include_once getTemplatePath('page/global/master-guest-one-page.html.php');
        } else {
            include_once FILE_PATH(PAGE_404);
        }
    }

    public function chooseMenuPost() {
//        echo '<script>window.alert(\'tes\')</script>';
        $sf = new SecurityFunction();
        $sfa = new SecurityFunctionAssignment();
        $mpf = new MasterPostFunction();
        $mp = new MasterPost();
//        $db->select("mst_product");
//        $list_product = $db->getResult();
        $postId = $_POST['post_id_now'];
        $functionId = $_POST['function_id_now'];
//        echo $postId;
        $db = new Database();
        $db->connect();
        $list_function = $db->selectByID($sf, $sf->getParent() . "='" . $functionId . "'");
        if (!empty($list_function)) {
//            print_r($rs_post);
            $str_replace_url = str_replace(URL(), "", FULLURL());
            $split_url_now = explode('/', $str_replace_url);
            $split_url_now_end = end($split_url_now);
            $replace_split_url_now = str_replace('/' . $split_url_now_end, '', $str_replace_url);
//            echo $replace_split_url_now;
            $list_function_parent = $db->selectByID($sf, $sf->getId() . "='" . $functionId . "'");

            $breadcrumb = array(
                URL($list_function_parent[0][$sf->getUrl()]) => $list_function_parent[0][$sf->getName()],
            );

            include_once FILE_PATH('view/page/global/master-guest-list-function.html.php');
        } else {
            include_once FILE_PATH(PAGE_404);
        }
    }

    public function pageOneNews() {
        $mpf = new MasterPostFunction();
        $mp = new MasterPost();
        $mpl = new MasterPostLanguage;
        $post = $_POST['posting'];
        $db = new Database();
        if (isset($_SESSION[LANGUAGE_SESSION])) {
            $mp_lang = $db->selectByID($mpl, $mpl->getLanguage() . "='" . $_SESSION[LANGUAGE_SESSION] . "'"
                    . " AND " . $mpl->getPostId() . "=" . $post[$mp->getId()]);
        }
        if (isset($_SESSION['read_artikel_' . $post[$mp->getId()]])) {
            if ($_SESSION['read_artikel_' . $post[$mp->getId()]] == $post[$mp->getId()]) {
                
            } else {
                
            }
        } else {
            $_SESSION['read_artikel_' . $post[$mp->getId()]] = $post[$mp->getId()];
            $select = $db->selectByID($mp, $mp->getId() . EQUAL . $post[$mp->getId()]);
                $count = $select[0][$mp->getReadCount()];
                $db->update($mp->getEntity(), array(
                    $mp->getReadCount() => ($count + 1),
                        ), $mp->getId() . EQUAL . $post[$mp->getId()]);
        }
        include_once getTemplatePath('page/global/master-guest-one-page.html.php');
//        print_r($post);
    }

}
