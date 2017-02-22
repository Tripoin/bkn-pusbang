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
use app\Model\TransactionActivity;
use app\Model\TransactionRegistration;
use app\Util\Form;

class Activity {

    //put your code here

    public function index() {
//        $url_template = getTemplateURL($url);

        $transActivity = new TransactionActivity();
        $db = new Database();

        $rs_activity = $db->selectByID($transActivity);
        $Form = new Form();
        include getTemplatePath('page/global/activity.html.php');
    }

    public function registerActivityPage($id) {
        $transActivity = new TransactionActivity();
        $db = new Database();

        $rs_subject = $db->selectByID($transActivity,$transActivity->getId().EQUAL.$id);
//        print_r($rs_subject);
        $Form = new Form();
        include getTemplatePath('/page/global/activity/register.html.php');
    }

    public function saveNewRegister(){
        $code = createRandomBooking();
        $picName = $_POST['pic_name'];
        $picEmail = $_POST['pic_email'];
        $picPhone = $_POST['pic_telephone'];
        $picFax = $_POST['pic_fax'];
        $picAddress = $_POST['pic_address'];
        $picProvince = $_POST['province'];
        $picCity = $_POST['city'];
        $picDistrict = $_POST['district'];
        $picVillage = $_POST['village'];
        $picZipCode = $_POST['zip_code'];
        $picParticipant = $_POST['participant_category'];
        $picGovAgencies = $_POST['government_agencies'];
        $picWorkingUnit = $_POST['working_unit'];
        $ofcAddress = $_POST['address_instansi'];
        $ofcOfficePhone = $_POST['office_telephone'];
        $ofcProvince = $_POST['province_instansi'];
        $ofcCity = $_POST['city_instansi'];
        $ofcDistrict = $_POST['district_instansi'];
        $ofcVillage = $_POST['village_instansi'];
        $ofcFax = $_POST['office_fax'];
        $ofcZipCode = $_POST['post_code'];
        $subjectTitle = $_POST['subject'];
        $msgSubject = $_POST['message'];


        $recommendLetter = $_FILES['recommend_letter'];
        $reArray = reArrayFiles($recommendLetter);
        $upload = uploadFileImg($reArray[0],$reArray[0]['name'],FILE_PATH('uploads/'));

        $trxRegdata = new TransactionRegistration();


        $db = new Database();
        $db->connect();
        $db->insert($trxRegdata->getEntity()
        , array(
                $trxRegdata->getCode() => $code,
                $trxRegdata->getDelegationName() => $picName,
                $trxRegdata->getDelegationEmail() => $picEmail,
                $trxRegdata->getDelegationPhoneNumber() => $picPhone,
                $trxRegdata->getDelegationFax() => $picFax,
                $trxRegdata->getDelegationAddress() => $picAddress,
                $trxRegdata->getProvinceId() => $picProvince,
                $trxRegdata->getCityId() => $picCity,
                $trxRegdata->getDistrictId() => $picDistrict,
                $trxRegdata->getVillageId() => $picVillage,
                $trxRegdata->getZipCode() =>$picZipCode,
                $trxRegdata->getParticipantTypeId() => $picParticipant,
                $trxRegdata->getWorkingUnitId() => $picWorkingUnit,
                $trxRegdata->getGovernmentAgencies() => $picGovAgencies,
                $trxRegdata->getWuPhoneNumber() => $ofcOfficePhone,
                $trxRegdata->getWuFax() =>$ofcFax,
                $trxRegdata->getWuAddress() => $ofcAddress,
                $trxRegdata->getWuProvinceId() => $ofcProvince,
                $trxRegdata->getWuCityId() => $ofcCity,
                $trxRegdata->getWuDistrictId() => $ofcDistrict,
                $trxRegdata->getWuVillageId() => $ofcVillage,
                $trxRegdata->getWuZipCode() => $ofcZipCode,
                $trxRegdata->getMessageTitle() => $subjectTitle,
                $trxRegdata->getMessageContent() => $msgSubject
            ));
        $result = $db->getResult();
        if(is_numeric($result[0])){
            echo toastAlert('success',lang('general.title_register_success'),lang('general.message_register_success'));
            echo resultPageMsg('success',lang('general.title_register_success'),lang('general.message_register_success'));
        } else {
            echo toastAlert('error',lang('general.title_register_failed'),lang('general.message_register_failed'));
            echo resultPageMsg('danger',lang('general.title_register_failed'),lang('general.message_register_failed'));
        }
        //echo toastAlert();
    }
}