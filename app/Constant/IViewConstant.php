<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Constant;

/**
 * Description of PathConstant
 *
 * @author sfandrianah
 */
interface IViewConstant {

    //put your code here

    const CRUD_VIEW_INDEX = 'view/template/crud/index.html.php';
    const CRUD_LIST_VIEW_INDEX = 'view/template/crud/list.html.php';
    const CRUD_NEW_VIEW_INDEX = 'view/template/crud/new.html.php';
    const CRUD_EDIT_VIEW_INDEX = 'view/template/crud/edit.html.php';
    const CRUD_LOV_VIEW_INDEX = 'view/template/crud/lov/index.html.php';
    const CRUD_LOV_LIST_VIEW_INDEX = 'view/template/crud/lov/list.html.php';
//    const GROUP_VIEW_INDEX = 'view/page/security/group/index.html.php';
    //INDEX VIEW SECURITY
    const USER_VIEW_INDEX = 'view/page/security/user';
    const GROUP_VIEW_INDEX = 'view/page/security/group';
    const GROUP_VIEW_LIST = 'view/page/security/group/list.html.php';
    const GROUP_VIEW_CREATE = 'view/page/security/group/new.html.php';
    const GROUP_VIEW_EDIT = 'view/page/security/group/edit.html.php';
//    const FUNCTION_VIEW_INDEX = 'view/page/security/function/index.html.php';

    const FUNCTION_ASSIGNMENT_VIEW_INDEX = 'view/page/security/function-assignment';
    const FUNCTION_VIEW_INDEX = 'view/page/security/function';
    const FUNCTION_VIEW_LIST = 'view/page/security/function/list.html.php';
    const FUNCTION_VIEW_CREATE = 'view/page/security/function/new.html.php';
    const FUNCTION_VIEW_EDIT = 'view/page/security/function/edit.html.php';
    const USER_VIEW_LIST = 'view/page/security/user/list.html.php';
    const USER_VIEW_CREATE = 'view/page/security/user/new.html.php';
    const USER_VIEW_EDIT = 'view/page/security/user/edit.html.php';
    const TOPUP_SALDO_VIEW_LIST = 'view/page/approval/topup-saldo/list.html.php';
    const TOPUP_SALDO_VIEW_EDIT = 'view/page/approval/topup-saldo/edit.html.php';
    const POST_VIEW_LIST = 'view/page/posting/post/list.html.php';
    const POST_VIEW_CREATE = 'view/page/posting/post/new.html.php';
    const POST_VIEW_EDIT = 'view/page/posting/post/edit.html.php';
    const POST_ASSIGN_VIEW_LIST = 'view/page/posting/post-assign/list.html.php';
    const POST_ASSIGN_VIEW_LIST_POST = 'view/page/posting/post-assign/list-post.html.php';
    const POST_ASSIGN_VIEW_CREATE = 'view/page/posting/post-assign/new.html.php';
    const POST_ASSIGN_VIEW_EDIT = 'view/page/posting/post-assign/edit.html.php';
    const POST_ASSIGN_VIEW_CREATE_POST_ASSIGN = 'view/page/posting/post-assign/create-post-assign.html.php';
    const POST_ASSIGN_VIEW_LIST_POST_ASSIGN = 'view/page/posting/post-assign/list-post-assign.html.php';
    const POST_ASSIGN_VIEW_VIEW_POST_ASSIGN = 'view/page/posting/post-assign/view-post-assign.html.php';
    //PATH INDEX MASTER BANK
    const MASTER_BANK_VIEW_INDEX = 'view/page/master/bank';
    const MASTER_BANK_ACCOUNT_VIEW_INDEX = 'view/page/master/bank-account';
    const MASTER_LANGUAGE_VIEW_INDEX = 'view/page/master/language';
    const MASTER_VIDEO_SEMINAR_VIEW_INDEX = 'view/page/master/video-seminar';
    const MASTER_AUTHOR_VIEW_INDEX = 'view/page/master/author';
    const MASTER_PRICE_VIEW_INDEX = 'view/page/master/price';
    const MASTER_ROOM_VIEW_INDEX = 'view/page/master/room';
    const MASTER_FACILITY_VIEW_INDEX = 'view/page/master/facility';
    const MASTER_CATEGORY_ASSESS_VIEW_INDEX = 'view/page/master/category-assess';
    const MASTER_ANSWER_TYPE_VIEW_INDEX = 'view/page/master/answer-type';
    const MASTER_SUBJECT_VIEW_INDEX = 'view/page/master/subject';
    const MASTER_MATERIAL_SUBJECT_VIEW_INDEX = 'view/page/master/material-subject';
    const AGENDA_KEGIATAN_VIEW_INDEX = 'view/page/transaction/agenda-kegiatan';
    const AGENDA_WIDYAISWARA_VIEW_INDEX = 'view/page/member/agenda-widyaiswara';
    
    const APPROVAL_PARTICIPANT_REGISTRATION_VIEW_INDEX = 'view/page/approval/participant-registration';
    const APPROVAL_ACTIVITY_REGISTRATION_VIEW_INDEX = 'view/page/approval/activity-registration';
    const APPROVAL_PIC_REGISTRATION_VIEW_INDEX = 'view/page/approval/pic-registration';

    const SURVEY_TRAINER_VIEW_INDEX = 'view/page/survey/survey-trainer';
    const SURVEY_ORGANIZER_VIEW_INDEX = 'view/page/survey/survey-organizer';
    


}
