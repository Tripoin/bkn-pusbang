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
Routes::set('test-hashing', 'app\Controller\Master\Test@hashing');
Routes::set('test-mail', 'app\Controller\Master\Test@testMail');
Routes::set('test-parameter/{param}', 'app\Controller\Master\Test@testParam');
//Routes::set('page/carrer', 'app\Controller\Master\Carrer@page');
//Routes::set('page/tala-membership', 'app\Controller\Master\MemberShip@page');
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
    Routes::set('register/proses', 'app\Controller\Base\Auth@register');
    Routes::group(['prefix' => 'register'], function() {
        Routes::set('proses', 'app\Controller\Base\Auth@loginPage');
    });
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
Routes::set('alumni', 'app\Controller\Guest\Alumni@index');

Routes::set('selected', 'app\Controller\Base\General@getArea');
if (isset($_SESSION[SESSION_USERNAME]) && isset($_SESSION[SESSION_GROUP])) {

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


    Routes::set('page/member/gallery', 'app\Controller\Member\Gallery@index');
    Routes::set('page/member/gallery/list', 'app\Controller\Member\Gallery@lists');
    Routes::set('page/member/gallery/create', 'app\Controller\Member\Gallery@create');
    Routes::set('page/member/gallery/edit', 'app\Controller\Member\Gallery@edit');
    Routes::set('page/member/gallery/update', 'app\Controller\Member\Gallery@update');
    Routes::set('page/member/gallery/view', 'app\Controller\Member\Gallery@view');
    Routes::set('page/member/gallery/delete', 'app\Controller\Member\Gallery@delete');
    Routes::set('page/member/gallery/save', 'app\Controller\Member\Gallery@save');

    Routes::set('page/member/article', 'app\Controller\Member\Article@index');
    Routes::set('page/member/article/list', 'app\Controller\Member\Article@lists');
    Routes::set('page/member/article/create', 'app\Controller\Member\Article@create');
    Routes::set('page/member/article/edit', 'app\Controller\Member\Article@edit');
    Routes::set('page/member/article/update', 'app\Controller\Member\Article@update');
    Routes::set('page/member/article/view', 'app\Controller\Member\Article@view');
    Routes::set('page/member/article/delete', 'app\Controller\Member\Article@delete');
    Routes::set('page/member/article/save', 'app\Controller\Member\Article@save');

    Routes::set('page/member/notification', 'app\Controller\Member\Notification@index');
    Routes::set('page/member/notification/list', 'app\Controller\Member\Notification@lists');
    Routes::set('page/member/notification/view', 'app\Controller\Member\Notification@view');

    Routes::set('page/member/video-seminar', 'app\Controller\Member\VideoSeminar@index');
    Routes::set('page/member/video-seminar/list', 'app\Controller\Member\VideoSeminar@lists');
    Routes::set('page/member/video-seminar/view', 'app\Controller\Member\VideoSeminar@view');
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
            Routes::setScaffolding(IURLConstant::AGENDA_KEGIATAN_INDEX_URL, 'app\Controller\Transaction\AgendaKegiatan');
            
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