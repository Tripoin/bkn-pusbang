<?php

namespace app\Controller\Member\Survey;

use app\Constant\IURLMemberConstant;
use app\Controller\Base\ControllerMember;
use app\Model\LinkTrainerAssess;
use app\Model\MasterCategoryAssess;
use app\Model\MasterSurveyCategory;
use app\Model\TransactionActivity;
use app\Model\TransactionActivityDetails;
use app\Model\TransactionSurvey;
use app\Model\MasterUserAssignment;
use app\Model\MasterUserMain;
use app\Model\TransactionSurveyDetails;
use app\Util\Form;
use app\Util\DataTable;
use app\Util\Database;
use app\Util\Button;
use app\Constant\IViewMemberConstant;


    /**
 * Created by PhpStorm.
 * User: Dayat
 * Date: 21/03/2017
 * Time: 4:47
 */
class TrainerSurvey extends ControllerMember
{
    public $saveUrl = '';
    public function __construct(){
        $this->modelData = new TransactionActivity();
        $this->setTitle(lang('survey.survey'));
        $this->setSubtitle(lang('survey.evaluation_trainer'));
        $this->setBreadCrumb(array(lang('survey.evaluation_trainer') => ""));
        $this->search_filter = array(
            "name" => lang('transaction.type')
        );
        $this->orderBy = $this->modelData->getId() . " DESC";
        $this->indexUrl = IURLMemberConstant::SURVEY_TRAINER_URL;
        $this->viewPath = IViewMemberConstant::SURVEY_TRAINER_VIEW_INDEX;
        $this->setAutoCrud();
        parent::__construct();
    }

    public function listData(){
        $transactionActivity = new TransactionActivity();
        $this->modelSubject = $transactionActivity;
        $masterUserAssignment = new MasterUserAssignment();
        $masterUserMain = new MasterUserMain();
        print_r(getUserMember()['sec_user']['code']);
        $data_user = getUserMember();
//        echo $data_user[$masterUserMain->getId()];
        $this->search_list = $transactionActivity->getEntity();
        $this->select_entity = $transactionActivity->getEntity().'.*';
        $this->join_list = array($masterUserAssignment->getEntity());
        $this->where_list = $transactionActivity->getEntity().DOT.$transactionActivity->getId().EQUAL.$masterUserAssignment->getEntity().DOT.$masterUserAssignment->getActivity_id()
            . " AND ".$masterUserAssignment->getEntity().DOT.$masterUserAssignment->getUser_main_id().equalToIgnoreCase($data_user[$masterUserMain->getEntity()][$masterUserMain->getId()]);

        $sr = $this->modelSubject->search($_POST['search_by']);

        if (empty($sr)) {
            $_POST['search_by'] = "";
            $_POST['search_pagination'] = "";
        }
        parent::listData();
    }

    public function activityDetail(){
        $Form = new Form();
        $Datatable = new DataTable();
        $db = new Database();
        $activity = $_POST['id'];
        $data = new MasterUserAssignment();
        $activityModel = new TransactionActivity();
        $activityDetails = new TransactionActivityDetails();

        $userMain = new MasterUserMain();

        $search = '';

        $whereList = $activityDetails->getEntity() . "." . $activityDetails->getActivityId() . EQUAL . $activity . " AND " .
            $activityModel->getEntity() . "." . $activityModel->getId() . EQUAL . $activityDetails->getEntity() . "." . $activityDetails->getActivityId() . " AND "
            . "(" . $activityDetails->getDuration() . " is not null AND " . $activityDetails->getDuration() . notEqualToIgnoreCase(0) . ")" . $search;

        $list_data = $Datatable->select_pagination($activityDetails, $activityDetails->getEntity(), $whereList, $activityModel->getEntity(), $activityModel->getEntity(), null, ""
            . $activityDetails->getEntity() . "." . $activityDetails->getId() . " as id,"
            . $activityDetails->getEntity() . "." . $activityDetails->getCode() . " as code,"
            . $activityDetails->getEntity() . "." . $activityDetails->getStartTime() . ","
            . $activityDetails->getEntity() . "." . $activityDetails->getEndTime() . ","
            . $activityDetails->getEntity() . "." . $activityDetails->getDuration() . ","
            . $activityDetails->getEntity() . "." . $activityDetails->getMaterialName() . ","
            . $activityDetails->getEntity() . "." . $activityDetails->getUserMainId() . ","
            . $activityDetails->getEntity() . "." . $activityDetails->getUserMainName() . ","
            . $activityDetails->getEntity() . "." . $activityDetails->getDescription() . " as description,"
            . $activityDetails->getEntity() . "." . $activityDetails->getName() . " as name", $activityDetails->getEntity() . "." . $activityDetails->getId());

        //$dataSurvey = $db->select();
        include_once FILE_PATH(IViewMemberConstant::SURVEY_TRAINER_VIEW_INDEX . '/details/list.html.php');
    }

