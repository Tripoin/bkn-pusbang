<?= $Form->formHeader(); ?>
<?php
$data = array(
    array("id"=>1,"label"=>"CHECKBOX 1"),
    array("id"=>2,"label"=>"CHECKBOX 2"),
);
?>
<?php echo $Form->id('code')->title(lang('general.code'))->placeholder(lang('general.code') . ' ....')->textbox(); ?>
<?php echo $Form->id('name')->title(lang('general.name'))->placeholder(lang('general.name') . ' ....')->textbox(); ?>
<?php echo $Form->id('checkbox')->title(lang('general.name'))->data($data)->checkbox(); ?>
<?= $Form->formFooter($this->insertUrl); ?>
