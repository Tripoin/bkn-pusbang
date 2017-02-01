<?= $Form->formHeader(); ?>
<?php

$autoData = $_SESSION[SESSION_ADMIN_AUTO_DATA];
$arrayNew = array();
$countAutoData;
foreach ($autoData as $valueData) {
    if ($valueData != 'id') {
        if (!in_array($valueData, $this->unsetAutoData)) {
            echo $Form->id($valueData)->title(lang('general.' . $valueData))->placeholder(lang('general.' . $valueData) . ' ....')->textbox();
        }
    }
}
?>
<?= $Form->formFooter($this->insertUrl); ?>
