<?= $Form->formHeader(); ?>

<?php echo $Form->id('code')->title(lang('master.bank_no_account'))->placeholder(lang('master.bank_no_account') . ' ....')->textbox(); ?>
<?php echo $Form->id('name')->title(lang('general.name'))->placeholder(lang('general.name') . ' ....')->textbox(); ?>
<?php echo $Form->id('bank')->title(lang('general.bank'))->data($this->data_bank)->combobox(); ?>
<?php echo $Form->id('branch')->title(lang('master.bank_branch'))->placeholder(lang('master.bank_branch') . ' ....')->textbox(); ?>

<?= $Form->formFooter($this->insertUrl); ?>
