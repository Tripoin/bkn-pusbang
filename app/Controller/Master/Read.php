<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controller\Master;

/**
 * Description of Read
 *
 * @author sfandrianah
 */
use app\Util\Database;
use app\Model\MasterPostFunction;

class Read {

    //put your code here
    public function child() {
        if (isset($_POST['month']) && isset($_POST['years'])) {
            $month = $_POST['month'];
            $years = $_POST['years'];
            if ($month == 0 && $years == 0) {
                $this->findPost($month, $years);
            } else {
                $this->findPost($month, $years);
            }
        } else {
            $mpf = new MasterPostFunction();
            $db = new Database();
            $db->connect();
            $db->select(
                    $mpf->getFunction()->getEntity(), $mpf->getFunction()->getId() . ',' . $mpf->getFunction()->getName(), array(), $mpf->getFunction()->getCode() . EQUAL . "'" . ENDURL() . "'"
            );
            $cek_menu = $db->getResult();
            if (empty($cek_menu)) {
                $db->select(
                        $mpf->getPost()->getEntity(), "*", array(), $mpf->getPost()->getCode() . EQUAL . "'" . ENDURL() . "'"
                        . " AND " . $mpf->getPost()->getPostStatus() . EQUAL . "'" . PUBLISH . "'"
                );
                $list_post_function = $db->getResult();
                setTitle(" | ".$list_post_function[0][$mpf->getPost()->getTitle()]);
                if (empty($list_post_function)) {
                    include FILE_PATH(PAGE_404);
                } else {
                    include_once FILE_PATH('view/page/read/read-child.html.php');
                }
            } else {
                $db->select(
                        $mpf->getFunction()->getEntity(), $mpf->getFunction()->getName(), array(), $mpf->getFunction()->getCode() . EQUAL . "'" . ENDURL(1) . "'"
                );
                $cek_menu_parent = $db->getResult();

                $db->select(
                        $mpf->getEntity(), "*", array($mpf->getPost()->getEntity()), $mpf->getEntity() . DOT . $mpf->getPost()->getId() . EQUAL . $mpf->getPost()->getEntity() . DOT . $mpf->getPost()->getId()
                        . " AND " . $mpf->getEntity() . DOT . $mpf->getFunction()->getId() . EQUAL . $cek_menu[0][$mpf->getFunction()->getId()]
                        . " AND " . $mpf->getPost()->getEntity() . DOT . $mpf->getPost()->getPostStatus() . EQUAL . "'" . PUBLISH . "'"
                        , "DATE(" . $mpf->getPost()->getPublishOn() . ") DESC"
                );

                $list_post_function = $db->getResult();
                setTitle(" | ".$cek_menu[0][$mpf->getFunction()->getName()]);
                include_once FILE_PATH('view/page/read/read.html.php');
            }
        }
    }

    public function findPost($month, $years) {
        $mpf = new MasterPostFunction();
        $db = new Database();
        $db->connect();
        $db->select(
                $mpf->getFunction()->getEntity(), $mpf->getFunction()->getId() . ',' . $mpf->getFunction()->getName(), array(), $mpf->getFunction()->getCode() . EQUAL . "'" . ENDURL() . "'"
        );
        $cek_menu = $db->getResult();

        $db->select(
                $mpf->getFunction()->getEntity(), $mpf->getFunction()->getName(), array(), $mpf->getFunction()->getCode() . EQUAL . "'" . STARTURL() . "'"
        );
        $cek_menu_parent = $db->getResult();
        $monthyears = '';
//        echo $month.$years;
        if ($month == 0 && $years == 0) {
            $monthyears = '';
        } else {
            $monthyears = " AND MONTH(" . $mpf->getPost()->getEntity() . DOT . $mpf->getPost()->getPublishOn() . ")" . EQUAL . $month;
            $monthyears .= " AND YEAR(" . $mpf->getPost()->getEntity() . DOT . $mpf->getPost()->getPublishOn() . ")" . EQUAL . $years;
        }
        $db->select(
                $mpf->getEntity(), "*", array($mpf->getPost()->getEntity()), $mpf->getEntity() . DOT . $mpf->getPost()->getId() . EQUAL . $mpf->getPost()->getEntity() . DOT . $mpf->getPost()->getId()
                . " AND " . $mpf->getEntity() . DOT . $mpf->getFunction()->getId() . EQUAL . $cek_menu[0][$mpf->getFunction()->getId()]
                . " AND " . $mpf->getPost()->getEntity() . DOT . $mpf->getPost()->getPostStatus() . EQUAL . "'" . PUBLISH . "'"
                . $monthyears
                , "DATE(" . $mpf->getPost()->getPublishOn() . ") DESC"
        );

        $list_post_function = $db->getResult();
//        print_r($list_post_function);
        if (empty($list_post_function)) {
            echo $this->dataNotFound();
        } else {
            include_once FILE_PATH('view/page/read/read-post.html.php');
        }
    }
    public function dataNotFound(){
        return '<div id="content" class="container-fluid" height="10" style="padding-top: 85px;">
        <div class="row top_banner" id="post_header">
            <img src="' . URL('/ccc') . '" width="100%" class="img-responsive">
            <div id="banner_text" class="noselect">
                <div class="banner_title col-md-24 zeropad" style="text-align: center;margin-top: -125px;">Data Not Found</div>
                
            </div>
        </div>
        
    </div>';
    }
    
    public function search(){
        $value = $_POST['value'];
        $mpf = new MasterPostFunction();
        $db = new Database();
        $db->connect();
        $db->select(
                $mpf->getEntity(), "*", array($mpf->getPost()->getEntity(),$mpf->getFunction()->getEntity()), 
                $mpf->getEntity() . DOT . $mpf->getPost()->getId() . EQUAL . $mpf->getPost()->getEntity() . DOT . $mpf->getPost()->getId()
                . " AND " .$mpf->getEntity() . DOT . $mpf->getFunction()->getId() . EQUAL . $mpf->getFunction()->getEntity() . DOT . $mpf->getFunction()->getId()
//                . " AND " . $mpf->getEntity() . DOT . $mpf->getFunction()->getId() . EQUAL . $cek_menu[0][$mpf->getFunction()->getId()]
                . " AND " . $mpf->getPost()->getEntity() . DOT . $mpf->getPost()->getPostStatus() . EQUAL . "'" . PUBLISH . "'"
                . " AND " .$mpf->getPost()->getTitle() . LIKE($value)
                , "DATE(" . $mpf->getPost()->getPublishOn() . ") DESC"
        );
        
        $list_post_function = $db->getResult();
//        print_r($list_post_function);
        if (empty($list_post_function)) {
            echo $this->dataNotFound();
        } else {
            include_once FILE_PATH('view/page/read/read-search.html.php');
        }
    }

}
