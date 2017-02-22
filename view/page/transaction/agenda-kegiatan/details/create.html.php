<?= $Form->formHeader(); ?>
<?php

if(empty($get_data)){
    $date = date('Y-m-d');
    $startTime = date('h:i:s');
    $endTime = date('h:i:s');
    $curriculum = 0;
    $curriculum_name = "";
    $lesson_time = "";
    $user_main = 0;
    $user_main_name = "";
} else {
    $date = date('Y-m-d', strtotime($get_data[0][$activityDetails->getStartTime()]));
    $startTime = date('h:i:s', strtotime($get_data[0][$activityDetails->getStartTime()]));
    $endTime = date('h:i:s', strtotime($get_data[0][$activityDetails->getStartTime()]));
    $curriculum = $get_data[0][$activityDetails->getCurriculumId()];
    $curriculum_name = $get_data[0][$activityDetails->getMaterialName()];
    $lesson_time = $get_data[0][$activityDetails->getDuration()];
    $user_main = $get_data[0][$activityDetails->getUserMainId()];
    $user_main_name = $get_data[0][$activityDetails->getUserMainName()];
}

?>
<?php
echo Form()->id('date')->attr('style="width:50%;"')
        ->title(lang('transaction.date'))
        ->value($date)
        ->placeholder(lang('transaction.date') . ' ....')->datepicker();
?>

<?php
$startdate = '<div class="row"><div class="col-md-5">' . Form()->id('startActivity')->value($startTime)->placeholder(lang('transaction.startdate') . ' ....')->onlyTimepicker() . '</div>';
$enddate = '<div class="col-md-6">' . Form()->id('endActivity')->value($endTime)->placeholder(lang('transaction.enddate') . ' ....')->onlyTimepicker() . '</div></div>';
echo Form()->label(lang('transaction.time'))
        ->title(lang('transaction.time'))->formGroup($startdate . $enddate);
?>
<?php
$comb1= Form()->id('curriculum')->attr('style="width:50%;" onchange="checkMaterial(this)"')
        ->data($this->data_curriculum)
        ->value($curriculum)
        ->required(false)
        ->onlyComponent(true)
        ->placeholder(lang('transaction.material') . ' ....')->combobox();
$inp1=  Form()->id('curriculum_name')->attr('style="width:50%;"')
        ->value($curriculum_name)
        ->required(false)
        ->onlyComponent(true)
        ->placeholder(lang('general.empty_if_there_option') . ' ....')->textbox();

echo Form()->label(lang('transaction.material'))
        ->title(lang('transaction.material'))->formGroup($comb1.$inp1);
?>
<?php
echo Form()->id('lesson_time')
        ->title(lang('transaction.lesson_time'))
        ->value($lesson_time)
        ->placeholder(lang('transaction.lesson_time') . ' ....')->inputSpinner();
?>
<?php
//echo Form()->id('trainer')->attr('style="width:50%;"')
//        ->title(lang('transaction.trainer'))
//        ->data($this->data_user)
//        ->value($user_main)
//        ->placeholder(lang('transaction.trainer') . ' ....')->combobox();

$comb2= Form()->id('trainer')->attr('style="width:50%;" onchange="checkTrainer(this)"')
        ->title(lang('transaction.trainer'))
        ->data($this->data_user)
        ->value($user_main)
        ->required(false)
        ->onlyComponent(true)
        ->placeholder(lang('transaction.trainer') . ' ....')->combobox();
$inp2=  Form()->id('trainer_name')->attr('style="width:50%;"')
        ->value($user_main_name)
        ->required(false)
        ->onlyComponent(true)
        ->placeholder(lang('general.empty_if_there_option') . ' ....')
        ->textbox();

echo Form()->label(lang('transaction.trainer'))
        ->title(lang('transaction.trainer'))->formGroup($comb2.$inp2);
?>

<?php
//$action_kirim = Button()->onClick('ajaxPostModalManual(\'' . URL($this->admin_theme_url . $this->indexUrl . '/assignment/' . $activity . '/edit') . '\',\'id=0\')')->icon('fa fa-save')->label('Save')->title('Save')->buttonManual();
$act = 'update';
if ($id == 0) {
    $act = 'save';
}
?>
<input type="hidden" value="<?=$id;?>" id="id" name="id"/>
<?= $Form->formFooter(URL($this->admin_theme_url . $this->indexUrl . '/details/' . $activity . '/' . $act)); ?>
<script>
    $(function () {
        initDetails();
        $('#modal-title-self').html('<?= lang('general.create'); ?> <?= lang('transaction.activity_details'); ?>');
        checkMaterial(document.getElementById('curriculum'));
        checkTrainer(document.getElementById('trainer'));
    });
    
    function checkMaterial(e){
        if(e.value==""){
            $('#curriculum_name').show();
        } else {
            $('#curriculum_name').hide();
        }
    }
    
    function checkTrainer(e){
        if(e.value==""){
            $('#trainer_name').show();
        } else {
            $('#trainer_name').hide();
        }
    }
//location.reload(true);
</script>
