<?php

use app\Model\MasterGovernmentAgencies;
use app\Model\MasterUserMain;
use app\Model\MasterWorkingUnit;
use app\Model\MasterAddress;
use app\Model\MasterContact;
use app\Model\SecurityUserProfile;
use app\Model\SecurityUser;
use app\Model\MasterGovernmentClassification;
use app\Util\Database;

$db = new Database();
$db->connect();
$masterAddress = new MasterAddress();
$masterContact = new MasterContact();
$masterWorkingUnit = new MasterWorkingUnit();
$masterGovernmentAgency = new MasterGovernmentAgencies();
$masterUserMain = new MasterUserMain();
$securityUser = new SecurityUser();
$securityUserProfile = new SecurityUserProfile();
$masterGovernmentClassification = new MasterGovernmentClassification();

$data_government_class = getLov($masterGovernmentClassification);
$government_name = "";
$encode_data_government = "";
//echo $encode_data_government; 
?>
<form id="form-newedit" action="<?= URL('/page/member/user-profile/save') ?>" method="POST" class="form" onsubmit="return false;">
    <div id="form-message"></div>
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#accountTab" data-toggle="tab"><?= lang('general.your_personal_details'); ?></a></li>
        <li role="presentation"><a href="#contactTab" data-toggle="tab"><?= lang('general.your_contact'); ?></a></li>
        <li role="presentation"><a href="#educationTab" data-toggle="tab"><?= lang('general.your_education'); ?></a></li>
        <li role="presentation"><a href="#companyTab" data-toggle="tab"><?= lang('general.your_company'); ?></a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="accountTab">
            <fieldset id="account">

                <?= Form()->id('participant_name')->value($userMember[$up->getEntity()][$up->getName()])->title(lang('member.participant_name'))->placeholder(lang('member.participant_name') . ' ....')->textbox(); ?>
                <?php
                $idNumber = '<div class="row">'
                        . '<div class="col-md-9">' . Form()
                                ->title(lang('member.no_id'))
                                ->id('idNumber')
                                ->onlyComponent(true)
                                ->value($userMember[$masterUserMain->getEntity()][$masterUserMain->getIdNumber()])
                                ->placeholder(lang('member.no_id') . " ... ")
                                ->textbox() . '</div>';
                $noType = '<div class="col-md-3">' . Form()->id('noidType')
                                ->onlyComponent(true)
                                ->autocomplete(false)
                                ->value($userMember[$masterUserMain->getEntity()][$masterUserMain->getNoIdTypeId()])
                                ->data($data_noid_type)
                                ->combobox() . '</div></div>';
                echo Form()->required(true)
                        ->label(lang('member.no_id'))
                        ->title(lang('member.no_id'))
                        ->formGroup($idNumber . $noType);
                echo Form()
                        ->title(lang('member.front_degree'))
                        ->required(false)
                        ->value($userMember[$masterUserMain->getEntity()][$masterUserMain->getFront_degree()])
                        ->id('front_degree')
                        ->placeholder(lang('member.front_degree') . " ... ")
                        ->textbox();
                echo Form()
                        ->title(lang('member.behind_degree'))
                        ->id('behind_degree')
                        ->value($userMember[$masterUserMain->getEntity()][$masterUserMain->getBehind_degree()])
                        ->placeholder(lang('member.behind_degree') . " ... ")
                        ->textbox();
                echo Form()
                        ->title(lang('member.place_of_birth'))
                        ->value($userMember[$securityUserProfile->getEntity()][$securityUserProfile->getPlace()])
                        ->id('place_of_birth')
                        ->placeholder(lang('member.place_of_birth') . " ... ")
                        ->textbox();
                echo Form()->value($userMember[$securityUserProfile->getEntity()][$securityUserProfile->getBirthdate()])
                        ->title(lang('member.date_of_birth'))
                        ->id('date_of_birth')
                        ->placeholder(lang('member.date_of_birth') . " ... ")
                        ->datepicker();
                echo Form()->id('religion')->title(lang('member.religion'))
                        ->autocomplete(false)->value($userMember[$securityUserProfile->getEntity()][$securityUserProfile->getReligionId()])
                        ->data($data_religion)
                        ->combobox();
                echo Form()->id('gender')->title(lang('member.gender'))
                        ->autocomplete(false)->value($userMember[$securityUserProfile->getEntity()][$securityUserProfile->getGender()])
                        ->data($data_gender)
                        ->radiobox();
                echo Form()->id('maritalStatus')->title(lang('member.marital_status'))
                        ->autocomplete(false)->value($userMember[$securityUserProfile->getEntity()][$securityUserProfile->getMarriage()])
                        ->data($data_maritalStatus)
                        ->radiobox();
                ?>

            </fieldset>
        </div>
        <div class="tab-pane" id="contactTab">
            <fieldset id="contactLayout">
                <?= Form()->id('email')->value($userMember[$su->getEntity()][$su->getEmail()])->title(lang('general.email'))->placeholder(lang('general.email') . ' ....')->textbox(); ?>
                <?php
                echo Form()->value($userMember[$masterContact->getEntity()][$masterContact->getPhoneNumber1()])
                        ->title(lang('member.telephone'))
                        ->id('telephone')
                        ->placeholder(lang('member.telephone') . " ... ")
                        ->textbox();
                echo Form()->value($userMember[$masterContact->getEntity()][$masterContact->getFax()])
                        ->title(lang('member.fax'))
                        ->id('fax')->required(FALSE)
                        ->placeholder(lang('member.fax') . " ... ")
                        ->textbox();
                ?>
                <?php
                $val_province = null;
                $val_city = null;
                $val_district = null;
                $val_village = null;
                ?>
                <?php
                echo Form()->id('participant_province')->title(lang('general.province'))
                        ->data($data_province)->placeholder(lang('general.province') . ' ....')
                        ->autocomplete(false)->value($userMember[$masterAddress->getEntity()][$masterAddress->getProvinceId()])->required(FALSE)
                        ->attr('onchange="ajaxCombobox(\'participant_province\',\'' . URL('selected?action=city') . '\', \'participant_city\', \'\',\'' . $userMember[$masterAddress->getEntity()][$masterAddress->getCityId()] . '\');"')
                        ->combobox();
                ?>
                <?php
                echo Form()->id('participant_city')->title(lang('general.city'))->placeholder(lang('general.city') . ' ....')
                        ->autocomplete(false)->value($userMember[$masterAddress->getEntity()][$masterAddress->getCityId()])->required(FALSE)
                        ->attr('onchange="ajaxCombobox(\'participant_city\',\'' . URL('selected?action=district') . '\', \'participant_district\', \'\',\'' . $userMember[$masterAddress->getEntity()][$masterAddress->getDistrictId()] . '\');"')
                        ->combobox();
                ?>
                <?php
                echo Form()->id('participant_district')->title(lang('general.district'))->placeholder(lang('general.district') . ' ....')
                        ->autocomplete(false)->value($userMember[$masterAddress->getEntity()][$masterAddress->getDistrictId()])->required(FALSE)
                        ->attr('onchange="ajaxCombobox(\'participant_district\',\'' . URL('selected?action=village') . '\', \'participant_village\', \'\',\'' . $userMember[$masterAddress->getEntity()][$masterAddress->getVillageId()] . '\');"')
                        ->combobox();
                ?>
                <?= Form()->id('participant_village')->required(FALSE)->value($userMember[$masterAddress->getEntity()][$masterAddress->getVillageId()])->title(lang('general.village'))->placeholder(lang('general.village') . ' ....')->combobox(); ?>
                <?= Form()->id('zipCode')->required(FALSE)->value($userMember[$masterAddress->getEntity()][$masterAddress->getZipCode()])->title(lang('general.zipCode'))->placeholder(lang('general.zipCode') . ' ....')->textbox(); ?>

            </fieldset>
        </div>
        <div class="tab-pane" id="educationTab">
            <fieldset id="educationLayout">
                <?php
                echo Form()->id('government_classification')->title(lang('member.government_classification'))
                        ->autocomplete(false)->value($userMember[$masterUserMain->getEntity()][$masterUserMain->getGovernmentClassificationId()])
                        ->data($data_government_class)
                        ->combobox();
                echo Form()->value($userMember[$masterUserMain->getEntity()][$masterUserMain->getJsonOccupation()])
                        ->title(lang('member.json_occupation'))
                        ->id('json_occupation')
                        ->placeholder(lang('member.json_occupation') . " ... ")
                        ->textbox();
                echo Form()->value($userMember[$masterUserMain->getEntity()][$masterUserMain->getDegree()])
                        ->title(lang('member.degree'))
                        ->id('degree')
                        ->placeholder(lang('member.degree') . " ... ")
                        ->textbox();
                echo Form()->id('college')->title(lang('member.college'))
                        ->setclass('fa fa-eye')
                        ->value($userMember[$masterUserMain->getEntity()][$masterUserMain->getCollegeId()])
                        ->valueName($userMember[$masterUserMain->getEntity()][$masterUserMain->getCollege()])
                        ->tooltipTitleButton(lang('general.view'))
                        ->openLOV();
                echo Form()->value($userMember[$masterUserMain->getEntity()][$masterUserMain->getFaculty()])
                        ->title(lang('member.faculity'))
                        ->id('faculity')
                        ->placeholder(lang('member.faculity') . " ... ")
                        ->textbox();
                echo Form()->id('study_program')
                        ->title(lang('member.study_program'))
                        ->setclass('fa fa-eye')
                        ->value($userMember[$masterUserMain->getEntity()][$masterUserMain->getStudyProgramId()])
                        ->valueName($userMember[$masterUserMain->getEntity()][$masterUserMain->getStudyProgram()])
                        ->tooltipTitleButton(lang('general.view'))
