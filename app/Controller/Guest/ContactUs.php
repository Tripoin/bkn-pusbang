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

class ContactUs {

    //put your code here

    public function index() {
//        $url_template = getTemplateURL($url);

        $Form = new Form();

        include getTemplatePath('page/global/contact.html.php');
    }

    public function save() {
//        echo 'masuk';
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $security_code = $_POST['security_code_contact'];
//        echo $_SESSION[SESSION_CAPTCHA];
//        print_r($_SESSION['captcha']);
        if ($security_code == $_SESSION[SESSION_CAPTCHA]['code']) {
            $db = new Database();
            $contactMessage = new ContactMessage();

            $db->connect();
            $db->insert($contactMessage->getEntity(), array(
                $contactMessage->getCode() => $security_code . "-" . createRandomBooking(),
                $contactMessage->getGuestName() => $name,
                $contactMessage->getGuestMail() => $email,
                $contactMessage->getSubject() => $subject,
                $contactMessage->getContent() => $message,
                $contactMessage->getStatus() => 1,
                $contactMessage->getCreatedOn() => 'guest',
            ));
            $rs_insert = $db->getResult();
            if (is_numeric($rs_insert[0])) {
                echo resultPageMsg('success', lang('general.title_submit_success'), lang('general.message_submit_success'));
                echo "<script>$(function(){ $('#security_code').val(''); ajaxPostManual('" . URL('captcha/reload') . "','captcha_image_security_code','') })</script>";
            } else {
                echo resultPageMsg('danger', lang('general.title_submit_error'), lang('general.message_submit_error'));
                echo "<script>$(function(){ $('#security_code').focus();$('#security_code').val(''); ajaxPostManual('" . URL('captcha/reload') . "','captcha_image_security_code','') })</script>";
            }
        } else {
            echo resultPageMsg('danger', 'Send Message Contact Failed', 'Please Check Your Security Code');
            echo "<script>$(function(){ $('#security_code').focus();$('#security_code').val(''); ajaxPostManual('" . URL('captcha/reload') . "','captcha_image_security_code','') })</script>";
        }
    }

}
