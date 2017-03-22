<?= $Form->formHeader(); ?>

<?php echo $Form->id('code')->title(lang('general.code'))->placeholder(lang('general.code') . ' ....')->textbox(); ?>
<?php echo $Form->id('name')->title(lang('general.name'))->placeholder(lang('general.name') . ' ....')->textbox(); ?>

<?= $Form->formFooter($this->insertUrl); ?>
