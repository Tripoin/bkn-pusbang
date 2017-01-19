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

class Carrer {

    //put your code here

    public function page() {
//        $db->select("mst_product");
//        $list_product = $db->getResult();
        include_once FILE_PATH('view/page/global/carrer/carrer.html.php');
    }

}
