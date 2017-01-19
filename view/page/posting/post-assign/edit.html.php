<?= $Form->formHeader(); ?>
<?php // echo $get_data[$data->getName()];  ?>
<?php echo $Form->id('code')->attr('readonly')->title(lang('general.code'))->value($get_data[$data->getCode()])->placeholder(lang('general.code') . ' ....')->textbox(); ?>
<?php echo $Form->id('name')->attr('readonly')->title(lang('general.name'))->value($get_data[$data->getName()])->placeholder(lang('general.name') . ' ....')->textbox(); ?>

<input type="hidden" id="id" name="id" value="<?= $_POST['id']; ?>"/>

<div class="row">
    <div class="col-md-12">
        <?php
        $action_edit = $Button->setclass('btn-warning')
                ->onClick('ajaxPostModalByValue(\'' . FULLURL('create-post-assign') . '\',\'Pilih Posting\',\'&id='.$_POST['id'].'\')')->icon('fa fa-plus')->label('Add Post Assign')->title(lang("general.create"))->buttonManual();
        echo $action_edit;
        ?>
    </div>
    <div class="col-md-12" style="margin-top:20px">
        <div id="bodyPageManual">

        </div>
    </div>

</div>
<input type="hidden" id="urlPageManual-bodyPageManual" value="<?= URL($this->admin_theme_url . '/posting/post-assign/list-post'); ?>"/>
<input type="hidden" id="pagination_parameter-bodyPageManual" value="&id=<?= $_POST['id']; ?>" />
<?= $Form->formFooter($this->updateUrl, ' '); ?>
<script>
    $(function () {
        postAjaxPaginationManual('bodyPageManual');
    });
//location.reload(true);
</script>
