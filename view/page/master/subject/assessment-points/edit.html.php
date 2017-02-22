<?= $Form->formHeader(); ?>
<?php
//print_r($get_data);

?>
<?php echo Form()->id('code')->title(lang('general.code'))->placeholder(lang('general.code') )->textbox(); ?>
<?php echo $Form->id('name')->title(lang('general.name'))->placeholder(lang('general.name') )->textbox(); ?>
<?php echo $Form->id('subject_name')->title(lang('master.subject_name'))->placeholder(lang('master.subject_name'))->textbox(); ?>
<?php echo $Form->id('budget_type')->title(lang('master.budget_type_id'))->data($this->budget_types)->combobox(); ?>
<?php echo $Form->id('capacity')->title(lang('master.budget_amount'))->placeholder(lang('master.budget_amount') )->textbox(); ?>

<?php
$dt = json_decode($this->subject_requirements,true);
$convert = convertJsonCombobox($dt,'id','name');
if(empty($convert)){

}else{
    echo Form()->id('subject_requirements')->title(lang('master.subject_requirements') .'')->data(json_decode(json_encode($convert),true))->checkbox();
}
?>
<?php
echo Form()->title(lang('master.subject_description'))->id('subject_description')->textarea();
?>
<?php // echo Form()->textbox();?>
<?= $Form->formFooter($this->updateUrl); ?>
