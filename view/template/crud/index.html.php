<!doctype html>
<html lang="en">
    <?= contentPage(); ?>
    <?= pageAutoCrudBody(); ?>
    <?php if ($this->list_parameter == true) { ?>
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-6">
                <?= $Form->id('form-search')->formHeader(); ?>
                <?php
                echo $Form->id('code')->title(lang('general.code'))
                        ->placeholder(lang('general.code') . ' ....')->textbox();
                ?>
                <?php
                $action_edit = Button()->onClick('postAjaxPagination()')->icon('fa fa-search')
                                ->label(lang("general.search"))->buttonManual();
//            echo $action_edit;
                ?>
                <?= $Form->formFooter(null, $action_edit); ?>
            </div>
        </div>
    <?php } ?>
    <?= pageAutoCrudHeadBody(); ?>
    <?php if ($this->list_parameter == false) { ?>
        <?= $Datatable->show(); ?>
        <script>
            $(function () {
                //        location.reload(true);
                postAjaxPagination();
            });
        </script>
    <?php } ?>
    <?= endPageBody(); ?>
    <?= endContentPage(); ?>
</html>