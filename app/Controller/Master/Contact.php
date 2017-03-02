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
use app\Model\ContactMessage;

class Contact {

    //put your code here

    public function page() {

//        $db->select("mst_product");
//        $list_product = $db->getResult();
        if (isset($_POST['name']) && isset($_POST['email'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];

            $cm = new ContactMessage();

            $db = new Database();
            $db->connect();
            $db->insert($cm->getEntity(), array(
                $cm->getGuestName() => $name,
                $cm->getGuestMail() => $email,
                $cm->getSubject() => $subject,
                $cm->getContent() => $message,
                $cm->getCreatedOn() =>  date(DATE_FORMAT_PHP_DEFAULT),
                $cm->getCreatedByIp() => getClientIp()
            ));
            $result = $db->getResult();
            if(is_numeric($result[0])){
                $rs = array("success"=>true,"message"=>lang('contact.contact_title_success'));
                echo json_encode($rs);
            } else {
                 $rs = array("success"=>false,"message"=>"Pengirimin Failed");
                echo json_encode($rs);
            }
//            include_once FILE_PATH('view/page/global/contact/contact-success.html.php');
        } else {
            include_once FILE_PATH('view/page/global/contact/contact.html.php');
        }
    }

}
