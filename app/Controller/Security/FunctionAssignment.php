<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controller\Security;

/**
 * Description of Test
 *
 * @author sfandrianah
 */
use app\Controller\Base\Controller;
use app\Util\Database;
use app\Constant\IURLConstant;
use app\Constant\IViewConstant;
use app\Model\SecurityGroup;
use app\Model\SecurityFunction;
use app\Model\SecurityFunctionAssignment;
use app\Util\Form;
use app\Model\MasterActionParameter;

//use Malenki\Bah\S;
class FunctionAssignment extends Controller {

    //put your code here

    public function __construct() {
//        echo 'masuk';
        $this->modelData = new SecurityGroup();
        $this->setTitle(lang('security.function_assignment'));
        $this->setBreadCrumb(array(lang('security.security') => "", lang('security.function_assignment') => FULLURL()));
        $this->indexUrl = IURLConstant::FUNCTION_ASSIGNMENT_INDEX_URL;
        $this->viewPath = IViewConstant::FUNCTION_ASSIGNMENT_VIEW_INDEX;
        $this->setAutoCrud();


        parent::__construct();
    }

    public function addFunction() {

        $db = new Database();
        $Form = new Form();
        $sf = new SecurityFunction();
        $sfa = new SecurityFunctionAssignment();

        $listIdParent = $_POST['list_id_parent'];
        $id = $_POST['id'];
        if ($id == 0) {
            $id_group = $_POST['id_group'];
            $db->connect();
            $db->select(
                    $sfa->getEntity(), $sfa->getFunction()->getEntity() . DOT . $sfa->getFunction()->getId(), array($sfa->getFunction()->getEntity(), $sfa->getGroup()->getEntity()), $sfa->getFunction()->getEntity() . DOT . $sfa->getFunction()->getId() . EQUAL . $sfa->getEntity() . DOT . $sfa->getFunctionId()
                    . " AND " . $sfa->getGroup()->getEntity() . DOT . $sfa->getGroup()->getId() . EQUAL . $sfa->getEntity() . DOT . $sfa->getGroupId()
                    . " AND " . $sfa->getEntity() . DOT . $sfa->getStatus() . EQUAL . "1"
                    . " AND " . $sfa->getEntity() . DOT . $sfa->getGroupId() . EQUAL . $id_group
                    . " AND " . $sfa->getFunction()->getEntity() . DOT . $sfa->getFunction()->getLevel() . EQUAL . "0"
                    , $sfa->getFunctionAssignmentOrder() . ' ASC'
            );
            $function_parent = $db->getResult();
            LOGGER($function_parent);

            $listIdParent = '';
            foreach ($function_parent as $value) {
                $listIdParent .= $value[$sfa->getFunction()->getId()] . ',';
            }
            $listIdParent = rtrim($listIdParent, ",");
            LOGGER($listIdParent);
            if ($listIdParent == "") {
                $function = $db->selectByID($sf, $sf->getLevel() . EQUAL . "0");
            } else {
                $function = $db->selectByID($sf, $sf->getId() . " NOT IN (" . $listIdParent . ")"
                        . " AND " . $sf->getLevel() . EQUAL . "0");
            }
        } else {
            $id_group = $_POST['id_group'];
            $id_function = $_POST['id_function'];
            $db->connect();
            $db->select(
                    $sfa->getEntity(), $sfa->getFunction()->getEntity() . ".*", array($sfa->getFunction()->getEntity(), $sfa->getGroup()->getEntity()), $sfa->getFunction()->getEntity() . DOT . $sfa->getFunction()->getId() . EQUAL . $sfa->getEntity() . DOT . $sfa->getFunction()->getId()
                    . " AND " . $sfa->getGroup()->getEntity() . DOT . $sfa->getGroup()->getId() . EQUAL . $sfa->getEntity() . DOT . $sfa->getGroup()->getId()
                    . " AND " . $sfa->getEntity() . DOT . $sfa->getStatus() . EQUAL . "1"
                    . " AND " . $sfa->getEntity() . DOT . $sfa->getGroup()->getId() . EQUAL . $id_group
                    . " AND " . $sfa->getFunction()->getEntity() . DOT . $sfa->getFunction()->getParent() . EQUAL . $id_function
                    , $sfa->getFunctionAssignmentOrder() . ' ASC'
            );
            $function_child = $db->getResult();
//            print_r($function_child);
            $listIdChild = '';
            foreach ($function_child as $value) {
                $listIdChild .= $value[$sfa->getFunction()->getId()] . ',';
            }
            $listIdChild = rtrim($listIdChild, ",");
//            echo $listIdChild;
            if ($listIdChild == "") {
                $function = $db->selectByID($sf, $sf->getParent() . EQUAL . $id_function);
//                print_r($function);
            } else {
                $function = $db->selectByID($sf, $sf->getId() . " NOT IN (" . $listIdChild . ")"
                        . " AND " . $sf->getParent() . EQUAL . $id_function);
            }
        }
        $data_function = convertJsonCombobox($function, $sf->getId(), $sf->getName());
//        print_r($function);
        include FILE_PATH('view/page/security/function-assignment/list-function.html.php');
//        echo 'tes';
    }

