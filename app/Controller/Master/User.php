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
class User {

    //put your code here

    public function change() {
        $request_uri = $_SERVER['REQUEST_URI'];
        $explode_uri = explode('/', $request_uri);
        $Form = new Form();
        include_once FILE_PATH('view/page/user/change.html.php');
    }

}
