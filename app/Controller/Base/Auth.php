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

namespace app\Controller\Base;

use app\Util\RestClient;
use app\Util\Facebook\FacebookSession;
use app\Util\Facebook\FacebookRedirectLoginHelper;
use app\Util\Facebook\FacebookRequest;
use app\Util\Facebook\FacebookResponse;
use app\Util\Facebook\FacebookSDKException;
use app\Util\Facebook\FacebookRequestException;
use app\Util\Facebook\FacebookAuthorizationException;
use app\Util\Facebook\GraphObject;
use app\Util\Facebook\Entities\AccessToken;
use app\Util\Facebook\HttpClients\FacebookCurlHttpClient;
use app\Util\Facebook\HttpClients\FacebookHttpable;
use app\Util\Database;
use app\Util\Form;
use app\Model\SecurityUser;
use app\Model\SecurityUserProfile;
use app\Model\SecurityGroup;
use app\Util\PHPMail\PHPMailer;
use app\Model\TransactionRegistration;
use app\Model\LinkRegistration;
use app\Model\MasterAttachment;
use app\Model\MasterAddress;
use app\Model\MasterContact;
use app\Model\MasterWorkingUnit;
use app\Model\MasterGovernmentAgencies;

class Auth {

    //put your code here
    public function __construct() {
        
    }

    public function login() {
        $this->loginProses();
    }

    public function register() {
        $this->registerProses();
    }

    public function registerProsesTest() {
        echo resultPageMsg("success", lang('general.title_register_success'), lang('general.message_register_member'));
        echo '<script>$(\'#form-newedit\').remove()</script>';
    }

