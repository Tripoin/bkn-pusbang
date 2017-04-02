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

namespace app\Controller\Security;

use app\Model\MasterSystemParameter;
use app\Model\MasterLanguage;
use app\Util\Database;
use app\Util\Form;
use app\Util\RestClient\TripoinRestClient;

class Settings {

    //put your code here
    public function __construct() {
        setTitle(lang('security.setting'));
        setTitleBody(lang('security.setting'));
        setBreadCrumb(array(lang('security.setting') => FULLURL()));
    }

    public function eLearning() {

        
        include 'view/page/security/settings/e-learning.html.php';
    }

    public function index() {
//        echo 'masuk';
        $Form = new Form();
        $mo = new MasterSystemParameter();
        $db = new Database();

        $ml = new MasterLanguage();
        $list_ml = $db->selectByID($ml, $ml->getStatus() . EQUAL . ONE);
        $data_ml = convertJsonCombobox($list_ml, $ml->getCode(), $ml->getName());
        include 'view/page/security/settings/index.html.php';
    }

    public function update() {
//        $Form = new Form();
        $mo = new MasterSystemParameter();
        $db = new Database();
        $db->connect();
        $result = true;
        foreach ($_POST as $key => $value) {
            $db->update($mo->getEntity(), array(
                $mo->getName() => $value
                    ), $mo->getCode() . "='" . $key . "'");
            $rs = $db->getResult();
            if ($rs[0] != 1) {
                $result = false;
            }
        }
        if ($result == true) {
            echo resultPageMsg("success", lang('general.title_update_success'), lang('general.message_update_success'));
        } else {
            echo resultPageMsg("danger", lang('general.title_update_error'), lang('general.message_update_error'));
        }
    }

}
