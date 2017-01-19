<?php
$adminthemeurl = getAdminTheme();
?>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-12">
            <?= $Form->formHeader(); ?>
            <div id="form-message-function"></div>
            <?php echo $Form->id('function')->attr('onchange="postAjaxFunctionActionType(\''.URL($adminthemeurl.'/security/function-assignment/get-function-action-type').'\', \'form-group-action-type\', this)"')->title(lang('security.function'))->data($data_function)->combobox(); ?>
            <?php // echo $Form->id('name')->title(lang('general.name'))->placeholder(lang('general.name') . ' ....')->textbox(); ?>
            <div class="form-group" id="form-group-action-type">
                
            </div>
            <?= $Form->formFooter($this->insertUrl,null,'saveMenu('.$_POST['id'].',\''.URL($adminthemeurl.'/security/function-assignment/save-function').'\')'); ?>
        </div>
    </div>
</div>