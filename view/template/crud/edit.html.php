<?= $Form->formHeader(); ?>
<?php

use app\Util\Database;

$db = new Database();
$db->connect();
$autoData = $_SESSION[SESSION_ADMIN_AUTO_DATA];
$arrayNew = array();
$countAutoData;
if ($this->modelData == null) {
    foreach ($autoData as $valueData) {
        if ($valueData != 'id') {
            if (!in_array($valueData, $this->unsetAutoData)) {
                if (is_object($get_data)) {
                    echo $Form->id($valueData)->title(lang('general.' . $valueData))
                            ->value($get_data->$valueData)->placeholder(lang('general.' . $valueData) . ' ....')->textbox();
                } else {
                    echo $Form->id($valueData)->title(lang('general.' . $valueData))
                            ->value($get_data[$valueData])->placeholder(lang('general.' . $valueData) . ' ....')->textbox();
                }
            }
        }
    }
} else {
    $relation = $db->selectRelation($this->modelData->getEntity());
    $checkLov = array();
    foreach ($autoData as $valueData) {
        if ($valueData != 'id') {
            if (!in_array($valueData, $this->unsetAutoData)) {
                if (is_object($get_data)) {
                    echo $Form->id($valueData)->title(lang('general.' . $valueData))
                            ->value($get_data->$valueData)->placeholder(lang('general.' . $valueData) . ' ....')->textbox();
                } else {
                    $check = false;
                    foreach ($relation as $val_relation) {
                        if ($valueData == $val_relation['COLUMN_NAME']) {
                            $check = true;
                            $db->select($val_relation['REFERENCED_TABLE_NAME'], "*", null);
                            $res_rel = $db->getResult();
                            $cv = convertJsonCombobox($res_rel, 'id', 'name', null);
                            $ex_val2 = explode('_', $valueData);
                            $langData = '';
                            if (isset($ex_val2[1])) {
                                if ($ex_val2[1] == 'id') {
                                    $langData = $ex_val2[0];
                                    array_push($checkLov, $langData);
                                }
                            } else {
                                $langData = $valueData;
                            }
                            echo $Form->id($valueData)->value($get_data[$valueData])
                                    ->title(lang('general.' . $langData))->data($cv)->placeholder('Select')->combobox();
                        }
                    }
                    if ($check == false) {
                        if (in_array($valueData, $checkLov)) {
                            
                        } else {
                            echo $Form->id($valueData)->title(lang('general.' . $valueData))
                                    ->value($get_data[$valueData])->placeholder(lang('general.' . $valueData) . ' ....')->textbox();
                        }
                    }
                }
            }
        }
    }
}
?>

<input type="hidden" id="id" name="id" value="<?= $_POST['id']; ?>"/>

<?= $Form->formFooter($this->updateUrl); ?>
