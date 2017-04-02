<?php

namespace app\Controller\Member;

use app\Controller\Base\ControllerMember;
use app\Model\TransactionActivity;
use app\Model\TransactionActivityDetails;
use app\Constant\IURLMemberConstant;
use app\Model\LinkSubjectAssess;
use app\Model\MasterSubject;
use app\Model\MasterCategoryAssess;
use app\Model\MasterSurveyCategory;
use app\Model\MasterUserAssignment;
use app\Model\MasterUserMain;
use app\Model\TransactionSurvey;
use app\Model\TransactionSurveyDetails;
use app\Model\SecurityRole;
use app\Constant\IViewMemberConstant;
use app\Util\Database;

/**
 * Modified by Netbeans 8.1.
 * User: Syahrial Fandrianah
 * Date: 29/03/2017
 * Time: 24:00
 */
class RekapitulasiNilai extends ControllerMember {

    public $data_activity,$data_activity_details, $data_parent_subject_assess;

    public function __construct() {
        $this->modelData = new TransactionActivity();
        $this->setTitle(lang('member.recapitulation_value'));
//        $this->setSubtitle(lang('survey.survey_organizer'));
        $this->setBreadCrumb(array(lang('member.recapitulation_value') => ""));
        $this->search_filter = array(
            "name" => lang('transaction.type')
        );
        $this->orderBy = $this->modelData->getId() . " DESC";
        $this->indexUrl = IURLMemberConstant::REKAPITULASI_NILAI_URL;
        $this->viewPath = IViewMemberConstant::RECAPITULATION_VALUE_VIEW_INDEX;
        $this->setAutoCrud();
        parent::__construct();
    }

    public function edit() {
        $this->setBreadCrumb(array(lang('survey.survey_organizer') => "","edit"=>""));
        $db = new Database();
        $id = $_POST['id'];

        $transactionActivity = new TransactionActivity();
        $transactionActivityDetails = new TransactionActivityDetails();
        $masterCategoryAssess = new MasterCategoryAssess();
        $masterSubject = new MasterSubject();
        $linkSubjectAssess = new LinkSubjectAssess();
        $masterSurveyCategory = new MasterSurveyCategory();

        $data_survey_category = $db->selectByID($masterSurveyCategory, $masterSurveyCategory->getCode() . equalToIgnoreCase('SURVEY-KEGIATAN'));
        $this->data_activity = $db->selectByID($transactionActivity, $transactionActivity->getId() . equalToIgnoreCase($id));

        $db->select($linkSubjectAssess->getEntity(), $masterCategoryAssess->getEntity() . DOT . $masterCategoryAssess->getName() . " as name,"
                . $masterCategoryAssess->getEntity() . DOT . $masterCategoryAssess->getId() . " as id", array(
            $masterCategoryAssess->getEntity()
                ), ""
                . $linkSubjectAssess->getEntity() . DOT . $linkSubjectAssess->getCategoryAssessParentId() . EQUAL . $masterCategoryAssess->getEntity() . DOT . $masterCategoryAssess->getId()
                . " AND " . $linkSubjectAssess->getEntity() . DOT . $linkSubjectAssess->getSubjectId() . equalToIgnoreCase($this->data_activity[0][$transactionActivity->getSubjectId()])
                . " GROUP BY " . $linkSubjectAssess->getEntity() . DOT . $linkSubjectAssess->getCategoryAssessParentId());
        $this->data_parent_subject_assess = $db->getResult();
        
        $this->data_activity_details = $db->selectByID($transactionActivityDetails, $transactionActivityDetails->getActivityId() . equalToIgnoreCase($id));
        parent::edit();
    }

