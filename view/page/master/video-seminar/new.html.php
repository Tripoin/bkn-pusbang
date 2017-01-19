<?= $Form->formHeader(); ?>

<?php echo $Form->id('title')->title(lang('master.title'))->placeholder(lang('master.title') . ' ....')->textbox(); ?>
<?php echo $Form->id('urlVideo')->title(lang('master.url'))->placeholder(lang('master.url') . ' ....')->textbox(); ?>

<?= $Form->formFooter($this->insertUrl); ?>
