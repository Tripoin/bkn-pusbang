<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of City
 * @email : sfandrianah2@gmail.com
 * @author Syahrial Fandrianah
 * @FRAMEWORK NATIVE ECCOMERCE V.1.0
 */

namespace app\Controller\Base;

use app\Util\Database;
use app\Model\MasterPostFunction;

class Menu {
    
    public function __construct() {
        

    }

    //put your code here
    public function menu() {
        $sfa = new MasterPostFunction();
        $db = new Database();
        $db->connect();
        $db->select(
                $sfa->getFunction()->getEntity(), $sfa->getFunction()->getId() . ',' . $sfa->getFunction()->getName() . ',' . $sfa->getFunction()->getUrl(), array(), $sfa->getFunction()->getCode() . EQUAL . "'" . ENDURL() . "'"
        );
        $cek_menu = $db->getResult();
        $db->select(
                $sfa->getFunction()->getEntity(), $sfa->getFunction()->getName().','.$sfa->getFunction()->getCode(), array(), $sfa->getFunction()->getParent() . EQUAL . "'" . $cek_menu[0][$sfa->getFunction()->getId()] . "'"
        );
        $list_menu = $db->getResult();
        include_once FILE_PATH('view/page/menu/menu3.html.php');
    }

}
