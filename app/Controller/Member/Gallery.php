<?php

/**
 * Created by PhpStorm.
 * User: Dayat
 * Date: 07/12/2016
 * Time: 18:23
 */

namespace app\Controller\Member;

use app\Controller\Base\ControllerMember;
use app\Constant\MemberConstant;
use app\Model\MemberPost;

class Gallery extends ControllerMember{

    public function __construct() {
        setActiveMenuMember('gallery');
        parent::__construct(new MemberPost);
        $this->title = lang('member.gallery_title');
        $this->title_create = lang('member.gallery_title_new');
        $this->title_edit = lang('member.gallery_title_edit');
        $this->type_member_post = 1;
        
        $this->setURLMember();
    }
    
    public function setURLMember(){
        $this->index_url = MemberConstant::GALLERY_INDEX_URL;
        $this->list_url= MemberConstant::GALLERY_LIST_URL;
        $this->create_url = MemberConstant::GALLERY_CREATE_URL;
        $this->view_url = MemberConstant::GALLERY_VIEW_URL;
        $this->edit_url = MemberConstant::GALLERY_EDIT_URL;
        $this->update_url = MemberConstant::GALLERY_UPDATE_URL;
        $this->save_url = MemberConstant::GALLERY_SAVE_URL;
        $this->delete_url = MemberConstant::GALLERY_DELETE_URL;
    }

    
}
