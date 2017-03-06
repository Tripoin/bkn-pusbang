<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Approval -> ParticipantRegistration
 * @email : sfandrianah2@gmail.com
 * @author Syahrial Fandrianah
 * @FRAMEWORK NATIVE ADMIN TEMPLATE V.1.0
 */

namespace app\Controller\Approval;

use app\Controller\Base\Controller;
use app\Model\TransactionActivity;
use app\Model\TransactionActivityDetails;
use app\Model\TransactionRegistrationDetails;
use app\Model\MasterApproval;
use app\Model\MasterApprovalCategory;
use app\Model\MasterWaitingList;
use app\Model\MasterParticipantType;
use app\Model\MasterWorkingUnit;
use app\Model\MasterGovernmentAgencies;
use app\Model\MasterUserAssignment;
use app\Model\MasterUserMain;
use app\Model\MasterCurriculum;
use app\Model\MasterSubject;
use app\Model\MasterReligion;
use app\Model\MasterContact;
use app\Model\MasterAddress;
use app\Model\MasterProvince;
use app\Model\MasterCity;
use app\Model\MasterDistrict;
use app\Model\MasterVillage;
use app\Model\MasterGovernmentClassification;
use app\Model\LinkRegistration;
use app\Model\TransactionRegistration;
use app\Model\MasterAttachment;
use app\Model\SecurityUserProfile;
use app\Model\SecurityUser;
use app\Model\SecurityGroup;
use app\Constant\IURLConstant;
use app\Constant\IViewConstant;
use app\Util\Form;
use app\Util\DataTable;
use app\Util\Database;
use app\Util\Button;
use app\Util\PHPMail\PHPMailer;

//use app\Util\Form;

class ParticipantRegistration extends Controller {

    //put your code here

    public function __construct() {
        $this->modelData = new MasterApproval();
        $this->setTitle(lang('approval.approval'));
        $this->setSubTitle(lang('approval.participant_registration'));
        $this->setBreadCrumb(array(lang('approval.approval') => "", lang('approval.participant_registration') => FULLURL()));
        $this->search_filter = array(
            "code" => lang('general.code'),
            "created_by" => lang('approval.user')
        );
        $this->orderBy = $this->modelData->getId() . " DESC";
        $this->indexUrl = IURLConstant::APPROVAL_PARTICIPANT_REGISTRATION_INDEX_URL;
        $this->viewPath = IViewConstant::APPROVAL_PARTICIPANT_REGISTRATION_VIEW_INDEX;
        $this->setAutoCrud();
        parent::__construct();
    }

    public function listData() {
        $Form = new Form();
        $Datatable = new DataTable();
        $Button = new Button();
        $db = new Database();
//        $group = new SecurityGroup();
        $data = $this->modelData;
        $masterApproval = new MasterApproval();
        $masterApprovalCategory = new MasterApprovalCategory();
        $linkRegistration = new LinkRegistration();
        $transactionRegistration = new TransactionRegistration();
        if ($_POST['per_page'] == "") {
            $Datatable->per_page = 10;
        } else {
            $Datatable->per_page = $_POST['per_page'];
        }

//        }
        $Datatable->urlDeleteCollection($this->urlDeleteCollection);
        $Datatable->searchFilter($this->search_filter);
        $Datatable->createButton(FALSE);
        $Datatable->current_page = $_POST['current_page'];
        if ($_POST['current_page'] == '') {
            $Datatable->current_page = 1;
        }
        $search = $_POST['search_pagination'];
        if ($_POST['search_by'] == '') {
            $search = " AND " . $masterApproval->getEntity() . ".code LIKE  '%" . $search . "%'";
        } else if ($_POST['search_by'] == 'null') {
            $search = " AND " . $masterApproval->getEntity() . ".code LIKE  '%" . $search . "%'";
        } else {
            $search = " AND " . $masterApproval->getEntity() . "." . $_POST['search_by'] . " LIKE  '%" . $search . "%'";
        }

//        echo $Datatable->search;

        $whereList = $masterApprovalCategory->getEntity() . DOT . $masterApprovalCategory->getId() . EQUAL . $masterApproval->getEntity() . DOT . $masterApproval->getApprovalCategoryId() . ""
                . " AND " . $masterApproval->getEntity() . DOT . $masterApproval->getApprovalDetailId() . EQUAL . $linkRegistration->getEntity() . DOT . $linkRegistration->getId() . ""
                . " AND " . $linkRegistration->getEntity() . DOT . $linkRegistration->getRegistrationId() . EQUAL . $transactionRegistration->getEntity() . DOT . $transactionRegistration->getId() . ""
                . " AND " . $masterApprovalCategory->getEntity() . DOT . $masterApproval->getCode() . equalToIgnoreCase('REGISTRATION-DETAILS') . ""
                . "" . $search;
//        $Datatable->debug(true);
        $list_data = $Datatable->select_pagination($masterApproval, $masterApproval->getEntity(), $whereList, array($masterApprovalCategory->getEntity(), $linkRegistration->getEntity(), $transactionRegistration->getEntity()), $masterApprovalCategory->getEntity(), $this->orderBy, ""
                . $masterApproval->getEntity() . DOT . $masterApproval->getId() . " as id,"
                . $masterApproval->getEntity() . DOT . $masterApproval->getCode() . " as code,"
                . $transactionRegistration->getEntity() . DOT . $transactionRegistration->getName() . " as pic_name,"
                . $masterApproval->getEntity() . DOT . $masterApproval->getCreatedByUsername() . " as username,"
                . $masterApproval->getEntity() . DOT . $masterApproval->getCreatedOn() . " as created_on,"
                . $masterApproval->getEntity() . DOT . $masterApproval->getIsExecuted() . " as excecuted,"
                . $masterApproval->getEntity() . DOT . $masterApproval->getStatus() . " as status,"
                . $masterApprovalCategory->getEntity() . "." . $masterApprovalCategory->getName() . " as approval_category_name", $linkRegistration->getEntity() . DOT . $linkRegistration->getRegistrationId());

//        print_r($list_data);
        include_once FILE_PATH($this->viewList);
    }

