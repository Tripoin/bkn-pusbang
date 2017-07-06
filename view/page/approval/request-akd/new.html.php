<?= $Form->formHeader(); ?>
<?php
//date($format);
/*
$data = array(
    array("id" => 1, "label" => "Example 1"),
    array("id" => 2, "label" => "Example 2"),
    array("id" => 3, "label" => "Example 3"),
    array("id" => 4, "label" => "Example 4"),
    array("id" => 5, "label" => "Example 5"),
);
echo Form()->idLeft('code')->idRight('code2')
        ->titleLeft(lang('general.code'))->titleRight(lang('general.code'))
        ->valueLeft(array(1,3,5))
        ->dataLeft($data)
        ->listBoxAssignment();
 *
 */
?>
<?php echo Form()->id('code')->title(lang('general.code'))->placeholder(lang('general.code') . ' ....')->textbox(); ?>
<?php echo Form()->id('name')->title(lang('general.name'))->placeholder(lang('general.name') . ' ....')->textbox(); ?>
<?php

echo Form()->id('isMaterial')
        ->title(lang('general.is_material'))
        ->data($this->data_tipe_material)
        ->placeholder(lang('general.is_material') . ' ....')->checkbox();
?>
<?php

echo Form()->id('duration')->title(lang('general.duration'))
        ->placeholder(lang('general.duration') . ' ....')->inputSpinner();
?>
<?php

echo Form()->id('unitId')->title(lang('general.unit'))
        ->data($this->data_unit)
        ->placeholder(lang('general.unit') . ' ....')->combobox();
?>
<?php echo Form()->id('authorName')->title(lang('general.author_name'))->placeholder(lang('general.author_name') . ' ....')->textbox(); ?>
<?php echo Form()->id('copyrightDate')->title(lang('general.copyright_date'))->placeholder(lang('general.copyright_date') . ' ....')->datepicker(); ?>

<?= $Form->formFooter($this->insertUrl); ?>