    public function registerProses() {
        $db = new Database();
        $transactionRegistration = new TransactionRegistration();
        $security_code = $_POST['security_code'];
        if ($security_code == $_SESSION[SESSION_CAPTCHA]['code']) {
            $participant_category = $_POST['participant_category'];

            $subject_name = $_POST['subject_name'];
            $recommend_letter = $_FILES['recommend_letter'];
            $pic_name = $_POST['pic_name'];
            $pic_email = $_POST['pic_email'];
            $pic_telephone = $_POST['pic_telephone'];
            $pic_fax = $_POST['pic_fax'];
            $pic_address = $_POST['pic_address'];
            $province = $_POST['province'];
            $city = $_POST['city'];
            $district = $_POST['district'];
            $village = $_POST['village'];
            $zipCode = $_POST['zip_code'];

            $subject = $_POST['subject'];
            $message = $_POST['message'];

            if (!filter_var($pic_email, FILTER_VALIDATE_EMAIL)) {
                echo resultPageMsg('danger', lang('general.title_register_failed'), lang('member.pic_email') . ' is Invalid');
                echo toastAlert('error', lang('general.title_register_failed'), lang('member.pic_email') . ' is Invalid');
            } else {
                $explode_email = explode("@", $pic_email);
                $reArray = reArrayFiles($recommend_letter);
                $result = array("upload_result" => 1, "upload_message" => "");
                foreach ($reArray as $value) {
                    $temporary = explode(".", $value['name']);
                    $upload_img = uploadFileImg($value, $temporary[0] . '-' . date('Ymdhis'), FILE_PATH('uploads/member/' . $explode_email[0] . '/'));
                    if ($upload_img['result'] != 1) {
                        $result = array("upload_result" => 0, "upload_message" => $upload_img['message']);
                    } else {
                        $result = array(
                            "upload_result" => 1,
                            "upload_message" => $upload_img['message'],
                            "upload_file_name" => $upload_img['file_name']
                        );
                    }
                }
                if ($result['upload_result'] == 1) {
                    $result_all = false;

                    $code = createRandomBooking();
                    $db->connect();
                    $db->insert($transactionRegistration->getEntity(), array(
                        $transactionRegistration->getCode() => $code,
                        $transactionRegistration->getDelegationName() => $pic_name,
                        $transactionRegistration->getDelegationEmail() => $pic_email,
                        $transactionRegistration->getDelegationPhoneNumber() => $pic_telephone,
                        $transactionRegistration->getDelegationFax() => $pic_fax,
                        $transactionRegistration->getDelegationAddress() => $pic_address,
                        $transactionRegistration->getProvinceId() => $province,
                        $transactionRegistration->getCityId() => $city,
                        $transactionRegistration->getDistrictId() => $district,
                        $transactionRegistration->getVillageId() => $village,
                        $transactionRegistration->getParticipantTypeId() => $participant_category,
                        $transactionRegistration->getMessageTitle() => $subject,
                        $transactionRegistration->getMessageContent() => $message,
                        $transactionRegistration->getCreatedByUsername() => $explode_email[0]
                    ));
                    $rs_registration = $db->getResult();
                    if (is_numeric($rs_registration[0])) {
                        $masterAttachment = new MasterAttachment();
                        $code_attachment = createRandomBooking() . $result['upload_file_name'];
                        $db->insert($masterAttachment->getEntity(), array(
                            $masterAttachment->getCode() => $code_attachment,
                            $masterAttachment->getName() => $result['upload_file_name'],
                            $masterAttachment->getStatus() => 1,
                            $masterAttachment->getCreatedByUsername() => $explode_email[0]
                        ));
                        $rs_attach = $db->getResult();
                        if (is_numeric($rs_attach[0])) {
                            $linkRegistration = new LinkRegistration();
                            $db->insert($linkRegistration->getEntity(), array(
                                $linkRegistration->getRegistrationId() => $rs_registration[0],
                                $linkRegistration->getAttachmentLetterId() => $rs_attach[0],
                                $linkRegistration->getSubjectId() => $subject_name,
                            ));
                            $rs_link_regis = $db->getResult();
                            if (is_numeric($rs_link_regis[0])) {

                                if ($participant_category == 1) {
                                    $sendMail = $this->sendMailRegister();
                                    if ($sendMail == 1) {
                                        echo resultPageMsg("success", lang('general.title_register_success'), lang('general.message_register_member'));
                                        echo toastAlert('success', lang('general.title_register_success'), lang('general.message_register_member'));
                                        echo '<script>$(\'#form-newedit\').remove()</script>';
                                    } else {
                                        echo resultPageMsg('danger', lang('general.title_register_failed'), lang('general.message_register_failed'));
                                        echo toastAlert('error', lang('general.title_register_failed'), lang('general.message_register_failed'));
                                    }
                                }
                                $result_all = true;
                            } else {
                                echo resultPageMsg('danger', lang('general.title_register_failed'), lang('general.message_register_failed') . json_encode($rs_link_regis));
                                echo toastAlert('error', lang('general.title_register_failed'), lang('general.message_register_failed'));
                            }
                        } else {
                            echo resultPageMsg('danger', lang('general.title_register_failed'), lang('general.message_register_failed'));
                            echo toastAlert('error', lang('general.title_register_failed'), lang('general.message_register_failed'));
                        }
                    } else {
                        echo resultPageMsg('danger', lang('general.title_register_failed'), lang('general.message_register_failed'));
                        echo toastAlert('error', lang('general.title_register_failed'), lang('general.message_register_failed'));
                    }
                } else {
                    echo resultPageMsg('danger', lang('general.title_register_failed'), $result['upload_message']);
                    echo toastAlert('error', lang('general.title_register_failed'), $result['upload_message']);
                }
                if ($result_all == true) {
                    if ($participant_category != 1) {
                        $workingUnit = $_POST['working_unit'];

                        $addressInstansi = $_POST['address_instansi'];
                        $provinceInstansi = $_POST['province_instansi'];
                        $cityInstansi = $_POST['city_instansi'];
                        $districtInstansi = $_POST['district_instansi'];
                        $villageInstansi = $_POST['village_instansi'];
                        $masterAddress = new MasterAddress();

                        $code_address = createRandomBooking();
                        $db->insert($masterAddress->getEntity(), array(
                            $masterAddress->getCode() => $code_address,
                            $masterAddress->getName() => $addressInstansi,
                            $masterAddress->getProvinceId() => $provinceInstansi,
                            $masterAddress->getCityId() => $cityInstansi,
                            $masterAddress->getVillageId() => $villageInstansi,
                            $masterAddress->getDistrictId() => $districtInstansi,
                            $masterAddress->getZipCode() => $zipCode
                        ));

                        $rs_address = $db->getResult();
                        if (is_numeric($rs_address[0])) {
                            $governmentAgentcies = $_POST['government_agencies'];
                            $masterContact = new MasterContact();
                            $officeTelephone = $_POST['office_telephone'];
                            $officeFax = $_POST['office_fax'];

                            $code_contact = createRandomBooking();
                            $db->insert($masterContact->getEntity(), array(
                                $masterContact->getCode() => $code_contact,
                                $masterContact->getPhoneNumber1() => $officeTelephone,
                                $masterContact->getFax() => $officeFax,
                            ));
                            $rs_contact = $db->getResult();
                            if (is_numeric($rs_contact[0])) {
                                $governmentAgentcies_id = null;
                                if ($governmentAgentcies == "") {
                                    $code_agencies = createRandomBooking();
                                    $masterGovernmentAgencies = new MasterGovernmentAgencies();
                                    $governmentAgentcies_name = $_POST['government_agencies_2'];
                                    $db->insert($masterGovernmentAgencies->getEntity(), array(
                                        $masterGovernmentAgencies->getCode() => $code_agencies,
                                        $masterGovernmentAgencies->getName() => $governmentAgentcies_name,
                                    ));
                                    $rs_agencies = $db->getResult();
                                    if (is_numeric($rs_agencies[0])) {
                                        $governmentAgentcies_id = $rs_agencies[0];
                                    } else {
                                        $governmentAgentcies_id = null;
                                    }
                                } else {
                                    $governmentAgentcies_id = $governmentAgentcies;
                                }
                                $workingUnitId = null;
                                if ($workingUnit == "") {
                                    $masterWorkingUnit = new MasterWorkingUnit();
                                    $code_working_unit = createRandomBooking();
                                    $workingUnit_name = $_POST['working_unit_2'];
                                    $db->insert($masterWorkingUnit->getEntity(), array(
                                        $masterWorkingUnit->getCode() => $code_working_unit,
                                        $masterWorkingUnit->getName() => $workingUnit_name,
                                        $masterWorkingUnit->getAddress_id() => $rs_address[0],
                                        $masterWorkingUnit->getContact_id() => $rs_contact[0],
                                        $masterWorkingUnit->getGovernment_agency_id() => $governmentAgentcies_id,
                                        $masterWorkingUnit->getStatus() => 1
                                    ));
                                    $rs_working_unit = $db->getResult();
                                    if (is_numeric($rs_working_unit[0])) {
                                        $workingUnitId = $rs_working_unit[0];
                                    } else {
                                        $workingUnitId = null;
                                    }
                                } else {
                                    $masterWorkingUnit = new MasterWorkingUnit();
                                    $code_working_unit = createRandomBooking();
                                    $workingUnit_name = $_POST['working_unit_2'];
                                    $db->update($masterWorkingUnit->getEntity(), array(
                                        $masterWorkingUnit->getCode() => $code_working_unit,
                                        $masterWorkingUnit->getName() => $workingUnit_name,
                                        $masterWorkingUnit->getAddress_id() => $rs_address[0],
                                        $masterWorkingUnit->getContact_id() => $rs_contact[0],
                                        $masterWorkingUnit->getGovernment_agency_id() => $governmentAgentcies_id,
                                        $masterWorkingUnit->getStatus() => 1
                                            ), $masterWorkingUnit->getId() . EQUAL . $workingUnit);
                                    $workingUnitId = $workingUnit;
                                }
//                            $rs_registration[0];
                                $db->update($transactionRegistration->getEntity(), array(
                                    $transactionRegistration->getWorkingUnitId() => $workingUnitId,
                                        ), $transactionRegistration->getId() . EQUAL . $rs_registration[0]);
                                $rs_update_registration = $db->getResult();
                                if ($rs_update_registration[0] == 1) {
//                                    echo resultPageMsg("success", lang('general.title_register_success'), lang('general.message_register_member'));
//                                    echo toastAlert('success', lang('general.title_register_success'), lang('general.message_register_member'));
//                                    echo '<script>$(\'#form-newedit\').remove()</script>';
                                    $sendMail = $this->sendMailRegister();
                                    if ($sendMail == 1) {
                                        echo resultPageMsg("success", lang('general.title_register_success'), lang('general.message_register_member'));
                                        echo toastAlert('success', lang('general.title_register_success'), lang('general.message_register_member'));
                                        echo '<script>$(\'#form-newedit\').remove()</script>';
                                    } else {
                                        echo resultPageMsg('danger', lang('general.title_register_failed'), lang('general.message_register_failed'));
                                        echo toastAlert('error', lang('general.title_register_failed'), lang('general.message_register_failed'));
                                    }
                                } else {
                                    echo resultPageMsg('danger', lang('general.title_register_failed'), lang('general.message_register_failed'));
                                    echo toastAlert('error', lang('general.title_register_failed'), lang('general.message_register_failed'));
                                }
                            } else {
                                echo resultPageMsg('danger', lang('general.title_register_failed'), lang('general.message_register_failed'));
                                echo toastAlert('error', lang('general.title_register_failed'), lang('general.message_register_failed'));
                            }
                        } else {
                            echo resultPageMsg('danger', lang('general.title_register_failed'), lang('general.message_register_failed'));
                            echo toastAlert('error', lang('general.title_register_failed'), lang('general.message_register_failed'));
                        }
                    }
                } else {
                    echo resultPageMsg('danger', lang('general.title_register_failed'), lang('general.message_register_failed'));
                    echo toastAlert('error', lang('general.title_register_failed'), lang('general.message_register_failed'));
                }
            }
        } else {
            echo resultPageMsg('danger', lang('general.title_register_failed'), lang('general.security_code') . ' is Wrong');
            echo toastAlert('error', lang('general.title_register_failed'), lang('general.security_code') . ' is Wrong');
        }
    }

