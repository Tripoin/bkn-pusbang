<?= $Form->formHeader(); ?>

<?php echo Form()->id('subject_code')->title(lang('master.subject_code'))->placeholder(lang('master.subject_code') )->textbox(); ?>
<?php echo $Form->id('subject_name')->title(lang('master.subject_name'))->placeholder(lang('master.subject_name'))->textbox(); ?>
<?php
$convert = convertJsonCombobox($this->subject_parents,'id','name');
if(empty($convert)){
/* DO NOTHING */
}else{
    echo Form()->id('subject_parents')->title(lang('master.subject_parent') .'')->data(json_decode(json_encode($convert),true))->combobox();
}
?>

<?php
$convert = convertJsonCombobox($this->subject_parents,'id','name');

$dataTypes = array();
$dataTypes=array_fill(0,1,array("id"=>"parent","name"=>"child"));
$dataTypes=array_fill(1,1,array("id"=>"parent","name"=>"child"));
$convert = convertJsonCombobox($dataTypes,'id','name');

if(empty($convert)){
    /* DO NOTHING */

}else{
    echo Form()->id('data_type')->title(lang('master.type_data') .'')->data(json_decode(json_encode($convert),true))->radiobox();
}
?>


<?php echo $Form->id('budget_type_id')->title(lang('master.budget_type_id'))->data($this->budget_types)->combobox(); ?>
<?php echo $Form->id('budget_amount')->title(lang('master.budget_amount'))->placeholder(lang('master.budget_amount') )->textbox(); ?>

<?php
$dt = json_decode($this->subject_requirements,true);
$convert = convertJsonCombobox($dt,'id','name');
if(empty($convert)){
    /* DO NOTHING */
}else{
    echo Form()->id('subject_requirements')->title(lang('master.subject_requirements') .'')->data(json_decode(json_encode($convert),true))->checkbox();
}
?>

<?php
echo Form()->title(lang('master.subject_description'))->id('subject_description')->textarea();
?>
<?php // echo Form()->textbox();?>
<?= $Form->formFooter($this->insertUrl); ?>
