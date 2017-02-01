<?= $Form->formHeader(); ?>
<?php
$autoData = $_SESSION[SESSION_ADMIN_AUTO_DATA];
$arrayNew = array();
$countAutoData;
foreach ($autoData as $valueData) {
    if ($valueData != 'id' && $valueData != 'description') {
        if (!in_array($valueData, $this->unsetAutoData)) {
            echo $Form->id($valueData)->title(lang('general.' . $valueData))->value($get_data->$valueData)->placeholder(lang('general.' . $valueData) . ' ....')->textbox();
        }
    }
}
?>

<input type="hidden" id="id" name="id" value="<?= $_POST['id']; ?>"/>

<?= $Form->formFooter($this->updateUrl); ?>
