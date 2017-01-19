<?php
$adminthemeurl = getAdminTheme();
?>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-12">
            <?= $Form->formHeader(); ?>
            <div id="form-message-function"></div>
            <?php
//            echo $replaceListFunction;
            $disab = '';
            if ($sf_count_child[0]['count_function_child'] != 0) {
                $disab = 'disabled="disabled"';
            }
            ?>
            <?php echo $Form->id('function')->value($idFunction)->attr($disab.' onchange="postAjaxFunctionActionType(\'' . URL($adminthemeurl.'/security/function-assignment/get-function-action-type') . '\', \'form-group-action-type\', this)"')->title(lang('security.function'))->data($data_function)->combobox(); ?>
            <?php // echo $Form->id('name')->title(lang('general.name'))->placeholder(lang('general.name') . ' ....')->textbox(); ?>
            <div class="form-group" id="form-group-action-type">

            </div>
            <?=
            $Form->formFooter($this->insertUrl, null, 'updateMenu(\'&list_id_parent=' . $_POST['list_id_parent'] . '&id=' . $_POST['id'] . ''
                    . '&id_function_parent=' . $_POST['id_function_parent'] . ''
                    . '&id_parent=' . $_POST['id_parent'] . ''
                    . '&id_group=' . $_POST['id_group'] . ''
                    . '&id_function_assignment=' . $_POST['id_function_assignment'] . '\',\'' . URL($adminthemeurl.'/security/function-assignment/update-function') . '\')');
            ?>
        </div>
    </div>
</div>
<input type="hidden" value="<?= $idFunction; ?>" id="idFunctionEdit"/>
<input type="hidden" value="<?= $idFunctionAssignment; ?>" id="idFunctionAssignmentEdit"/>
<input type="hidden" value="<?= $fAssignActionType; ?>" id="listActionType"/>
<script>
    $(function () {
        $('#function').change();

    });
</script>