    public function updateSortFunction() {

        $db = new Database();
        $Form = new Form();
        $sfa = new SecurityFunctionAssignment();
        $all_id = rtrim($_POST['all_id'], ',');
        $ex_all_id = explode(',', $all_id);
        $db->connect();
        $no = 0;
        foreach ($ex_all_id as $value) {
            if ($value != 0) {
                $no++;
                $db->update($sfa->getEntity(), array(
                    $sfa->getFunctionAssignmentOrder() => $no
                        ), $sfa->getId() . EQUAL . $value);
            }
        }
    }

    public function getActionType() {

        $db = new Database();
        $Form = new Form();
        $sap = new MasterActionParameter();
        $sf = new SecurityFunction();

        $id = $_POST['id'];
        $function = $db->selectByID($sf, $sf->getId() . EQUAL . $id);
        if (!is_array($function[0])) {
            $function = array();
        }
        if (!empty($function)) {
//            print_r($function);
            if ($function[0][$sf->getActionParameter()] == "") {
                $actionTypeName = "view";
            } else {
                $actionType = $db->selectByID($sap, $sap->getId() . EQUAL . $function[0][$sf->getActionParameter()]);
                $actionTypeName = $actionType[0][$sap->getName()];
            }
            $exActionType = explode(',', $actionTypeName);

            $combobox = '<label class="control-label" for="focusedinput"><span style="color:red;">*</span>' . lang('security.action_type') . '</label>
                <div id="comp_acton_type">
                    <div class="mt-checkbox-inline">';
            foreach ($exActionType as $value) {
                $combobox .= '<label class="mt-checkbox">
                            <input type="checkbox" id="action_type_' . $value . '" name="action_type" value="' . $value . '"> ' . $value . '
                            <span></span>
                        </label>';
            }
            $combobox .= '<a class="btn btn-primary btn-xs" id="checkAllActionType" rel="tooltip" 
    title="" href="javascript:void(0)" onclick="checkAllActionType()" 
    data-original-title="Check All"> Check All</a> ';
            $combobox .= ' <a class="btn btn-primary btn-xs" id="unCheckAllActionType" rel="tooltip" 
                    title="" href="javascript:void(0)" onclick="unCheckAllActionType()" 
                    data-original-title="UnCheck All"> UnCheck All</a>';

            $combobox .= '</div>
                </div>
                <span class="material-input"></span>';
            $combobox .= "<script>
    $(function () {
    
    if($('#idFunctionEdit')){
        if($('#idFunctionEdit').val() == " . $id . "){
            var listActionType = $('#listActionType').val();
            var exp = listActionType.split(',');
            for (var no = 0; no < exp.length; no++) {
                $('#action_type_' + exp[no]).prop('checked', true);
            }
        }
    }
    });
</script>";
            echo $combobox;
        }
//        $data_function = convertJsonCombobox($function, $sf->getId(), $sf->getName());
//        print_r($function);
//        include FILE_PATH('view/page/security/function-assignment/list-function.html.php');
//        echo 'tes';
    }

