<?= $Form->formHeader(); ?>
<?php
//print_r($get_data);

?>
<?php echo $Form->id('code')->title(lang('general.code'))->value($get_data->code)->placeholder(lang('general.code') . ' ....')->textbox(); ?>
<?php echo $Form->id('name')->title(lang('general.name'))->value($get_data->name)->placeholder(lang('general.name') . ' ....')->textbox(); ?>
<?php echo Form()->id('parent_id')->title(lang('master.parent'))->required(false)->value($get_data->parent_id)->data($this->data_parent)->combobox(); ?>
<input type="hidden" id="id" name="id" value="<?= $_POST['id']; ?>"/>

<?= $Form->formFooter($this->updateUrl); ?>
