
<div id="pageAKDCode">
    <div class="col-md-8">
        <div class="title">
            <p class="lead">
                Masukkan Kode Aktivasi untuk melakukan pengisian AKD yang telah dikirim sebelumnya ke email anda
            </p>
        </div>
        <?= Form()->formHeader(); ?>
        <?php
        echo $Form->id('code_request_akd')->alignLabel('right')
                ->title(lang('general.input') . " " . lang('general.code'))->classComponent('i_box')
                ->formLayout('horizontal')->placeholder(lang('general.code') . ' ....')->textbox();
        ?>
        <?php echo $Form->id('security_code_request_akd')->alignLabel('right')->title(lang('general.security_code'))->classComponent('i_box')->formLayout('horizontal')->placeholder(lang('general.security_code') . ' ....')->captcha(); ?>

        <?= $Form->formFooter(null, '<button type="submit" onclick="postFormAjaxPostSetContent(\'' . URL('akd/submit-check-code') . '\',\'form-newedit\')" class="read_more buttonc">submit</button>'); ?>
        <br/>
        <br/>
    </div>
    <div class="col-md-8">
        <div class="title">
            <p class="lead">
                <a href="javascript:void(0)" onclick="ajaxGetPage('<?= URL('akd/page-email-request-code'); ?>', 'pageAKD')">Kembali</a>

            </p>
        </div>

    </div>
    <script>
        $(function () {
            $('.alert-danger').hide();
        });

    </script>	
</div>