    public function edit() {
        $Form = new Form();
        $id = $_POST['id'];
        $db = new Database();
        $db->connect();
        $masterApproval = new MasterApproval();
        $masterApprovalCategory = new MasterApprovalCategory();
        $masterWaitingList = new MasterWaitingList();
        $masterParticipantType = new MasterParticipantType();
        $m_act = new TransactionActivity();
        $m_user_assign = new MasterUserAssignment();
        $m_user_main = new MasterUserMain();
        $m_participant_type = new MasterParticipantType();
        $m_working_unit = new MasterWorkingUnit();
        $m_gov_agencies = new MasterGovernmentAgencies();
        $user = new SecurityUser();
        $userProfile = new SecurityUserProfile();
        $masterReligion = new MasterReligion();
        $masterContact = new MasterContact();
        $masterAddress = new MasterAddress();
        $masterProvince = new MasterProvince();
        $masterCity = new MasterCity();
        $masterDistrict = new MasterDistrict();
        $masterVillage = new MasterVillage();
        $mGovClass = new MasterGovernmentClassification();
        $masterSubject = new MasterSubject();
//        print_r($id);
        $dt_approval = $db->selectByID($masterApproval, $masterApproval->getId() . EQUAL . $id);
//        print_r($dt_approval);
        $dt_approval_category = $db->selectByID($masterApprovalCategory, $masterApprovalCategory->getId() . EQUAL . $dt_approval[0][$masterApproval->getApprovalCategoryId()]);
        $linkRegistration = new LinkRegistration();
        $transactionRegistration = new TransactionRegistration();

        $masterAttachment = new MasterAttachment();
        $rs_link_registration = $db->selectByID($linkRegistration, $linkRegistration->getId() . equalToIgnoreCase($dt_approval[0][$masterApproval->getApprovalDetailId()]));
//        print_r($rs_link_registration);
        $dt_activity = $db->selectByID($m_act, $m_act->getId() . EQUAL . $rs_link_registration[0][$linkRegistration->getActivityId()]);
        $rs_registration = $db->selectByID($transactionRegistration, $transactionRegistration->getId() . equalToIgnoreCase($rs_link_registration[0][$linkRegistration->getRegistrationId()]));
        $dt_mst_participant_type = $db->selectByID($masterParticipantType, $masterParticipantType->getId() . equalToIgnoreCase($rs_registration[0][$transactionRegistration->getParticipantTypeId()]));

//        print_r($rs_registration);
        $rs_attachment = $db->selectByID($masterAttachment, $masterAttachment->getId() . equalToIgnoreCase($rs_link_registration[0][$linkRegistration->getAttachmentLetterId()]));
        $dt_participant_type = $db->selectByID($m_participant_type, $m_participant_type->getId() . equalToIgnoreCase($rs_registration[0][$transactionRegistration->getParticipantTypeId()]));
//            print_r($rs_attachment);
        $data_subject = valueComboBoxParent($masterSubject->getEntity(), $masterSubject->getId(), $masterSubject->getName(), $masterSubject->getParentId(), $masterSubject->getId() . equalToIgnoreCase($dt_activity[0][$m_act->getSubjectId()]));
        include_once FILE_PATH(IViewConstant::APPROVAL_PARTICIPANT_REGISTRATION_VIEW_INDEX . '/edit.html.php');
    }

