<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Approval -> RequestAKD
 * @email : sfandrianah2@gmail.com
 * @author Syahrial Fandrianah
 * @FRAMEWORK NATIVE ADMIN TEMPLATE V.1.0
 */

namespace app\Controller\Approval;

use app\Controller\Base\Controller;
use app\Model\TransactionAKDRequest;
use app\Constant\IURLConstant;
use app\Constant\IViewConstant;
use app\Util\Database;

class RequestAKD extends Controller {

    //put your code here
    public $data_tipe_material = array();
    public $data_unit = array();

    public function __construct() {
        $this->modelData = new TransactionAKDRequest();
        $this->setTitle(lang('approval.approval'));
        $this->setSubtitle(lang('approval.request_akd'));
        $this->setBreadCrumb(array(lang('approval.approval') => "", lang('approval.request_akd') => FULLURL()));
        $this->search_filter = array("code" => lang('general.code'), "name" => lang('general.name'));
        $this->indexUrl = IURLConstant::APPROVAL_REQUEST_AKD_INDEX_URL;
        $this->viewPath = IViewConstant::APPROVAL_REQUEST_AKD_VIEW_INDEX;
        $this->setAutoCrud();
        parent::__construct();
    }

    public function save() {
        if (!isset($_POST['isMaterial'])) {
            $_POST['isMaterial'] = 0;
        }
        parent::save();
    }

    public function update() {
        if (isset($_POST)) {
            if ($_POST['type'] == "approved") {
                $this->approved();
            } else if ($_POST['type'] == "rejected") {
                $this->rejected();
            }
        }
    }

    public function approved() {
        $id = $_POST['id'];
        $db = new Database();
        $data = $this->modelData;
        $codeRandom = createRandomBooking(10);
        $data_select = $db->selectByID($data, $data->getId() . equalToIgnoreCase($id));
        if (!empty($data_select)) {
            $subject = "Appoval Request Code untuk Mengisi AKD";
            $db->connect();
            $db->update($data->getEntity(), array(
                $this->modelData->getIsActived() => 1,
                $this->modelData->getRequestCode() => $codeRandom,
                $this->modelData->getDescription() => $subject . " Disetujui untuk email -> " . $data_select[0][$data->getEmail()],
                $this->modelData->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                $this->modelData->getModifiedByUsername() => $_SESSION[SESSION_ADMIN_USERNAME],
                    ), $data->getId() . EQUAL . $id
            );
            $rs_update = $db->getResult();

            if (is_numeric($rs_update[0]) == 1) {

                $img_logo = IMAGE_ICON_EMAIL_URL;
                $body = '<div style="border-style: solid;border-width: thin;font-family: \'Roboto\';">
                      <div align="center" style="margin:15px;"><img src="' . $img_logo . '" width="120" height="40"/></div>
                        <div align="left" style="margin:15px;">
                            Kepada Yang Terhormat ' . $data_select[0][$data->getParticipantName()] . ',
                        <br/><br/>
                       <p>
                            Request Code untuk Mengisi AKD anda telah <span style="color:#18bf23;font-weight:bold">diseutujui</span>, 
                            Anda bisa melakukan pengisian akd dengan kode dibawah ini:
                            <br/><br/>Request Code : <b>' . $codeRandom . '</b>
                            <br/><br/>
                            Silahkan klik link dibawah ini untuk menuju kehalaman pengisian akd pada Portal Pusbang ASN,
                            <br/>
                            <a href="' . URL('akd') . '" target="_blank">' . URL('akd') . '</a>
                       </p>
                        <br/>
                        <br/>
                        Terima Kasih telah melakukan permintaan kode untuk pengisian akd di Pusbang ASN
                        <br/><a href="' . URL('akd') . '" target="_blank">' . URL('akd') . '</a>
                        </div>
                        </div>
                            ';
                $sendMail = sendMail($data_select[0][$data->getEmail()], $subject, $body);

                if ($sendMail == true) {
                    echo toastAlert("success", lang('general.title_approved_success'), lang('general.message_approved_success'));
                    echo postAjaxPagination();
                } else {
                    $db->update($data->getEntity(), array(
                        $this->modelData->getIsActived() => null,
                        $this->modelData->getRequestCode() => null,
                        $this->modelData->getDescription() => null,
                        $this->modelData->getModifiedOn() => null,
                        $this->modelData->getModifiedByUsername() => null,
                            ), $data->getId() . EQUAL . $id
                    );
                    $rs_update = $db->getResult();
                    echo toastAlert("error", lang('general.title_approved_error'), "Email Gagal di Kirim, Mohon Coba Lagi ...");
                    echo postAjaxPagination();
                    
                }
            } else {
                echo toastAlert("error", lang('general.title_approved_error'), lang('general.message_approved_error') . '<br/>' .
                        json_encode($db->getResult()));
            }
        }
    }

