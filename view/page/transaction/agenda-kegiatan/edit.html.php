<?= $Form->formHeader(); ?>

<?php
echo $Form->id('subjectId')->placeholder('Selected ....')
        ->title(lang('member.subject_name'))
        ->value($get_data[$data->getSubjectId()])
        ->data($this->data_subject)
        ->combobox();
?>
<?php
$startdate = '<div class="row"><div class="col-md-5">'.Form()->id('startActivity')->value($get_data[$data->getStartActivity()])->placeholder(lang('transaction.startdate') . ' ....')->onlyDatepicker().'</div>';
$enddate = '<div class="col-md-6">'.Form()->id('endActivity')->value($get_data[$data->getEndActivity()])->placeholder(lang('transaction.enddate') . ' ....')->onlyDatepicker().'</div></div>';
echo Form()->label(lang('transaction.excecution_time'))->title(lang('transaction.excecution_time'))->formGroup($startdate.$enddate);
echo Form()->id('generation')->placeholder(lang('member.generation').' ....')
        ->title(lang('member.generation'))
        ->value($get_data[$data->getGeneration()])
        ->textbox();
?>
<?php echo Form()->id('quota')->value($get_data[$data->getQuota()])->title(lang('transaction.number_of_participants'))->placeholder(lang('transaction.number_of_participants') . ' ....')->inputSpinner(); ?>
<?php
echo Form()->id('description')->placeholder(lang('general.description').' ....')
        ->title(lang('general.description'))
        ->value($get_data[$data->getDescription()])
        ->textarea();
?>
<input type="hidden" id="id" name="id" value="<?= $_POST['id']; ?>"/>

<?= $Form->formFooter($this->updateUrl); ?>
