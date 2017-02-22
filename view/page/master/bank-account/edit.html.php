<?= $Form->formHeader(); ?>

<?php echo $Form->id('code')->title(lang('master.bank_no_account'))->value($get_data[$data->getCode()])->placeholder(lang('master.bank_no_account') . ' ....')->textbox(); ?>
<?php echo $Form->id('name')->title(lang('general.name'))->value($get_data[$data->getName()])->placeholder(lang('general.name') . ' ....')->textbox(); ?>
<?php echo $Form->id('bank')->title(lang('general.bank'))->data($this->data_bank)->value($get_data[$data->getBank()->getId()])->combobox(); ?>
<?php echo $Form->id('branch')->title(lang('master.bank_branch'))->value($get_data[$data->getBranch()])->textbox(); ?>

<input type="hidden" id="id" name="id" value="<?= $_POST['id']; ?>"/>

<?= $Form->formFooter($this->updateUrl); ?>
