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
    
    /*ACTIVITY AGENDA*/
    const AGENDA_ACTIVITY_VIEW = 'view/page/member/activity-agenda';
    const ACTIVITY_VIEW_INDEX = 'view/page/member/activity-agenda/activity/activity.html.php';
    const ACTIVITY_LIST_VIEW_INDEX = 'view/page/member/activity-agenda/activity/list.html.php';
    const ACTIVITY_VIEW_VIEW_INDEX = 'view/page/member/activity-agenda/activity/view.html.php';
    const AGENDA_ORGANIZER_VIEW = 'view/page/member/activity-agenda/agenda-organizer';
    const AGENDA_ORGANIZER_VIEW_INDEX = 'view/page/member/activity-agenda/agenda-organizer/index.html.php';
    const AGENDA_ORGANIZER_VIEW_VIEW_INDEX = 'view/page/member/activity-agenda/agenda-organizer/view.html.php';
    const AGENDA_ORGANIZER_LIST_VIEW_INDEX = 'view/page/member/activity-agenda/agenda-organizer/list.html.php';
    
    
    
    /*REGISTRATION*/
    const REGISTRATION_VIEW = 'view/page/member/registration';
    const REGISTRATION_ACTIVITY_VIEW_INDEX = 'view/page/member/registration/activity/index.html.php';
    const REGISTRATION_ACTIVITY_LIST_VIEW_INDEX = 'view/page/member/registration/activity/list.html.php';
    const REGISTRATION_ACTIVITY_VIEW_VIEW_INDEX = 'view/page/member/registration/activity/view.html.php';
}