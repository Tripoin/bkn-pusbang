<?= $Form->formHeader(); ?>
<?php
$status = '';
$status_class_alert = '';
$status_disabled = '';
if ($get_data[$data->getConfirmStatus()] == 1) {
    $status = lang('general.approve');
    $status_class_alert = 'success';
    $status_disabled = 'disabled';
} else if ($get_data[$data->getConfirmStatus()] == 3) {
    $status = lang('general.reject');
    $status_class_alert = 'danger';
    $status_disabled = 'disabled';
} else {
    $status_class_alert = 'warning';
    $status = lang('general.pending');
    $status_disabled = '';
}
?>
<div class="alert alert-<?= $status_class_alert; ?>" style="text-align:center;">
    <?= lang('topupsaldo.status_message'); ?> <strong><?= $status; ?></strong>
</div>
<div class="row">
    <div class="col-md-6">

        <?php echo $Form->id('code')->attr($status_disabled)->title(lang('topupsaldo.invoice_number'))->value($get_data[$data->getCode()])->textbox(); ?>
        <?php echo $Form->id('name')->attr('disabled')->title(lang('topupsaldo.email'))->value($get_data[$data->getEmail()])->textbox(); ?>
        <?php echo $Form->id('bank_to')->attr('disabled')->title(lang('topupsaldo.bank_to'))->value($get_data[$data->getBankTo()])->textbox(); ?>
        <?php echo $Form->id('sender_bank')->attr('disabled')->title(lang('topupsaldo.sender_bank'))->value($get_data[$data->getBankSender()])->textbox(); ?>
        <?php echo $Form->id('sender_account_number')->attr('disabled')->title(lang('topupsaldo.sender_account_number'))->value($get_data[$data->getNoAccount()])->textbox(); ?>
        <?php echo $Form->id('sender_name')->attr('disabled')->title(lang('topupsaldo.sender_name'))->value($get_data[$data->getSenderName()])->textbox(); ?>
    </div>
    <div class="col-md-6">
        <?php echo $Form->id('transfer_date')->attr('disabled')->title(lang('topupsaldo.transfer_date'))->value(subMonth($get_data[$data->getTransferDate()]))->textbox(); ?>
        <?php echo $Form->id('transfer_amount')->attr('disabled')->title(lang('topupsaldo.transfer_amount'))->value(amountToStr($get_data[$data->getTransferAmount()]))->textbox(); ?>
        <?php echo $Form->id('notes')->attr('disabled')->title(lang('topupsaldo.notes'))->value($get_data[$data->getNotes()])->textbox(); ?>
        <div class="form-group">
            <label class="control-label" for="focusedinput"><span style="color:red;">*</span><?= lang('topupsaldo.upload_proof_payment'); ?></label>
            <div id="compuploadimg">
                <img height="200" <?= notFoundImg(); ?> src="<?= URL(DIR_WEB.'uploads/image/confirm/' . $get_data[$data->getUploadImg()]); ?>"/>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="id" name="id" value="<?= $_POST['id']; ?>"/>
<?php
$action_reject = $Button->onClick('postAjaxByAlert(this,\'' . $this->rejectedUrl . '\',\'form-newedit\')')
                ->icon('fa fa-times')->setClass('btn-danger')
                ->alertTitle(lang("general.alert_title"))
                ->alertMsg(lang("general.alert_msg_reject"))
                ->alertBtnMsg(lang("general.alert_button_reject"))
                ->label(lang("general.reject"))
                ->title(lang("general.reject"))->buttonManual();
$action_approved = $Button->onClick('postAjaxByAlert(this,\'' . $this->approvedUrl . '\',\'form-newedit\')')
                ->icon('fa fa-check')->setClass('btn-success')
                ->alertTitle(lang("general.alert_title"))
                ->alertMsg(lang("general.alert_msg_approve"))
                ->alertBtnMsg(lang("general.alert_button_approve"))
                ->label(lang("general.approve"))
                ->title(lang("general.approve"))->buttonManual();
?>
<?php if ($get_data[$data->getConfirmStatus()] == 0) { ?>
    <?= $Form->formFooter('', $action_approved . $action_reject); ?>
<?php } else { ?>
    <?= $Form->formFooter('',' '); ?>
<?php } ?>


