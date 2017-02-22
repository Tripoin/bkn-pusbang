<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controller\Base;

/**
 * Description of GuestMenu
 *
 * @author sfandrianah
 */
class GuestMenu {
    //put your code here
    public function index() {
         setBreadCrumb('');
        setTitle('Guest Menu');
        setTitleBody('Guest Menu');
        showActionHeader(false);
        include FILE_PATH('view/page/security/guest-menu/index.html.php');
    }
}
