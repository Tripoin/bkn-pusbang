<?php
use app\Constant\IURLConstant;
//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "","","","", "text-align:center;width:100px;"));
$Datatable->header(array(lang("general.no"), lang("general.code"),
    lang("approval.approval_category"),
    lang("approval.user"),
    lang("approval.status"),
    lang("approval.time"),
    lang("general.action")
));
$no = $list_data['from'];


foreach ($list_data['item'] as $value) {

    $action_delete = $Button->url($this->deleteUrl)->value($value[$data->getId()])->buttonDelete();
    $action_edit = $Button->url($this->editUrl)->value($value[$data->getId()])->buttonEdit();

    $status = "";
    if (is_null($value[$data->getStatus()])) {
        $status = '<a href="javascript:void(0)" '
                . 'onclick="postAjaxEdit(\'' . URL(getAdminTheme().IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/edit') . '\',\'id=' . $value[$data->getId()] . '\')">' . lang("general.detail") . '</a>';
    } else if ($value[$data->getStatus()] == 1) {
        $status = '<span class="text-success">' . lang('general.approve') . '</span>';
    } else if($value[$data->getStatus()] == 0) {
        $status = '<span class="text-danger">' . lang('general.reject') . '</span>';
    }
    $Datatable->body(array($no,
        '<a href="javascript:void(0)" onclick="postAjaxEdit(\'' . URL(getAdminTheme().IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/edit') . '\',\'id=' . $value[$data->getId()] . '\')">' . $value[$data->getCode()] . '</a>',
        $value['approval_category_name'],
        $value['username'],
        $status,
        $value['created_on'],
       $action_delete
    ));
    $no += 1;
}

echo $Datatable->show();
?>
<!--<script>location.reload(true);</script>-->
