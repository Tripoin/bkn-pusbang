<?= $Form->formHeader(); ?>

<?php echo $Form->id('code')->title(lang('general.code'))->value($get_data[$data->getCode()])->placeholder(lang('general.code') . ' ....')->textbox(); ?>
<?php echo $Form->id('name')->title(lang('general.name'))->value($get_data[$data->getName()])->placeholder(lang('general.name') . ' ....')->textbox(); ?>
<?php
//$data = array(
//    array("id" => 1, "label" => "Usia Minimal 17 Tahu"),
//    array("id" => 2, "label" => "Pendidikan Terakhir Minimal D3"),
//    array("id" => 2, "label" => "Pendidikan Terakhir Minimal S1"),
//    array("id" => 4, "label" => "Khusus Pegawai Negeri Sipil"),
//);
//echo Form()->title('Checkbox Example')->id('checkbox')->data($data)->checkbox();
?>
<input type="hidden" id="id" name="id" value="<?= $_POST['id']; ?>"/>

<?= $Form->formFooter($this->updateUrl); ?>
