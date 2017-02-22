<legend>Detail Saldo Topup Anda</legend>
<?php
$Datatable->createButton(false);
//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "", "text-align:center;width:100px;"));
$Datatable->header(array("No", lang('topupsaldo.transfer_date'), lang('topupsaldo.invoice_number'), lang('topupsaldo.transfer_amount'), lang('general.status')));
$no = $list_data['from'];

//$no=0;
$amount = 0;
foreach ($list_data['item'] as $value) {
//for($no =0;$no<=10;$no++){
    $status = '';
    if ($value[$confirm->getConfirmStatus()] == 1) {
        $amount+= $value[$confirm->getTransferAmount()];
        $status = "<label class='label label-success' rel='tooltip' title='Success'><i class='fa fa-check'></i></label>";
    } else if ($value[$confirm->getConfirmStatus()] == 3) {
        $status = "<label class='label label-danger' rel='tooltip' title='Reject'><i class='fa fa-times'></i></label>";
    } else {
        $status = "<label class='label label-warning' rel='tooltip' title='Pending'><i class='fa fa-warning'></i></label>";
    }
    $Datatable->body(array($no, $value[$confirm->getTransferDate()], $value[$confirm->getCode()], amountToStr($value[$confirm->getTransferAmount()]), $status));
//    $action_delete = $Button->url($this->deleteUrl)->value($value[$data->getId()])->buttonDelete();
//    $action_edit = $Button->url($this->editUrl)->value($value[$data->getId()])->buttonEdit();
//    $Datatable->body(array($no, $value[$data->getCode()], $value[$data->getName()],$action_edit.$action_delete));
    $no += 1;
}

echo $Datatable->show();
?>
<div class="alert alert-success">
    Saldo Topup Anda di Tala Indonesia Adalah <strong>Rp. <?= amountToStr($rs_saldo[0]['saldo']); ?></strong>
</div>
