<?php

namespace app\Controller\Member\AgendaActivity;

use app\Controller\Base\ControllerMember;
use app\Model\TransactionActivity;
use app\Constant\IURLMemberConstant;
use app\Constant\IViewConstant;
use app\Model\SecurityRole;
use app\Model\TransactionActivityDetails;
//use app\Model\TransactionSurvey;
use app\Model\LinkSubjectAssess;
use app\Model\MasterSubject;
use app\Model\MasterCategoryAssess;
use app\Model\MasterSurveyCategory;
use app\Model\MasterUserAssignment;
use app\Model\MasterUserMain;
use app\Model\TransactionSurvey;
use app\Model\TransactionSurveyDetails;
use app\Model\TransactionEvaluation;
use app\Model\TransactionEvaluationDetails;
use app\Constant\IViewMemberConstant;
use app\Util\Database;

/**
 * created by Netbeans 8.1.
 * User: Syahrial Fandrianah
 * Date: 29/03/2017
 * Time: 24:00
 */
class AgendaWidyaiswara extends ControllerMember {

    public $data_activity, $data_activity_details, $data_evaluation, $data_parent_subject_assess;
    public $urlListUser, $urlEditUser, $urlSaveUser;

    public function __construct() {
        $this->modelData = new TransactionActivity();
        $this->setTitle(lang('member.agenda_widyaiswara'));
        $this->setBreadCrumb(array(lang('survey.survey_organizer') => ""));
        $this->search_filter = array(
            "startActivity" => lang('member.year')
        );
        $this->orderBy = $this->modelData->getId() . " DESC";
        $this->indexUrl = IURLMemberConstant::AGENDA_WIDYAISWARA_URL;
        $this->viewPath = IViewMemberConstant::AGENDA_WIDYAISWARA_VIEW_INDEX;
        $this->setAutoCrud();
        parent::__construct();
    }

    public function edit() {
        $db = new Database();
        $id = $_POST['id'];

        $transactionActivity = new TransactionActivity();

        $this->data_activity = $db->selectByID($transactionActivity, $transactionActivity->getId() . equalToIgnoreCase($id));

        $this->urlListUser = URL(IURLMemberConstant::AGENDA_WIDYAISWARA_LIST_USER_URL);
        parent::edit();
    }

    public function listUser() {
        $db = new Database();
        $id = $_POST['id'];

        $transactionActivity = new TransactionActivity();

        $this->data_activity = $db->selectByID($transactionActivity, $transactionActivity->getId() . equalToIgnoreCase($id));
        $this->urlEditUser = URL(IURLMemberConstant::AGENDA_WIDYAISWARA_EDIT_USER_URL);
        include_once FILE_PATH(IViewMemberConstant::AGENDA_WIDYAISWARA_LIST_USER_VIEW_INDEX);
    }

    public function editUser() {
        $db = new Database();
        $id = $_POST['id'];

        $transactionActivity = new TransactionActivity();
        $transactionActivityDetails = new TransactionActivityDetails();
        $transactionEvaluation = new TransactionEvaluation();
        $masterUserAssignment = new MasterUserAssignment();
        $masterUserMain = new MasterUserMain();

        $data_user = getUserMember();


        $this->data_activity_details = $db->selectByID($transactionActivityDetails, $transactionActivityDetails->getId() . equalToIgnoreCase($id));
        $this->data_activity = $db->selectByID($transactionActivity, $transactionActivity->getId() . equalToIgnoreCase($this->data_activity_details[0][$transactionActivityDetails->getActivityId()]));

        $data_user_assignment = $db->selectByID($masterUserAssignment, $masterUserAssignment->getUser_main_id() . equalToIgnoreCase($data_user[$masterUserMain->getEntity()][$masterUserMain->getId()])
                . " AND " . $masterUserAssignment->getActivity_id() . equalToIgnoreCase($this->data_activity_details[0][$transactionActivityDetails->getActivityId()]));

        $this->data_evaluation = $db->selectByID($transactionEvaluation, $transactionEvaluation->getActivityDetailsId() . equalToIgnoreCase($this->data_activity_details[0][$transactionActivityDetails->getId()])
                . " AND " . $transactionEvaluation->getUserAssignmentId() . equalToIgnoreCase($data_user_assignment[0][$masterUserAssignment->getId()])
        );
//                print_r($this->data_evaluation);
        $this->urlListUser = URL(IURLMemberConstant::AGENDA_WIDYAISWARA_LIST_USER_URL);
        $this->urlEditUser = URL(IURLMemberConstant::AGENDA_WIDYAISWARA_EDIT_USER_URL);
        $this->urlSaveUser = URL(IURLMemberConstant::AGENDA_WIDYAISWARA_SAVE_USER_URL);
        include_once FILE_PATH(IViewMemberConstant::AGENDA_WIDYAISWARA_EDIT_USER_VIEW_INDEX);
    }

