<?php

use app\Model\MasterSubject;
use app\Model\MasterGovernmentAgency;
use app\Model\MasterWorkingUnit;
use app\Model\MasterParticipantType;
use app\Util\Database;

$db = new Database();

$masterSubject = new MasterSubject();
$masterGovernmentAgency = new MasterGovernmentAgency();
$masterWorkingUnit = new MasterWorkingUnit();
$masterParticipantType = new MasterParticipantType();
$data_subject = valueComboBoxParent($masterSubject->getEntity(), $masterSubject->getId(), $masterSubject->getName(), $masterSubject->getParentId());

$gov = $db->selectByID($masterGovernmentAgency);
$data_gov = convertJsonCombobox($gov, $masterGovernmentAgency->getId(), $masterGovernmentAgency->getName());

$working_unit = $db->selectByID($masterWorkingUnit);
$data_working_unit = convertJsonCombobox($working_unit, $masterWorkingUnit->getId(), $masterWorkingUnit->getName());

$participant_type = $db->selectByID($masterParticipantType);
$data_participant_type = convertJsonCombobox($participant_type, $masterParticipantType->getId(), $masterParticipantType->getName());



//echo json_encode($data_subject);
//echo $t;
?>
<?php include_once getTemplatePath('page/content-page.html.php'); ?>
<div id="form-message">
</div>
<form role="form" id="form-newedit" action="#" onsubmit="return false;" method="POST" novalidate="novalidate">

    <div class="signup">
        <div class="row">
            <div class="col-md-12">
                <legend>
                    <?= lang('general.message_register_have_account'); ?> 
                    <button type="button" class="btn btn-danger btn-sm"  onclick="ajaxPostModal('<?= URL('member/login'); ?>', '<?= lang('general.sign_in'); ?>')"><?= lang('general.sign_in'); ?></button>
                </legend>
            </div>
            <div class="col-md-6">
                <?php
                echo $Form->id('subject_name')->placeholder('Selected ....')
                        ->title(lang('member.subject_name'))
                        ->data($data_subject)
                        ->combobox();
                ?>
                <?php
                echo Form()->id('recommend_letter')->placeholder(lang('member.recommend_letter') . ' ....')
                        ->title(lang('member.recommend_letter'))
                        ->fileinput();
                ?>
                <?php
                echo $Form->id('pic_name')->placeholder(lang('member.pic_name') . ' ....')
                        ->title(lang('member.pic_name'))
                        ->textbox();
                ?>
                <?php
                echo $Form->id('pic_email')->placeholder(lang('member.pic_email') . ' ....')
                        ->title(lang('member.pic_email'))
                        ->textbox();
                ?>
                <?php
                echo $Form->id('pic_telephone')->placeholder(lang('member.pic_telephone') . ' ....')
                        ->title(lang('member.pic_telephone'))
                        ->textbox();
                ?>
                <?php
                echo $Form->id('pic_fax')->placeholder(lang('member.pic_fax') . ' ....')
                        ->title(lang('member.pic_fax'))
                        ->required(false)
                        ->textbox();
                ?>
                <?php
