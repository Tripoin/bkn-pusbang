<?php

use app\Model\MasterNoIdType;
use app\Model\MasterLevelQuestionnaire;

$masterNoidType = new MasterNoIdType();
$masterLevelQuestionnaire = new MasterLevelQuestionnaire();
?>
<div class="col-md-8">
    <div class="title">
        <p class="lead">
            Permintaan Kode untuk mengisi AKD dan jika di setujui email anda akan menerima kode tersebut.
        </p>
    </div>
    <?= $Form->formHeader(); ?>
    <?php
    $data_noid_type = getLov($masterNoidType);
    $data_level_questionnaire = getLov($masterLevelQuestionnaire);
    $idNumber = '<div class="row">'
            . '<div class="col-md-9">' . Form()
                    ->title(lang('member.no_id'))
                    ->id('idNumber')
                    ->onlyComponent(true)
                    ->placeholder(lang('member.no_id') . " ... ")
                    ->textbox() . '</div>';
    $noType = '<div class="col-md-3">' . Form()->id('noidType')
                    ->onlyComponent(true)
                    ->autocomplete(false)
                    ->data($data_noid_type)
                    ->combobox() . '</div></div>';
    echo Form()->required(true)
            ->label(lang('member.no_id'))
            ->alignLabel('right')
            ->formLayout('form-horizontal')
            ->title(lang('member.no_id'))
            ->formGroup($idNumber . $noType);
    ?>
    <?php
    echo Form()->id('participant_name_request_akd')->alignLabel('right')
            ->title(lang('general.input') . " " . lang('general.name'))
            ->classComponent('i_box')->formLayout('horizontal')
            ->placeholder(lang('general.name') . ' ....')->textbox();
    ?>
    <?php
    echo Form()->id('email_request_akd')->alignLabel('right')
            ->title(lang('general.input') . " " . lang('general.email'))
            ->classComponent('i_box')->formLayout('horizontal')
            ->placeholder(lang('general.email') . ' ....')->textbox();
    ?>
    <?php
    echo Form()->id('agencies_name_request_akd')->alignLabel('right')
            ->title(lang('general.input') . " " . lang('alumnus.agencies'))
            ->classComponent('i_box')->formLayout('horizontal')
            ->placeholder(lang('alumnus.agencies') . ' ....')->textbox();
    ?>
    <?php
    echo Form()->id('occupation_name_request_akd')->alignLabel('right')
            ->title(lang('general.input') . " " . lang('member.json_occupation'))
            ->classComponent('i_box')->formLayout('horizontal')
            ->placeholder(lang('member.json_occupation') . ' ....')->textbox();
    ?>
    <?php
    echo Form()->id('position_request_akd')->alignLabel('right')
            ->title(lang('general.position_participant_akd'))
            ->classComponent('i_box')->formLayout('horizontal')
            ->autocomplete(false)
            ->data($data_level_questionnaire)
            ->combobox();
    ?>
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