    public function activityDetailSurvey(){
        $Form = new Form();
        $Datatable = new DataTable();
        $db = new Database();
        $idActivityDetail = $_POST['id'];

        $trxActivity = new TransactionActivity();
        $trxActivityDetails = new TransactionActivityDetails();
        $userMain = new MasterUserMain();
        $linkTrainerAss = new LinkTrainerAssess();
        $mstCategoryAssess = new MasterCategoryAssess();

        $trxSurvey = new TransactionSurvey();
        $trxSurveyDtl = new TransactionSurveyDetails();

        $dataActDetail = $db->selectByID($trxActivityDetails, $trxActivityDetails->getId() .EQUAL. $idActivityDetail);
        $dataAct = $db->selectByID($trxActivity, $trxActivity->getId() .EQUAL. $dataActDetail[0]['activity_id']);

        $dataLinkTrainer = $db->selectByID($linkTrainerAss, $linkTrainerAss->getCurriculumId().EQUAL.$dataActDetail[0]['curriculum_id']);

        $db->select(
            $linkTrainerAss->getEntity(),
            $mstCategoryAssess->getEntity().'.'.$mstCategoryAssess->getName().','.$mstCategoryAssess->getEntity().'.'.$mstCategoryAssess->getCode(),
            array(
                $mstCategoryAssess->getEntity()
            ),
            $linkTrainerAss->getEntity().'.'.$linkTrainerAss->getCategoryAssessId().EQUAL. $mstCategoryAssess->getEntity().'.'.$mstCategoryAssess->getId().' AND '
            .$linkTrainerAss->getEntity().'.'.$linkTrainerAss->getCurriculumId() .EQUAL. $dataActDetail[0]['curriculum_id']
        );
        $dataCtrAssess = $db->getResult();

        $dataTrxSurvey = $db->selectByID($trxSurvey, $trxSurvey->getTargetSurveyId().EQUAL. $idActivityDetail);

        $this->saveUrl = URL(IURLMemberConstant::SURVEY_TRAINER_URL . '/save');
        include_once FILE_PATH(IViewMemberConstant::SURVEY_TRAINER_VIEW_INDEX . '/details/create.html.php');
    }

    public function getCtrAssess(){
        $Form = new Form();
        $Datatable = new DataTable();
        $db = new Database();
//        $group = new SecurityGroup();

        $idActivityDetail = $_POST['id'];

        $trxActivityDetails = new TransactionActivityDetails();
        $linkTrainerAss = new LinkTrainerAssess();
        $mstCategoryAssess = new MasterCategoryAssess();

        $dataActDetail = $db->selectByID($trxActivityDetails, $trxActivityDetails->getId() .EQUAL. $idActivityDetail);

        $db->select(
            $linkTrainerAss->getEntity(),
            $mstCategoryAssess->getEntity().'.'.$mstCategoryAssess->getId().','.$mstCategoryAssess->getEntity().'.'.$mstCategoryAssess->getName().','.$mstCategoryAssess->getEntity().'.'.$mstCategoryAssess->getCode(),
            array(
                $mstCategoryAssess->getEntity()
            ),
            $linkTrainerAss->getEntity().'.'.$linkTrainerAss->getCategoryAssessId().EQUAL. $mstCategoryAssess->getEntity().'.'.$mstCategoryAssess->getId().' AND '
            .$linkTrainerAss->getEntity().'.'.$linkTrainerAss->getCurriculumId() .EQUAL. $dataActDetail[0]['curriculum_id']
        );
        $dataCtrAssess = $db->getResult();
        return $dataCtrAssess;
    }

    public function saveSurvey(){
        $Form = new Form();
        $db = new Database();

        $surveyCategory = new MasterSurveyCategory();
        $trxSurvey = new TransactionSurvey();
        $trxSurveyDtl = new TransactionSurveyDetails();

        $surveyCategoryWdy = $db->selectByID($surveyCategory, $surveyCategory->getCode().equalToIgnoreCase('SURVEY-WIDYAISWARA'));
        $db->connect();
        $usrMain = new MasterUserMain();
        $usrAssigment = new MasterUserAssignment();
        $db->select($usrAssigment->getEntity(),
            $usrAssigment->getEntity().'.'.$usrAssigment->getId(),
            array(
                $usrMain->getEntity()
            ),
            $usrMain->getEntity().'.'.$usrMain->getId().EQUAL.$usrAssigment->getEntity().'.'.$usrAssigment->getUser_main_id().' AND '
            .$usrMain->getEntity().'.'.$usrMain->getCode().equalToIgnoreCase(getUserMember()['sec_user']['code'])
        );
        $idUsrAssg = $db->getResult();

        $db->insert($trxSurvey->getEntity(), array(
            $trxSurvey->getCode() => createRandomBooking(),
            $trxSurvey->getSurveyCategoryId() => $surveyCategoryWdy[0]['id'],
            $trxSurvey->getValue() => $_POST['total'],
            $trxSurvey->getRateValue() => $_POST['average'],
            $trxSurvey->getTargetSurveyId() => $_POST['id'],
            $trxSurvey->getUserAssignmentId() => $idUsrAssg,
        ));
        $getTrxSurvey = $db->getResult();
        $getCtrAssess = $this->getCtrAssess();
        foreach($getCtrAssess as $data){
            $db->insert($trxSurveyDtl->getEntity(), array(
                $trxSurveyDtl->getSurveyId() => $getTrxSurvey[0],
                $trxSurveyDtl->getCategoryAssessId() => $data['id'],
                $trxSurveyDtl->getValue() => $_POST[$data['code']],
                $trxSurveyDtl->getEvaluatedBy() => $_SESSION[SESSION_FULLNAME_GUEST],
                $trxSurveyDtl->getEvaluatedOn() => date("Y-m-d H:i:s")
            ));
            $db->getResult();
        }

        if(is_numeric($getTrxSurvey[0])){
            echo toastAlert('success', lang('general.title_insert_success'), lang('general.message_insert_success'));
        } else {
            echo toastAlert('error', lang('general.title_insert_error'), lang('general.message_insert_error'));
        }
        echo postAjaxPagination();
    }
}