<?php

namespace app\Controller\Member;

use app\Controller\Base\ControllerMember;
use app\Model\TransactionActivity;
use app\Constant\IURLMemberConstant;
use app\Constant\IViewConstant;
use app\Model\TransactionActivityDetails;
//use app\Model\TransactionSurvey;
use app\Model\LinkSubjectAssess;
use app\Model\MasterSubject;
use app\Model\MasterCategoryAssess;
use app\Model\MasterSurveyCategory;
use app\Model\MasterUserAssignment;
use app\Model\MasterUserMain;
use app\Model\SecurityUserProfile;
use app\Model\MasterNotification;
use app\Model\SecurityGroup;
use app\Model\TransactionSurveyDetails;
use app\Model\SecurityUser;
use app\Util\Form;
use app\Util\DataTable;
use app\Util\Database;
use app\Util\Button;
use app\Constant\IViewMemberConstant;

/**
 * Modified by Netbeans 8.1.
 * User: Syahrial Fandrianah
 * Date: 29/04/2017
 * Time: 24:00
 */
class Notification extends ControllerMember {

    public $data_activity, $data_parent_subject_assess;

    public function __construct() {
        $masterNotification = new MasterNotification();
        $this->modelData = $masterNotification;
        $this->setTitle(lang('general.message'));
        $this->setSubtitle("");
        $this->setBreadCrumb(array(lang('general.message') => ""));
        $this->search_filter = array(
            "title" => lang('general.title')
        );
        $this->orderBy = $masterNotification->getCreatedOn() . " DESC";
        $this->indexUrl = IURLMemberConstant::NOTIFICATION_URL;
        $this->viewPath = IViewMemberConstant::NOTIFICATION_VIEW_INDEX;
        $this->setAutoCrud();
        parent::__construct();
    }

    public function edit() {
        $this->setBreadCrumb(array(lang('survey.survey_organizer') => "", "edit" => ""));
        $db = new Database();
        $id = $_POST['id'];

        $transactionActivity = new TransactionActivity();
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
        parent::edit();
    }

    public function update() {
        $db = new Database();
        $masterNotification = new MasterNotification();
        $securityUserProfile = new SecurityUserProfile();
        if (isset($_POST)) {
            $data_user = getUserMember();
            $db->connect();
            $to = $_POST['to'];
            $title = $_POST['title'];
            $message = $_POST['message'];
            $code = createRandomBooking();
            $result = true;
            foreach ($to as $value) {
                if ($result == true) {
                    $db->insert($masterNotification->getEntity(), array(
                        $masterNotification->getCode() => $code,
                        $masterNotification->getName() => $title,
                        $masterNotification->getTitle() => $title,
                        $masterNotification->getMessage() => $message,
                        $masterNotification->getFrom() => $data_user[$securityUserProfile->getEntity()][$securityUserProfile->getId()],
                        $masterNotification->getTo() => $value,
                        $masterNotification->getDate() => date(DATE_FORMAT_PHP_DEFAULT),
                    ));

                    $rs_insert_notif = $db->getResult();
                    if (!is_numeric($rs_insert_notif[0])) {
                        $result = false;
                    }
                }
            }
            if ($result == true) {
                echo toastAlert('success', lang('general.title_send_success'), lang('general.message_send_success'));
                echo postAjaxPagination();
            } else {
                echo toastAlert('error', lang('general.title_send_error'), lang('general.message_send_error'));
            }
        }
    }

    public function listData() {
        $masterNotification = new MasterNotification();
        $this->modelSubject = $masterNotification;
        $securityUserProfile = new SecurityUserProfile();
        $masterUserAssignment = new MasterUserAssignment();
        $masterUserMain = new MasterUserMain();

        $data_user = getUserMember();
        $this->where_list = $masterNotification->getTo() . equalToIgnoreCase($data_user[$securityUserProfile->getEntity()][$securityUserProfile->getId()])
                . " OR " . $masterNotification->getFrom() . equalToIgnoreCase($data_user[$securityUserProfile->getEntity()][$securityUserProfile->getId()]);

        $sr = $this->modelSubject->search($_POST['search_by']);
        echo $sr;
        if (empty($sr)) {
            $_POST['search_by'] = "";
            $_POST['search_pagination'] = "";
        }
        parent::listData();
    }