    public function update() {
        $id = $_POST['id'];
        $db = new Database();
        $db->connect();


        $masterUserMain = new MasterUserMain();
        $masterUserAssignment = new MasterUserAssignment();
        $data_user = getUserMember();
//        echo $data_user[$masterUserMain->getEntity()][$masterUserMain->getId()];
        $data_user_assign = $db->selectByID($masterUserAssignment, ""
                . $masterUserAssignment->getUser_main_id() . equalToIgnoreCase($data_user[$masterUserMain->getEntity()][$masterUserMain->getId()])
                . " AND " . $masterUserAssignment->getActivity_id() . equalToIgnoreCase($id));

        $transactionActivity = new TransactionActivity();
        $masterCategoryAssess = new MasterCategoryAssess();
//        $masterSubject = new MasterSubject();
        $linkSubjectAssess = new LinkSubjectAssess();
        $masterSurveyCategory = new MasterSurveyCategory();
        $transactionSurvey = new TransactionSurvey();
        $transactionSurveyDetails = new TransactionSurveyDetails();


        $data_survey_category = $db->selectByID($masterSurveyCategory, $masterSurveyCategory->getCode() . equalToIgnoreCase('SURVEY-KEGIATAN'));
        $this->data_activity = $db->selectByID($transactionActivity, $transactionActivity->getId() . equalToIgnoreCase($id));

        $db->select($linkSubjectAssess->getEntity(), ""
                . $masterCategoryAssess->getEntity() . DOT . $masterCategoryAssess->getName() . " as name,"
                . $masterCategoryAssess->getEntity() . DOT . $masterCategoryAssess->getCode() . " as code,"
                . $masterCategoryAssess->getEntity() . DOT . $masterCategoryAssess->getId() . " as id", array(
            $masterCategoryAssess->getEntity()
                ), ""
                . $linkSubjectAssess->getEntity() . DOT . $linkSubjectAssess->getCategoryAssessParentId() . EQUAL . $masterCategoryAssess->getEntity() . DOT . $masterCategoryAssess->getId()
                . " AND " . $linkSubjectAssess->getEntity() . DOT . $linkSubjectAssess->getSubjectId() . equalToIgnoreCase($this->data_activity[0][$transactionActivity->getSubjectId()])
                . " GROUP BY " . $linkSubjectAssess->getEntity() . DOT . $linkSubjectAssess->getCategoryAssessParentId());
        $this->data_parent_subject_assess = $db->getResult();

        $result = true;

        if (!empty($data_user_assign)) {
            foreach ($this->data_parent_subject_assess as $data_parent) {

                $db->select($linkSubjectAssess->getEntity(), ""
                        . $masterCategoryAssess->getEntity() . DOT . $masterCategoryAssess->getName() . " as name,"
                        . $masterCategoryAssess->getEntity() . DOT . $masterCategoryAssess->getCode() . " as code,"
                        . $masterCategoryAssess->getEntity() . DOT . $masterCategoryAssess->getId() . " as id", array(
                    $masterCategoryAssess->getEntity()
                        ), ""
                        . $linkSubjectAssess->getEntity() . DOT . $linkSubjectAssess->getCategoryAssessId() . EQUAL . $masterCategoryAssess->getEntity() . DOT . $masterCategoryAssess->getId()
                        . " AND " . $linkSubjectAssess->getEntity() . DOT . $linkSubjectAssess->getSubjectId() . equalToIgnoreCase($this->data_activity[0][$transactionActivity->getSubjectId()])
                        . " AND " . $linkSubjectAssess->getEntity() . DOT . $linkSubjectAssess->getCategoryAssessParentId() . equalToIgnoreCase($data_parent['id'])
                );
                $data_subject_assess = $db->getResult();
                $total = 0;
//            $average = 0;
                foreach ($data_subject_assess as $value) {
                    $total += intval($_POST[$value['code']]);
                }

                $average = intval($total) / count($data_subject_assess);
                $db->insert($transactionSurvey->getEntity(), array(
                    $transactionSurvey->getCode() => createRandomBooking() . '-' . $data_parent['code'],
                    $transactionSurvey->getName() => $data_parent['name'],
                    $transactionSurvey->getValue() => $total,
                    $transactionSurvey->getRateValue() => $average,
                    $transactionSurvey->getUserAssignmentId() => $data_user_assign[0][$masterUserAssignment->getId()],
                    $transactionSurvey->getSurveyCategoryId() => $data_survey_category[0][$masterSurveyCategory->getId()],
                    $transactionSurvey->getStatus() => 1,
                    $transactionSurvey->getCreatedByUsername() => $_SESSION[SESSION_USERNAME_GUEST],
                    $transactionSurvey->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT)
                ));
                $rs_insert_survey = $db->getResult();
                if (is_numeric($rs_insert_survey[0])) {
                    foreach ($data_subject_assess as $value) {
                        $db->insert($transactionSurveyDetails->getEntity(), array(
                            $transactionSurveyDetails->getSurveyId() => $rs_insert_survey[0],
                            $transactionSurveyDetails->getCategoryAssessId() => $value['id'],
                            $transactionSurveyDetails->getValue() => $_POST[$value['code']],
                            $transactionSurveyDetails->getEvaluatedBy() => $_SESSION[SESSION_USERNAME_GUEST],
                            $transactionSurveyDetails->getEvaluatedOn() => date(DATE_FORMAT_PHP_DEFAULT)
                                )
                        );
                        $rs_insert_survey_details = $db->getResult();
                        if (!is_numeric($rs_insert_survey_details[0])) {
                            $result = false;
                        }
                    }
                } else {
                    $result = false;
                }
            }
            if ($result == true) {
                echo toastAlert("success", lang('general.title_update_success'), lang('general.message_update_success'));
            } else {
                echo toastAlert("error", lang('general.title_update_error'), lang('general.message_update_error'));
            }
        } else {
            echo toastAlert("error", lang('general.title_update_error'), "Anda Belum terdaftar pada kegiatan ini");
        }
        echo postAjaxPagination();
    }

    public function listData() {
        $db = new Database();
//        $db->connect();
        $transactionActivity = new TransactionActivity();
        $this->modelSubject = $transactionActivity;
        $masterUserAssignment = new MasterUserAssignment();
        $masterUserMain = new MasterUserMain();
        $securityRole = new SecurityRole();


        $data_user = getUserMember();

        $data_role = $db->selectByID($securityRole, $securityRole->getCode() . equalToIgnoreCase('PARTICIPANT'));
//        echo $data_user[$masterUserMain->getId()];
        $this->search_list = $transactionActivity->getEntity();
        $this->select_entity = $transactionActivity->getEntity() . '.*';
        $this->join_list = array($masterUserAssignment->getEntity());
        $this->where_list = $transactionActivity->getEntity() . DOT . $transactionActivity->getId() . EQUAL . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getActivity_id()
                . " AND " . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getUser_main_id() . equalToIgnoreCase($data_user[$masterUserMain->getEntity()][$masterUserMain->getId()])
                . " AND " . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getRoleId() . equalToIgnoreCase($data_role[0][$securityRole->getId()]);
//        echo $_POST['search_by'];
        $sr = $this->modelSubject->search($_POST['search_by']);

        if (empty($sr)) {
            $_POST['search_by'] = "";
            $_POST['search_pagination'] = "";
        }
        parent::listData();
    }

    

}
