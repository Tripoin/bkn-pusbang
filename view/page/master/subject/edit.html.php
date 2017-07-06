<?php
use app\Model\LinkSubjectRequirements;
use app\Util\Database;

$db = new Database();
$linkSubjectRequirements = new LinkSubjectRequirements();

$data_subject_req = $db->selectByID($linkSubjectRequirements,$linkSubjectRequirements->getSubjectId().  equalToIgnoreCase($get_data->id));
$subjectReq = array();
foreach ($data_subject_req as $valueSReq) {
    array_push($subjectReq, $valueSReq[$linkSubjectRequirements->getSubjectRequirementsId()]);
}
?>
<?= $Form->formHeader(); ?>

<?php echo Form()->id('subject_code')->value($get_data->code)->title(lang('master.subject_code'))->placeholder(lang('master.subject_code'))->textbox(); ?>
<?php echo $Form->id('subject_name')->value($get_data->name)->title(lang('master.subject_name'))->placeholder(lang('master.subject_name'))->textbox(); ?>
<?php
$convert = convertJsonCombobox($this->subject_parents, 'id', 'name');
if (empty($convert)) {
    /* DO NOTHING */
} else {
    echo Form()->id('subject_parents')->value($get_data->parent_id)->title(lang('master.subject_parent') . '')
            ->data(json_decode(json_encode($convert), true))->required(false)->combobox();
}
?>

<?php
$convert = convertJsonCombobox($this->subject_parents, 'id', 'name');

$dataTypes = array();
$dataTypes[0] = array("id" => "parent", "name" => "Kategori Kegiatan");
$dataTypes[1] = array("id" => "child", "name" => "Jenis Kegiatan");
$convert = convertJsonCombobox($dataTypes, 'id', 'name');
$data_type = 'parent';
if ($get_data->is_child == 1) {
    $data_type = 'child';
}
if (empty($convert)) {
    /* DO NOTHING */
} else {
    echo Form()->id('data_type')->title(lang('master.data_type') . '')
            ->value($data_type)
            ->data(json_decode(json_encode($convert), true))
            ->radiobox();
}
?>
<div id="hideable">

</div>
<input type="hidden" id="id" name="id" value="<?= $_POST['id']; ?>"/>
<?= $Form->formFooter($this->updateUrl); ?>
<div id="detail-kegiatan-header" class="hidden">
    <div id="detail-kegiatan-content" class="portlet light bordered">
        <div class="portlet-title">Detail Kegiatan</div>
        <div class="portlet-body">
            <?php
            echo Form()->id('budget_type_id')->title(lang('master.budget_type_id'))
                    ->data($this->budget_types)->value($get_data->budget_type_id)->combobox();
            ?>
            <?php echo $Form->id('budget_amount')->type('number')->value($get_data->subject_amount)->attr('step="any"')->title(lang('master.budget_amount'))->placeholder(lang('master.budget_amount'))->textbox(); ?>
            <?php echo $Form->id('location')->title(lang('master.location'))->value($get_data->location)->placeholder(lang('master.location'))->textbox(); ?>
            <?php
//            $dt = json_decode($this->subject_requirements, true);
//            $convert = convertJsonCombobox($dt, 'id', 'name');
            if (empty($this->subject_requirements)) {
                /* DO NOTHING */
            } else {
                echo Form()->id('subject_requirements[]')->title(lang('master.subject_requirements') . '')
                        ->value($subjectReq)->data($this->subject_requirements)->checkbox();
            }
            ?>

            <?php
            echo Form()->title(lang('master.subject_description'))->value($get_data->description)->required(false)->id('subject_description')->textarea();
            ?>
        </div>
    </div>
</div>
<script>

    $(function () {
        changeDataType();
        $('input:radio').click(
                function () {
                    changeDataType();
                }
        );
    }
    );

    function changeDataType() {
        var data_type = $('input[name="data_type"]:checked').val();
        if (data_type == "child") {
            $("#detail-kegiatan-content").appendTo("#hideable");
        } else {
//                                $('#configform')[0].reset();
            $("#detail-kegiatan-content").appendTo("#detail-kegiatan-header");
        }
    }

</script>