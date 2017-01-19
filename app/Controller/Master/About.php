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
use app\Model\MasterPostFunction;
use app\Model\SecurityFunction;
use app\Model\SecurityFunctionAssignment;

class About {

    //put your code here

    public function page() {
        $sf = new SecurityFunction();
        $mpf = new MasterPostFunction();
        $mp = new MasterPost();
        $functionId = $_POST['function_id_now'];
        $db = new Database();
        $db->connect();
        $db->select($mpf->getEntity(), "*", array($mp->getEntity(), $sf->getEntity()), ""
                . $mpf->getEntity() . DOT . $mpf->getPost()->getId() . EQUAL . $mp->getEntity() . DOT . $mp->getId() . " AND "
                . $mpf->getEntity() . DOT . $mpf->getFunction()->getId() . EQUAL . $sf->getEntity() . DOT . $sf->getId() . " AND "
                . $mp->getEntity() . DOT . $mp->getPostStatus() . EQUAL . "'published'" . " AND "
                . $mpf->getEntity() . DOT . $mpf->getFunction()->getId() . EQUAL . $functionId);
        $list_post_function = $db->getResult();

//        print_r("masuk");
//        $db->select("mst_product");
//        $list_product = $db->getResult();
        include_once FILE_PATH('view/page/global/about/about.html.php');
    }

}
