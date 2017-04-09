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
use app\Model\TransactionEvaluation;
use app\Model\TransactionEvaluationDetails;
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

    public $data_activity, $data_activity_details, $data_parent_subject_assess;
    public $urlListUser, $urlEditUser, $urlSaveUser;

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
        $this->setBreadCrumb(array(lang('survey.survey_organizer') => "", "edit" => ""));
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

        $this->data_activity_details = $db->selectByID($transactionActivityDetails, $transactionActivityDetails->getActivityId() . equalToIgnoreCase($id)
                . " AND " . $transactionActivityDetails->getUserMainId() . " is not null "
        );
        parent::edit();
    }

    public function create() {
        $db = new Database();
        $id = $_POST['id'];

        $transactionActivity = new TransactionActivity();
        $transactionActivityDetails = new TransactionActivityDetails();
        $transactionEvaluation = new TransactionEvaluation();
        $masterUserAssignment = new MasterUserAssignment();
        $masterUserMain = new MasterUserMain();

        $data_user = getUserMember();


        $id_user_assignment = $_POST['id_user_assignment'];
        $this->data_activity_details = $db->selectByID($transactionActivityDetails, $transactionActivityDetails->getId() . equalToIgnoreCase($id));
//        print_r($this->data_activity_details);
        $this->data_activity = $db->selectByID($transactionActivity, $transactionActivity->getId() . equalToIgnoreCase($this->data_activity_details[0][$transactionActivityDetails->getActivityId()]));

        $data_user_assignment = $db->selectByID($masterUserAssignment,
//                $masterUserAssignment->getUser_main_id() . equalToIgnoreCase($data_user[$masterUserMain->getEntity()][$masterUserMain->getId()])
                $masterUserAssignment->getId() . equalToIgnoreCase($id_user_assignment));

        $this->data_evaluation = $db->selectByID($transactionEvaluation, $transactionEvaluation->getActivityDetailsId() . equalToIgnoreCase($this->data_activity_details[0][$transactionActivityDetails->getId()])
                . " AND " . $transactionEvaluation->getUserAssignmentId() . equalToIgnoreCase($id_user_assignment)
        );
//                print_r($this->data_evaluation);
        $this->urlListUser = URL(IURLMemberConstant::REKAPITULASI_NILAI_URL.'/edit');
//        $this->urlEditUser = URL(IURLMemberConstant::AGENDA_WIDYAISWARA_EDIT_USER_URL);
//        $this->urlSaveUser = URL(IURLMemberConstant::AGENDA_WIDYAISWARA_SAVE_USER_URL);
        include_once FILE_PATH(IViewMemberConstant::RECAPITULATION_VALUE_VIEW_INDEX . '/view-user.html.php');
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
