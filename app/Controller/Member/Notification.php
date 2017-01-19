<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controller\Member;

/**
 * Description of Notification
 *
 * @author sfandrianah
 */
use app\Model\Notification as Notif;
use app\Util\Database;
use app\Util\Form;
use app\Util\DataTable;

//use app\Model\Confirm;
//use app\Model\SecurityUser;
class Notification {

    //put your code here
    public function __construct() {
        setActiveMenuMember('notification');
    }

    public function index() {
        $Form = new Form();
        setTitle(' | ' . lang('general.notification'));
        include_once FILE_PATH('view/page/member/notification/notification.html.php');
    }

    public function lists() {
        $Form = new Form();
//        setTitle(' | ' . lang('general.notification'));
        $Datatable = new DataTable();
        $Datatable->searchFilter(array("title" => lang('notification.title')));
        $Datatable->collectionRow(false);

        if (isset($_POST['current_page'])) {
            $Datatable->current_page = $_POST['current_page'];
        }
        if (isset($_POST['per_page'])) {
            $Datatable->per_page = $_POST['per_page'];
        }
        if (isset($_POST['search_pagination'])) {
            $Datatable->search = $_POST['search_by'] . '>' . $_POST['search_pagination'];
        }
        $notif = new Notif();
        $rs_notif = $Datatable->select_pagination($notif, $notif->getEntity(), $notif->getTo() . "='" . $_SESSION[SESSION_USERNAME] . "'",null,null,$notif->getDate()." DESC ");


        include_once FILE_PATH('view/page/member/notification/notification-list.html.php');
    }

    public function view() {
        $db = new Database();
        $notif = new Notif();

        $db->connect();
        $s_notif = $db->selectByID($notif, $notif->getId() . "='" . $_POST['id'] . "' AND " . $notif->getTo() . "='" . $_SESSION[SESSION_USERNAME] . "'");
        if (!empty($s_notif)) {
            $db->update($notif->getEntity(), array(
                $notif->getRead() => 1,
                    ), $notif->getId() . EQUAL . $_POST['id']);
            $r_notif_update = $db->getResult();
            $db->sql("SELECT COUNT(" . $notif->getRead() . ") as total_notif FROM " . $notif->getEntity() . " WHERE " . $notif->getRead() . EQUAL . "0 AND " . $notif->getTo() . "='" . $_SESSION[SESSION_USERNAME] . "'");
            $sql_reads = $db->getResult();
        }

        include_once FILE_PATH('view/page/member/notification/notification-view.html.php');
    }

}
