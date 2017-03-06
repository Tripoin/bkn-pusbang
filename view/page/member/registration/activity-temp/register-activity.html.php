<?php

use app\Constant\IURLMemberConstant;
?>
<?= Form()->formHeader(); ?>
<div class="row">
    <div class="col-md-7">
        <?php
        $detailSubject = lang('transaction.tentative');
        $due = strtotime($data_activity[0][$modelActivity->getStartActivity()]);
        if ($due != strtotime('0000-00-00')) {
            $detailSubject = '' . subMonth($data_activity[0][$modelActivity->getStartActivity()]) . ' - ' . subMonth($data_activity[0][$modelActivity->getEndActivity()]) . '';
        } else if ($data_activity[0][$modelActivity->getStartActivity()] == null) {
            $detailSubject = lang('transaction.tentative');
        }
        ?>
        <?= $data_activity[0][$modelActivity->getSubjectName()]; ?>
        :
        <?= $detailSubject; ?>
    </div>
    <div class="col-md-5" style="margin-bottom: 20px;" id="pageBtnHeader">
        <button id="buttonBack" title="<?= lang('general.back'); ?>" 
                rel="tooltip"
                class="btn btn-danger btn-sm pull-right" type="submit" 
                onsubmit="return false;" onclick="postAjaxPagination();" 
                style="margin-left: 10px;"
                class="btn">
            <i class="fa fa-arrow-circle-left"></i> <?= lang('general.back'); ?>
        </button>
    </div>
    <div class="col-md-12">
        <?php
        echo Form()->title(lang('member.recommend_letter'))
                ->id('recommend_letter')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.recommend_letter') . " ... ")
                ->fileinput();
        ?>
        <input type="hidden" id="registration_id" name="registration_id" value="<?= $_POST['registration_id']; ?>"/>
    </div>
</div>
<?= Form()->formFooter(''); ?>
<script>
    $(function () {
        $('.alert').remove();
//        postFormAjaxPostSetContent()
        //        postAjaxByAlertFormManual();
        $('#btn-save').attr("class", "btn btn-info");
        $('#btn-save').prepend('<i class="fa fa-save"></i> ');
        $('#btn-reset').attr("class", "btn btn-default");
        $('#btn-save').attr("onclick", "postFormAjaxPostSetContent('<?= URL(IURLMemberConstant::ACTIVITY_REGISTRATION_TEMP_URL . '/' . $activity . '/save-register'); ?>','form-newedit')");
    });
</script>