    function editFunction() {
        $db = new Database();
        $Form = new Form();
        $sap = new MasterActionParameter();
        $sf = new SecurityFunction();
        $sfa = new SecurityFunctionAssignment();

        $listIdParent = $_POST['list_id_parent'];
        $idFunction = $_POST['id_function'];
        $idParent = $_POST['id'];
        if ($idParent == 0) {
            $id_group = $_POST['id_group'];
            $db->connect();
            $db->select(
                    $sfa->getEntity(), $sfa->getFunction()->getEntity() . "." . $sfa->getFunction()->getId(), array(
                $sfa->getFunction()->getEntity(),
                $sfa->getGroup()->getEntity()), $sfa->getFunction()->getEntity() . DOT . $sfa->getFunction()->getId() . EQUAL . $sfa->getEntity() . DOT . $sfa->getFunctionId()
                    . " AND " . $sfa->getGroup()->getEntity() . DOT . $sfa->getGroup()->getId() . EQUAL . $sfa->getEntity() . DOT . $sfa->getGroupId()
                    . " AND " . $sfa->getEntity() . DOT . $sfa->getStatus() . EQUAL . "1"
                    . " AND " . $sfa->getEntity() . DOT . $sfa->getGroupId() . EQUAL . $id_group
                    . " AND " . $sfa->getFunction()->getEntity() . DOT . $sfa->getFunction()->getLevel() . EQUAL . "0"
                    , $sfa->getFunctionAssignmentOrder() . ' ASC'
            );
            $function_parent = $db->getResult();
//            print_r($function_parent);
            LOGGER($function_parent);
            LOGGER("tet");
            $listIdParent = '';
            foreach ($function_parent as $value) {
                $listIdParent .= $value[$sfa->getFunction()->getId()] . ',';
            }
            $listIdParent = rtrim($listIdParent, ",");
            if ($listIdParent == "") {
                $function = $db->selectByID($sf);
            } else {

                $replaceListFunction = '';
                if (strpos($listIdParent, ',' . $idFunction) !== false) {
//                echo 'true';
                    $replaceListFunction = str_replace(',' . $idFunction, "", $listIdParent);
                } else if (strpos($listIdParent, $idFunction) !== false) {
                    $replaceListFunction = str_replace($idFunction . ",", "", $listIdParent);
                } else {
                    $replaceListFunction = $listIdParent;
                }
                if ($replaceListFunction == "") {
                    $function = $db->selectByID($sf, $sf->getLevel() . EQUAL . "0");
                } else {
                    $function = $db->selectByID($sf, $sf->getId() . " NOT IN (" . $replaceListFunction . ")"
                            . " AND " . $sf->getLevel() . EQUAL . "0");
                }
            }
        } else {
            $id_parent = $_POST['id_parent'];
            $id_group = $_POST['id_group'];
            $id_function = $_POST['id_function'];
            $id_function_parent = $_POST['id_function_parent'];
            $db->connect();
            $db->select(
                    $sfa->getEntity(), $sfa->getFunction()->getEntity() . ".*", array($sfa->getFunction()->getEntity(), $sfa->getGroup()->getEntity()), $sfa->getFunction()->getEntity() . DOT . $sfa->getFunction()->getId() . EQUAL . $sfa->getEntity() . DOT . $sfa->getFunction()->getId()
                    . " AND " . $sfa->getGroup()->getEntity() . DOT . $sfa->getGroup()->getId() . EQUAL . $sfa->getEntity() . DOT . $sfa->getGroup()->getId()
                    . " AND " . $sfa->getEntity() . DOT . $sfa->getStatus() . EQUAL . "1"
                    . " AND " . $sfa->getEntity() . DOT . $sfa->getGroup()->getId() . EQUAL . $id_group
                    . " AND " . $sfa->getFunction()->getEntity() . DOT . $sfa->getFunction()->getParent() . EQUAL . $id_function_parent
                    , $sfa->getFunctionAssignmentOrder() . ' ASC'
            );
            $function_child = $db->getResult();
//            print_r($function_child);
            $listIdChild = '';
            foreach ($function_child as $value) {
                $listIdChild .= $value[$sfa->getFunction()->getId()] . ',';
            }
            $listIdChild = rtrim($listIdChild, ",");
            $replaceListFunction = '';
            if (strpos($listIdChild, ',' . $idFunction) !== false) {
//                echo 'true';
                $replaceListFunction = str_replace(',' . $idFunction, "", $listIdChild);
            } else if (strpos($listIdChild, $idFunction) !== false) {
                $replaceListFunction = str_replace($idFunction . ",", "", $listIdChild);
            } else {
                $replaceListFunction = $listIdChild;
            }
//            echo $listIdChild.",";
            if ($replaceListFunction == "") {
                $function = $db->selectByID($sf, $sf->getParent() . EQUAL . $id_function_parent);
            } else {
//                $function = $db->selectByID($sf, $sf->getParent() . EQUAL . $id_function);
                $function = $db->selectByID($sf, $sf->getId() . " NOT IN (" . $replaceListFunction . ")"
                        . " AND " . $sf->getParent() . EQUAL . $id_function_parent);
            }
        }
//        echo $db->getSql();
//        print_r($function);

        $db->sql(SELECT . "COUNT(" . $sfa->getFunction()->getId() . ") as count_function_child " .
                FROM . $sfa->getFunction()->getEntity() .
                WHERE . $sfa->getFunction()->getParent() . EQUAL . $idFunction);
        $sf_count_child = $db->getResult();

        $data_function = convertJsonCombobox($function, $sf->getId(), $sf->getName());

        $idFunctionAssignment = $_POST['id_function_assignment'];
        $id = $_POST['id'];
        $functionAssign = $db->selectByID($sfa, $sfa->getId() . EQUAL . $idFunctionAssignment);

        $fAssignActionType = $functionAssign[0][$sfa->getActionType()];
//        print_r($function);
        include FILE_PATH('view/page/security/function-assignment/list-edit-function.html.php');
    }

