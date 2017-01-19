
<?php
//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->deleteCollection(false);
$Datatable->createButton(false);

$Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "","text-align:right;width:100px;", "text-align:center;width:100px;", "text-align:center;width:100px;"));
$Datatable->header(array(lang("general.no"), lang("general.code"),lang("topupsaldo.transfer_date"),
    lang("general.email"),lang("topupsaldo.transfer_amount"),lang("general.status"), lang("general.action")));
$no = $list_data['from'];


foreach ($list_data['item'] as $value) {

    $action_reject = $Button->onClick('postAjaxByAlert(this,\'' . URL('page/approval/confirm-saldo/reject') . '\',\'' . $value[$data->getId()] . '\')')
                    ->icon('fa fa-times')->setClass('btn-danger')
                    ->alertTitle(lang("general.alert_title"))
                    ->alertMsg(lang("general.alert_msg_reject"))
                    ->alertBtnMsg(lang("general.alert_button_reject"))
                    ->title(lang("general.reject"))->buttonCircleManual();
    /* $action_approved = $Button->onClick('postAjaxByAlert(this,\'' . URL('page/approval/confirm-saldo/approved') . '\',\'' . $value[$data->getId()] . '\')')
      ->icon('fa fa-check')->setClass('btn-success')
      ->alertTitle(lang("general.alert_title"))
      ->alertMsg(lang("general.alert_msg_approve"))
      ->alertBtnMsg(lang("general.alert_button_approve"))
      ->title(lang("general.approve"))->buttonCircleManual(); */
    $action_approved = $Button->url($this->editUrl)
                    ->title(lang("general.view"))
                    ->icon('fa fa-eye')
                    ->value($value[$data->getId()])->buttonEdit();

    $status = '';
    if( $value[$data->getConfirmStatus()] == 1){
        $status = '<label class="label label-success label-sm">'.lang('general.approve').'</label>';
    } else if( $value[$data->getConfirmStatus()] == 3){
        $status = '<label class="label label-danger label-sm">'.lang('general.reject').'</label>';
    } else {
        $status = '<label class="label label-warning label-sm">'.lang('general.pending').'</label>';
    }
    $Datatable->body(array($no, $value[$data->getCode()],
        $value[$data->getTransferDate()],
        $value[$data->getEmail()],
        amountToStr($value[$data->getTransferAmount()]),
        $status,
        $action_approved));
    $no += 1;
}

echo $Datatable->show();
?>

<script>
//    location.reload(true);
</script>