//                ->data($data_study_program)
                        ->openLOV();
                echo Form()->value($userMember[$masterUserMain->getEntity()][$masterUserMain->getGraduationYear()])
                        ->title(lang('member.graduation_year'))
                        ->id('graduation_year')
                        ->placeholder(lang('member.graduation_year') . " ... ")
                        ->textbox();
                ?>
            </fieldset>
        </div>
        <div class="tab-pane" id="companyTab">
            <fieldset id="companyLayout">
            </fieldset>
        </div>

    </div>

    <button id="btn_signup" type="submit" onsubmit="return false;" 
            onclick="return postFormAjaxPostSetContent('<?= URL('/page/member/user-profile/save') ?>', 'form-newedit')" class="btn btn-danger"><?= lang('general.save'); ?>
    </button>
</form>


<script>
    $(function () {
        var participantProvince = $('#participant_province');
        var participantCity = $('#participant_city');
        var participantDistrict = $('#participant_district');
        var participantVillage = $('#participant_village');
        $('#participant_province').change();
        participantProvince.attr("onchange", "ajaxCombobox('participant_province', '<?= URL('selected?action=city'); ?>', 'participant_city', '', '<?=$userMember[$masterAddress->getEntity()][$masterAddress->getCityId()];?>');");
        $('#participant_province').change();
        participantCity.attr("onchange", "ajaxCombobox('participant_city', '<?= URL('selected?action=district'); ?>', 'participant_district', '', '<?=$userMember[$masterAddress->getEntity()][$masterAddress->getDistrictId()];?>');");
        $('#participant_city').change();
        participantDistrict.attr("onchange", "ajaxCombobox('participant_district', '<?= URL('selected?action=village'); ?>', 'participant_village', '','<?=$userMember[$masterAddress->getEntity()][$masterAddress->getVillageId()];?>');");
        $('#participant_district').change();

    });

</script>