    function saveFunction() {
        $adminthemeurl = getAdminTheme();

        $db = new Database();
        $Form = new Form();
        $sap = new MasterActionParameter();
        $sf = new SecurityFunction();
        $sfa = new SecurityFunctionAssignment();

        $action_type = $_POST['action_type'];
        $function_id = $_POST['function'];
        $id_parent = $_POST['id_parent'];
        $group = $_POST['id'];
        $db->connect();
        $db->insert($sfa->getEntity(), array(
            $sfa->getCode() => createRandomBooking()."-".$group . $function_id,
            $sfa->getActionType() => $action_type,
            $sfa->getFunctionId() => $function_id,
            $sfa->getGroupId() => $group,
            $sfa->getFunctionAssignmentOrder() => 0,
            $sfa->getStatus() => 1,
            $sfa->getCreatedByUsername() => $_SESSION[SESSION_USERNAME],
            $sfa->getCreatedOn() =>  date(DATE_FORMAT_PHP_DEFAULT)
        ));
        $result_save = $db->getResult();
        if (is_numeric($result_save[0])) {
            $function = $db->selectByID($sf, $sf->getId() . EQUAL . $function_id);
//            $function_parent = $db->selectByID($sf, $sf->getParent() . EQUAL . $function[0][$sfa->getFunction()->getParent()]);
            $db->sql(SELECT . "COUNT(" . $sfa->getFunction()->getId() . ") as count_function_parent " .
                    FROM . $sfa->getFunction()->getEntity() .
                    WHERE . $sfa->getFunction()->getParent() . EQUAL . $function_id);
            $sf_count_parent = $db->getResult();
            $count_function_parent = intval($sf_count_parent[0]['count_function_parent']);
            $db->select($sfa->getEntity(), 'max(assignment_order) as orders', null, $sfa->getGroupId() . EQUAL . $group);
            $cek_order = $db->getResult();
            $ttl_order = intval($cek_order[0]['orders']) + 1;
            $db->update($sfa->getEntity(), array(
                $sfa->getFunctionAssignmentOrder() => $ttl_order
                    ), $sfa->getId() . EQUAL . $result_save[0]);
            $rs_update = $db->getResult();

            $db->select($sfa->getFunction()->getEntity(), $sfa->getFunction()->getLevel(), null, $sfa->getFunction()->getId() . EQUAL . $function_id);
            $cek_level = $db->getResult();
//            LOGGER($db->getSql());
//            LOGGER($cek_level);
            echo toastAlert('success', lang('general.title_insert_success'), lang('general.message_insert_success'));
            $txt = '<li class="dd-item dd3-item" data-id="' . $result_save[0] . '" id="id-menu' . $result_save[0] . '">';
            if ($cek_level[0][$sfa->getFunction()->getLevel()] == 0) {
                $txt .= '<div class="dd-handle dd3-handle"> </div>';
            }
            $txt .= '<div class="dd3-content">' . $function[0][$sfa->getFunction()->getName()];
            if ($count_function_parent != 0) {
                $txt .= '<i class="fa fa-plus text-warning" rel="tooltip" data-original-title="Add" style="cursor:pointer"></i>';
            }
            $txt .= '<i class="fa fa-pencil text-primary" rel="tooltip" data-original-title="Edit" style="cursor:pointer"
              onclick="addEditMenu(this, \'&id_group=' . $group . '&id_function_parent=0&id_parent=0&id_function_parent=' . $function[0][$sfa->getFunction()->getParent()] . '&id_parent=' . $id_parent . '&id_function=' . $function_id . '&id=' . $result_save[0] . '&id_function_assignment=' . $result_save[0] . '\', \'Edit Menu\', \'' . URL($adminthemeurl . '/security/function-assignment/edit-function') . '\')"></i>';

            $txt .= '<i class="fa fa-minus text-danger" rel="tooltip" alert-title="Delete Data" 
                            alert-button-delete="Yes, Delete it." alert-message="Are you sure Delete this Data??" 
                            onclick="deleteFunction(this,\'' . URL($adminthemeurl . '/security/function-assignment/delete-function') . '\',' . $result_save[0] . ')" data-original-title="Delete" style="cursor:pointer"></i>
                        </div>
                    </li>';
            echo $txt;
        } else {
            echo toastAlert('error', lang('general.title_insert_error'), lang('general.message_insert_error'));
        }
    }