//                $data_radio = array(
//                    array("id" => "1", "label" => "Instansi Pemerintahan"),
//                    array("id" => "2", "label" => "Individu")
//                );
                echo Form()->id('participant_category')->placeholder(lang('member.participant_category') . ' ....')
                        ->title(lang('member.participant_category'))
                        ->data($data_participant_type)
                        ->value(1)
                        ->attr('onchange="changeCategoryParticipant(this)"')
                        ->radiobox();
                ?>


            </div>
            <div class="col-md-6">
                <?php
                echo $Form->id('pic_address')->placeholder(lang('member.pic_address') . ' ....')
                        ->title(lang('member.pic_address'))
                        ->required(false)
                        ->textbox();
                ?>
                <?php
                echo Form()->id('province')->placeholder('Selected ....')
                        ->title(lang('member.province'))
                        ->autocomplete(false)
                        ->attr('onchange="ajaxComboboxProvince(\'province\',\'' . URL('selected?action=city') . '\', \'city\', \'\');"')
                        ->combobox();
                ?>
                <?php
                echo Form()->id('city')->placeholder('Selected ....')
                        ->title(lang('member.city'))
                        ->autocomplete(false)
                        ->attr('onchange="ajaxComboboxProvince(\'city\',\'' . URL('selected?action=district') . '\', \'district\', \'\');"')
                        ->combobox();
                ?>
                <?php
                echo Form()->id('district')->placeholder('Selected ....')
                        ->title(lang('member.district'))
                        ->autocomplete(false)
                        ->attr('onchange="ajaxComboboxProvince(\'district\',\'' . URL('selected?action=village') . '\', \'village\', \'\');"')
                        ->combobox();
                ?>
                <?php
                echo Form()->id('village')->placeholder('Selected ....')
                        ->title(lang('member.village'))
                        ->autocomplete(false)
                        ->combobox();
                ?>
                <?php
                echo $Form->id('zip_code')->placeholder(lang('member.zip_code') . ' ....')
                        ->title(lang('member.zip_code'))
                        ->textbox();
                ?>


            </div>
            <div class="col-md-12" id="pageInstansi">
                <div class="panel panel-default">
                    <div class="panel-heading"><?= lang('member.government_agencies'); ?></div>
                    <div class="panel-body">
                        <div class="col-md-6">
                            <?php
                            echo Form()->id('working_unit')->placeholder(lang('member.working_unit') . ' ....')
                                    ->title(lang('member.working_unit'))
                                    ->data($data_working_unit)
                                    ->attr('onchange="openBlankField(this,\'working_unit\')"')
                                    ->combobox();
                            ?>
                            <?php
                            echo Form()->id('government_agencies')->placeholder(lang('member.government_agencies') . ' ....')
                                    ->title(lang('member.government_agencies'))
                                    ->data($data_gov)
                                    ->attr('onchange="openBlankField(this,\'government_agencies\')"')
                                    ->combobox();
                            ?>
                            <?php
                            echo Form()->id('office_telephone')->placeholder(lang('member.office_telephone') . ' ....')
                                    ->title(lang('member.office_telephone'))
                                    ->textbox();
                            ?>
                            <?php
                            echo Form()->id('office_fax')->placeholder(lang('member.office_fax') . ' ....')
                                    ->title(lang('member.office_fax'))
                                    ->textbox();
                            ?>
                            <?php
                            echo Form()->id('pic_address')->placeholder(lang('member.pic_address') . ' ....')
                                    ->title(lang('member.pic_address'))
                                    ->textarea();
                            ?>
                        </div>
                        <div class="col-md-6">

                            <?php
                            echo Form()->id('province_instansi')->placeholder('Selected ....')
                                    ->title(lang('member.province'))
                                    ->autocomplete(false)
                                    ->attr('onchange="ajaxComboboxProvince(\'province_instansi\',\'' . URL('selected?action=city') . '\', \'city_instansi\', \'\');"')
                                    ->combobox();
                            ?>
                            <?php
                            echo Form()->id('city_instansi')->placeholder('Selected ....')
                                    ->title(lang('member.city'))
                                    ->autocomplete(false)
                                    ->attr('onchange="ajaxComboboxProvince(\'city_instansi\',\'' . URL('selected?action=district') . '\', \'district_instansi\', \'\');"')
                                    ->combobox();
                            ?>
                            <?php
                            echo Form()->id('district_instansi')->placeholder('Selected ....')
                                    ->title(lang('member.district'))
                                    ->autocomplete(false)
                                    ->attr('onchange="ajaxComboboxProvince(\'district_instansi\',\'' . URL('selected?action=village') . '\', \'village_instansi\', \'\');"')
                                    ->combobox();
                            ?>
                            <?php
                            echo Form()->id('village_instansi')->placeholder('Selected ....')
                                    ->title(lang('member.village'))
                                    ->autocomplete(false)
                                    ->combobox();
                            ?>
                            <?php
                            echo $Form->id('post_code')->placeholder(lang('member.zip_code') . ' ....')
                                    ->title(lang('member.zip_code'))
                                    ->textbox();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <?php echo $Form->id('subject')->alignLabel('right')->title(lang('general.subject'))->placeholder(lang('general.subject') . ' ....')->textbox(); ?>
                    <?php echo $Form->id('message')->alignLabel('right')->title(lang('general.message'))->placeholder(lang('general.message') . ' ....')->textarea(); ?>
                    <?php
                    echo Form()->id('security_code')
                            ->alignLabel('right')->title(lang('general.security_code'))
                            ->placeholder(lang('general.security_code') . ' ....')->captcha();
                    ?>
                </div>
            </div>
            <div class="col-md-12">
                <button type="button" class="btn btn-danger" onclick="postRegisterMember('<?= URL('member/register/proses'); ?>', 'form-newedit')"><?= lang('general.sign_up'); ?></button>
            </div>
        </div>
    </div>
    
</form>
<script>
    $(function () {
//        location.reload(true);
        ajaxComboboxProvince('province_instansi', '<?= URL('selected?action=province'); ?>', 'province_instansi', '');
        ajaxComboboxProvince('province', '<?= URL('selected?action=province'); ?>', 'province', '');
        $('[rel="tooltip"]').tooltip();
//        $('#city').select2();
//        jQuery(document).on("keyup",".select2-input", function (event) { alert(jQuery(this).val()); });
        $('#pageInstansi').hide();
        $('#compgovernment_agencies').append('<input type="text" placeholder="Kosongkan jika ada pada pilihan ..." class="form-control" id="government_agencies_2">');
        $('#compworking_unit').append('<input type="text" placeholder="Kosongkan jika ada pada pilihan ..." class="form-control" id="working_unit_2">');
    });

    function changeCategoryParticipant(e) {
        if (e.value == 2) {
            $('#pageInstansi').show();
        } else {
            $('#pageInstansi').hide();
        }
    }

    function openBlankField(e, id) {
        if (e.value == "") {
            $('#comp' + id).append('<input type="text" placeholder="Kosongkan jika ada pada pilihan ..." class="form-control" id="' + id + '_2">');
        } else {
            $('#' + id + '_2').remove();
        }
    }

    function ajaxComboboxProvince(parent, page, target, value) {
        $('#' + target).html('');

        var search = $('#' + parent).val();
        var txt = '&search=' + search;
        $.ajax({
            type: "POST",
            url: page + txt,
            data: value,
            success: function (data) {
//                console.log(data);
                var result = JSON.parse(data);

                $('#' + target).select2({
                    data: result
                });
            },
            error: function (data) {
                console.log(data);
//                $('#' + target).html(data.responseText);
            },
        });
    }
</script>
<?php include_once getTemplatePath('page/end-content-page.html.php'); ?>