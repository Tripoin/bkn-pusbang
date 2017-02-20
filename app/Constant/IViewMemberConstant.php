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
    
    
    const AGENDA_ACTIVITY_VIEW = 'view/page/member/activity-agenda';
    const ACTIVITY_VIEW_INDEX = self::AGENDA_ACTIVITY_VIEW.'/activity/activity.html.php';
    const ACTIVITY_LIST_VIEW_INDEX = self::AGENDA_ACTIVITY_VIEW.'/activity/list.html.php';
    const ACTIVITY_VIEW_VIEW_INDEX = self::AGENDA_ACTIVITY_VIEW.'/activity/view.html.php';
}