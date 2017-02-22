<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controller\Member;

/**
 * Description of VideoSeminar
 *
 * @author sfandrianah
 */
use app\Model\MasterVideoSeminar as VSeminar;
use app\Model\Notification as Notif;
use app\Util\Database;
use app\Util\Form;
use app\Util\DataTable;
class VideoSeminar {
    //put your code here
    public function __construct() {
        setActiveMenuMember('viewseminar');
    }

    public function index() {
        $Form = new Form();
        setTitle(' | ' . lang('general.video_seminar'));
        include_once FILE_PATH('view/page/member/video-seminar/video-seminar.html.php');
    }

    public function lists() {
//        $Form = new Form();
//        setTitle(' | ' . lang('general.video-seminar'));
        $vSeminar = new VSeminar();
        $db = new Database();
        $db->connect();
        $s_vs = $db->selectByID($vSeminar,$vSeminar->getStatus().EQUAL."1");
//        print_r($s_vs);
        include_once FILE_PATH('view/page/member/video-seminar/video-seminar-list.html.php');
    }

    public function view() {
         $vSeminar = new VSeminar();
        $db = new Database();
        $db->connect();
        $v_vs = $db->selectByID($vSeminar,$vSeminar->getId().EQUAL.$_POST['id']." AND ".$vSeminar->getStatus().EQUAL."1");
//        print_r($v_vs);
        include_once FILE_PATH('view/page/member/video-seminar/video-seminar-view.html.php');
    }
}
