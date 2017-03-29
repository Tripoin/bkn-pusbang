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
        //$this->setTitle(lang('survey.survey'));
        $this->setSubtitle(lang('survey.evaluation_trainer'));
        $this->setBreadCrumb(array(lang('survey.survey') => "", lang('survey.evaluation_trainer') => FULLURL()));
        $this->search_filter = array(
            "code" => lang('transaction.type')
        );
        $this->orderBy = $this->modelData->getId() . " DESC";
        $this->indexUrl = IURLMemberConstant::SURVEY_TRAINER_URL;
        $this->viewPath = IViewMemberConstant::SURVEY_TRAINER_VIEW_INDEX;
        $this->setAutoCrud();
        parent::__construct();
    }

    public function listData(){
        $this->modelSubject = new TransactionActivity();
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
//        $group = new SecurityGroup();

        $activity = $_POST['id'];
        $data = new MasterUserAssignment();
        $activityModel = new TransactionActivity();
        $activityDetails = new TransactionActivityDetails();
        $trxSurvey = new TransactionSurvey();
        $userMain = new MasterUserMain();

        $Datatable->urlDeleteCollection($this->urlDeleteCollection);
        $search = '';

//        echo $Datatable->search;
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

        include_once FILE_PATH(IViewMemberConstant::SURVEY_TRAINER_VIEW_INDEX . '/details/list.html.php');
    }

    public function activityDetailSurvey(){

        $Form = new Form();
        $Datatable = new DataTable();
        $db = new Database();
//        $group = new SecurityGroup();

        $idActivityDetail = $_POST['id'];

        $trxActivity = new TransactionActivity();
        $trxActivityDetails = new TransactionActivityDetails();
        $userMain = new MasterUserMain();
        $linkTrainerAss = new LinkTrainerAssess();
        $mstCategoryAssess = new MasterCategoryAssess();

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
        $db->insert($trxSurvey->getEntity(), array(
            $trxSurvey->getCode() => createRandomBooking(),
            $trxSurvey->getSurveyCategoryId() => $surveyCategoryWdy[0]['id'],
            $trxSurvey->getValue() => $_POST['total'],
            $trxSurvey->getRateValue() => $_POST['average'],
            $trxSurvey->getTargetSurveyId() => $_POST['id']
        ));
        $getTrxSurvey = $db->getResult();
        $getCtrAssess = $this->getCtrAssess();
        foreach($getCtrAssess as $data){
            $db->insert($trxSurveyDtl->getEntity(), array(
                $trxSurveyDtl->getSurveyId() => $getTrxSurvey[0],
                $trxSurveyDtl->getCategoryAssessId() => $data['id'],
                $trxSurveyDtl->getValue() => $_POST[$data['code']]
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