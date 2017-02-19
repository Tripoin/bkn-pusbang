<?= $Form->formHeader(); ?>

<?php echo $Form->id('code')->title(lang('general.code'))->placeholder(lang('general.code') . ' ....')->textbox(); ?>
<?php echo $Form->id('name')->title(lang('general.name'))->placeholder(lang('general.name') . ' ....')->textbox(); ?>
<?php echo $Form->id('subject_name')->title(lang('master.subject_name'))->placeholder(lang('master.subject_name') . ' ....')->textbox(); ?>
<?php echo $Form->id('budget_type')->title(lang('master.budget_type_id'))->data($this->budget_types)->combobox(); ?>
<?php echo $Form->id('capacity')->title(lang('master.budget_amount'))->placeholder(lang('master.budget_amount') . ' ....')->textbox(); ?>
<?php // echo Form()->textbox();?>
<?= $Form->formFooter($this->insertUrl); ?>
