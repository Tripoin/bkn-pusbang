<?= $Form->formHeader(); ?>

<?php echo $Form->id('code')->title(lang('general.code'))->placeholder(lang('general.code') . ' ....')->textbox(); ?>
<?php echo $Form->id('name')->title(lang('general.name'))->placeholder(lang('general.name') . ' ....')->textbox(); ?>
<?php echo $Form->id('amount')->title(lang('master.amount'))->placeholder(lang('master.amount') . ' ....')->textbox(); ?>

<?= $Form->formFooter($this->insertUrl); ?>
