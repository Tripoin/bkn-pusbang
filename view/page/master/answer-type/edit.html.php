<?= $Form->formHeader(); ?>
<?php
//print_r($get_data);

?>
<?php echo $Form->id('code')->title(lang('general.code'))->value($get_data->code)->placeholder(lang('general.code') . ' ....')->textbox(); ?>
<?php echo $Form->id('name')->title(lang('general.name'))->value($get_data->name)->placeholder(lang('general.name') . ' ....')->textbox(); ?>
<?php echo $Form->id('answer_category_id')->title(lang('master.answer_category'))->value($get_data->answer_category_id)->data($this->data_parent)->combobox(); ?>
<?php echo Form()->id('description')->required(false)->title(lang('general.description'))->value($get_data->description)->placeholder(lang('general.description') . ' ....')->textbox(); ?>
<input type="hidden" id="id" name="id" value="<?= $_POST['id']; ?>"/>

<?= $Form->formFooter($this->updateUrl); ?>
