<?= $Form->formHeader(); ?>

<?php
echo $Form->id('subjectId')->placeholder('Selected ....')
        ->title(lang('member.subject_name'))
        ->data($this->data_subject)
        ->combobox();
?>
<?php
$startdate = '<div class="row"><div class="col-md-5">'.Form()->id('startActivity')->placeholder(lang('transaction.startdate') . ' ....')->onlyDatepicker().'</div>';
$enddate = '<div class="col-md-6">'.Form()->id('endActivity')->placeholder(lang('transaction.enddate') . ' ....')->onlyDatepicker().'</div></div>';
echo Form()->label(lang('transaction.excecution_time'))->title(lang('transaction.excecution_time'))->formGroup($startdate.$enddate);
?>
<?php echo Form()->id('quota')->title(lang('transaction.number_of_participants'))->placeholder(lang('transaction.number_of_participants') . ' ....')->inputSpinner(); ?>

<?= $Form->formFooter($this->insertUrl); ?>

