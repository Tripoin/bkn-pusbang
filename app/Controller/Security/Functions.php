<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SECURITY -> FUNCTION
 * @email : sfandrianah2@gmail.com
 * @author Syahrial Fandrianah
 * @FRAMEWORK NATIVE ADMIN TEMPLATE V.1.0
 */

namespace app\Controller\Security;

use app\Util\Database;
use app\Controller\Base\Controller;
use app\Model\SecurityFunction;
use app\Constant\IURLConstant;
use app\Constant\IViewConstant;
use app\Model\MasterActionParameter;
use app\Model\MasterLanguage;
use app\Model\SecurityFunctionLanguage;
use app\Model\MasterFunctionType;
use app\Model\MasterUrlType;

class Functions extends Controller {

    //put your code here
    public $data_function = array();
    public $data_url_type = array();
    public $data_type = array();
    public $data_action_parameter = array();
    public $data_lang = array();
    public $lang = array();

    public function __construct() {
        $sap = new MasterActionParameter();
        $sf = new SecurityFunction();
        $this->modelData = $sf;
        $this->setTitle(lang('security.function'));
//        $this->setSubtitle($subtitle);
        $this->setBreadCrumb(array(lang('security.security') => "", lang('security.function') => URL()));

        $db = new Database();

        $manual_data = [array("id" => 0, "label" => "Parent Menu")];

        $rs_menu = $db->selectByID($sf, $sf->getLevel() . EQUAL . "0");
        $rs = convertJsonCombobox($rs_menu, $sf->getId(), $sf->getName(), $manual_data);
        $this->data_function = $rs;

        $rs_data_ap = $db->selectByID($sap);
        $rs = convertJsonCombobox($rs_data_ap, $sap->getId(), $sap->getName());
        $this->data_action_parameter = $rs;

//        $rs_data_ut = $db->selectByID($sap);
        $manual_data_ut = [
            array("id" => 1, "label" => lang('security.standard_page')),
            array("id" => 2, "label" => lang('security.one_column_page')),
            array("id" => 3, "label" => lang('security.page_posting')),
            array("id" => 4, "label" => lang('security.two_column_page'))
        ];
        $masterFunctionType = new MasterFunctionType();
        $rs_data_mft = $db->selectByID($masterFunctionType);
        $rs = convertJsonCombobox($rs_data_mft, $masterFunctionType->getId(), $masterFunctionType->getName());
        $this->data_url_type = $rs;


        $manual_data_ut = [
            array("id" => 1, "label" => lang('security.standard_menu')),
            array("id" => 2, "label" => lang('security.footer_menu')),
        ];
        $masterUrlType = new MasterUrlType();
        $rs_data_mut = $db->selectByID($masterUrlType);
        $rs = convertJsonCombobox($rs_data_mut, $masterUrlType->getId(), $masterUrlType->getName());
        $this->data_type = $rs;

        $lang = new MasterLanguage();
        $this->lang = $lang;
        $this->data_lang = $db->selectByID($lang);

        $this->indexUrl = IURLConstant::FUNCTION_INDEX_URL;
        $this->viewPath = IViewConstant::FUNCTION_VIEW_INDEX;
        $this->setAutoCrud();

//        $menu = [array("id"=>0,"label"=>"Parent Menu")];
//        $this->data_function = array_push($menu,$rs);
//        $this->setViewURL();
//        $this->setViewPath();
    }

    public function delete() {
        $db = new Database();
        $sfl = new MasterLanguage();
        $db->connect();
        $id = $_POST['id'];
        $get_data = $db->delete($sfl->getEntity(), $sfl->getId() . EQUAL . $id);
//        print_r($get_data);
        if ($get_data == 1) {
            parent::delete();
        } else {
            LOGGER($get_data);
        }
    }

