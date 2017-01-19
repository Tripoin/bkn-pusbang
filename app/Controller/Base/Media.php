<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controller\Base;

/**
 * Description of Media
 *
 * @author sfandrianah
 */
use app\Util\Database;
use app\Util\Form;

class Media {

    //put your code here

    public function __construct() {
        setTitle(lang('general.file_manager'));
        setTitleBody(lang('general.file_manager'));
        setBreadCrumb(array(lang('general.file_manager') => FULLURL()));
    }

    public function index() {
        $Form = new Form();
        $db = new Database();

        if (isset($_POST['path'])) {
            include FILE_PATH('view/page/media/list.html.php');
        } else if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'delete':
                    $this->deleteFile();
                    break;
                case 'upload':
                    $this->uploadFile();
                    break;
                default:
                    break;
            }
        } else {
            include FILE_PATH('view/page/media/index.html.php');
        }
    }

    public function uploadFile() {
        $path = FILE_PATH($_POST['file_path']);
        $reArray = reArrayFiles($_FILES['file_name']);
        $result = 1;
        foreach ($reArray as $value) {
            $temporary = explode(".", $value['name']);
            $upload_img = uploadFileImg($value, $temporary[0] . '-' . date('Ymdhis'), $path . '/');
            if ($upload_img['result'] != 1) {
                $result = 0;
            }
        }
        echo $result;
//        print_r($reArray);
    }

    public function deleteFile() {
        $path = rtrim($_POST['file_path'], '/');
        $trim_name = rtrim($_POST['id'], ',');
        $exp_name = explode(',', $trim_name);
//        $path = $_POST['file_path'];
        $result = 1;
        foreach ($exp_name as $value) {
            if (!unlink(FILE_PATH($path . "/" . $value))) {
                $result = 0;
            }
        }
        echo $result;
    }

}
