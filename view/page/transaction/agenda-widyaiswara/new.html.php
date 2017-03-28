<?= $Form->formHeader(); ?>

<?php

echo Form()->id('subjectId')->placeholder('Selected ....')
        ->title(lang('member.subject_name'))
        ->data($this->data_subject)
        ->combobox();
$StaringDate = date('Y-m-d');
$oneYearOn = date("Y", strtotime(date("Y-m-d", strtotime($StaringDate)) . " +1 year"));
?>
<?php

$startdate = '<div class="row">'
        . '<div class="col-md-5">' . Form()->id('startActivity')->required(false)->placeholder(lang('transaction.startdate') . ' ....')->onlyDatepicker() . '</div>';
$enddate = '<div class="col-md-6">' . Form()->id('endActivity')->required(false)->placeholder(lang('transaction.enddate') . ' ....')->onlyDatepicker() . '</div></div>';
echo Form()->required(false)->label(lang('transaction.excecution_time'))->title(lang('transaction.excecution_time'))->formGroup($startdate . $enddate);
echo Form()->id('execution_years')->placeholder('Selected ....')
        ->title(lang('transaction.excecution_years'))
        ->value($oneYearOn)
        ->data($this->data_years)
        ->combobox();
echo Form()->id('generation')->required(false)->placeholder(lang('member.generation') . ' ....')
        ->title(lang('member.generation'))
        ->textbox();
?>
<?php echo Form()->id('quota')->title(lang('transaction.number_of_participants'))->placeholder(lang('transaction.number_of_participants') . ' ....')->inputSpinner(); ?>
<?php

echo Form()->id('location')->required(false)->placeholder(lang('transaction.location') . ' ....')
        ->title(lang('transaction.location'))
        ->value('Pusbang')
        ->textbox();
/* echo Form()->id('description')->placeholder(lang('general.description').' ....')
  ->title(lang('general.description'))
  ->textarea();
 * 
 */
?>
<?= $Form->formFooter($this->insertUrl); ?>

