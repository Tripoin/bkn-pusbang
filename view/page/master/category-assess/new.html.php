<?= $Form->formHeader(); ?>

<?php echo $Form->id('code')->title(lang('general.code'))->placeholder(lang('general.code') . ' ....')->textbox(); ?>
<?php echo $Form->id('name')->title(lang('general.name'))->placeholder(lang('general.name') . ' ....')->textbox(); ?>
<?php echo $Form->id('parent_id')->title(lang('master.parent'))->data($this->data_parent)->combobox(); ?>
<?= $Form->formFooter($this->insertUrl); ?>