    public function save() {
        $db = new Database();
//        $group = new SecurityGroup();
        $sf = new SecurityFunction();
//        $data = $this->modelData;

        $db->connect();
        $db->createAuditrail();
//        $datas = $data->setData($_POST);
        $url = $_POST['url'];
        $parent = $_POST['parent'];
        $actionParameter = $_POST['actionParameter'];
        $typeUrl = $_POST['typeUrl'];
        $type = $_POST['type'];
        $style = $_POST['style'];
        $level = 0;
        if ($parent != 0) {
            $level = 1;
        }
        if ($parent == 0) {
            $parent = null;
        }
        $db->insert($sf->getEntity(), array(
            $sf->getCode() => $_POST['code'],
            $sf->getName() => $_POST['name_id'],
            $sf->getLevel() => $level,
            $sf->getParent() => $parent,
            $sf->getOrder() => 0,
            $sf->getActionParameter() => $actionParameter,
            $sf->getStatus() => 1,
            $sf->getTypeUrl() => $typeUrl,
            $sf->getTypeId() => $type,
            $sf->getUrl() => $url,
            $sf->getStyle() => $style,
            $sf->getCreatedByUsername() => $_SESSION[SESSION_USERNAME],
            $sf->getCreatedOn() => date('Y-m-d h:i:s'),
        ));
        $rs_save = $db->getResult();
        if (is_numeric($rs_save[0])) {
            $sfl = new SecurityFunctionLanguage();
            $lang = new MasterLanguage();
            $data_lang = $db->selectByID($lang);
            foreach ($data_lang as $val_lang) {
                $name = $_POST['name_' . $val_lang[$lang->getCode()]];
                if ($name == "") {
                    $name = $_POST['name_id'];
                }
                if ($val_lang[$lang->getCode()] != 'id') {
                    $db->insert($sfl->getEntity(), array(
                        $sfl->getFunctionId() => $rs_save[0],
                        $sfl->getCode() => $_POST['code'].$val_lang[$lang->getId()],
                        $sfl->getName() => $name,
                        $sfl->getLanguageId() => $val_lang[$lang->getId()]
                    ));
                }
//                echo $db->getSql();
            }
            echo toastAlert("success", lang('general.title_insert_success'), lang('general.message_insert_success'));
            echo '<script>$(function(){postAjaxPagination()});</script>';
        } else {
//            print_r($rs_save);
            echo toastAlert("error", lang('general.title_insert_error'), lang('general.message_insert_error'));
            LOGGER($db->getSql());
            LOGGER($rs_save);
//            echo '<script>$(function(){postAjaxGetValue(\'' . URL(IURLConstant::FUNCTION_CREATE_URL) . '\', \'bodyPage\', \'' . json_encode($_POST) . '\')});</script>';
//            echo '<script>$(function(){postAjaxPagination()});</script>';
        }
//        parent::save();
    }

    public function update() {
        $db = new Database();
//        $group = new SecurityGroup();
        $sf = new SecurityFunction();
//        $data = $this->modelData;

        $db->connect();
        $db->updateAuditrail();
//        $datas = $data->setData($_POST);
        $url = $_POST['url'];
        $parent = $_POST['parent'];
        $actionParameter = $_POST['actionParameter'];
        $typeUrl = $_POST['typeUrl'];
        $type = $_POST['type'];
        $style = $_POST['style'];
        $level = 0;
        if ($parent != 0) {
            $level = 1;
        }
        if ($parent == 0) {
            $parent = NULL;
        }
        $id = $_POST['id'];
        $db->update($sf->getEntity(), array(
            $sf->getCode() => $_POST['code'],
            $sf->getName() => $_POST['name_id'],
            $sf->getLevel() => $level,
            $sf->getParent() => $parent,
            $sf->getOrder() => 0,
            $sf->getActionParameter() => $actionParameter,
            $sf->getStatus() => 1,
            $sf->getTypeUrl() => $typeUrl,
            $sf->getTypeId() => $type,
            $sf->getUrl() => $url,
            $sf->getStyle() => $style,
            $sf->getCreatedByUsername() => $_SESSION[SESSION_USERNAME],
            $sf->getCreatedOn() => date('Y-m-d h:i:s'),
                ), $sf->getId() . EQUAL . $id);
        $rs_save = $db->getResult();
        if ($rs_save[0] == 1) {
            $sfl = new SecurityFunctionLanguage();
            $lang = new MasterLanguage();
            $data_lang = $db->selectByID($lang);
            foreach ($data_lang as $val_lang) {
                $name = $_POST['name_' . $val_lang[$lang->getCode()]];
                if ($name == "") {
                    $name = $_POST['name_id'];
                }
                if ($val_lang[$lang->getCode()] != 'id') {
                    $data_function_lang = $db->selectByID($sfl, $sfl->getFunctionId() . EQUAL . $id . ""
                            . " AND " . $sfl->getLanguageId() . "='" . $val_lang[$lang->getId()] . "'");
                    if (empty($data_function_lang)) {
                        $db->insert($sfl->getEntity(), array(
                            $sfl->getFunctionId() => $id,
                            $sfl->getName() => $name,
                            $sfl->getLanguageId() => $val_lang[$lang->getId()]
                        ));
                    } else {
                        $db->update($sfl->getEntity(), array(
                            $sfl->getFunctionId() => $id,
                            $sfl->getName() => $name,
                            $sfl->getLanguageId() => $val_lang[$lang->getId()]
                                ), $sfl->getFunctionId() . EQUAL . $id . ""
                                . " AND " . $sfl->getLanguageId() . "='" . $val_lang[$lang->getId()] . "'");
                    }
                }
//                echo $db->getSql();
            }
            echo toastAlert("success", lang('general.title_update_success'), lang('general.message_update_success'));
            echo '<script>$(function(){postAjaxPagination()});</script>';
        } else {
//            print_r($rs_save);
            echo toastAlert("error", lang('general.title_update_error'), lang('general.message_update_error'));
//            echo '<script>$(function(){postAjaxGetValue(\'' . URL(IURLConstant::FUNCTION_CREATE_URL) . '\', \'bodyPage\', \'' . json_encode($_POST) . '\')});</script>';
//            echo '<script>$(function(){postAjaxPagination()});</script>';
        }
//        parent::save();
    }

}
