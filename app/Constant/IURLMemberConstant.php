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
    const AGENDA_ACTIVITY_URL = 'member/activity-agenda';
    const ACTIVITY_URL = self::AGENDA_ACTIVITY_URL.'/activity';
}
