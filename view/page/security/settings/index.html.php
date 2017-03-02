<!doctype html>
<html lang="en">
    <?= contentPage(); ?>
    <?= pageBody(); ?>
    <?= $Form->formHeader(); ?>
    <?php
    $string_general = 'GENERAL_';
    $string_contact = 'CONTACT_';
    $string_setting = array("GENERAL_" => lang("security.GENERAL"),
        "CONTACT_" => lang("security.CONTACT"),
        "SYSTEM_" => lang("security.SYSTEM"));

    $theme_general = '';
    if ($handle = opendir(getTemplatePath('/assets/css/themes'))) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
//            echo "$entry\n";
                $ex_theme_entry = explode(".", $entry);
                if (strpos($ex_theme_entry[0], 'mobile') === false) {
                    $theme_general[] = array("id" => $ex_theme_entry[0], "label" => $ex_theme_entry[0]);
                }
            }
        }
        closedir($handle);
    }
    $convertheme_general = convertJsonCombobox(null, null, null, $theme_general);

    $theme_admin_general = '';
    if ($handle = opendir(getAdminTemplatePath('/assets/css/themes'))) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
//            echo "$entry\n";
                $ex_theme_entry = explode(".", $entry);
                if (strpos($ex_theme_entry[0], 'mobile') === false) {
                    $theme_admin_general[] = array("id" => $ex_theme_entry[0], "label" => $ex_theme_entry[0]);
                }
            }
        }
        closedir($handle);
    }
    $convertThemeAdmingeneral = convertJsonCombobox(null, null, null, $theme_admin_general);
    ?>
    <div>
        <ul class="nav nav-tabs">
            <?php
            foreach ($string_setting as $key => $value) {
                $active = '';
                if ($key == 'GENERAL_') {
                    $active = 'active';
                }
                ?>
                <li  class="<?= $active; ?>">
                    <a href="#<?= $key; ?>" data-toggle="tab" aria-expanded="false"><?= $value; ?></a>
                </li>
            <?php } ?>
        </ul>
        <div class="tab-content">
            <?php
            foreach ($string_setting as $key => $value) {
                $active = '';
                if ($key == 'GENERAL_') {
                    $active = 'active';
                }
                ?>
                <div class="tab-pane <?= $active; ?>" id="<?= $key; ?>">
                    <?php
                    $rs_option = $db->selectByID($mo, $mo->getCode() . " LIKE '" . $key . "%'");
                    ?>
                    <?php
                    foreach ($rs_option as $val_option) {
                        if ($val_option[$mo->getCode()] == 'GENERAL_THEME_STYLE') {
                            echo $Form->id($val_option[$mo->getCode()])->title(lang('security.' . $val_option[$mo->getCode()]))->value($val_option[$mo->getName()])->data($convertheme_general)->combobox();
                        } else if ($val_option[$mo->getCode()] == 'GENERAL_TEMPLATE_THEME') {
                            echo $Form->attr('disabled')->id($val_option[$mo->getCode()])->title(lang('security.' . $val_option[$mo->getCode()]))->value($val_option[$mo->getName()])->textbox();
                        } else if ($val_option[$mo->getCode()] == 'SYSTEM_ADMINISTRATOR_THEME_STYLE') {
                            echo $Form->id($val_option[$mo->getCode()])->title(lang('security.' . $val_option[$mo->getCode()]))->value($val_option[$mo->getName()])->data($convertThemeAdmingeneral)->combobox();
                        } else if ($val_option[$mo->getCode()] == 'SYSTEM_ADMINISTRATOR_THEME') {
                            echo $Form->attr('disabled')->id($val_option[$mo->getCode()])->title(lang('security.' . $val_option[$mo->getCode()]))->value($val_option[$mo->getName()])->textbox();
                        } else if ($val_option[$mo->getCode()] == 'GENERAL_LANGUAGE_DEFAULT') {
                            echo $Form->id($val_option[$mo->getCode()])->title(lang('security.' . $val_option[$mo->getCode()]))->value($val_option[$mo->getName()])->data($data_ml)->combobox();
                        }  else if ($val_option[$mo->getCode()] == 'SYSTEM_ADMINISTRATOR_BG_LOGIN') {
                            echo Form()->value($val_option[$mo->getName()])->id($val_option[$mo->getCode()])->title(lang('security.' . $val_option[$mo->getCode()]))->getInputMedia();
                        }   else if ($val_option[$mo->getCode()] == 'SYSTEM_ADMINISTRATOR_LOGO_LOGIN') {
                            echo Form()->value($val_option[$mo->getName()])->id($val_option[$mo->getCode()])->title(lang('security.' . $val_option[$mo->getCode()]))->getInputMedia();
                        } else {
                            echo $Form->id($val_option[$mo->getCode()])->title(lang('security.' . $val_option[$mo->getCode()]))->value($val_option[$mo->getName()])->textbox();
                        }
                    }
                    
                    ?>
                </div>
            <?php } ?>

        </div>
    </div>
    <?= $Form->formFooter(null, null, "postFormAjaxPost('" . FULLURL('/update') . "')"); ?>
    <script>
        $(function () {
            $('#buttonBack').remove();
        })
    </script>
    <?= endPageBody(); ?>
    <?= endContentPage(); ?>
</html>