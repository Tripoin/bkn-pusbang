<?= $Form->formHeader(); ?>

<?php echo $Form->id('code')->title(lang('general.code'))->placeholder(lang('general.code') . ' ....')->textbox(); ?>
<?php echo $Form->id('name')->title(lang('general.name'))->placeholder(lang('general.name') . ' ....')->textbox(); ?>
<?php echo $Form->id('answer_category_id')->title(lang('master.answer_category'))->data($this->data_parent)->combobox(); ?>
<?php echo Form()->id('description')->required(false)->title(lang('general.description'))->placeholder(lang('general.description') . ' ....')->textbox(); ?>
<?= $Form->formFooter($this->insertUrl); ?>