    function updateFunction() {
        $db = new Database();
        $Form = new Form();
        $sap = new MasterActionParameter();
        $sf = new SecurityFunction();
        $sfa = new SecurityFunctionAssignment();

        $action_type = $_POST['action_type'];
        $function_id = $_POST['function'];
        $id_function_assignment = $_POST['id_function_assignment'];
        $group = $_POST['id_group'];

//        $function = $_POST['function'];
//        $action_type = $_POST['action_type'];
//        $id_function_assignment = $_POST['id_function_assignment'];
        $db->connect();
        $db->update($sfa->getEntity(), array(
            $sfa->getFunctionId() => $function_id,
            $sfa->getActionType() => $action_type,
            $sfa->getFunctionAssignmentOrder() => 0,
            $sfa->getStatus() => 1,
            $sfa->getModifiedByUsername() => $_SESSION[SESSION_USERNAME],
            $sfa->getModifiedOn() =>  date(DATE_FORMAT_PHP_DEFAULT)
                ), $sfa->getId() . EQUAL . $id_function_assignment);
        $rs_update = $db->getResult();
        if ($rs_update[0] == 1) {
            $function = $db->selectByID($sf, $sf->getId() . EQUAL . $function_id);
            $result = array(
                "result" => 1,
                "title" => lang('general.title_update_success'),
                "message" => lang('general.message_update_success'),
                "function_name" => $function[0][$sfa->getFunction()->getName()],
                "id_function_assignment" => $_POST['id_function_assignment'],
                "referrer_event" => '&list_id_parent=' . $_POST['list_id_parent'] . ''
                . '&id=' . $_POST['id'] . ''
                . '&id_function=' . $_POST['function'] . ''
                . '&id_function_parent=' . $_POST['id_function_parent'] . ''
                . '&id_parent=' . $_POST['id_parent'] . ''
                . '&id_group=' . $_POST['id_group'] . ''
                . '&id_function_assignment=' . $_POST['id_function_assignment'],
                "referrer_url" => URL('/security/function-assignment/edit-function'),
                "referrer_title" => "Edit Menu"
            );
            echo json_encode($result);
        } else {
            $result = array(
                "result" => 0,
                "title" => lang('general.title_update_error'),
                "message" => lang('general.message_update_error')
            );
            echo json_encode($result);
        }
    }

    function deleteFunction() {
        $db = new Database();
        $Form = new Form();
//        $sap = new MasterActionParameter();
//        $sf = new SecurityFunction();
        $sfa = new SecurityFunctionAssignment();
        $id = $_POST['id'];
        $db->connect();
        $db->delete($sfa->getEntity(), $sfa->getId() . EQUAL . $id);
        $result_save = $db->getResult();
        if ($result_save[0] == 1) {
            $result = array("result" => 1, "title" => lang('general.title_delete_success'), "message" => lang('general.message_delete_success'));
            echo json_encode($result);
//            echo "1,".toastAlert('success', lang('general.title_delete_success'), lang('general.message_delete_success'));
        } else {
            $result = array("result" => 0, "title" => lang('general.title_delete_error'), "message" => lang('general.message_delete_error'));
            echo json_encode($result);
//            echo "0,",toastAlert('error', lang('general.title_delete_error'), lang('general.message_delete_error'));
        }
    }

}