    public function editParticipant() {
        $Form = new Form();
        $linkRegistrationId = $_POST['link_registration_id'];
        $approvalId = $_POST['approval_id'];

//        $activityId = $_POST['activity_id'];
//        $registrationId = $_POST['registration_id'];
        $db = new Database();
        $db->connect();
        $regDetail = new TransactionRegistrationDetails();
        $linkRegistration = new LinkRegistration();
        $transactionRegistration = new TransactionRegistration();
        $masterApproval = new MasterApproval();
        $masterApprovalCategory = new MasterApprovalCategory();
        $masterWaitingList = new MasterWaitingList();
        $masterParticipantType = new MasterParticipantType();
        $m_act = new TransactionActivity();
        $m_user_assign = new MasterUserAssignment();
        $m_user_main = new MasterUserMain();
        $m_participant_type = new MasterParticipantType();
        $m_working_unit = new MasterWorkingUnit();
        $m_gov_agencies = new MasterGovernmentAgencies();
        $user = new SecurityUser();
        $userProfile = new SecurityUserProfile();
        $masterReligion = new MasterReligion();
        $masterContact = new MasterContact();
        $masterAddress = new MasterAddress();
        $masterProvince = new MasterProvince();
        $masterCity = new MasterCity();
        $masterDistrict = new MasterDistrict();
        $masterVillage = new MasterVillage();
        $mGovClass = new MasterGovernmentClassification();
        $masterSubject = new MasterSubject();
        $masterAttachment = new MasterAttachment();
//        print_r($id);
        $rs_link_registration = $db->selectByID($linkRegistration, $linkRegistration->getId() . equalToIgnoreCase($linkRegistrationId));

        $dt_approval = $db->selectByID($masterApproval, $masterApproval->getId() . EQUAL . $approvalId);



//        $rs_link_registration = $db->selectByID($linkRegistration, $linkRegistration->getId() . equalToIgnoreCase($dt_approval[0][$masterApproval->getApprovalDetailId()]));
//        print_r($rs_link_registration);
        $dt_activity = $db->selectByID($m_act, $m_act->getId() . EQUAL . $rs_link_registration[0][$linkRegistration->getActivityId()]);
        $rs_registration = $db->selectByID($transactionRegistration, $transactionRegistration->getId() . equalToIgnoreCase($rs_link_registration[0][$linkRegistration->getRegistrationId()]));
        $rs_registration_detail = $db->selectByID($regDetail, $regDetail->getId() . equalToIgnoreCase($rs_link_registration[0][$linkRegistration->getRegistrationDetailsId()]));
        $dt_religion = $db->selectByID($masterReligion, $masterReligion->getId() . EQUAL . $rs_registration_detail[0][$regDetail->getReligionId()]);
        $dt_mst_participant_type = $db->selectByID($masterParticipantType, $masterParticipantType->getId() . equalToIgnoreCase($rs_registration[0][$transactionRegistration->getParticipantTypeId()]));

        $rs_attachment = $db->selectByID($masterAttachment, $masterAttachment->getId() . equalToIgnoreCase($rs_link_registration[0][$linkRegistration->getAttachmentLetterId()]));
        $dt_participant_type = $db->selectByID($m_participant_type, $m_participant_type->getId() . equalToIgnoreCase($rs_registration[0][$transactionRegistration->getParticipantTypeId()]));
        $data_subject = valueComboBoxParent($masterSubject->getEntity(), $masterSubject->getId(), $masterSubject->getName(), $masterSubject->getParentId(), $masterSubject->getId() . equalToIgnoreCase($dt_activity[0][$m_act->getSubjectId()]));
        $dt_gov_class = $db->selectByID($mGovClass, $mGovClass->getId() . EQUAL . $rs_registration_detail[0][$regDetail->getGovernmentClassificationId()]);
        include_once FILE_PATH(IViewConstant::APPROVAL_PARTICIPANT_REGISTRATION_VIEW_INDEX . '/edit-participant.html.php');
    }

    public function create() {
        parent::create();
    }

    public function backErrorApprovedReject($linkRegistrationId, $approvalId) {
        return '<script>$(function () {postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_PARTICIPANT_REGISTRATION_INDEX_URL . '/edit-participant') . '\',\'link_registration_id=' . $linkRegistrationId . '&approval_id=' . $approvalId . '\')});</script>';
    }

    public function backSuccessApprovedReject($approvalParentId) {
        return '<script>$(function () {postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_PARTICIPANT_REGISTRATION_INDEX_URL . '/edit') . '\',\'id=' . $approvalParentId . '\')});</script>';
    }