    public function sendMailRegister() {
        $pic_name = $_POST['pic_name'];
        $pic_email = $_POST['pic_email'];

        $mail = new PHPMailer;
        try {
            $mail->isSMTP();

            $mail->Debugoutput = 'html';
//            $mail->SMTPDebug = 4;
            $mail->Host = MAIL_HOST;

            $mail->Port = MAIL_SMTP_PORT;
            $mail->SMTPSecure = MAIL_SMTPSECURE;
            $mail->SMTPAuth = MAIL_SMTPAUTH;
//        $mail->SMTPAutoTLS = ['ssl'=> ['allow_self_signed' => true]];

            $mail->Username = MAIL_USERNAME;
            $mail->Password = MAIL_PASSWORD;


            $mail->isHTML(true);

//Set who the message is to be sent from
            $mail->setFrom(MAIL_USERNAME, MAIL_FULLNAME);

//Set an alternative reply-to address
            $mail->addReplyTo($pic_email, $pic_name);

//Set who the message is to be sent to
            $mail->addAddress($pic_email, $pic_name);
            $img_logo_tala = 'http://54.251.168.102/e-portal/contents/logo-kecil.png';
            $mail->Subject = 'Registrasi Peserta Pusbang BKN';
            $mail->Body = '<div style="border-style: solid;border-width: thin;font-family: \'Roboto\';">
                      <div align="center" style="margin:15px;"><img src="' . $img_logo_tala . '" width="120" height="40"/></div>
                        <div align="left" style="margin:15px;">
                            Halo ' . $pic_name . ',
                        <br/><br/>
                       ' . lang('general.message_register_member') . '
                        
                        <br/>
                        <a href="' . URL('') . '" target="_blank">' . URL('') . '</a>
                        </div>
                        </div>
                            ';
            if ($mail->smtpConnect()) {
                $mail->smtpClose();
                if (!$mail->send()) {
                    echo $mail->ErrorInfo;
                } else {
                    return 1;
                }
            } else {
                return 0;
            }
        } catch (\Exception $e) {
            echo $e->getMessage(); //Boring error messages from anything else!
        }
    }