    public function rejected() {
        $id = $_POST['id'];
        $db = new Database();
        $data = $this->modelData;

        $data_select = $db->selectByID($data, $data->getId() . equalToIgnoreCase($id));
        if (!empty($data_select)) {
            $subject = "Appoval Request Code untuk Mengisi AKD";
            $db->connect();
            $db->update($data->getEntity(), array(
                $this->modelData->getIsActived() => 2,
                $this->modelData->getRequestCode() => null,
                $this->modelData->getDescription() => $subject . " tidak disetujui untuk email -> " . $data_select[0][$data->getEmail()],
                $this->modelData->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                $this->modelData->getModifiedByUsername() => $_SESSION[SESSION_ADMIN_USERNAME],
                    ), $data->getId() . EQUAL . $id
            );
            if (is_numeric($db->getResult()[0]) == 1) {
                $subject = "Appoval Request Code untuk Mengisi AKD";

                $img_logo = IMAGE_ICON_EMAIL_URL;
                $body = '<div style="border-style: solid;border-width: thin;font-family: \'Roboto\';">
                      <div align="center" style="margin:15px;"><img src="' . $img_logo . '" width="120" height="40"/></div>
                        <div align="left" style="margin:15px;">
                            Kepada Yang Terhormat ' . $data_select[0][$data->getEmail()] . ',
                        <br/><br/>
                       <p>
                            Request Code untuk Mengisi AKD anda <span style="color:#d80000;font-weight:bold">tidak diseutujui</span>, 
                            Anda bisa menghubungi pihak pusbang asn.
                            <br/><br/>
                            
                       </p>
                        <br/>
                        <br/>
                        Terima Kasih telah melakukan permintaan kode untuk pengisian akd di Pusbang ASN
                        <br/><a href="' . URL('') . '" target="_blank">' . URL('') . '</a>
                        </div>
                        </div>
                            ';
                $sendMail = sendMail($data_select[0][$data->getEmail()], $subject, $body);

                if ($sendMail == true) {
                    echo toastAlert("success", lang('general.title_rejected_success'), lang('general.message_rejected_success'));
                    echo postAjaxPagination();
                } else {
                    
                     $db->update($data->getEntity(), array(
                        $this->modelData->getIsActived() => null,
                        $this->modelData->getRequestCode() => null,
                        $this->modelData->getDescription() => null,
                        $this->modelData->getModifiedOn() => null,
                        $this->modelData->getModifiedByUsername() => null,
                            ), $data->getId() . EQUAL . $id
                    );
                    $rs_update = $db->getResult();
                    echo toastAlert("error", lang('general.title_rejected_error'), "Email Gagal di Kirim, Mohon Coba Lagi ...");
                    echo postAjaxPagination();
                }
            } else {
                echo toastAlert("error", lang('general.title_rejected_error'), lang('general.message_rejected_error') . '<br/>' .
                        json_encode($db->getResult()));
            }
        } else {
            echo postAjaxPagination();
        }
    }

}
