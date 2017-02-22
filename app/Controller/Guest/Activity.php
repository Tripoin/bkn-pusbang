<?php

namespace app\Controller\Guest;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ContactUs
 *
 * @author sfandrianah
 */
use app\Util\Database;
use app\Model\ContactMessage;
use app\Util\Form;

class Activity {

    //put your code here

    public function index() {
//        $url_template = getTemplateURL($url);

        $Form = new Form();

        include getTemplatePath('page/global/activity.html.php');
    }
}