<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Home
 *
 * @author sfandrianah
 */

namespace app\Controller\Base;


use app\Model\MasterPostFunction;
use app\Model\MasterPost;
use app\Util\Database;
use app\Util\DataTable;

class Home {

    //put your code here
    public function __construct() {
        setTitle('');
    }

    public function index() {
//        echo 'masuk';
        if (!isset($_POST['urut'])) {
            if (isset($_GET[LANGUAGE_SESSION])) {
                $_SESSION[LANGUAGE_SESSION] = $_GET[LANGUAGE_SESSION];
                echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';
            }
            try {

                $prm_template = getSystemParameter('GENERAL_TEMPLATE_THEME');
                if ($prm_template == '') {
                    include 'template/' . TEMPLATE_DEFAULT . '/index.php';
                } else {
                    include 'template/' . $prm_template . '/index.php';
                }
            } catch (Exception $e) {
                echo 'Message: ' . $e->getMessage();
            }
        } else {
            $mpf = new MasterPostFunction();
            $masterPost = new MasterPost();

            $db = new Database();
            $Datatable = new DataTable();
            $Datatable->per_page = 5;
            $Datatable->current_page = $_POST['urut'];
            $where = $mpf->getEntity() . "." . $mpf->getPostId() . EQUAL . $masterPost->getEntity() . "." . $masterPost->getId() . ""
                    . " AND " . $mpf->getEntity() . "." . $mpf->getFunctionId() . EQUAL . "1";

            $join = $masterPost->getEntity();
            $list_data = $Datatable->select_pagination($mpf, $mpf->getEntity(), $where, $join, null, $masterPost->getPublishOn()." DESC");
            
            include getTemplatePath('/page/global/list-artikel.html.php');
        }
    }

    public function indexAdministrator() {
//        echo 'masuk ';
        $prm_template = getSystemParameter('SYSTEM_ADMINISTRATOR_THEME');
        setTitle(lang('general.dashboard'));
        if ($prm_template == '') {

            include getAdminTemplatePath('index.php');
        } else {
//            include 'view/index.php';

            include getAdminTemplatePath('index.php');
        }
    }

}
