<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controller\Base;

/**
 * Description of Register
 *
 * @author sfandrianah
 */
use app\Util\Form;
class Register {

    //put your code here

    public function index() {
        echo 'masuk';
        $Form = new Form();
        include FILE_PATH('view/page/user/register.html.php');
    }

}
