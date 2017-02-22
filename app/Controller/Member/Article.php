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

class Article extends ControllerMember {

    public function __construct() {


        setActiveMenuMember('article');
        parent::__construct(new MemberPost);
        $this->title = lang('member.article_title');
        $this->title_create = lang('member.article_title_new');
        $this->title_edit = lang('member.article_title_edit');
        $this->type_member_post = 2;
       


        $this->setURLMember();
    }

    public function setURLMember() {
        $this->index_url = MemberConstant::ARTICLE_INDEX_URL;
        $this->list_url = MemberConstant::ARTICLE_LIST_URL;
        $this->create_url = MemberConstant::ARTICLE_CREATE_URL;
        $this->view_url = MemberConstant::ARTICLE_VIEW_URL;
        $this->edit_url = MemberConstant::ARTICLE_EDIT_URL;
        $this->update_url = MemberConstant::ARTICLE_UPDATE_URL;
        $this->save_url = MemberConstant::ARTICLE_SAVE_URL;
        $this->delete_url = MemberConstant::ARTICLE_DELETE_URL;
    }

}
