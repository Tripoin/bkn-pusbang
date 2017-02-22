<?= $Form->formHeader(); ?>

<?php echo $Form->id('title')->title(lang('master.title'))->value($get_data[$data->getTitle()])->placeholder(lang('master.title') . ' ....')->textbox(); ?>
<?php echo $Form->id('urlVideo')->title(lang('master.url'))->value($get_data[$data->getUrlVideo()])->placeholder(lang('master.url') . ' ....')->textbox(); ?>

<input type="hidden" id="id" name="id" value="<?= $_POST['id']; ?>"/>

<?= $Form->formFooter($this->updateUrl); ?>
