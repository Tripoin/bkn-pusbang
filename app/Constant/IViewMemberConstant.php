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
interface IViewMemberConstant {
    
    /*SCAFOLDING VIEW INDEX*/
    const CRUD_VIEW_INDEX = 'view/template/crud/member/index.html.php';
    const CRUD_LIST_VIEW_INDEX = 'view/template/crud/member/list.html.php';
    const CRUD_NEW_VIEW_INDEX = 'view/template/crud/member/new.html.php';
    const CRUD_EDIT_VIEW_INDEX = 'view/template/crud/member/edit.html.php';
    const CRUD_LOV_VIEW_INDEX = 'view/template/crud/lov/index.html.php';
    const CRUD_LOV_LIST_VIEW_INDEX = 'view/template/crud/lov/list.html.php';
    
    /*LIST PARTICIPANT*/
    const LIST_PARTICIPANT_VIEW_INDEX = 'view/page/member/list-participant/index.html.php';
    const LIST_PARTICIPANT_LIST_VIEW_INDEX = 'view/page/member/list-participant/list.html.php';
    const LIST_PARTICIPANT_VIEW_VIEW_INDEX = 'view/page/member/list-participant/view.html.php';
    const LIST_PARTICIPANT_EDIT_VIEW_INDEX = 'view/page/member/list-participant/edit.html.php';
    
    /*ACTIVITY AGENDA*/
    const AGENDA_ACTIVITY_VIEW = 'view/page/member/activity-agenda';
    const ACTIVITY_VIEW_INDEX = 'view/page/member/activity-agenda/activity.html.php';
    const ACTIVITY_LIST_VIEW_INDEX = 'view/page/member/activity-agenda/list.html.php';
    const ACTIVITY_VIEW_VIEW_INDEX = 'view/page/member/activity-agenda/view.html.php';
    const AGENDA_ORGANIZER_VIEW = 'view/page/member/agenda-organizer';
    const AGENDA_ORGANIZER_VIEW_INDEX = 'view/page/member/agenda-organizer/index.html.php';
    const AGENDA_ORGANIZER_LIST_VIEW_INDEX = 'view/page/member/agenda-organizer/list.html.php';
    const AGENDA_WIDYAISWARA_VIEW_INDEX = 'view/page/member/agenda-widyaiswara';
    const AGENDA_WIDYAISWARA_LIST_USER_VIEW_INDEX = 'view/page/member/agenda-widyaiswara/list-user.html.php';
    const AGENDA_WIDYAISWARA_EDIT_USER_VIEW_INDEX = 'view/page/member/agenda-widyaiswara/edit-user.html.php';
    
    
    
    /*REGISTRATION*/
    const REGISTRATION_VIEW = 'view/page/member/registration';
    const REGISTRATION_ACTIVITY_VIEW_INDEX = 'view/page/member/registration/activity/index.html.php';
    const REGISTRATION_ACTIVITY_LIST_VIEW_INDEX = 'view/page/member/registration/activity/list.html.php';
    const REGISTRATION_ACTIVITY_VIEW_VIEW_INDEX = 'view/page/member/registration/activity/view.html.php';
    const REGISTRATION_ACTIVITY_TEMP_VIEW_INDEX = 'view/page/member/registration/activity-temp/index.html.php';
    const REGISTRATION_ACTIVITY_TEMP_LIST_VIEW_INDEX = 'view/page/member/registration/activity-temp/list.html.php';
    const REGISTRATION_ACTIVITY_TEMP_VIEW_VIEW_INDEX = 'view/page/member/registration/activity-temp/view.html.php';
    const REGISTRATION_ACTIVITY_TEMP_REGISTER_VIEW_INDEX = 'view/page/member/registration/activity-temp/register-activity.html.php';
    const REGISTRATION_ACTIVITY_TEMP_LIST_USER_VIEW_INDEX = 'view/page/member/registration/activity-temp/list-user/list.html.php';
    const REGISTRATION_ACTIVITY_TEMP_LIST_USER_CREATE_VIEW_INDEX = 'view/page/member/registration/activity-temp/list-user/create.html.php';
    const REGISTRATION_ACTIVITY_TEMP_LIST_USER_ADD_VIEW_INDEX = 'view/page/member/registration/activity-temp/list-user/add/index.html.php';
    const REGISTRATION_ACTIVITY_TEMP_LIST_USER_ADD_LIST_VIEW_INDEX = 'view/page/member/registration/activity-temp/list-user/add/list.html.php';
    
    
    /*SURVEY*/
    const SURVEY_ORGANIZER_VIEW_INDEX = 'view/page/member/survey/survey-organizer';
    const SURVEY_TRAINER_VIEW_INDEX = 'view/page/member/survey/survey-trainer';
    
    
    /*RECAPITULATION VALUE*/
    const RECAPITULATION_VALUE_VIEW_INDEX = 'view/page/member/recapitulation-value';
    
    const REPORT_SURVEY_ORGANIZER_VIEW_INDEX = 'view/page/member/report/report-survey-organizer';
}