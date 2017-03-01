<?= $Form->formHeader(); ?>

<?php
echo Form()->id('subjectId')->placeholder('Selected ....')
        ->title(lang('member.subject_name'))
        ->data($this->data_subject)
        ->combobox();
?>
<?php
$startdate = '<div class="row"><div class="col-md-5">'.Form()->id('startActivity')->placeholder(lang('transaction.startdate') . ' ....')->onlyDatepicker().'</div>';
$enddate = '<div class="col-md-6">'.Form()->id('endActivity')->placeholder(lang('transaction.enddate') . ' ....')->onlyDatepicker().'</div></div>';
echo Form()->label(lang('transaction.excecution_time'))->title(lang('transaction.excecution_time'))->formGroup($startdate.$enddate);
echo Form()->id('generation')->placeholder(lang('member.generation').' ....')
        ->title(lang('member.generation'))
        ->textbox();
?>
<?php echo Form()->id('quota')->title(lang('transaction.number_of_participants'))->placeholder(lang('transaction.number_of_participants') . ' ....')->inputSpinner(); ?>
<?php
echo Form()->id('description')->placeholder(lang('general.description').' ....')
        ->title(lang('general.description'))
        ->textarea();
?>
<?= $Form->formFooter($this->insertUrl); ?>

