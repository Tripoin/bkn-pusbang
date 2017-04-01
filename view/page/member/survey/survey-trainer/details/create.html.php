<?php
use app\Constant\IURLMemberConstant;
?>

<?= $Form->formHeader(); ?>

<?php
echo Form()->attr('style="width:50%;"')
    ->title(lang('transaction.trainer'))
    ->label($dataActDetail[0]['user_main_name'])
    ->formLayout('horizontal')->labels();

echo Form()->attr('style="width:50%;"')
    ->title(lang('survey.material_name'))
    ->label($dataActDetail[0]['material_name'])
    ->formLayout('horizontal')->labels();

echo Form()->attr('style="width:50%;"')
    ->title(lang('transaction.execution_time'))
    ->label(fullDateString($dataActDetail[0]['start_time']).' '.subTimeOnly($dataActDetail[0]['start_time']).' - '.subTimeOnly($dataActDetail[0]['end_time']))
    ->formLayout('horizontal')->labels();

echo Form()->attr('style="width:50%;"')
    ->title(lang('transaction.subject_name'))
    ->label($dataAct[0]['subject_name'])
    ->formLayout('horizontal')->labels();
foreach($dataCtrAssess as $fieldLabel){
    echo Form()
        ->title($fieldLabel['name'])
        ->id($fieldLabel['code'])
        ->type('number')
        ->value(0)
        ->attr('style="width:30%;" tripoin="spinner" min="0" onchange="testFunction();" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"')
        ->formLayout('horizontal')->textbox();
}

echo Form()
    ->title(lang('survey.total_value'))
    ->id('total')
    ->attr('readonly style="width:30%;"')
    ->formLayout('horizontal')->textbox();

echo Form()
    ->title(lang('survey.average_value'))
    ->id('average')
    ->attr('readonly style="width:30%;"')
    ->formLayout('horizontal')->textbox();

?>

<input type="hidden" id="id" name="id" value="<?=$idActivityDetail;?>"/>
<input type="hidden" id="id_usr_as" name="id_usr_as" value="<?=$idUsrAsg;?>"/>
<?= Form()->formFooter($this->saveUrl, null, null); ?>
<script>
    function testFunction(){
//        alert($('[name="spinner"]').attr());
        var values = [];
        $('[tripoin="spinner"]').each(function() {
            values.push($(this).val());
        });
        var calc = 0;
        var avg = 0;
        var ttlField = values.length;
        for(var no=0; no<values.length;no++){
            calc += parseInt(values[no]);
            avg = calc/ttlField;
        }

        $('#total').val(calc);
        $('#average').val(avg);
    }
    $(function () {

//        initDetails();
        $('#buttonBack').attr("onclick","postAjaxEdit('<?=URL(IURLMemberConstant::SURVEY_TRAINER_URL . '/detail');?>','id=<?=$_POST['id_activity'];?>')");
        $('#buttonCreate').hide();
    });


//location.reload(true);
</script>