    public function saveUser() {
        $id = $_POST['id'];
        $db = new Database();
        $db->connect();
        $transactionActivity = new TransactionActivity();
        $transactionActivityDetails = new TransactionActivityDetails();
        $transactionEvaluation = new TransactionEvaluation();
        $transactionEvaluationDetails = new TransactionEvaluationDetails();

        $masterUserAssignment = new MasterUserAssignment();
        $masterUserMain = new MasterUserMain();
        $masterCategoryAssess = new MasterCategoryAssess();

        $data_user = getUserMember();


        $this->data_activity_details = $db->selectByID($transactionActivityDetails, $transactionActivityDetails->getId() . equalToIgnoreCase($id));
        $this->data_activity = $db->selectByID($transactionActivity, $transactionActivity->getId() . equalToIgnoreCase($this->data_activity_details[0][$transactionActivityDetails->getActivityId()]));

        $data_user_assignment = $db->selectByID($masterUserAssignment, $masterUserAssignment->getUser_main_id() . equalToIgnoreCase($data_user[$masterUserMain->getEntity()][$masterUserMain->getId()])
                . " AND " . $masterUserAssignment->getActivity_id() . equalToIgnoreCase($this->data_activity_details[0][$transactionActivityDetails->getActivityId()]));

        $sql_assess = SELECT . 'mca1.' . $masterCategoryAssess->getId() . ',' . 'mca1.' . $masterCategoryAssess->getName() . ',' . 'mca1.' . $masterCategoryAssess->getCode() . ''
                . FROM . $masterCategoryAssess->getEntity() . ' as mca1 '
                . '' . JOIN . $masterCategoryAssess->getEntity() . ' as mca2' . ON . ''
                . ' mca1.' . $masterCategoryAssess->getParentId() . EQUAL . 'mca2.' . $masterCategoryAssess->getId()
                . ' WHERE mca2.' . $masterCategoryAssess->getCode() . equalToIgnoreCase('ET');
        $db->sql($sql_assess);

        $data_category_asses = $db->getResult();

        $result = true;
        $totalValue = 0;
        $no = 0;
        foreach ($data_category_asses as $value_) {
            $no += 1;
            $totalValue += intval($_POST[$value_[$masterCategoryAssess->getCode()]]);
        }
        $totalAverage = $totalValue / $no;
        LOGGER('total-average:' . $totalAverage . ' | totalvalue:' . $totalValue);

        $this->data_evaluation = $db->selectByID($transactionEvaluation, $transactionEvaluation->getActivityDetailsId() . equalToIgnoreCase($this->data_activity_details[0][$transactionActivityDetails->getId()])
                . " AND " . $transactionEvaluation->getUserAssignmentId() . equalToIgnoreCase($data_user_assignment[0][$masterUserAssignment->getId()])
        );
        if (empty($this->data_evaluation)) {
            $db->insert($transactionEvaluation->getEntity(), array(
                $transactionEvaluation->getCode() => createRandomBooking() . '|' . $this->data_activity_details[0][$transactionActivityDetails->getCode()],
                $transactionEvaluation->getName() => $this->data_activity_details[0][$transactionActivityDetails->getCode()],
                $transactionEvaluation->getValue() => intval($totalValue),
                $transactionEvaluation->getRateValue() => intval($totalAverage),
                $transactionEvaluation->getUserAssignmentId() => $data_user_assignment[0][$masterUserAssignment->getId()],
                $transactionEvaluation->getActivityDetailsId() => $this->data_activity_details[0][$transactionActivityDetails->getId()],
                $transactionEvaluation->getStatus() => 1,
                $transactionEvaluation->getCreatedByUsername() => $_SESSION[SESSION_USERNAME_GUEST],
                $transactionEvaluation->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT)
            ));
            $rs_insert_evaluation = $db->getResult();
//        LOGGER($rs_insert_evaluation);

            if (is_numeric($rs_insert_evaluation[0])) {
                $result = true;
            } else {
                $result = false;
            }
            foreach ($data_category_asses as $value) {
                if ($result == true) {
                    $db->insert($transactionEvaluationDetails->getEntity(), array(
                        $transactionEvaluationDetails->getEvaluationId() => $rs_insert_evaluation[0],
                        $transactionEvaluationDetails->getCategoryAssessId() => $value[$masterCategoryAssess->getId()],
                        $transactionEvaluationDetails->getValue() => $_POST[$value[$masterCategoryAssess->getCode()]],
                        $transactionEvaluationDetails->getEvaluatedBy() => $_SESSION[SESSION_USERNAME_GUEST],
                        $transactionEvaluationDetails->getEvaluatedOn() => date(DATE_FORMAT_PHP_DEFAULT)
                            )
                    );
                    $rs_insert_survey_details = $db->getResult();
                    if (!is_numeric($rs_insert_survey_details[0])) {
                        $result = false;
                    }
                }
            }
        } else {
            $db->update($transactionEvaluation->getEntity(), array(
                $transactionEvaluation->getValue() => intval($totalValue),
                $transactionEvaluation->getRateValue() => intval($totalAverage),
                $transactionEvaluation->getUserAssignmentId() => $data_user_assignment[0][$masterUserAssignment->getId()],
                $transactionEvaluation->getActivityDetailsId() => $this->data_activity_details[0][$transactionActivityDetails->getId()],
                $transactionEvaluation->getStatus() => 1,
                $transactionEvaluation->getModifiedByUsername() => $_SESSION[SESSION_USERNAME_GUEST],
                $transactionEvaluation->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT)
                    ), $transactionEvaluation->getId() . equalToIgnoreCase($this->data_evaluation[0][$transactionEvaluation->getId()]));
            $rs_insert_evaluation = $db->getResult();
//        LOGGER($rs_insert_evaluation);

