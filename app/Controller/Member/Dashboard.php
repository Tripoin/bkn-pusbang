<?php

/**
 * Description of User Profile
 * @email : sfandrianah2@gmail.com
 * @author Syahrial Fandrianah
 * @FRAMEWORK NATIVE ECCOMERCE V.1.0
 */

namespace app\Controller\Member;

use app\Model\SecurityUserProfile;
use app\Util\Database;
use app\Util\Form;
use app\Util\DataTable;
use app\Model\Confirm;
use app\Model\SecurityUser;
use app\Model\MasterContact;

class Dashboard {

    public function __construct() {
//        setActiveMenuMember('userprofile,changeprofile');
    }

    public function index() {
        $Form = new Form();
        setTitle(' | ' . lang('general.dashboard'));
        include_once FILE_PATH('view/page/member/dashboard/dashboard.html.php');
    }

    

}
