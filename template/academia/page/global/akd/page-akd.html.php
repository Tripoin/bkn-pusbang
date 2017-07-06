
<div class="col-md-8">
    <div class="title">
        <p class="lead">
            AKD 
        </p>
    </div>
    <?= $Form->formHeader(); ?>
    <?php echo $Form->id('email_request_akd')->alignLabel('right')->title(lang('general.input') . " " . lang('general.email'))->classComponent('i_box')->formLayout('horizontal')->placeholder(lang('general.email') . ' ....')->textbox(); ?>
    <?php echo $Form->id('security_code_request_akd')->alignLabel('right')->title(lang('general.security_code'))->classComponent('i_box')->formLayout('horizontal')->placeholder(lang('general.security_code') . ' ....')->captcha(); ?>

    <?= $Form->formFooter(null, '<button type="submit" onclick="postFormAjaxPostSetContent(\'' . FULLURL('submit-code') . '\',\'form-newedit\')" class="read_more buttonc">submit</button>'); ?>
    <br/>
    <br/>
</div>
<div class="col-md-8">
    <div class="title">
        <p class="lead">
            <a href="javascript:void(0)" onclick="ajaxGetPage('<?= URL('akd/page-request-code'); ?>', 'pageAKD')">Klik link ini jika sudah mempunyai kode yang dikirimkan dari pihak Pusbang ASN</a>
        </p>
    </div>

</div>
<script>
    $(function () {
        $('.alert-danger').hide();
    });

</script>