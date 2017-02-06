<?= $Form->formHeader(); ?>

<?php echo $Form->id('code')->title(lang('general.code'))->placeholder(lang('general.code') . ' ....')->textbox(); ?>
<?php echo $Form->id('name')->title(lang('general.name'))->placeholder(lang('general.name') . ' ....')->textbox(); ?>
<?php echo $Form->id('dimension')->title(lang('master.dimension'))->placeholder(lang('master.dimension') . ' ....')->textbox(); ?>
<?php echo $Form->id('facility_id')->title(lang('master.facility'))->data($this->data_facility)->combobox(); ?>
<?php echo $Form->id('capacity')->title(lang('master.capacity'))->placeholder(lang('master.capacity') . ' ....')->textbox(); ?>
<?php // echo Form()->textbox();?>
<?= $Form->formFooter($this->insertUrl); ?>
