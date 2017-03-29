<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Router
 * @email : sfandrianah2@gmail.com
 * @author Syahrial Fandrianah
 * @FRAMEWORK NATIVE ECCOMERCE V.1.0
 */
use app\Util\Routes;
// ROUTE;
use app\Util\Database;
use app\Model\SecurityFunction;
use app\Model\SecurityFunctionAssignment;
use app\Model\MasterPostFunction;
use app\Model\MasterPost;
use app\Constant\IURLConstant;
use app\Constant\IURLMemberConstant;

$db = new Database();

$sfa = new SecurityFunctionAssignment();
$Routes = new Routes();


//Routes::setTest('test');
//DEFAULT ROUTES
Routes::set('', 'app\Controller\Base\Home@index');
$sys_url_admin = getSystemParameter('SYSTEM_ADMINISTRATOR_URL');
//echo 'tes'.$sys_url_admin;
Routes::set($sys_url_admin, 'app\Controller\Base\Home@indexAdministrator');
Routes::set($sys_url_admin . '/login/proses', 'app\Controller\Base\AuthAdmin@login');
Routes::set($sys_url_admin . '/logout', 'app\Controller\Base\AuthAdmin@logout');
//Routes::set('page/about-tala', 'app\Controller\Master\About@page');
Routes::set('page/contact', 'app\Controller\Master\Contact@page');
Routes::set('test-test', 'app\Controller\Master\Test@index');
Routes::set('test-hashing', 'app\Controller\Master\Test@hashing');
Routes::set('test-mail', 'app\Controller\Master\Test@testMail');
Routes::set('test-parameter/{param}', 'app\Controller\Master\Test@testParam');
//Routes::set('page/carrer', 'app\Controller\Master\Carrer@page');
//Routes::set('page/tala-membership', 'app\Controller\Master\MemberShip@page');

Routes::set('search/lov', 'app\Controller\Base\SelectLOV@index');
Routes::set('chat/send', 'app\Controller\Base\Chat@sendChat');
Routes::set('chat/load', 'app\Controller\Base\Chat@loadChat');
Routes::set('chat/load/staging', 'app\Controller\Base\Chat@loadChatStaging');
Routes::set('chat/load/user', 'app\Controller\Base\Chat@loadChatUsers');
Routes::set('chat/load/parentuser', 'app\Controller\Base\Chat@loadChatParentUsers');
//Routes::set('FNC005', 'app\Controller\Master\Project@index');
//Routes::set('FNC006', 'app\Controller\Master\Project@index');


Routes::set('page/login', 'app\Controller\Base\Auth@loginPage');
Routes::set('page/login/proses', 'app\Controller\Base\Auth@login');
Routes::set('page/logout', 'app\Controller\Base\Auth@logout');

Routes::group(['prefix' => 'member'], function() {
    Routes::set('register', 'app\Controller\Base\Auth@registerPage');
    Routes::set('register/proses', 'app\Controller\Guest\Activity@register');
});

Routes::set('member/login', 'app\Controller\Base\Auth@loginPage');


Routes::set('page/forgot-password', 'app\Controller\Base\Auth@forgotPasswordPage');
Routes::set('page/forgot-password/proses', 'app\Controller\Base\Auth@forgotPassword');
Routes::set('page/change-password/member', 'app\Controller\Base\Auth@changePassword');
Routes::set('page/search', 'app\Controller\Master\Read@search');

Routes::set('captcha/search', 'app\Util\TCaptcha\TCaptcha@getCaptcha');
Routes::set('captcha/reload', 'app\Util\TCaptcha\TCaptcha@reloadCaptcha');

Routes::set('contact-us', 'app\Controller\Guest\ContactUs@index');
Routes::set('contact-us/submit', 'app\Controller\Guest\ContactUs@save');

Routes::set('activity', 'app\Controller\Guest\Activity@index');
Routes::set('activity/search', 'app\Controller\Guest\Activity@search');
Routes::set('activity/{id}/register', 'app\Controller\Guest\Activity@registerActivityPage');
Routes::set('activity/register/save/{idActivity}', 'app\Controller\Guest\Activity@saveNewRegister');
Routes::set('alumni', 'app\Controller\Guest\Alumni@index');
Routes::set('alumni/search', 'app\Controller\Guest\Alumni@search');