    public function backSuccessModalApprovedReject($approvalParentId) {
        return '<script>$(function () {$(\'#myModal_self\').modal(\'hide\');postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_PARTICIPANT_REGISTRATION_INDEX_URL . '/edit') . '\',\'id=' . $approvalParentId . '\')});</script>';
    }

    public function rollBackRegDetail($regDetailId) {
        $regDetail = new TransactionRegistrationDetails();
        $db = new Database();
        $db->connect();
        $db->update($regDetail->getEntity(), array(
            $regDetail->getIsApproved() => null,
            $regDetail->getApprovedMessage() => null,
            $regDetail->getApprovedBy() => null,
            $regDetail->getApprovedOn() => null,
            $regDetail->getModifiedOn() => null,
            $regDetail->getModifiedByUsername() => null,
                ), $regDetail->getId() . equalToIgnoreCase($regDetailId));
        $rs_update_reg_detail = $db->getResult();
    }

    public function rollBackLinkRegistration($linkRegistrationId) {
        $linkRegistration = new LinkRegistration();
        $db = new Database();
        $db->connect();
        $db->update($linkRegistration->getEntity(), array(
            $linkRegistration->getStatus() => 1,
            $linkRegistration->getDescription() => "Approved Success",
            $linkRegistration->getCreatedBy() => $_SESSION[SESSION_ADMIN_USERNAME],
            $linkRegistration->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                ), $linkRegistration->getId() . equalToIgnoreCase($linkRegistrationId));
        $rs_update_link_registration = $db->getResult();
    }

