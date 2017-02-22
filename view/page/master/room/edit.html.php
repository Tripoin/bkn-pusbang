<?= $Form->formHeader(); ?>
<?php
//print_r($get_data);

?>
<?php echo $Form->id('code')->title(lang('general.code'))->value($get_data->code)->placeholder(lang('general.code') . ' ....')->textbox(); ?>
<?php echo $Form->id('name')->title(lang('general.name'))->value($get_data->name)->placeholder(lang('general.name') . ' ....')->textbox(); ?>
<?php echo $Form->id('dimension')->title(lang('master.dimension'))->value($get_data->dimension)->textbox(); ?>
<?php echo $Form->id('facility')->title(lang('master.facility'))->value($get_data->facility_id)->data($this->data_facility)->combobox(); ?>
<?php echo $Form->id('capacity')->title(lang('master.capacity'))->value($get_data->capacity)->textbox(); ?>
<input type="hidden" id="id" name="id" value="<?= $_POST['id']; ?>"/>

<?= $Form->formFooter($this->updateUrl); ?>
