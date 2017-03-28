<?= $Form->formHeader(); ?>

<?php echo $Form->id('code')->title(lang('general.code'))->value($get_data[$data->getCode()])->placeholder(lang('general.code') . ' ....')->textbox(); ?>
<?php echo $Form->id('name')->title(lang('general.name'))->value($get_data[$data->getName()])->placeholder(lang('general.name') . ' ....')->textbox(); ?>
<?php
echo Form()->id('isMaterial')
        ->title(lang('general.is_material'))
        ->data($this->data_tipe_material)
        ->value($get_data[$data->getIsMaterial()])
        ->placeholder(lang('general.is_material') . ' ....')->checkbox();
?>
<?php echo Form()->id('duration')->title(lang('general.duration'))
        ->value($get_data[$data->getDuration()])
        ->placeholder(lang('general.duration') . ' ....')->inputSpinner(); ?>
<?php echo Form()->id('unitId')->title(lang('general.unit'))
        ->data($this->data_unit)
        ->value($get_data[$data->getUnitId()])
        ->placeholder(lang('general.unit') . ' ....')->combobox(); ?>
<?php echo Form()->id('authorName')->value($get_data[$data->getAuthorName()])->title(lang('general.author_name'))->placeholder(lang('general.author_name') . ' ....')->textbox(); ?>
<?php echo Form()->id('copyrightDate')->value($get_data[$data->getCopyrightDate()])->title(lang('general.copyright_date'))->placeholder(lang('general.copyright_date') . ' ....')->datepicker(); ?>
<input type="hidden" id="id" name="id" value="<?= $_POST['id']; ?>"/>

<?= $Form->formFooter($this->updateUrl); ?>
