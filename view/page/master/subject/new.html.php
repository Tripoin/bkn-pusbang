<?= $Form->formHeader(); ?>

<?php echo Form()->id('subject_code')->title(lang('master.subject_code'))->placeholder(lang('master.subject_code'))->textbox(); ?>
<?php echo $Form->id('subject_name')->title(lang('master.subject_name'))->placeholder(lang('master.subject_name'))->textbox(); ?>
<?php
$convert = convertJsonCombobox($this->subject_parents, 'id', 'name');
if (empty($convert)) {
    /* DO NOTHING */
} else {
    echo Form()->id('subject_parents')->title(lang('master.subject_parent') . '')
            ->data(json_decode(json_encode($convert), true))->required(false)->combobox();
}
?>

<?php
$convert = convertJsonCombobox($this->subject_parents, 'id', 'name');

$dataTypes = array();
$dataTypes[0] = array("id" => "parent", "name" => "Kategori Kegiatan");
$dataTypes[1] = array("id" => "child", "name" => "Jenis Kegiatan");
$convert = convertJsonCombobox($dataTypes, 'id', 'name');

if (empty($convert)) {
    /* DO NOTHING */
} else {
    echo Form()->id('data_type')->title(lang('master.data_type') . '')
            ->value('parent')
            ->data(json_decode(json_encode($convert), true))
            
            ->radiobox();
}
?>
<div id="hideable">
    
</div>

<?= $Form->formFooter($this->insertUrl); ?>
<div id="detail-kegiatan-header" class="hidden">
    <div id="detail-kegiatan-content" class="portlet light bordered">
        <div class="portlet-title">Detail Kegiatan</div>
        <div class="portlet-body">
            <?php echo Form()->id('budget_type_id')->title(lang('master.budget_type_id'))
                    ->data($this->budget_types)->combobox(); ?>
            <?php echo $Form->id('budget_amount')->type('number')->attr('step="any"')->title(lang('master.budget_amount'))->placeholder(lang('master.budget_amount'))->textbox(); ?>
            <?php echo $Form->id('location')->title(lang('master.location'))->placeholder(lang('master.location'))->textbox(); ?>
            <?php
 
//            $dt = json_decode($this->subject_requirements, true);
//            $convert = convertJsonCombobox($dt, 'id', 'name');
            if (empty($this->subject_requirements)) {
                /* DO NOTHING */
            } else {
                echo Form()->id('subject_requirements[]')->title(lang('master.subject_requirements') . '')
                        ->data($this->subject_requirements)->checkbox();
            }
            ?>

            <?php
            echo Form()->title(lang('master.subject_description'))->required(false)->id('subject_description')->textarea();
            ?>
        </div>
    </div>
</div>
<script>
    
    $(function(){
                $('input:radio').click(
                        function () {
                            var data_type = $('input[name="data_type"]:checked').val();
                            if (data_type == "child") {
                                $("#detail-kegiatan-content").appendTo("#hideable");
                            } else {
//                                $('#configform')[0].reset();
                                $("#detail-kegiatan-content").appendTo("#detail-kegiatan-header");
                            }
                        }
                );
            }
    );
    
</script>