<?php

use app\Constant\IURLMemberConstant;
use app\Model\MasterCategoryAssess;
use app\Model\LinkSubjectAssess;
use app\Model\TransactionActivity;
use app\Util\Database;

$db = new Database();
$db->connect();
$masterCategoryAssess = new MasterCategoryAssess();
$linkSubjectAssess = new LinkSubjectAssess();
$transactionActivity = new TransactionActivity();
//$transactionSurvey
?>

<?= $Form->formHeader(); ?>
<div class="form-group">
    <label for="inputEmail3" class="control-label">To</label>
    <select id="selectTo" class="form-control js-data-example-ajax" name="to[]" multiple>
        <!--<option value="2126244" selected="selected">twbs/bootstrap</option>-->
        <!--<option value="3620194" selected="selected">select2/select2</option>-->
    </select>
</div>
<?php
echo Form()
        ->title(lang('member.title'))
        ->id('title')
        ->value('')
        ->textbox();
?>
<?php
echo Form()
        ->title(lang('general.message'))
        ->id('message')
        ->ckeditor();
?>

<?php
$button_save = '<button type="submit" id="btn-send" onclick="postFormAjaxPost(\'' . URL(IURLMemberConstant::NOTIFICATION_URL . '/update') . '\')" class="btn green">' . lang('general.send') . '</button>
                <button type="reset" id="btn-reset" class="btn default">' . lang('general.reset') . '</button>';
?>
<?= $Form->formFooter(null, $button_save); ?>
<script>
    $(function () {
//        alert("masul");
        function e(e) {
//            if (e.loading)
//                return e.name;
            return e.group_name + " - " + e.name;

        }
        function t(e) {
            return e.name;
//            return e.group_name+" - "+e.name;
        }
        $("#selectTo").select2({
//            width: "off",
            ajax: {
                url: "<?= URL(IURLMemberConstant::NOTIFICATION_URL . '/list-user'); ?>",
                dataType: "json",
                delay: 250,
                data: function (e) {
                    return {
                        q: e.term,
                        page: e.page
                    }
                },
                processResults: function (e, t) {
                    return {
                        results: e.items
                    }
                },
                cache: !0
            },
            escapeMarkup: function (e) {
                return e
            },
            minimumInputLength: 1,
            templateResult: e,
            templateSelection: t
        });
    });
</script>