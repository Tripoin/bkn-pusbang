
<?php
//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "text-align:center;width:100px;"));
$Datatable->header(array(lang("general.no"), lang("general.code"),
    lang("approval.approval_category"),
    lang("approval.user"),
    lang("approval.status"),
    lang("approval.time"),
//    lang("general.action")
));
$no = $list_data['from'];


foreach ($list_data['item'] as $value) {

    $action_delete = $Button->url($this->deleteUrl)->value($value[$data->getId()])->buttonDelete();
    $action_edit = $Button->url($this->editUrl)->value($value[$data->getId()])->buttonEdit();

    $status = '<a href="javascript:void(0)"  onclick="postAjaxEdit(\'' . $this->editUrl . '\',\'id=' . $value[$data->getId()] . '\')" rel="tooltip" title="' . lang("approval.detail") . '">' . lang("approval.detail") . '</a>';
    if ($value['excecuted'] == "N") {
        $status = lang("approval.rejected");
    } else if ($value['excecuted'] == "Y") {
        $status = lang("approval.approved");
    }
    $Datatable->body(array($no, 
        '<a href="#">' .$value[$data->getCode()].'</a>',
        $value['approval_category_name'],
        $value['username'],
        $status,
        $value['created_on'],
//        $action_edit . $action_delete
    ));
    $no += 1;
}

echo $Datatable->show();
?>
<!--<script>location.reload(true);</script>-->
