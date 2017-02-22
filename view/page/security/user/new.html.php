<?= $Form->formHeader(); ?>

<?php echo $Form->id('code')->title(lang('security.username'))->placeholder(lang('security.username') . ' ....')->textbox(); ?>
<?php echo $Form->id('fullname')->title(lang('security.fullname'))->placeholder(lang('security.fullname') . ' ....')->textbox(); ?>
<?php echo $Form->id('email')->title(lang('security.email'))->placeholder(lang('security.email') . ' ....')->textbox(); ?>
<?php echo $Form->id('group')->title(lang('security.group'))->data($this->data_group)->combobox(); ?>

<?= $Form->formFooter($this->insertUrl); ?>
