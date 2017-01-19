<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controller\Master;

/**
 * Description of Project
 *
 * @author sfandrianah
 */
use app\Util\Database;
use app\Model\SecurityFunctionAssignment;
use app\Model\MasterPost;
use app\Model\MasterPostFunction;

//use Katzgrau\KLogger\Logger;

class Project {
//    public $title_name;
    
    public function __construct() {
        
    }

    //put your code here
    public function index() {


        $sfa = new SecurityFunctionAssignment();
//        echo 'masuk';
//        $mPost = new MasterPost();
        $db = new Database();
        $db->connect();
        $db->select(
                $sfa->getFunction()->getEntity(), $sfa->getFunction()->getId() . ',' . $sfa->getFunction()->getName() . ',' . $sfa->getFunction()->getUrl(), array(), $sfa->getFunction()->getCode() . EQUAL . "'" . ENDURL() . "'"
        );
        $cek_menu = $db->getResult();
        $db->select(
                $sfa->getFunction()->getEntity(), $sfa->getFunction()->getName() . ',' . $sfa->getFunction()->getCode(), array(), $sfa->getFunction()->getParent() . EQUAL . "'" . $cek_menu[0][$sfa->getFunction()->getId()] . "'"
        );
        $list_menu = $db->getResult();
        
        setTitle(" | ".$cek_menu[0][$sfa->getFunction()->getName()]);
        include_once FILE_PATH('view/page/project/project.html.php');
    }

    public function child() {
//        echo 'tes';
//        echo ENDURL(1);
        $sfa = new SecurityFunctionAssignment();
        $mPost = new MasterPost();
        $mpf = new MasterPostFunction();
        $db = new Database();
        $db->connect();
        $db->select(
                $sfa->getFunction()->getEntity(), $sfa->getFunction()->getId() . ',' . $sfa->getFunction()->getName(), array(), $sfa->getFunction()->getCode() . EQUAL . "'" . ENDURL() . "'"
        );
        $cek_menu = $db->getResult();

        $db->select(
                $sfa->getFunction()->getEntity(), $sfa->getFunction()->getName(), array(), $sfa->getFunction()->getCode() . EQUAL . "'" . ENDURL(1) . "'"
        );
        $cek_menu_parent = $db->getResult();

        /*
          $db->select(
          $mPost->getEntity(), "*", array(), $mPost->getFunction()->getId() . EQUAL . $cek_menu[0][$sfa->getFunction()->getId()]
          );
          $list_menu = $db->getResult();
         * */
        $db->select(
                $mpf->getEntity(), "*", array($mpf->getPost()->getEntity()), $mpf->getEntity() . DOT . $mpf->getPost()->getId() . EQUAL . $mpf->getPost()->getEntity() . DOT . $mpf->getPost()->getId()
                . " AND " . $mpf->getEntity() . DOT . $mpf->getFunction()->getId() . EQUAL . $cek_menu[0][$mpf->getFunction()->getId()]
                . " AND " . $mpf->getPost()->getEntity() . DOT . $mpf->getPost()->getPostStatus() . EQUAL . "'" . PUBLISH . "'"
                , "DATE(" . $mpf->getPost()->getPublishOn() . ") DESC"
        );
        $list_menu = $db->getResult();
        setTitle(" | ".$cek_menu[0][$sfa->getFunction()->getName()]);
        include_once FILE_PATH('view/page/project/project-child.html.php');
    }

}