    public function approveData() {
        $linkRegistrationId = $_POST['link_registration_id'];
        $approvalId = $_POST['approval_id'];

        $regDetail = new TransactionRegistrationDetails();
        $linkRegistration = new LinkRegistration();
        $masterApproval = new MasterApproval();
        $db = new Database();
        $db->connect();

        $rs_link_registration = $db->selectByID($linkRegistrationId, $linkRegistration->getId() . equalToIgnoreCase($linkRegistrationId));
        $db->update($regDetail->getEntity(), array(
            $regDetail->getIsApproved() => 1,
            $regDetail->getApprovedMessage() => "Approved Success",
            $regDetail->getApprovedBy() => $_SESSION[SESSION_ADMIN_USERNAME],
            $regDetail->getApprovedOn() => date(DATE_FORMAT_PHP_DEFAULT),
            $regDetail->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT),
            $regDetail->getModifiedByUsername() => $_SESSION[SESSION_ADMIN_USERNAME],
                ), $regDetail->getId() . equalToIgnoreCase($rs_link_registration[0][$linkRegistration->getRegistrationDetailsId()]));
        $rs_update_reg_detail = $db->getResult();
        if (is_numeric($rs_update_reg_detail[0] == 1)) {
            $db->update($linkRegistration->getEntity(), array(
                $linkRegistration->getStatus() => 1,
                $linkRegistration->getDescription() => "Approved Success",
                $linkRegistration->getCreatedBy() => $_SESSION[SESSION_ADMIN_USERNAME],
                $linkRegistration->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                    ), $linkRegistration->getId() . equalToIgnoreCase($linkRegistrationId));
            $rs_update_link_registration = $db->getResult();
            if (is_numeric($rs_update_link_registration[0] == 1)) {
                $db->update($masterApproval->getEntity(), array(
                    $masterApproval->getStatus() => 1,
                    $masterApproval->getDescription() => "Approved Success",
                    $masterApproval->getCreatedBy() => $_SESSION[SESSION_ADMIN_USERNAME],
                    $masterApproval->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                        ), $masterApproval->getId() . equalToIgnoreCase($approvalId));
                $rs_update_approval = $db->getResult();
                if (is_numeric($rs_update_approval[0] == 1)) {
                    
                } else {
                    $this->rollBackLinkRegistration($linkRegistrationId);
                    $this->rollBackRegDetail($rs_link_registration[0][$linkRegistration->getRegistrationDetailsId()]);
                    echo toastAlert('error', lang('general.title_approved_error'), lang('general.message_approved_error'));
                    echo $this->backErrorApprovedReject($linkRegistrationId, $approvalId);
                }
            } else {
                $this->rollBackRegDetail($rs_link_registration[0][$linkRegistration->getRegistrationDetailsId()]);
                echo toastAlert('error', lang('general.title_approved_error'), lang('general.message_approved_error'));
                echo $this->backErrorApprovedReject($linkRegistrationId, $approvalId);
            }
        } else {
            echo toastAlert('error', lang('general.title_approved_error'), lang('general.message_approved_error'));
            echo $this->backErrorApprovedReject($linkRegistrationId, $approvalId);
        }
    }

    public function createUserFromRegistration() {
        $approvalCategoryId = $_POST['approval_category_id'];
        $registrationId = $_POST['registration_id'];
        $transactionRegistration = new TransactionRegistration();
        $masterApproval = new MasterApproval();
        $securityUser = new SecurityUser();
        $securityUserProfile = new SecurityUserProfile();
        $securityGroup = new SecurityGroup();
        $masterContact = new MasterContact();
        $masterAddress = new MasterAddress();

        $db = new Database();
        $db->connect();

        $rs_reg = $db->selectByID($transactionRegistration, $transactionRegistration->getId() . equalToIgnoreCase($registrationId));
        $rs_approve = $db->selectByID($masterApproval, $masterApproval->getApprovalDetailId() . EQUAL . $registrationId . " AND " . $masterApproval->getApprovalCategoryId() . EQUAL . $approvalCategoryId);
        $code = explode('@', $rs_reg[0][$transactionRegistration->getDelegationEmail()]);

        $rs_group = $db->selectByID($securityGroup, $securityGroup->getCode() . equalToIgnoreCase('DELEGATION'));

        $password = password_hash($code[0], PASSWORD_BCRYPT);
        $db->insert($securityUser->getEntity(), array(
            $securityUser->getCode() => $code[0],
            $securityUser->getName() => $code[0],
            $securityUser->getEmail() => $rs_reg[0][$transactionRegistration->getDelegationEmail()],
            $securityUser->getPassword() => $password,
            $securityUser->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
            $securityUser->getCreatedByUsername() => $_SESSION[SESSION_ADMIN_USERNAME],
            $securityUser->getStatus() => 1,
            $securityUser->getGroupId() => $rs_group[0][$securityGroup->getId()],
            $securityUser->getDescription() => $code[0] . ' - From Registration PIC'
        ));
        $rs_user = $db->getResult();
//        LOGGER("insert user:".$rs_user);
        if (is_numeric($rs_user[0])) {
            $db->insert($masterContact->getEntity(), array(
                $masterContact->getCode() => createRandomBooking() . "-" . $code[0],
                $masterContact->getName() => $code[0],
                $masterContact->getEmail1() => $rs_reg[0][$transactionRegistration->getDelegationEmail()],
                $masterContact->getFax() => $rs_reg[0][$transactionRegistration->getDelegationFax()],
                $masterContact->getPhoneNumber1() => $rs_reg[0][$transactionRegistration->getDelegationPhoneNumber()],
                $masterContact->getStatus() => 1,
                $masterContact->getCreatedOn() => $_SESSION[SESSION_ADMIN_USERNAME],
                $masterContact->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
            ));
            $rs_contact = $db->getResult();

            $db->insert($masterAddress->getEntity(), array(
                $masterAddress->getCode() => createRandomBooking() . "-" . $code[0],
                $masterAddress->getName() => $rs_reg[0][$transactionRegistration->getDelegationAddress()],
                $masterAddress->getDescription() => $rs_reg[0][$transactionRegistration->getDelegationAddress()],
                $masterAddress->getProvinceId() => $rs_reg[0][$transactionRegistration->getProvinceId()],
                $masterAddress->getCityId() => $rs_reg[0][$transactionRegistration->getCityId()],
                $masterAddress->getVillageId() => $rs_reg[0][$transactionRegistration->getVillageId()],
                $masterAddress->getDistrictId() => $rs_reg[0][$transactionRegistration->getDistrictId()],
                $masterAddress->getZipCode() => $rs_reg[0][$transactionRegistration->getZipCode()],
                $masterAddress->getStatus() => 1,
                $masterAddress->getCreatedOn() => $_SESSION[SESSION_ADMIN_USERNAME],
                $masterAddress->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
            ));
            $rs_address = $db->getResult();
            $db->insert($securityUserProfile->getEntity(), array(
                $securityUserProfile->getCode() => $code[0],
                $securityUserProfile->getName() => $rs_reg[0][$transactionRegistration->getDelegationName()],
                $securityUserProfile->getContactId() => $rs_contact[0],
                $securityUserProfile->getAddressId() => $rs_address[0],
                $securityUserProfile->getUserId() => $rs_user[0],
                $securityUserProfile->getStatus() => 1,
                $securityUserProfile->getCreatedOn() => $_SESSION[SESSION_ADMIN_USERNAME],
                $securityUserProfile->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
            ));
            $rs_user_profile = $db->getResult();
            if (is_numeric($rs_user_profile[0])) {
                $db->update($transactionRegistration->getEntity(), array(
                    $transactionRegistration->getUserId() => $rs_user[0],
                        ), $transactionRegistration->getId() . equalToIgnoreCase($registrationId));
                $rs_update_reg = $db->getResult();
                $sendMail = $this->sendMailUserFromRegistration();
                if ($sendMail == true) {
                    echo toastAlert('success', lang('general.title_approved_success'), lang('general.message_approved_success'));
                    echo '<script>$(function () {$(\'#myModal_self\').modal(\'hide\');postAjaxPagination();});</script>';
                } else {
                    if (is_numeric($rs_contact[0])) {
                        $db->delete($masterContact->getEntity(), $masterContact->getId() . equalToIgnoreCase($rs_contact[0]));
                        $rs_delete = $db->getResult();
                    }
                    if (is_numeric($rs_address[0])) {
                        $db->delete($masterAddress->getEntity(), $masterAddress->getId() . equalToIgnoreCase($rs_address[0]));
                        $rs_delete = $db->getResult();
                    }
                    $db->delete($securityUserProfile->getEntity(), $securityUserProfile->getId() . equalToIgnoreCase($rs_user_profile[0]));
                    $rs_delete = $db->getResult();
                    $this->rollBackApproval();
                    echo toastAlert('error', lang('general.title_approved_error'), "Gagal Mengirim Email");
                    echo '<script>$(function () {postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_PARTICIPANT_REGISTRATION_INDEX_URL . '/edit') . '\',\'id=' . $rs_approve[0][$masterApproval->getId()] . '\');});</script>';
                }
            } else {
                if (is_numeric($rs_contact[0])) {
                    $db->delete($masterContact->getEntity(), $masterContact->getId() . equalToIgnoreCase($rs_contact[0]));
                    $rs_delete = $db->getResult();
                }
                if (is_numeric($rs_address[0])) {
                    $db->delete($masterAddress->getEntity(), $masterAddress->getId() . equalToIgnoreCase($rs_address[0]));
                    $rs_delete = $db->getResult();
                }
                $this->rollBackApproval();
                echo toastAlert('error', lang('general.title_approved_error'), lang('general.message_approved_error'));
                echo '<script>$(function () {postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_PARTICIPANT_REGISTRATION_INDEX_URL . '/edit') . '\',\'id=' . $rs_approve[0][$masterApproval->getId()] . '\');});</script>';
            }
        } else {
            $this->rollBackApproval();
            echo toastAlert('error', lang('general.title_approved_error'), lang('general.message_approved_error'));
            echo '<script>$(function () {postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_PARTICIPANT_REGISTRATION_INDEX_URL . '/edit') . '\',\'id=' . $rs_approve[0][$masterApproval->getId()] . '\');});</script>';
        }
    }

    public function sendMailRejectData() {
//        $approvalId = $_POST['approval_id'];
        $linkRegistrationId = $_POST['link_registration_id'];
        $linkRegistration = new LinkRegistration();
        $regDetail = new TransactionRegistrationDetails();
//        $masterApproval = new MasterApproval();
        $db = new Database();
        $db->connect();
        $rs_link_reg = $db->selectByID($linkRegistration, $linkRegistration->getId() . equalToIgnoreCase($linkRegistrationId));
        $rs_reg_detail = $db->selectByID($regDetail, $regDetail->getId() . equalToIgnoreCase($rs_link_reg[0][$linkRegistration->getRegistrationDetailsId()]));
//        $rs_approve = $db->selectByID($masterApproval, $masterApproval->getApprovalDetailId() . EQUAL . $registrationId . " AND " . $masterApproval->getApprovalCategoryId() . EQUAL . $approvalCategoryId);
//        $code = explode('@', $rs_reg[0][$transactionRegistration->getDelegationEmail()]);
//        $pic_code = $code[0];
        $pic_name = $rs_reg_detail[0][$regDetail->getName()];
        $pic_email = $rs_reg_detail[0][$regDetail->getEmail()];

        $img_logo_tala = 'http://54.251.168.102/e-portal/contents/logo-kecil.png';
        $subject = 'Approval Registrasi Pusbang BKN';
        $message = '<div style="border-style: solid;border-width: thin;font-family: \'Roboto\';">
                      <div align="center" style="margin:15px;"><img src="' . $img_logo_tala . '" width="120" height="40"/></div>
                        <div align="left" style="margin:15px;">
                            Kepada Yang Terhormat ' . $pic_name . ',
                        <br/><br/>
                       <p>
                            Pendaftaran Kegiatan anda <b>Tidak Disetujui</b> dengan Catatan:
                            <br/><br/>
                            ' . $_POST['message'] . '
                            <br/>
                       </p>
                        <br/>
                        <br/>
                        Terima Kasih telah mendaftar di Pusbang ASN
                        <br/><a href="' . URL('') . '" target="_blank">' . URL('') . '</a>
                        </div>
                        </div>
                            ';
        $mail = sendMail([array("email" => $pic_email, "name" => $pic_name)], $subject, $message);
        return $mail;
    }

    public function sendMailUserFromRegistration() {
        $approvalCategoryId = $_POST['approval_category_id'];
        $registrationId = $_POST['registration_id'];
        $transactionRegistration = new TransactionRegistration();
        $masterApproval = new MasterApproval();
        $db = new Database();
        $db->connect();
        $rs_reg = $db->selectByID($transactionRegistration, $transactionRegistration->getId() . equalToIgnoreCase($registrationId));
        $rs_approve = $db->selectByID($masterApproval, $masterApproval->getApprovalDetailId() . EQUAL . $registrationId . " AND " . $masterApproval->getApprovalCategoryId() . EQUAL . $approvalCategoryId);
        $code = explode('@', $rs_reg[0][$transactionRegistration->getDelegationEmail()]);
        $pic_code = $code[0];
        $pic_name = $rs_reg[0][$transactionRegistration->getDelegationName()];
        $pic_email = $rs_reg[0][$transactionRegistration->getDelegationEmail()];

        $mail = new PHPMailer;
        try {
            $mail->isSMTP();
//            echo MAIL_USERNAME . '-' . MAIL_PASSWORD;
//            $mail->Debugoutput = 'html';
//            $mail->SMTPDebug = 2;
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
            $mail->Subject = 'Approval Registrasi Pusbang BKN';
            $mail->Body = '<div style="border-style: solid;border-width: thin;font-family: \'Roboto\';">
                      <div align="center" style="margin:15px;"><img src="' . $img_logo_tala . '" width="120" height="40"/></div>
                        <div align="left" style="margin:15px;">
                            Kepada Yang Terhormat ' . $pic_name . ',
                        <br/><br/>
                       <p>
                            Pendaftaran Kegiatan anda telah disetujui, 
                            Anda bisa melakukan pendaftaran peserta menggunakan username dan password dibawah ini:
                            <br/><br/>Username : <b>' . $pic_code . '</b>
                            <br/>Password : <b>' . $pic_code . '</b>
                            <br/><br/>
                            Silahkan klik link dibawah ini untuk menuju kehalaman Portal Pusbang ASN,
                            <br/>
                            <a href="' . URL('') . '" target="_blank">' . URL('') . '</a>
                       </p>
                        <br/>
                        <br/>
                        Terima Kasih telah mendaftar di Pusbang ASN
                        <br/><a href="' . URL('') . '" target="_blank">' . URL('') . '</a>
                        </div>
                        </div>
                            ';
            if ($mail->smtpConnect()) {
                $mail->smtpClose();
                if (!$mail->send()) {
                    return false;
                    LOGGER($mail->ErrorInfo);
                } else {
                    return true;
                }
            } else {
                LOGGER("Error Connect SMTP");
                return false;
            }
        } catch (\Exception $e) {
            return false;
            LOGGER($e->getMessage());
        }
    }

    public function rollBackApproval($approvalId) {
        $masterApproval = new MasterApproval();
        $db = new Database();
        $db->connect();
        $db->update($masterApproval->getEntity(), array(
            $masterApproval->getStatus() => null,
            $masterApproval->getDescription() => null,
            $masterApproval->getCreatedBy() => null,
            $masterApproval->getCreatedOn() => null,
                ), $masterApproval->getId() . equalToIgnoreCase($approvalId));
        $rs_update_approval = $db->getResult();
    }

    public function rejectData() {
        $linkRegistrationId = $_POST['link_registration_id'];
        $approvalId = $_POST['approval_id'];
        $message = $_POST['message'];

        $regDetail = new TransactionRegistrationDetails();
        $linkRegistration = new LinkRegistration();
        $masterApproval = new MasterApproval();
        $db = new Database();
        $db->connect();

//        $rs_approval = $db->selectByID($masterApproval, $masterApproval->getAp() . equalToIgnoreCase($linkRegistrationId));
        $db->select($linkRegistration->getEntity(), $linkRegistration->getEntity().".*"
                . ",".$masterApproval->getEntity().DOT.$masterApproval->getId()." as approval_id", array($masterApproval->getEntity()), ""
                . $linkRegistration->getEntity() . DOT . $linkRegistration->getId() . EQUAL . $masterApproval->getEntity() . DOT . $masterApproval->getApprovalDetailId()
                . " AND " . $linkRegistration->getEntity().DOT.$linkRegistration->getId() . equalToIgnoreCase($linkRegistrationId));
        $rs_link_registration = $db->getResult();
        $db->update($regDetail->getEntity(), array(
            $regDetail->getIsApproved() => 0,
            $regDetail->getApprovedMessage() => $message,
            $regDetail->getApprovedBy() => $_SESSION[SESSION_ADMIN_USERNAME],
            $regDetail->getApprovedOn() => date(DATE_FORMAT_PHP_DEFAULT),
            $regDetail->getModifiedOn() => date(DATE_FORMAT_PHP_DEFAULT),
            $regDetail->getModifiedByUsername() => $_SESSION[SESSION_ADMIN_USERNAME],
                ), $regDetail->getId() . equalToIgnoreCase($rs_link_registration[0][$linkRegistration->getRegistrationDetailsId()]));
        $rs_update_reg_detail = $db->getResult();
//        print_r($rs_update_reg_detail);
        if (is_numeric($rs_update_reg_detail[0]) == 1) {
            $db->update($linkRegistration->getEntity(), array(
                $linkRegistration->getStatus() => 0,
                $linkRegistration->getDescription() => $message,
                $linkRegistration->getCreatedBy() => $_SESSION[SESSION_ADMIN_USERNAME],
                $linkRegistration->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                    ), $linkRegistration->getId() . equalToIgnoreCase($linkRegistrationId));
            $rs_update_link_registration = $db->getResult();
//            print_r($rs_update_link_registration);
            if (is_numeric($rs_update_link_registration[0]) == 1) {
                $db->update($masterApproval->getEntity(), array(
                    $masterApproval->getStatus() => 0,
                    $masterApproval->getDescription() => $message,
                    $masterApproval->getCreatedByUsername() => $_SESSION[SESSION_ADMIN_USERNAME],
                    $masterApproval->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                        ), $masterApproval->getId() . equalToIgnoreCase($rs_link_registration[0]['approval_id']));
                $rs_update_approval = $db->getResult();
                if (is_numeric($rs_update_approval[0]) == 1) {
                    $sendMail = $this->sendMailRejectData();
                    if ($sendMail == true) {
                        echo toastAlert('success', lang('general.title_rejected_success'), lang('general.message_rejected_success'));
                        echo $this->backSuccessModalApprovedReject($approvalId);
                    } else {
                        $this->rollBackApproval($rs_link_registration[0]['approval_id']);
                        $this->rollBackLinkRegistration($linkRegistrationId);
                        $this->rollBackRegDetail($rs_link_registration[0][$linkRegistration->getRegistrationDetailsId()]);
                        echo toastAlert('error', lang('general.title_rejected_error'), lang('general.message_rejected_error'));
                        echo $this->backErrorApprovedReject($linkRegistrationId, $rs_link_registration[0]['approval_id']);
                    }
                } else {
                    $this->rollBackLinkRegistration($linkRegistrationId);
                    $this->rollBackRegDetail($rs_link_registration[0][$linkRegistration->getRegistrationDetailsId()]);
                    echo toastAlert('error', lang('general.title_rejected_error'), lang('general.message_rejected_error'));
                    echo $this->backErrorApprovedReject($linkRegistrationId, $rs_link_registration[0]['approval_id']);
                }
            } else {
                $this->rollBackRegDetail($rs_link_registration[0][$linkRegistration->getRegistrationDetailsId()]);
                echo toastAlert('error', lang('general.title_rejected_error'), lang('general.message_rejected_error'));
                echo $this->backErrorApprovedReject($linkRegistrationId, $rs_link_registration[0]['approval_id']);
            }
        } else {
            echo toastAlert('error', lang('general.title_rejected_error'), lang('general.message_rejected_error'));
            echo $this->backErrorApprovedReject($linkRegistrationId, $rs_link_registration[0]['approval_id']);
        }
    }

    public function rejectDetail() {
//        echo $_SESSION[SESSION_ADMIN_USERNAME];
        echo '<form role="form" id="form-message-reject" class="signup" action="#" onsubmit="return false;" method="POST" novalidate="novalidate">';
        echo Form()->id('message')->title(lang('member.rejection_notes'))->placeholder('Tulis Alasan Penolakan')->textarea();
        $approvalId = $_POST['approval_id'];
        $linkRegistrationId = $_POST['link_registration_id'];
//            echo $registration_id;
        echo Button()->icon('fa fa-times')
                ->setClass('btn btn-warning')
                ->alertBtnMsg(lang('member.yes'))
                ->alertMsg(lang('member.notif_rejected_candidates'))
                ->alertTitle(lang('general.reject'))
                ->onClick('postAjaxByAlertFormManual(this,\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_PARTICIPANT_REGISTRATION_INDEX_URL . '/edit-participant/reject') . '\',\'form-message-reject\',\'approval_id=' . $approvalId . '&link_registration_id=' . $linkRegistrationId . '\')')
                ->label(lang('general.reject'))->buttonManual();
        echo '</form>';
        echo '<script>$(function(){$(\'#modal-title-self\').html(\'' . lang('member.detail_approved_reject_candidates') . " | " . lang('member.rejection_notes') . '\')});</script>';
    }

}
