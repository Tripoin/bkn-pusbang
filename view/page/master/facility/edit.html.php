<?= $Form->formHeader(); ?>

<?php echo $Form->id('code')->title(lang('general.code'))->value($get_data->code)->placeholder(lang('general.code') . ' ....')->textbox(); ?>
<?php echo $Form->id('name')->title(lang('general.name'))->value($get_data->name)->placeholder(lang('general.name') . ' ....')->textbox(); ?>


<input type="hidden" id="id" name="id" value="<?= $_POST['id']; ?>"/>

<?= $Form->formFooter($this->updateUrl); ?>
