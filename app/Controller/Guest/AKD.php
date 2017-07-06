<?php

namespace app\Controller\Guest;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AKD
 *
 * @author sfandrianah
 */
use app\Model\MasterUserAssignment;
use app\Util\Database;
use app\Model\TransactionAKDRequest;
use app\Model\TransactionQuestionnaire;
use app\Model\TransactionQuestionnaireDetails;
use app\Model\MasterQuestionCategory;
use app\Model\MasterQuestion;
use app\Util\Form;
use app\Util\DataTable;

class AKD {

    //put your code here

    public function index() {
        $Form = new Form();
        $db = new Database();
        $db->connect();
//        echo 'tes';
//        $db->sql("SELECT year_activity FROM trx_activity GROUP BY year_activity");
//        $rs_years = $db->getResult();
        include getTemplatePath('page/global/akd/index.html.php');
    }

    public function requestCode() {
//        echo 'masuk';
        $idNumber = $_POST['idNumber'];
        $noidType = $_POST['noidType'];
        $participantName = $_POST['participant_name_request_akd'];
        $email = $_POST['email_request_akd'];
        $agenciesName = $_POST['agencies_name_request_akd'];
        $occupatioName = $_POST['occupation_name_request_akd'];
        $positionRequestAKD = $_POST['position_request_akd'];
        $security_code = $_POST['security_code_request_akd'];
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if ($security_code == $_SESSION[SESSION_CAPTCHA]['code']) {
                $transactionQuestionnaire = new TransactionQuestionnaire();
                $transactionAKDRequest = new TransactionAKDRequest();
                $db = new Database();
                $db->connect();

                $checkData = $db->selectByID($transactionAKDRequest, ""
                        . $transactionAKDRequest->getEmail() . equalToIgnoreCase($email) .
                        " AND " . $transactionAKDRequest->getIsActived() . " is null");
                if (empty($checkData)) {


                    $code = createRandomBooking();

                    $db->insert($transactionQuestionnaire->getEntity(), array(
                        $transactionQuestionnaire->getCode() => $code . "-" . $idNumber,
                        $transactionQuestionnaire->getName() => $participantName,
                        $transactionQuestionnaire->getLevelQuestionnaireId() => $positionRequestAKD,
                        $transactionQuestionnaire->getStatus() => 1,
                        $transactionQuestionnaire->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                        $transactionQuestionnaire->getCreatedByUsername() => "Pengunjung",
                    ));
                    $result_insert_questionnaire = $db->getResult();
                    if (is_numeric($result_insert_questionnaire[0])) {
                        $db->insert($transactionAKDRequest->getEntity(), array(
                            $transactionAKDRequest->getCode() => $code . "-" . $idNumber,
                            $transactionAKDRequest->getName() => $participantName,
                            $transactionAKDRequest->getIdNumber() => $idNumber,
                            $transactionAKDRequest->getNoidTypeId() => $noidType,
                            $transactionAKDRequest->getQuestionnaireId() => $result_insert_questionnaire[0],
                            $transactionAKDRequest->getParticipantName() => $participantName,
                            $transactionAKDRequest->getAgencyName() => $agenciesName,
                            $transactionAKDRequest->getOccupationName() => $occupatioName,
                            $transactionAKDRequest->getStatus() => 1,
                            $transactionAKDRequest->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                            $transactionAKDRequest->getCreatedByUsername() => "Pengunjung",
                            $transactionAKDRequest->getEmail() => $email,
                            $transactionAKDRequest->getIsActived() => 0,
                        ));
                        $result = $db->getResult();
                        if (is_numeric($result[0])) {
                            $resultSuccess = resultPageMsg('success', lang('general.title_submit_success'), lang('general.message_submit_success'));
                            echo $resultSuccess;
                        } else {
                            echo resultPageMsg('danger', lang('general.title_submit_error'), lang('general.message_submit_error'));
                        }
                    } else {
                        echo resultPageMsg('danger', lang('general.title_submit_error'), lang('general.message_submit_error'));
                    }
                } else {
                    echo resultPageMsg('danger', 'Submit Failed', 'Email ini sudah mengirim request code untuk mengisi akd, Mohon tunggu approval dari pihak pusbang asn.');
                }
            } else {
                echo resultPageMsg('danger', 'Submit Failed', 'Security Code is Wrong');
            }
        } else {
            echo resultPageMsg('danger', 'Submit Failed', 'Format Email is Wrong');
            // invalid address
        }
        echo reloadCaptcha('security_code_request_akd');
    }

    public function pageRequestCode() {
        $Form = new Form();
        $db = new Database();
        $db->connect();
        include getTemplatePath('page/global/akd/page-request-code.html.php');
    }

    public function pageEmailRequestCode() {
        $Form = new Form();
        $db = new Database();
        $db->connect();
        include getTemplatePath('page/global/akd/page-email-request-code.html.php');
    }

    public function checkRequestCode() {
        $code = $_POST['code_request_akd'];
        $security_code = $_POST['security_code_request_akd'];
        if ($security_code == $_SESSION[SESSION_CAPTCHA]['code']) {
            $transactionAKDRequest = new TransactionAKDRequest();
            $db = new Database();
            $db->connect();

            $checkData = $db->selectByID($transactionAKDRequest, ""
                    . $transactionAKDRequest->getRequestCode() . equalToIgnoreCase($code) .
                    " AND " . $transactionAKDRequest->getIsActived() . equalToIgnoreCase(1));
            if (!empty($checkData)) {
                $transactionQuestionnaire = new TransactionQuestionnaire();
                $db->update($transactionQuestionnaire->getEntity(), array(
                    $transactionQuestionnaire->getQuestionnaireStart() => date(DATE_FORMAT_PHP_DEFAULT),
                    $transactionQuestionnaire->getStatus() => 1,
                    $transactionQuestionnaire->getModifiedByUsername() => "Pengunjung",
                    $transactionQuestionnaire->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                        ), $transactionQuestionnaire->getId() . equalToIgnoreCase($checkData[0][$transactionAKDRequest->getQuestionnaireId()]));
                $rs_update_question = $db->getResult();
                $url = URL('akd/page-submit-akd');
                $_SESSION[SESSION_CODE_AKD_GUEST] = $code;
                echo writeMainJavascript("ajaxPostManual('" . $url . "', 'pageAKD', 'code=" . $code . "')");
            } else {
                echo resultPageMsg('danger', 'Submit Failed', 'Your Code is Wrong, Please Rewrite your code');
            }
        } else {
            echo resultPageMsg('danger', 'Submit Failed', 'Security Code is Wrong');
        }
    }

    public function pageSubmitAKD() {
        $Form = new Form();
        $code = $_POST['code'];
        $transactionAKDRequest = new TransactionAKDRequest();
        $db = new Database();
        $db->connect();

        $checkData = $db->selectByID($transactionAKDRequest, ""
                . $transactionAKDRequest->getRequestCode() . equalToIgnoreCase($code) .
                " AND " . $transactionAKDRequest->getIsActived() . equalToIgnoreCase(1));

        if (!empty($checkData)) {
            include getTemplatePath('page/global/akd/page-akd-next.html.php');
        }
    }

    public function submitAKD() {
        if (isset($_POST)) {
            $db = new Database();
            $db->connect();
            $transactionAKDRequest = new TransactionAKDRequest();
            $transactionQuestionnaire = new TransactionQuestionnaire();
            $transactionQuestionnaireDetails = new TransactionQuestionnaireDetails();
            $masterQuestionCategory = new MasterQuestionCategory();
            $masterQuestion = new MasterQuestion();

            $requestCode = $_POST['requestCode'];

            $db->select($transactionAKDRequest->getEntity(), "*", array(), $transactionAKDRequest->getRequestCode() . equalToIgnoreCase($requestCode) .
                    " AND " . $transactionAKDRequest->getIsActived() . equalToIgnoreCase(1)
            );
            $data_akd_request = $db->getResult();
            $questionnaireId = 0;
            if (isset($data_akd_request[0][$transactionAKDRequest->getQuestionnaireId()])) {
                $questionnaireId = $data_akd_request[0][$transactionAKDRequest->getQuestionnaireId()];
            }

            $db->select($transactionQuestionnaire->getEntity(), "*", array(), $transactionQuestionnaire->getId() . equalToIgnoreCase($questionnaireId)
            );
            $data_questionnaire = $db->getResult();

            $result_save = true;
            if (!empty($data_questionnaire)) {
                $db->select($masterQuestionCategory->getEntity(), "*", array(), $masterQuestionCategory->getStatus() . equalToIgnoreCase(1), $masterQuestionCategory->getCode() . " ASC ");
                $data_question_category = $db->getResult();
                foreach ($data_question_category as $value_question_category) {
                    $db->select($masterQuestion->getEntity(), "*", array(), ""
                            . $masterQuestion->getStatus() . equalToIgnoreCase(1) .
                            " AND " . $masterQuestion->getQuestionCategoryId() . equalToIgnoreCase($value_question_category[$masterQuestionCategory->getId()]), $masterQuestion->getId() . " ASC ");
                    $data_question = $db->getResult();
                    foreach ($data_question as $value_question) {
                        $codeRandom = createRandomBooking();
                        if (isset($_POST[$value_question_category[$masterQuestionCategory->getCode()] . $value_question[$masterQuestion->getCode()] . '1']) && isset($_POST[$value_question_category[$masterQuestionCategory->getCode()] . $value_question[$masterQuestion->getCode()] . '2'])) {

                            $db->insert($transactionQuestionnaireDetails->getEntity(), array(
                                $transactionQuestionnaireDetails->getCode() => $codeRandom,
                                $transactionQuestionnaireDetails->getName() => $value_question[$masterQuestion->getName()],
                                $transactionQuestionnaireDetails->getQuestionId() => $value_question[$masterQuestion->getId()],
                                $transactionQuestionnaireDetails->getJsonAnswer() => $_POST[$value_question_category[$masterQuestionCategory->getCode()] . $value_question[$masterQuestion->getCode()] . '1'] . "," . $_POST[$value_question_category[$masterQuestionCategory->getCode()] . $value_question[$masterQuestion->getCode()] . '2'],
                                $transactionQuestionnaireDetails->getQuestionnaireId() => $data_questionnaire[0][$transactionQuestionnaire->getId()],
                                $transactionQuestionnaireDetails->getStatus() => 1,
                                $transactionQuestionnaireDetails->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                                $transactionQuestionnaireDetails->getCreatedByUsername() => "Pengunjung",
                            ));
                            $rs_insert_details = $db->getResult();
                            if (!is_numeric($rs_insert_details[0])) {
                                $result_save = false;
                            }
                        } else {
                            $db->insert($transactionQuestionnaireDetails->getEntity(), array(
                                $transactionQuestionnaireDetails->getCode() => $codeRandom,
                                $transactionQuestionnaireDetails->getName() => $value_question[$masterQuestion->getName()],
                                $transactionQuestionnaireDetails->getQuestionId() => $value_question[$masterQuestion->getId()],
                                $transactionQuestionnaireDetails->getJsonAnswer() => $_POST[$value_question_category[$masterQuestionCategory->getCode()] . $value_question[$masterQuestion->getCode()]],
                                $transactionQuestionnaireDetails->getQuestionnaireId() => $data_questionnaire[0][$transactionQuestionnaire->getId()],
                                $transactionQuestionnaireDetails->getStatus() => 1,
                                $transactionQuestionnaireDetails->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                                $transactionQuestionnaireDetails->getCreatedByUsername() => "Pengunjung",
                            ));
                            $rs_insert_details = $db->getResult();
                            if (!is_numeric($rs_insert_details[0])) {
                                $result_save = false;
                            }
                        }
//                    $answer = 
                    }
                }
            } else {
                $result_save = false;
            }
        } else {
            $result_save = false;
        }

        if ($result_save == true) {
            $db->update($transactionAKDRequest->getEntity(), array(
                $transactionAKDRequest->getIsActived() => 3,
                $transactionAKDRequest->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                $transactionAKDRequest->getModifiedByUsername() => $_SESSION[SESSION_ADMIN_USERNAME],
                    ), $transactionAKDRequest->getId() . EQUAL . $data_akd_request[0][$transactionAKDRequest->getId()]
            );
            $rs_akd_request_update = $db->getResult();

            $db->update($transactionQuestionnaire->getEntity(), array(
                $transactionQuestionnaire->getQuestionnaireEnd() => date(DATE_FORMAT_PHP_DEFAULT),
                $transactionQuestionnaire->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                $transactionQuestionnaire->getModifiedByUsername() => $_SESSION[SESSION_ADMIN_USERNAME],
                    ), $transactionQuestionnaire->getId() . EQUAL . $data_akd_request[0][$transactionAKDRequest->getQuestionnaireId()]
            );
            $rs_questionnaire_update = $db->getResult();

            unset($_SESSION[SESSION_CODE_AKD_GUEST]);
            $resultSuccess = resultPageMsg('success', lang('general.title_submit_success'), lang('general.message_submit_success'));
            echo toastAlert('success', lang('general.title_submit_success'), lang('general.message_submit_success'));
            echo $resultSuccess;
        } else {
            echo toastAlert('error', lang('general.title_submit_error'), lang('general.message_submit_error'));
            echo resultPageMsg('danger', lang('general.title_submit_error'), lang('general.message_submit_error'));
        }
    }

}
