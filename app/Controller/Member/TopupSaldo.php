<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controller\Member;

/**
 * Description of TopupSaldo
 *
 * @author sfandrianah
 */
use app\Util\Form;
use app\Util\Database;
use app\Model\Confirm;

class TopupSaldo {

    public $idimage;
    public $path;
    public $codeRandom;

    public function __construct() {
        $this->idimage = 'upload_proof_payment';
        $this->path = FILE_PATH('uploads/image/confirm/');
        setActiveMenuMember('konfirmasisaldo');
        $this->codeRandom =  createRandomBooking();
    }

    //put your code here
    public function indexKonfirmasi() {
        $Form = new Form();
        setTitle(' | Konfirmasi Topup Saldo');
        include_once FILE_PATH('view/page/member/topup-saldo/konfirmasi.html.php');
    }

    public function konfirmasi() {
        $Form = new Form();
//        setTitle(' | ' . lang('general.user-profile'));
        include_once FILE_PATH('view/page/member/topup-saldo/layout/konfirmasi.html.php');
    }

    public function save() {
        $db = new Database;
        $confirm = new Confirm();

        $temporary = explode(".", $_FILES[$this->idimage]["name"][0]);
        $file_extension = end($temporary);
        $file_name = "confirm-payment-saldo-" . $this->codeRandom . "-" . date('Ymdhis') . "." . $file_extension;

//        $invoice_number = $_POST['invoice_number'];
        $email = $_POST['email'];
        $bank_to = $_POST['bank_to'];
        $sender_bank = $_POST['sender_bank'];
        $sender_account_number = $_POST['sender_account_number'];
        $sender_name = $_POST['sender_name'];
        $transfer_date = $_POST['transfer_date'];
        $transfer_amount = $_POST['transfer_amount'];
        $notes = $_POST['notes'];
        $db->connect();
//        print_r($file_name);
        $db->insert($confirm->getEntity(), array(
//            $confirm->getCode() => $invoice_number,
            $confirm->getEmail() => $email,
            $confirm->getBankSender() => $sender_bank,
            $confirm->getBankTo() => $bank_to,
            $confirm->getNoAccount() => $sender_account_number,
            $confirm->getSenderName() => $sender_name,
            $confirm->getTransferDate() => $transfer_date,
            $confirm->getTransferAmount() => $transfer_amount,
            $confirm->getUploadImg() => $file_name,
            $confirm->getNotes() => $notes,
            $confirm->getCreatedByUsername() => $_SESSION[SESSION_USERNAME],
            $confirm->getCreatedOn() => date('Y-m-d h:i:s'),
            $confirm->getCreatedByIp() => getClientIp(),
            $confirm->getStatus() => 1,
            $confirm->getConfirmStatus() => 0,
            $confirm->getConfirmType() => 2
                )
        );

        $r_upload = $db->getResult();
//        print_r($r_upload);
//        if ($r_upload[0] == 1) {
        echo '1,';
        if (is_numeric($r_upload[0])) {
            
            include_once FILE_PATH('view/page/member/topup-saldo/layout/konfirmasi-success.html.php');
        } else {
            include_once FILE_PATH('view/page/member/topup-saldo/layout/konfirmasi-error.html.php');
        }
//        print_r($_FILES);
    }

    public function uploadImage() {


//        print_r($_FILES);
//        print_r($_POST);
//        $final_image = rand(1000, 1000000) . $img;
//        $this->path = $this->path . strtolower($final_image);
        if ($_FILES[$this->idimage]['error'][0] == 0) {
            $validextensions = array("jpeg", "jpg", "png");
            $temporary = explode(".", $_FILES[$this->idimage]["name"][0]);
            $file_extension = end($temporary);
            $file_name = "confirm-payment-saldo-" . $this->codeRandom . "-" . date('Ymdhis') . "." . $file_extension;
            $file_path_name = $this->path . $file_name;
            if ((($_FILES[$this->idimage]["type"] == "image/png") || ($_FILES[$this->idimage]["type"] == "image/jpg") || ($_FILES[$this->idimage]["type"] == "image/jpeg")
                    ) && in_array($file_extension, $validextensions)) {
                echo '0,' . lang('message.054');
            } else if ($_FILES[$this->idimage]["size"][0] > 2097152) {
                echo '0,' . lang('message.051');
            } else {
                if (file_exists($file_name)) {
                    $sourcePath = $_FILES[$this->idimage]['tmp_name'][0];
                    move_uploaded_file($sourcePath, $file_path_name);
                } else {
                    $sourcePath = $_FILES[$this->idimage]['tmp_name'][0];
                    move_uploaded_file($sourcePath, $file_path_name);
                }
                echo $this->save();
//                print_r($r_upload);
            }
        } else {
            if ($_FILES[$this->idimage]['error'][0] == 4) {
                echo '0,' . lang('message.053');
            } else {
                $image_size = getimagesize($_FILES[$this->idimage]['tmp_name'][0]);
                if ($image_size == false) {
                    echo '0,' . lang('message.051');
                }
            }
//            
        }
//        print_r($_FILES);
    }

}