            if (is_numeric($rs_insert_evaluation[0]) == 1) {
                $result = true;
            } else {
                $result = false;
            }
            foreach ($data_category_asses as $value) {
                if ($result == true) {
                    $data_value = $db->selectByID($transactionEvaluationDetails, $transactionEvaluationDetails->getEvaluationId() . equalToIgnoreCase($this->data_evaluation[0][$transactionEvaluation->getId()])
                            . " AND " . $transactionEvaluationDetails->getCategoryAssessId() . equalToIgnoreCase($value[$masterCategoryAssess->getId()]));
                    if (empty($data_value)) {
                        $db->insert($transactionEvaluationDetails->getEntity(), array(
                            $transactionEvaluationDetails->getEvaluationId() => $rs_insert_evaluation[0],
                            $transactionEvaluationDetails->getCategoryAssessId() => $value[$masterCategoryAssess->getId()],
                            $transactionEvaluationDetails->getValue() => $_POST[$value[$masterCategoryAssess->getCode()]],
                            $transactionEvaluationDetails->getEvaluatedBy() => $_SESSION[SESSION_USERNAME_GUEST],
                            $transactionEvaluationDetails->getEvaluatedOn() => date(DATE_FORMAT_PHP_DEFAULT)
                                )
                        );
                        $rs_insert_survey_details = $db->getResult();
                        if (!is_numeric($rs_insert_survey_details[0])) {
                            $result = false;
                        }
                    } else {
                        $db->update($transactionEvaluationDetails->getEntity(), array(
                            $transactionEvaluationDetails->getValue() => $_POST[$value[$masterCategoryAssess->getCode()]],
                            $transactionEvaluationDetails->getEvaluatedBy() => $_SESSION[SESSION_USERNAME_GUEST],
                            $transactionEvaluationDetails->getEvaluatedOn() => date(DATE_FORMAT_PHP_DEFAULT)
                                ), $transactionEvaluationDetails->getEvaluationId() . equalToIgnoreCase($this->data_evaluation[0][$transactionEvaluation->getId()])
                                . " AND " . $transactionEvaluationDetails->getCategoryAssessId() . equalToIgnoreCase($value[$masterCategoryAssess->getId()])
                        );
                        $rs_insert_survey_details = $db->getResult();
                        if (is_numeric($rs_insert_survey_details[0]) != 1) {
                            $result = false;
                        }
                    }
                }
            }
        }
        if ($result == true) {
            echo toastAlert("success", lang('general.title_update_success'), lang('general.message_update_success'));
            echo resultPageMsg("danger", lang('general.title_update_error'), lang('general.message_update_error'));
            echo writeMainJavascript("postAjaxEdit('" . URL(IURLMemberConstant::AGENDA_WIDYAISWARA_LIST_USER_URL) . "','id=" . $this->data_activity_details[0][$transactionActivityDetails->getActivityId()] . "')");
        } else {
            echo resultPageMsg("danger", lang('general.title_update_error'), lang('general.message_update_error'));
            echo toastAlert("error", lang('general.title_update_error'), lang('general.message_update_error'));
        }
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

        $data_role = $db->selectByID($securityRole, $securityRole->getCode() . equalToIgnoreCase('TRAINER'));
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
