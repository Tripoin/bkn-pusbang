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
$dataTypes[0]=array("id"=>"parent","name"=>"Kategori Kegiatan");
$dataTypes[1]=array("id"=>"child","name"=>"Jenis Kegiatan");
$convert = convertJsonCombobox($dataTypes,'id','name');

if(empty($convert)){
    /* DO NOTHING */
}else{
    echo Form()->id('data_type')->title(lang('master.data_type') .'')
        ->value('parent')
        ->data(json_decode(json_encode($convert),true))
        ->radiobox();
}
?>
<div id="hideable">

</div>
<?php // echo Form()->textbox();?>
<?= $Form->formFooter($this->insertUrl); ?>
<div id="detail-kegiatan-header" class="hidden">
<div id="detail-kegiatan-content" class="panel panel-default">
    <div class="panel-heading">Detail Kegiatan</div>
    <div class="panel-body">
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
    </div>
</div>
</div>
<script type="application/javascript">

    $('document').ready(
        function(){
            $('input:radio').click(
                function(){
                    var data_type=$('input[name="data_type"]:checked').val();
                    if(data_type=="child"){
                        $( "#detail-kegiatan-content" ).clone().appendTo( "#hideable" );
                    }else{
                        $( "#hideable" ).empty();
                    }
                }
            );
        }
    );
</script>