Routes::set('selected', 'app\Controller\Base\General@getArea');
if (isset($_SESSION[SESSION_USERNAME_GUEST]) && isset($_SESSION[SESSION_GROUP_GUEST])) {

    Routes::set('page/member/user-profile', 'app\Controller\Member\UserProfile@index');
    Routes::set('page/member/user-profile/change-password', 'app\Controller\Member\UserProfile@changePassword');
    Routes::set('page/member/user-profile/change-password/proses', 'app\Controller\Member\UserProfile@changePasswordProses');
    Routes::set('page/member/user-profile/save', 'app\Controller\Member\UserProfile@save');
    Routes::set('page/member/user-profile/edit', 'app\Controller\Member\UserProfile@edit');
    Routes::set('page/member/user-profile/list-saldo', 'app\Controller\Member\UserProfile@detailSaldoTopup');
    Routes::set('page/member/user-profile/changeProfile', 'app\Controller\Member\UserProfile@changeUserProfile');

    Routes::set('page/member/topup-saldo/konfirmasi', 'app\Controller\Member\TopupSaldo@indexKonfirmasi');
    Routes::set('page/member/topup-saldo/konfirmasi/layout', 'app\Controller\Member\TopupSaldo@konfirmasi');
    Routes::set('page/member/topup-saldo/konfirmasi/save', 'app\Controller\Member\TopupSaldo@uploadImage');


    Routes::set('page/member/dashboard', 'app\Controller\Member\Dashboard@index');




    Routes::set('page/member/notification', 'app\Controller\Member\Notification@index');
    Routes::set('page/member/notification/list', 'app\Controller\Member\Notification@lists');
    Routes::set('page/member/notification/view', 'app\Controller\Member\Notification@view');

    Routes::set('page/member/video-seminar', 'app\Controller\Member\VideoSeminar@index');
    Routes::set('page/member/video-seminar/list', 'app\Controller\Member\VideoSeminar@lists');
    Routes::set('page/member/video-seminar/view', 'app\Controller\Member\VideoSeminar@view');

    Routes::set(IURLMemberConstant::AGENDA_KEGIATAN_URL, 'app\Controller\Member\AgendaKegiatanMember@index');
    Routes::set(IURLMemberConstant::AGENDA_KEGIATAN_URL . '/list', 'app\Controller\Member\AgendaKegiatanMember@listData');
    Routes::set(IURLMemberConstant::AGENDA_KEGIATAN_URL . '/view', 'app\Controller\Member\AgendaKegiatanMember@view');

    Routes::set(IURLMemberConstant::ACTIVITY_REGISTRATION_URL, 'app\Controller\Member\RegistrationActivity@index');
    Routes::set(IURLMemberConstant::ACTIVITY_REGISTRATION_URL . '/list', 'app\Controller\Member\RegistrationActivity@listData');
    Routes::set(IURLMemberConstant::ACTIVITY_REGISTRATION_URL . '/approve', 'app\Controller\Member\RegistrationActivity@approved');

    Routes::set(IURLMemberConstant::ACTIVITY_REGISTRATION_TEMP_URL, 'app\Controller\Member\Registration\RegistrationActivityTemp@index');
    Routes::set(IURLMemberConstant::ACTIVITY_REGISTRATION_TEMP_URL . '/list', 'app\Controller\Member\Registration\RegistrationActivityTemp@listData');
    Routes::set(IURLMemberConstant::ACTIVITY_REGISTRATION_TEMP_URL . '/approve', 'app\Controller\Member\Registration\RegistrationActivityTemp@approved');
    Routes::set(IURLMemberConstant::ACTIVITY_REGISTRATION_TEMP_URL . '/{activity}/register', 'app\Controller\Member\Registration\RegistrationActivityTemp@registerActivityPage');
    Routes::set(IURLMemberConstant::ACTIVITY_REGISTRATION_TEMP_URL . '/{activity}/save-register', 'app\Controller\Member\Registration\RegistrationActivityTemp@saveRegisterActivity');
    Routes::set(IURLMemberConstant::ACTIVITY_REGISTRATION_TEMP_LIST_USER_URL . '/{activity}', 'app\Controller\Member\Registration\RegistrationActivityTemp@listUserData');
    Routes::set(IURLMemberConstant::ACTIVITY_REGISTRATION_TEMP_LIST_USER_URL . '/{activity}/create', 'app\Controller\Member\Registration\RegistrationActivityTemp@createUserData');
    Routes::set(IURLMemberConstant::ACTIVITY_REGISTRATION_TEMP_LIST_USER_URL . '/{activity}/save', 'app\Controller\Member\Registration\RegistrationActivityTemp@saveUserData');
    Routes::set(IURLMemberConstant::ACTIVITY_REGISTRATION_TEMP_LIST_USER_ADD_URL . '/{activity}/add', 'app\Controller\Member\Registration\RegistrationActivityTemp@addChooseUser');
    Routes::set(IURLMemberConstant::ACTIVITY_REGISTRATION_TEMP_LIST_USER_ADD_URL . '/{activity}/list', 'app\Controller\Member\Registration\RegistrationActivityTemp@listChooseUser');
    Routes::set(IURLMemberConstant::ACTIVITY_REGISTRATION_TEMP_LIST_USER_ADD_URL . '/{activity}/index', 'app\Controller\Member\Registration\RegistrationActivityTemp@indexChooseUser');


    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL, 'app\Controller\Member\AgendaOrganizer@index');
    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/list', 'app\Controller\Member\AgendaOrganizer@listData');
    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/approve', 'app\Controller\Member\AgendaOrganizer@approved');
    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/view/{activity}', 'app\Controller\Member\AgendaOrganizer@view');
    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/view/{activity}/detail', 'app\Controller\Member\AgendaOrganizer@detailApproval');
    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/view/{activity}/approve', 'app\Controller\Member\AgendaOrganizer@approveData');
    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/view/{activity}/reject', 'app\Controller\Member\AgendaOrganizer@rejectData');
    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/view/{activity}/reject-detail', 'app\Controller\Member\AgendaOrganizer@rejectDetail');
    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/assignment/{activity}', 'app\Controller\Member\AgendaOrganizer@listPanitia');
    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/assignment/{activity}/create', 'app\Controller\Member\AgendaOrganizer@createPanitia');
    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/assignment/{activity}/edit', 'app\Controller\Member\AgendaOrganizer@editPanitia');
    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/assignment/{activity}/list-user', 'app\Controller\Member\AgendaOrganizer@listUserPanitia');
    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/assignment/{activity}/save', 'app\Controller\Member\AgendaOrganizer@savePanitia');
    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/assignment/{activity}/update', 'app\Controller\Member\AgendaOrganizer@updatePanitia');
    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/assignment/{activity}/delete', 'app\Controller\Member\AgendaOrganizer@deletePanitia');
    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/assignment/{activity}/deleteCollection', 'app\Controller\Member\AgendaOrganizer@deleteCollectionPanitia');

    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/details/{activity}', 'app\Controller\Member\AgendaOrganizer@listDetails');
    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/details/{activity}/create', 'app\Controller\Member\AgendaOrganizer@createDetails');
    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/details/{activity}/edit', 'app\Controller\Member\AgendaOrganizer@editDetails');
    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/details/{activity}/list-user', 'app\Controller\Member\AgendaOrganizer@listDetails');
    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/details/{activity}/save', 'app\Controller\Member\AgendaOrganizer@saveDetails');
    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/details/{activity}/update', 'app\Controller\Member\AgendaOrganizer@updateDetails');
    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/details/{activity}/delete', 'app\Controller\Member\AgendaOrganizer@deleteDetails');
    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/details/{activity}/deleteCollection', 'app\Controller\Member\AgendaOrganizer@deleteCollectionDetails');

    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/list-peserta/{activity}', 'app\Controller\Member\AgendaOrganizer@listPeserta');
    Routes::set(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/list-peserta/{activity}/view', 'app\Controller\Member\AgendaOrganizer@viewPeserta');

    Routes::set(IURLMemberConstant::LIST_PARTICIPANT_URL . '', 'app\Controller\Member\ListParticipant@index');
    Routes::set(IURLMemberConstant::LIST_PARTICIPANT_URL . '/list', 'app\Controller\Member\ListParticipant@listData');
    Routes::set(IURLMemberConstant::LIST_PARTICIPANT_EDIT_URL, 'app\Controller\Member\ListParticipant@edit');
    Routes::set(IURLMemberConstant::LIST_PARTICIPANT_VIEW_URL, 'app\Controller\Member\ListParticipant@view');
    Routes::set(IURLMemberConstant::LIST_PARTICIPANT_UPDATE_URL, 'app\Controller\Member\ListParticipant@update');

    Routes::setScaffolding(IURLMemberConstant::SURVEY_ORGANIZER_URL, 'app\Controller\Member\Survey\OrganizerSurvey');
    Routes::setScaffolding(IURLMemberConstant::REKAPITULASI_NILAI_URL, 'app\Controller\Member\RekapitulasiNilai');

    Routes::setScaffolding(IURLMemberConstant::SURVEY_TRAINER_URL, 'app\Controller\Member\Survey\TrainerSurvey');
    Routes::set(IURLMemberConstant::SURVEY_TRAINER_URL . '/detail', 'app\Controller\Member\Survey\TrainerSurvey@activityDetail');
    Routes::set(IURLMemberConstant::SURVEY_TRAINER_URL . '/detail/survey', 'app\Controller\Member\Survey\TrainerSurvey@activityDetailSurvey');
    Routes::set(IURLMemberConstant::SURVEY_TRAINER_URL . '/save', 'app\Controller\Member\Survey\TrainerSurvey@saveSurvey');
}