    public function view() {
        $id = $_POST['id'];
        $masterNotification = new MasterNotification();
        $securityUserProfile = new SecurityUserProfile();
        $db = new Database();
        $db->connect();

        $data_user = getUserMember();

        $rs_message = $db->selectByID($masterNotification, $masterNotification->getId() . equalToIgnoreCase($id));

        $data_from = getLov($securityUserProfile, $securityUserProfile->getId() . equalToIgnoreCase($rs_message[0][$masterNotification->getFrom()]));
        $data_to = getLov($securityUserProfile, $securityUserProfile->getId() . equalToIgnoreCase($rs_message[0][$masterNotification->getTo()]));
        $result_update = 1;
        if ($rs_message[0][$masterNotification->getTo()] == $data_user[$securityUserProfile->getEntity()][$securityUserProfile->getId()]) {
            $db->update($masterNotification->getEntity(), array(
                $masterNotification->getRead() => 1,
                $masterNotification->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                $masterNotification->getModifiedByUsername() => $_SESSION[SESSION_USERNAME_GUEST],
                    ), $masterNotification->getId() . equalToIgnoreCase($id));
            $rs_update = $db->getResult();
            if (is_numeric($rs_update[0]) == 1) {
                $result_update = $rs_update[0];
            } else {
                $result_update = 0;
            }
        }


        if (is_numeric($result_update) == 1) {
//        print_r($data_from);
            echo '<div class="panel panel-info">
      <div class="panel-heading">' . $rs_message[0][$masterNotification->getTitle()] . '</div>
      <div class="panel-body">
            From : <b>' . $data_from[0]->label . '</b><br/>
            To : <b>' . $data_to[0]->label . '</b><br/><br/>
                <p>
                ' . $rs_message[0][$masterNotification->getMessage()] . '
                </p>
      </div>
    </div>';

            $db->select($masterNotification->getEntity(), "COUNT(" . $masterNotification->getId() . ") as total", array(), ""
                    . "" . $masterNotification->getTo() . equalToIgnoreCase($data_user[$securityUserProfile->getEntity()][$securityUserProfile->getId()])
                    . " AND (" . $masterNotification->getRead() . "<>1"
                    . " OR " . $masterNotification->getRead() . " is null)");
            $data_notification = $db->getResult();
            $total_notif = 0;
            if (!empty($data_notification)) {
                if (isset($data_notification[0]['total'])) {
                    $total_notif = $data_notification[0]['total'];
                }
            }
            if ($total_notif == 0) {
                echo writeMainJavascript("$('#notif-message').html('')");
            } else {
                echo writeMainJavascript("$('#notif-message').html('" . $total_notif . "')");
            }
        }
    }

    public function listUser() {
        if (isset($_GET['q'])) {
            $q = $_GET['q'];
            $masterNotification = new MasterNotification();
            $securityUserProfile = new SecurityUserProfile();
            $securityUser = new SecurityUser();
            $securityGroup = new SecurityGroup();
            $db = new Database();
            $db->connect();
            $db->select($securityUserProfile->getEntity(), ""
                    . $securityUserProfile->getEntity() . DOT . $securityUserProfile->getId() . ','
                    . $securityGroup->getEntity() . DOT . $securityGroup->getName() . ' as group_name,'
                    . $securityUserProfile->getEntity() . DOT . $securityUserProfile->getName() . ''
                    , array($securityUser->getEntity(), $securityGroup->getEntity()), ""
                    . $securityUserProfile->getEntity() . DOT . $securityUserProfile->getUserId() . EQUAL . $securityUser->getEntity() . DOT . $securityUser->getId()
                    . " AND " . $securityUser->getEntity() . DOT . $securityUser->getGroupId() . EQUAL . $securityGroup->getEntity() . DOT . $securityGroup->getId()
                    . " AND " . $securityUserProfile->getEntity() . DOT . $securityUserProfile->getName() . " LIKE '%" . $q . "%'"
                    , null, "0,10");
            $rs_message = $db->getResult();
            echo json_encode(array("items" => $rs_message));
        } else {
            echo json_encode(array());
        }
    }

}