    public function loginProses() {

        $user = new SecurityUser();
        $userProfile = new SecurityUserProfile();
        $group = new SecurityGroup();
//        $username = $_POST['username'];
        $email = $_POST['username'];
        $password = $_POST['password'];
        $security_code = $_POST['security_code'];
        if ($security_code == $_SESSION[SESSION_CAPTCHA]['code']) {

            $dbNew = new Database();
            $dbNew->connect();

            $dbNew->sql("SELECT * FROM " . $user->getEntity() . " 
            WHERE LOWER(" . $user->getCode() . ") = '" . $email . "' 
                AND " . $user->getStatus() . EQUAL . ONE);
            $rsPostNew = $dbNew->getResult();
            if (empty($rsPostNew)) {
                $dbNew->sql("SELECT * FROM " . $user->getEntity() . " 
            WHERE LOWER(" . $user->getEmail() . ") = '" . $email . "' 
                AND " . $user->getStatus() . EQUAL . ONE);
                $rsPostNew = $dbNew->getResult();
            }

            if (empty($rsPostNew)) {
                echo resultPageMsg("danger", lang('general.login_failed'), lang('general.login_failed_username'));
                echo '<script>ajaxPostManual(\'' . URL('captcha/reload') . '\',\'captcha_image_security_code\');</script>';
            } else {
                $result_group = false;
                if ($rsPostNew[0][$user->getGroupId()] != 2) {
                    $res_group = $dbNew->selectByID($group, $group->getId() . "='" . $rsPostNew[0][$user->getGroupId()] . "'");
                    if (!empty($res_group)) {
                        if ($res_group[0][$group->getParentId()] == 2) {
                            $result_group = true;
                        }
                    }
                } else {
                    $result_group = true;
                }

                if ($result_group == false) {
                    echo resultPageMsg("danger", lang('general.login_failed'), lang('general.login_failed_username'));
                    echo '<script>ajaxPostManual(\'' . URL('captcha/reload') . '\',\'captcha_image_security_code\');</script>';
                } else {
                    if (password_verify($password, $rsPostNew[0][$user->getPassword()])) {
                        $res_user = $dbNew->selectByID($userProfile, $userProfile->getUserId() . "='" . $rsPostNew[0][$user->getId()] . "'");
                        $_SESSION[SESSION_USERNAME_GUEST] = $rsPostNew[0][$user->getCode()];
                        $_SESSION[SESSION_EMAIL_GUEST] = $rsPostNew[0][$user->getEmail()];
                        $_SESSION[SESSION_FULLNAME_GUEST] = $res_user[0][$userProfile->getName()];
                        $_SESSION[SESSION_GROUP_GUEST] = $rsPostNew[0][$user->getGroupId()];
                        $_SESSION[SESSION_EXPIRED_DATE_GUEST] = $rsPostNew[0][$user->getExpiredDate()];
                        echo resultPageMsg("success", lang('general.login_success'), lang('general.login_success_message'));
                        echo '<script>window.location.href = "' . URL('') . '";</script>';
                    } else {
                        echo resultPageMsg("danger", lang('general.login_failed'), lang('general.login_failed_username'));
                        echo '<script>ajaxPostManual(\'' . URL('captcha/reload') . '\',\'captcha_image_security_code\');</script>';
                    }

//                
                }
            }
        } else {
            echo resultPageMsg("danger", lang('general.login_failed'), lang('general.security_code') . " is Wrong");
            echo '<script>ajaxPostManual(\'' . URL('captcha/reload') . '\',\'captcha_image_security_code\');</script>';
        }
    }

    public function loginApplication() {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $RestClient = new RestClient();
        $RestClient->to(URL_API_ECCOMERCE . '?action=login&rest=user')
                ->username($username)
                ->password($password)
                ->post();
        $response_decode = json_decode($RestClient->getBody);
        if ($response_decode->result == 0) {
            echo '
                <h5 class="text-danger text-center">' . lang('general.login_failed') . '</h5>
                <h6 class="text-inverse text-center">' . lang('general.login_failed_message') . '</h6>
                ';
        } else {
            $RestClient = new RestClient();
            $RestClient->to(URL_API_ECCOMERCE . '?action=profile&rest=user')
                    ->username($username)
                    ->password($password)
                    ->post();
            $response_decode_profile = json_decode($RestClient->getBody);
            $_SESSION[SESSION_USERNAME] = $username;
            $_SESSION[SESSION_FULLNAME] = $username;
            $_SESSION[SESSION_TOKEN] = $password;
            $_SESSION['profile'] = $response_decode_profile->item;
            echo '
                <h5 class="text-success text-center">' . lang('general.login_success') . '</h5>
                ';
            echo '<script>window.location.href = ".";</script>';
        }
    }

    public function loginPage() {
//        echo 'masuk';
        $Form = new Form();
        include FILE_PATH('/view/page/user/login.html.php');
    }

    public function registerPage() {
//        echo 'masuk';
        $Form = new Form();
        include FILE_PATH('/view/page/user/register.html.php');
    }

    public function forgotPasswordPage() {
//        echo 'masuk';
        if (isset($_GET['v'])) {
            $token = $_GET['v'];
            $exp_token = explode('-', $token);
            $user = new SecurityUser();
            $userProfile = new SecurityUserProfile();
            $dbNew = new Database();
            $dbNew->connect();
            $rsPostUser = $dbNew->selectByID($user, $user->getCode() . "='" . $exp_token[0] . "' AND " . $user->getPassword() . "='" . $exp_token[1] . "'");
            if (empty($rsPostUser)) {
                include FILE_PATH(PAGE_404);
            } else {
                include FILE_PATH('/view/page/user/forgot_password_member.html.php');
            }
        } else {
            include FILE_PATH('/view/page/user/forgot_password.html.php');
        }
    }

    public function changePassword() {
        $user = new SecurityUser();

        $password_new = $_POST['password_new'];
        $password_renew = $_POST['password_renew'];
        $token = $_POST['token'];

//        $username = $_POST['username'];

        if ($password_new == $password_renew) {
            $salt = substr(md5(uniqid(rand(), true)), 0, 9);
            $password_e = sha1($salt . sha1($salt . sha1($password_renew)));
            $exp_token = explode('-', $token);
            $dbNew = new Database();
            $dbNew->connect();
            $dbNew->update($user->getEntity(), array(
                $user->getPassword() => $password_e,
                $user->getSalt() => $salt
                    ), $user->getCode() . "='" . $exp_token[0] . "' AND " . $user->getPassword() . "='" . $exp_token[1] . "'");
            $rs_c_password = $dbNew->getResult();
            if ($rs_c_password[0] == 1) {
                echo resultPageMsg('success', lang('user.title_change_password_success'), lang('user.title_change_password_success'));
                echo '<script>window.location.href = "' . URL('') . '";</script>';
            } else {
                echo resultPageMsg('danger', lang('user.title_change_password_failed'), lang('user.title_change_password_failed'));
            }
        } else {
            echo resultPageMsg('danger', lang('user.title_change_password_failed'), lang('user.message_change_password_failed_not_same'));
        }
    }

    public function forgotPassword() {
        $user = new SecurityUser();
        $userProfile = new SecurityUserProfile();
//        $username = $_POST['username'];
        $email = $_POST['email'];
        $dbNew = new Database();
        $dbNew->connect();

        /* $dbNew->sql("SELECT * FROM " . $user->getEntity() . " 
          WHERE LOWER(" . $user->getEmail() . ") = '" . $email . "'
          AND (" . $user->getPassword() . " = SHA1(CONCAT(user_salt, SHA1(CONCAT(user_salt, SHA1('" . $password . "')))))
          OR " . $user->getEmail() . " = '" . md5($password) . "') AND status = '1' AND " . $user->getApproved() . " = '1'");
          $rsPostNew = $dbNew->getResult(); */

        $rsPostUP = $dbNew->selectByID($userProfile, $userProfile->getEmail() . "='" . $email . "'");
//        $rsPostUP = $dbNew->getResult();
//        print_r($rsPostUP);
        if (empty($rsPostUP)) {
//            echo 'Login Failed';
            echo toastAlert("error", lang('general.forgot_password_failed'), lang('general.email_not_registered'));
            echo "<script>$(function(){postAjaxGetValue('" . URL('/page/forgot-password') . "','modal-body-self','" . json_encode($_POST) . "'); })</script>";
        } else {
            $rsPostUP2 = $dbNew->selectByID($user, $user->getId() . "='" . $rsPostUP[0][$userProfile->getId()] . "'");
//            $rsPostUP2 = $dbNew->getResult();
            if (empty($rsPostUP2)) {
                echo toastAlert("error", lang('general.forgot_password_failed'), lang('general.email_not_registered') . $rsPostUP2[0]);
                echo "<script>$(function(){postAjaxGetValue('" . URL('/page/forgot-password') . "','modal-body-self','" . json_encode($_POST) . "'); })</script>";
            } else {

                $mail = new PHPMailer;

                $mail->isSMTP();

                $mail->Debugoutput = 'html';
//$mail->SMTPDebug = 2;
                $mail->Host = MAIL_HOST;

                /*       $mail->Port = 465;
                  $mail->SMTPSecure = 'ssl';
                  $mail->SMTPAuth = true;

                  $mail->Username = "talaindonesia2@gmail.com";
                  $mail->Password = "t4l4indonesia";
                 */
                $mail->Port = MAIL_SMTP_PORT;
                $mail->SMTPSecure = 'ssl';
                $mail->SMTPAuth = true;

                $mail->Username = MAIL_USERNAME;
                $mail->Password = MAIL_PASSWORD;

                $mail->isHTML(true);

//Set who the message is to be sent from
                $mail->setFrom(MAIL_USERNAME, MAIL_FULLNAME);

//Set an alternative reply-to address
                $mail->addReplyTo($email, $rsPostUP[0][$userProfile->getFullname()]);

//Set who the message is to be sent to
                $mail->addAddress($email, $rsPostUP[0][$userProfile->getFullname()]);
                $img_logo_tala = 'http://talaindonesia.com/assets/images/logo.png';
                $mail->Subject = 'Validasi Reset Password';
                $mail->Body = '<div style="border-style: solid;border-width: thin;font-family: \'Roboto\';">
                      <div align="center" style="margin:15px;"><img src="' . $img_logo_tala . '" width="70" height="40"/></div>
                        <div align="left" style="margin:15px;">
                            Halo ' . $rsPostUP[0][$userProfile->getFullname()] . ',
                        <br/><br/>
                        Kami menerima permintaan melakukan reset password Anda. Jika Anda merasa tidak melakukan ini, mohon abaikan saja email ini. Email ini tidak akan berguna setelah 2 jam.
                        <br/><br/>
                        Untuk melakukan reset password Anda, silahkan klik link dibawah:
                        <br/><br/>
                        <a href="' . URL('/page/forgot-password?v=' . $rsPostUP2[0][$user->getCode()] . '-' . $rsPostUP2[0][$user->getPassword()]) . '" target="_blank">' . URL('/page/forgot-password?v=' . $rsPostUP2[0][$user->getCode()] . '-' . $rsPostUP2[0][$user->getPassword()]) . '</a>
                        <br/><br/>
                        Setelah Anda meng-klik link di atas, password Anda akan direset dan kemudian sebuah password baru akan dikirimkan ke email Anda.
                        <br/><br/>
                        Terimakasih
                        <br/><br/>
                        ' . MAIL_FULLNAME . '
                        <br/>
                        <a href="' . URL('') . '" target="_blank">' . URL('') . '</a>
                        </div>
                        </div>
                            ';
                if ($mail->smtpConnect()) {
                    $mail->smtpClose();
                    //echo "Connected";
                    if (!$mail->send()) {
                        // echo "1" . $mail->ErrorInfo;
//                echo json_encode($statusgagal);
//                        return 'GAGAL';
                        echo toastAlert("error", lang('general.forgot_password_failed'), $mail->ErrorInfo);
                        echo "<script>$(function(){postAjaxGetValue('" . URL('/page/forgot-password') . "','modal-body-self','" . json_encode($_POST) . "'); })</script>";
                    } else {
//                echo json_encode($status);
//                        return 'SUKSES';
//                        echo toastAlert("success", lang('general.send_email_success'), lang('general.send_email_success_msg'));
//                        echo "<script>$(function(){postAjaxGetValue('" . URL('/page/forgot-password') . "','modal-body-self','" . json_encode($_POST) . "'); })</script>";
                        echo resultPageMsg('success', lang('general.send_email_success'), lang('general.send_email_success_msg'));
                    }
                } else {
//            echo json_encode($statusgagal);
//            echo "Connection Failed";
//                    return 'GAGAL';
                    echo toastAlert("error", lang('general.forgot_password_failed'), lang('general.not_connected'));
                    echo "<script>$(function(){postAjaxGetValue('" . URL('/page/forgot-password') . "','modal-body-self','" . json_encode($_POST) . "'); })</script>";
                }

//                echo '<script>window.location.href = "' . URL('') . '";</script>';
            }
        }
    }

    public function loginfacebook() {

        FacebookSession::setDefaultApplication(APP_ID, APP_SECRET);
        $helper = new FacebookRedirectLoginHelper(URL('/page/user/login?type=2'));
        try {
            $session = $helper->getSessionFromRedirect();
        } catch (FacebookRequestException $ex) {
            // When Facebook returns an error
        } catch (Exception $ex) {

            // When validation fails or other local issues
        }
        if (isset($session)) {

            // graph api request for user data
            $request = new FacebookRequest($session, 'GET', '/me');
            $response = $request->execute();
//            print_r($response);
            // get response
            $graphObject = $response->getGraphObject();
            $token = $response->getRequest()->getSession()->getAccessToken();
//            print_r($response->getRequest()->getSession()->getAccessToken());
            $fbid = $graphObject->getProperty('id');              // To Get Facebook ID
            $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
//            $femail = $graphObject->getProperty('email');    // To Get Facebook email ID
            /* ---- Session Variables ----- */
            $_SESSION[SESSION_USERNAME] = $fbid;
            $_SESSION[SESSION_FULLNAME] = $fbfullname;
            $_SESSION[SESSION_TOKEN] = $token;
            echo "<script>
            window.close();
            window.opener.location.reload();
        </script>";
//            echo 'masuk';
            /* ---- header location after session ---- */
//            checkuser($fbid,$fbfullname,$femail);
//  header("Location: index.php");
        } else {
            $loginUrl = $helper->getLoginUrl();
            header("Location: " . $loginUrl);
        }
    }

    public function logout() {
        ini_set("display_errors", "Off");
        session_unset($_SESSION[SESSION_USERNAME]);
        session_unset($_SESSION[SESSION_EMAIL]);
        session_unset($_SESSION[SESSION_FULLNAME]);
        session_unset($_SESSION[SESSION_GROUP]);
        echo '<script>window.location.href = "' . URL('') . '";</script>';
    }

}
