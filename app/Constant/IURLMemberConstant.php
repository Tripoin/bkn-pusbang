<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Constant;

/**
 * Description of IURLMemberConstant
 *
 * @author sfandrianah
 */
interface IURLMemberConstant {
    //put your code here
    /*AGENDA ACTIVITY URL*/
    const AGENDA_ACTIVITY_URL = 'member/activity-agenda';
    const ACTIVITY_URL = 'member/activity-agenda/activity';
    const AGENDA_ORGANIZER_URL = 'member/agenda-organizer';
    const AGENDA_WIDYAISWARA_URL = 'member/agenda-widyaiswara';
    
    const LIST_PARTICIPANT_URL = 'member/list-participant';
    const LIST_PARTICIPANT_EDIT_URL = 'member/list-participant/edit';
    const LIST_PARTICIPANT_VIEW_URL = 'member/list-participant/view';
    const LIST_PARTICIPANT_UPDATE_URL = 'member/list-participant/update';
    
    /*REGISTRATION URL*/
    const REGISTRATION_URL = 'member/registration';
    const ACTIVITY_REGISTRATION_URL = 'member/registration/activity';
    const ACTIVITY_REGISTRATION_TEMP_URL = 'member/registration/activity-temp';
    const ACTIVITY_REGISTRATION_TEMP_LIST_USER_URL = 'member/registration/activity-temp/list-user';
    const ACTIVITY_REGISTRATION_TEMP_LIST_USER_ADD_URL = 'member/registration/activity-temp/list-user/add';

    const SURVEY_TRAINER_URL = 'survey/survey-trainer';
    const SURVEY_ORGANIZER_URL = 'survey/survey-organizer';
}
