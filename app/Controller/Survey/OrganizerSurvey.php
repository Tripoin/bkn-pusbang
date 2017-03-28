<?php

namespace app\Controller\Survey;

use app\Controller\Base\Controller;
use app\Model\TransactionActivity;
use app\Constant\IURLConstant;
use app\Constant\IViewConstant;
use app\Model\TransactionActivityDetails;
use app\Model\TransactionSurvey;
use app\Model\MasterUserAssignment;
use app\Model\MasterUserMain;
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
class OrganizerSurvey extends Controller
{
    public function __construct(){
        $this->modelData = new TransactionActivity();
        $this->setTitle(lang('survey.survey'));
        $this->setSubtitle(lang('survey.evaluation_trainer'));
        $this->setBreadCrumb(array(lang('survey.survey') => "", lang('survey.evaluation_trainer') => FULLURL()));
        $this->search_filter = array(
            "code" => lang('transaction.type')
        );
        $this->orderBy = $this->modelData->getId() . " DESC";
        $this->indexUrl = IURLConstant::SURVEY_ORGANIZER_INDEX_URL;
        $this->viewPath = IViewConstant::SURVEY_ORGANIZER_VIEW_INDEX;
        $this->setAutoCrud();
        parent::__construct();
    }

    public function index() {
        setTitle(' | ' . lang('survey.survey_organizer'));
        include_once FILE_PATH(IViewConstant::SURVEY_ORGANIZER_VIEW_INDEX . "/index.html.php");
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

        include_once FILE_PATH(IViewConstant::SURVEY_ORGANIZER_VIEW_INDEX . '/details/list.html.php');
    }
}