//ROUTES ADMIN
if (isset($_SESSION[SESSION_USERNAME]) && isset($_SESSION[SESSION_GROUP])) {
    if ($_SESSION[SESSION_GROUP] != 1) {

        //ROUTES MENU POSTING - POST
        $post_class = 'app\Controller\Posting\Posting';
        Routes::set($sys_url_admin . IURLConstant::POST_INDEX_URL, $post_class . '@index');
        Routes::set($sys_url_admin . IURLConstant::POST_LIST_URL, $post_class . '@listData');
        Routes::set($sys_url_admin . IURLConstant::POST_CREATE_URL, $post_class . '@create');
        Routes::set($sys_url_admin . IURLConstant::POST_SAVE_URL, $post_class . '@save');
        Routes::set($sys_url_admin . IURLConstant::POST_UPDATE_URL, $post_class . '@update');
        Routes::set($sys_url_admin . IURLConstant::POST_EDIT_URL, $post_class . '@edit');
        Routes::set($sys_url_admin . IURLConstant::POST_DELETE_URL, $post_class . '@delete');


        //ROUTES MENU POSTING - POST_ASSIGN
        $post_assign_class = 'app\Controller\Posting\PostingAssignment';
        Routes::set($sys_url_admin . IURLConstant::POST_ASSIGN_INDEX_URL, $post_assign_class . '@index');
        Routes::set($sys_url_admin . IURLConstant::POST_ASSIGN_LIST_URL, $post_assign_class . '@listData');
        Routes::set($sys_url_admin . IURLConstant::POST_ASSIGN_CREATE_URL, $post_assign_class . '@create');
        Routes::set($sys_url_admin . IURLConstant::POST_ASSIGN_SAVE_URL, $post_assign_class . '@save');
        Routes::set($sys_url_admin . IURLConstant::POST_ASSIGN_UPDATE_URL, $post_assign_class . '@update');
        Routes::set($sys_url_admin . IURLConstant::POST_ASSIGN_EDIT_URL, $post_assign_class . '@edit');
        Routes::set($sys_url_admin . IURLConstant::POST_ASSIGN_DELETE_URL, $post_assign_class . '@delete');
        Routes::set($sys_url_admin . IURLConstant::POST_ASSIGN_LIST_POST, $post_assign_class . '@listPost');
        Routes::set($sys_url_admin . IURLConstant::POST_ASSIGN_EDIT_URL . "/create-post-assign", $post_assign_class . '@createPostAssign');
        Routes::set($sys_url_admin . IURLConstant::POST_ASSIGN_EDIT_URL . "/list-post-assign", $post_assign_class . '@listPostAssign');
        Routes::set($sys_url_admin . IURLConstant::POST_ASSIGN_EDIT_URL . "/add-post-assign", $post_assign_class . '@addPostAssign');
        Routes::set($sys_url_admin . IURLConstant::POST_ASSIGN_EDIT_URL . "/delete-post-assign", $post_assign_class . '@deletePostAssign');
        Routes::set($sys_url_admin . IURLConstant::POST_ASSIGN_EDIT_URL . "/view-post-assign", $post_assign_class . '@viewPostAssign');



        Routes::setScaffolding($sys_url_admin . IURLConstant::GROUP_INDEX_URL, 'app\Controller\Security\Group');
        Routes::setScaffolding($sys_url_admin . IURLConstant::USER_INDEX_URL, 'app\Controller\Security\User');
        Routes::setScaffolding($sys_url_admin . IURLConstant::FUNCTION_INDEX_URL, 'app\Controller\Security\Functions');
        Routes::setScaffolding($sys_url_admin . IURLConstant::FUNCTION_ASSIGNMENT_INDEX_URL, 'app\Controller\Security\FunctionAssignment');
        Routes::set($sys_url_admin . IURLConstant::FUNCTION_ASSIGNMENT_INDEX_URL . '/add-function', 'app\Controller\Security\FunctionAssignment@addFunction');
        Routes::set($sys_url_admin . IURLConstant::FUNCTION_ASSIGNMENT_INDEX_URL . '/get-function-action-type', 'app\Controller\Security\FunctionAssignment@getActionType');
        Routes::set($sys_url_admin . IURLConstant::FUNCTION_ASSIGNMENT_INDEX_URL . '/save-function', 'app\Controller\Security\FunctionAssignment@saveFunction');
        Routes::set($sys_url_admin . IURLConstant::FUNCTION_ASSIGNMENT_INDEX_URL . '/delete-function', 'app\Controller\Security\FunctionAssignment@deleteFunction');
        Routes::set($sys_url_admin . IURLConstant::FUNCTION_ASSIGNMENT_INDEX_URL . '/edit-function', 'app\Controller\Security\FunctionAssignment@editFunction');
        Routes::set($sys_url_admin . IURLConstant::FUNCTION_ASSIGNMENT_INDEX_URL . '/update-function', 'app\Controller\Security\FunctionAssignment@updateFunction');
        Routes::set($sys_url_admin . IURLConstant::FUNCTION_ASSIGNMENT_INDEX_URL . '/sorting-function', 'app\Controller\Security\FunctionAssignment@updateSortFunction');

        Routes::set($sys_url_admin . '/e-learning', 'app\Controller\Security\Settings@eLearning');
        Routes::set($sys_url_admin . '/settings', 'app\Controller\Security\Settings@index');
        Routes::set($sys_url_admin . '/settings/update', 'app\Controller\Security\Settings@update');
        Routes::set($sys_url_admin . '/profile', 'app\Controller\Base\General@profile');
        Routes::set($sys_url_admin . '/profile/update', 'app\Controller\Base\General@profileUpdate');
        Routes::set($sys_url_admin . '/change-password', 'app\Controller\Base\General@changePassword');
        Routes::set($sys_url_admin . '/change-password/update', 'app\Controller\Base\General@changePasswordUpdate');
        Routes::set($sys_url_admin . '/logout', 'app\Controller\Base\AuthAdmin@logout');
        Routes::set($sys_url_admin . '/media', 'app\Controller\Base\Media@index');
        Routes::set($sys_url_admin . '/get-media', 'app\Controller\Base\Media@getMedia');
        Routes::set($sys_url_admin . '/list-get-media', 'app\Controller\Base\Media@listGetMedia');
        Routes::set($sys_url_admin . '/lock-screen', 'app\Controller\Base\AuthAdmin@lockScreen');

        Routes::set($sys_url_admin . '/security/guest-menu', 'app\Controller\Base\GuestMenu@index');


        Routes::group(["prefix" => $sys_url_admin], function() {
            Routes::setScaffolding(IURLConstant::MASTER_ROOM_INDEX_URL, 'app\Controller\Master\Room');
            Routes::setScaffolding(IURLConstant::MASTER_FACILITY_INDEX_URL, 'app\Controller\Master\Facility');
            Routes::setScaffolding(IURLConstant::MASTER_ANSWER_CATEGORY_INDEX_URL, 'app\Controller\Master\AnswerCategory');
            Routes::setScaffolding(IURLConstant::MASTER_CITY_INDEX_URL, 'app\Controller\Master\City');
            Routes::setScaffolding(IURLConstant::DOCUMENTATION_INDEX_URL, 'app\Controller\Documentation\Documentation');
            Routes::setScaffolding(IURLConstant::MASTER_CATEGORY_ASSESS_INDEX_URL, 'app\Controller\Master\CategoryAssess');
            Routes::setScaffolding(IURLConstant::MASTER_QUESTION_CATEGORY_INDEX_URL, 'app\Controller\Master\QuestionCategory');
            Routes::setScaffolding(IURLConstant::MASTER_ANSWER_TYPE_INDEX_URL, 'app\Controller\Master\AnswerType');
            Routes::setScaffolding(IURLConstant::MASTER_SLIDER_INDEX_URL, 'app\Controller\Master\Slider');
            Routes::setScaffolding(IURLConstant::MASTER_SUBJECT_INDEX_URL, 'app\Controller\Master\Subject');
            Routes::setScaffolding(IURLConstant::MASTER_SUBJECT_REQUIREMENTS_INDEX_URL, 'app\Controller\Master\SubjectRequirementsController');
            Routes::setScaffolding(IURLConstant::AGENDA_KEGIATAN_INDEX_URL, 'app\Controller\Transaction\AgendaKegiatan');
            Routes::setScaffolding(IURLConstant::MASTER_MATERIAL_SUBJECT_INDEX_URL, 'app\Controller\Master\MaterialSubjectController');

            Routes::set(IURLConstant::MASTER_SUBJECT_INDEX_URL . '/curriculum/{subjectId}', 'app\Controller\Master\Subject@curriculums');
            Routes::set(IURLConstant::MASTER_SUBJECT_INDEX_URL . '/curriculum/{subjectId}/create', 'app\Controller\Master\Subject@createCurriculums');
            Routes::set(IURLConstant::MASTER_SUBJECT_INDEX_URL . '/assessment-point/{subjectId}', 'app\Controller\Master\Subject@assessmentPoints');


            Routes::set(IURLConstant::AGENDA_KEGIATAN_INDEX_URL . '/assignment/{activity}', 'app\Controller\Transaction\AgendaKegiatan@listPanitia');
            Routes::set(IURLConstant::AGENDA_KEGIATAN_INDEX_URL . '/assignment/{activity}/create', 'app\Controller\Transaction\AgendaKegiatan@createPanitia');
            Routes::set(IURLConstant::AGENDA_KEGIATAN_INDEX_URL . '/assignment/{activity}/edit', 'app\Controller\Transaction\AgendaKegiatan@editPanitia');
            Routes::set(IURLConstant::AGENDA_KEGIATAN_INDEX_URL . '/assignment/{activity}/list-user', 'app\Controller\Transaction\AgendaKegiatan@listUserPanitia');
            Routes::set(IURLConstant::AGENDA_KEGIATAN_INDEX_URL . '/assignment/{activity}/save', 'app\Controller\Transaction\AgendaKegiatan@savePanitia');
            Routes::set(IURLConstant::AGENDA_KEGIATAN_INDEX_URL . '/assignment/{activity}/update', 'app\Controller\Transaction\AgendaKegiatan@updatePanitia');
            Routes::set(IURLConstant::AGENDA_KEGIATAN_INDEX_URL . '/assignment/{activity}/delete', 'app\Controller\Transaction\AgendaKegiatan@deletePanitia');
            Routes::set(IURLConstant::AGENDA_KEGIATAN_INDEX_URL . '/assignment/{activity}/deleteCollection', 'app\Controller\Transaction\AgendaKegiatan@deleteCollectionPanitia');

            Routes::set(IURLConstant::AGENDA_KEGIATAN_INDEX_URL . '/details/{activity}', 'app\Controller\Transaction\AgendaKegiatan@listDetails');
            Routes::set(IURLConstant::AGENDA_KEGIATAN_INDEX_URL . '/details/{activity}/create', 'app\Controller\Transaction\AgendaKegiatan@createDetails');
            Routes::set(IURLConstant::AGENDA_KEGIATAN_INDEX_URL . '/details/{activity}/edit', 'app\Controller\Transaction\AgendaKegiatan@editDetails');
            Routes::set(IURLConstant::AGENDA_KEGIATAN_INDEX_URL . '/details/{activity}/list-user', 'app\Controller\Transaction\AgendaKegiatan@listDetails');
            Routes::set(IURLConstant::AGENDA_KEGIATAN_INDEX_URL . '/details/{activity}/save', 'app\Controller\Transaction\AgendaKegiatan@saveDetails');
            Routes::set(IURLConstant::AGENDA_KEGIATAN_INDEX_URL . '/details/{activity}/update', 'app\Controller\Transaction\AgendaKegiatan@updateDetails');
            Routes::set(IURLConstant::AGENDA_KEGIATAN_INDEX_URL . '/details/{activity}/delete', 'app\Controller\Transaction\AgendaKegiatan@deleteDetails');
            Routes::set(IURLConstant::AGENDA_KEGIATAN_INDEX_URL . '/details/{activity}/deleteCollection', 'app\Controller\Transaction\AgendaKegiatan@deleteCollectionDetails');

            Routes::set(IURLConstant::AGENDA_KEGIATAN_INDEX_URL . '/list-peserta/{activity}', 'app\Controller\Transaction\AgendaKegiatan@listPeserta');
            Routes::set(IURLConstant::AGENDA_KEGIATAN_INDEX_URL . '/list-peserta/{activity}/view', 'app\Controller\Transaction\AgendaKegiatan@viewPeserta');

            Routes::setScaffolding(IURLConstant::APPROVAL_PARTICIPANT_REGISTRATION_INDEX_URL, 'app\Controller\Approval\ParticipantRegistration');
            Routes::set(IURLConstant::APPROVAL_PARTICIPANT_REGISTRATION_INDEX_URL . '/edit-participant/approve', 'app\Controller\Approval\ParticipantRegistration@approveData');
            Routes::set(IURLConstant::APPROVAL_PARTICIPANT_REGISTRATION_INDEX_URL . '/edit-participant/reject', 'app\Controller\Approval\ParticipantRegistration@rejectData');
            Routes::set(IURLConstant::APPROVAL_PARTICIPANT_REGISTRATION_INDEX_URL . '/edit-participant/reject-detail', 'app\Controller\Approval\ParticipantRegistration@rejectDetail');
            Routes::set(IURLConstant::APPROVAL_PARTICIPANT_REGISTRATION_INDEX_URL . '/edit-participant', 'app\Controller\Approval\ParticipantRegistration@editParticipant');

            Routes::setScaffolding(IURLConstant::APPROVAL_PIC_REGISTRATION_INDEX_URL, 'app\Controller\Approval\PICRegistration');
            Routes::set(IURLConstant::APPROVAL_PIC_REGISTRATION_INDEX_URL . '/{activity}/approve', 'app\Controller\Approval\PICRegistration@approveData');
            Routes::set(IURLConstant::APPROVAL_PIC_REGISTRATION_INDEX_URL . '/{activity}/reject', 'app\Controller\Approval\PICRegistration@rejectData');
            Routes::set(IURLConstant::APPROVAL_PIC_REGISTRATION_INDEX_URL . '/{activity}/reject-detail', 'app\Controller\Approval\PICRegistration@rejectDetail');

            Routes::setScaffolding(IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL, 'app\Controller\Approval\ActivityRegistration');
            Routes::set(IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/{activity}/approve', 'app\Controller\Approval\ActivityRegistration@approveData');
            Routes::set(IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/{activity}/reject', 'app\Controller\Approval\ActivityRegistration@rejectData');
            Routes::set(IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/{activity}/reject-detail', 'app\Controller\Approval\ActivityRegistration@rejectDetail');
        });
    }
}










/* -- ROUTES SCAFOLDING FOR MEMBER, DON'T EDIT THIS SCRIPT -- */
//Routes::set('page/migration', 'app\Controller\Master\Test@migration');
//END DEFAULT ROUTES
//echo FULLURL();
$replace_url = ltrim(str_replace(URL(), "", FULLURL()), "/");
$exp_url = explode("/", $replace_url);

//echo count($exp_uri);


$db->connect();
$sf = new SecurityFunction();
/*
  $db->select($sf->getEntity(), "*", array($sfa->getEntity()), $sf->getEntity() . "." . $sf->getId() . EQUAL . $sfa->getEntity() . "." . $sfa->getFunction()->getId() . ""
  . " AND " . $sfa->getEntity() . DOT . $sfa->getGroup()->getId() . EQUAL . "1");
  $rs_menu = $db->getResult();
 * */

//print_r($rs_menu);
$str_replace_url = str_replace(URL(), "", FULLURL());
$rs_url_now = $db->selectByID($sf, $sf->getUrl() . "='" . $str_replace_url . "'");
//print_r($rs_url_now);
//$str_replace_url = str_replace(URL(''), $sf, $exp_url);



if (!empty($rs_url_now)) {
//    print_r($rs_url_now);
    $_POST['function_id_now'] = $rs_url_now[0][$sf->getId()];

    $url_guest = $rs_url_now[0][$sf->getUrl()];
    if (substr($url_guest, 0, 1) != "/") {
        $url_guest = $url_guest;
    } else {
        $url_guest = ltrim($url_guest, "/");
    }


    if ($rs_url_now[0][$sf->getTypeUrl()] == 2) {
//        echo $url_guest;
        Routes::set($url_guest, 'app\Controller\Master\MasterGuest@page');
    } else if ($rs_url_now[0][$sf->getTypeUrl()] == 3) {
        Routes::set($url_guest, 'app\Controller\Master\MasterGuest@pageGallery');
    } else if ($rs_url_now[0][$sf->getTypeUrl()] == 4) {
        $db->sql("SELECT COUNT('*') as count_menu FROM " . $sf->getEntity() . WHERE . $sf->getParent() . EQUAL . $rs_url_now[0][$sf->getId()]);
        $cm = $db->getResult();
//        print_r($count_menu);
        if ($cm[0]['count_menu'] == 0) {
            Routes::set($url_guest, 'app\Controller\Master\MasterGuest@pageListPosting');
        } else {
            Routes::set($url_guest, 'app\Controller\Master\MasterGuest@chooseMenuPost');
        }
    } else if ($rs_url_now[0][$sf->getTypeUrl()] == 5) {
        Routes::set($url_guest, 'app\Controller\Master\MasterGuest@pageTwoColumn');
    }
} else {
    if (isset($_SESSION[SESSION_EMAIL]) && isset($_SESSION[SESSION_USERNAME]) && isset($_SESSION[SESSION_GROUP])) {
        $mpf = new MasterPostFunction();
//    echo $str_replace_url . "<br/>";
        $split_url_now = explode('/', $str_replace_url);
        $split_url_now_end = end($split_url_now);
        $replace_split_url_now = str_replace('/' . $split_url_now_end, '', $str_replace_url);

        $post = new MasterPost();
        $rs_post = $db->selectByID($post, $post->getCode() . "='" . $split_url_now_end . "'");
//        print_r($rs_post);
        if (!empty($rs_post)) {
//        $_POST['function_id_now'];
//        echo $str_replace_url;
            $_POST['post_id_now'] = $rs_post[0][$post->getId()];
            $str_replace_url2 = ltrim($str_replace_url, "/");
//        echo $str_replace_url2;
//        echo 'masuk';
//            Routes::set($str_replace_url2, 'app\Controller\Master\MasterGuest@pageOnePost');
        }
    }
    //echo $replace_split_url_now;
}

$strRplCode = str_replace(URL(), "", FULLURL());
$strRplCode = ltrim($strRplCode, '/');
$mpf = new MasterPostFunction();
$masterPost = new MasterPost();

$where = $mpf->getEntity() . "." . $mpf->getPostId() . EQUAL . $masterPost->getEntity() . "." . $masterPost->getId() . ""
        . " AND " . $mpf->getEntity() . "." . $mpf->getFunctionId() . EQUAL . "1"
        . " AND " . $mpf->getPost()->getCode() . "='" . $strRplCode . "'";

$db->select($masterPost->getEntity(), $masterPost->getEntity() . ".*", array($mpf->getEntity()), $where);
$posting = $db->getResult();
//print_r($posting);
if (!empty($posting)) {
    $_POST['posting'] = $posting[0];
    Routes::set($strRplCode, 'app\Controller\Master\MasterGuest@pageOneNews');
}