<?php

use app\Model\MasterUserMain;
use app\Model\MasterReligion;
use app\Model\MasterApproval;
use app\Model\MasterApprovalCategory;
use app\Model\MasterWaitingList;
use app\Model\MasterProvince;
use app\Model\MasterGovernmentClassification;
use app\Model\MasterCollege;
use app\Model\MasterWorkingUnit;
use app\Model\MasterStudyProgram;
use app\Model\MasterNoIdType;
use app\Util\Database;

$db = new Database();
$db->connect();

$masterNoidType = new MasterNoIdType();
$masterReligion = new MasterReligion();
$masterProvince = new MasterProvince();
$masterGovernmentClassification = new MasterGovernmentClassification();

$data_noid_type = getLov($masterNoidType);
//        $data_study_program = getLov($masterStudyProgram);
$data_religion = getLov($masterReligion);
$data_province = getLov($masterProvince);
$data_government_class = getLov($masterGovernmentClassification);
$data_gender = [
    array("id" => "M", "label" => lang("general.male")),
    array("id" => "F", "label" => lang("general.female")),
];
$data_marital_status = [
    array("id" => "N", "label" => "Belum Menikah"),
    array("id" => "Y", "label" => "Menikah"),
];

$city_id = 0;
$village_id = 0;
$district_id = 0;
$masterWorkingUnit = new MasterWorkingUnit();
$working_unit = $db->selectByID($masterWorkingUnit);
$data_working_unit = convertJsonCombobox($working_unit, $masterWorkingUnit->getId(), $masterWorkingUnit->getName());
?>
<?= Form()->formHeader(); ?>

<?php
echo Form()
        ->title(lang('member.participant_name'))
        ->id('participant_name')
        ->formLayout('form-horizontal')
        ->placeholder(lang('member.participant_name') . " ... ")
        ->textbox();
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
        ->formLayout('form-horizontal')
        ->title(lang('member.no_id'))
        ->formGroup($idNumber . $noType);
echo Form()
        ->title(lang('member.front_degree'))
        ->required(false)
        ->id('front_degree')
        ->formLayout('form-horizontal')
        ->placeholder(lang('member.front_degree') . " ... ")
        ->textbox();
echo Form()
        ->title(lang('member.behind_degree'))
        ->id('behind_degree')
        ->formLayout('form-horizontal')
        ->placeholder(lang('member.behind_degree') . " ... ")
        ->textbox();
echo Form()
        ->title(lang('member.place_of_birth'))
        ->id('place_of_birth')
        ->formLayout('form-horizontal')
        ->placeholder(lang('member.place_of_birth') . " ... ")
        ->textbox();
echo Form()
        ->title(lang('member.date_of_birth'))
        ->id('date_of_birth')
        ->formLayout('form-horizontal')
        ->placeholder(lang('member.date_of_birth') . " ... ")
        ->datepicker();
echo Form()->id('religion')->title(lang('member.religion'))
        ->autocomplete(false)
        ->formLayout('form-horizontal')
        ->data($data_religion)
        ->combobox();
echo Form()->id('gender')->title(lang('member.gender'))
        ->autocomplete(false)
        ->formLayout('form-horizontal')
        ->data($data_gender)
        ->radiobox();
echo Form()->id('marital_status')->title(lang('member.marital_status'))
        ->autocomplete(false)
        ->formLayout('form-horizontal')
        ->data($data_marital_status)
        ->radiobox();
echo Form()
        ->title(lang('member.email'))
        ->id('email')
        ->formLayout('form-horizontal')
        ->placeholder(lang('member.email') . " ... ")
        ->textbox();
echo Form()
        ->title(lang('member.telephone'))
        ->id('telephone')
        ->formLayout('form-horizontal')
        ->placeholder(lang('member.telephone') . " ... ")
        ->textbox();
echo Form()
        ->title(lang('member.fax'))
        ->id('fax')
        ->formLayout('form-horizontal')
        ->placeholder(lang('member.fax') . " ... ")
        ->textbox();
echo Form()
        ->title(lang('member.address'))
        ->id('address')
        ->formLayout('form-horizontal')
        ->placeholder(lang('member.address') . " ... ")
        ->textarea();
echo Form()->id('province')->placeholder('Selected ....')
        ->title(lang('member.province'))
//        ->autocomplete(false)
        ->data($data_province)
        ->formLayout('form-horizontal')
        ->attr('onchange="ajaxCombobox(\'province\',\'' . URL('selected?action=city') . '\', \'city\', \'\',\'' . $city_id . '\');"')
        ->combobox();
echo Form()->id('city')->placeholder('Selected ....')
        ->title(lang('member.city'))
        ->autocomplete(false)
        ->formLayout('form-horizontal')
        ->attr('onchange="ajaxCombobox(\'city\',\'' . URL('selected?action=district') . '\', \'district\', \'\',\'' . $district_id . '\');"')
        ->combobox();
echo Form()->id('district')->placeholder('Selected ....')
        ->title(lang('member.district'))
        ->autocomplete(false)
        ->formLayout('form-horizontal')
        ->attr('onchange="ajaxCombobox(\'district\',\'' . URL('selected?action=village') . '\', \'village\', \'\',\'' . $village_id . '\');"')
        ->combobox();
echo Form()->id('village')->placeholder('Selected ....')
        ->title(lang('member.village'))
        ->autocomplete(false)
        ->formLayout('form-horizontal')
        ->combobox();


echo Form()
        ->title(lang('member.zip_code'))
        ->id('zip_code')
        ->formLayout('form-horizontal')
        ->placeholder(lang('member.zip_code') . " ... ")
        ->textbox();
echo Form()->id('working_unit')
        ->title(lang('member.working_unit'))
        ->formLayout('form-horizontal')
        ->data($data_working_unit)
        ->combobox();
echo Form()->id('government_classification')->title(lang('member.government_classification'))
        ->autocomplete(false)
        ->formLayout('form-horizontal')
        ->data($data_government_class)
        ->combobox();
echo Form()
        ->title(lang('member.json_occupation'))
        ->id('json_occupation')
        ->formLayout('form-horizontal')
        ->placeholder(lang('member.json_occupation') . " ... ")
        ->textbox();
echo Form()
        ->title(lang('member.degree'))
        ->id('degree')
        ->formLayout('form-horizontal')
        ->placeholder(lang('member.degree') . " ... ")
        ->textbox();
echo Form()->id('college')->title(lang('member.college'))
        ->formLayout('form-horizontal')
        ->setclass('fa fa-eye')
        ->tooltipTitleButton(lang('general.view'))
        ->openLOV();
echo Form()
        ->title(lang('member.faculity'))
        ->id('faculity')
        ->formLayout('form-horizontal')
        ->placeholder(lang('member.faculity') . " ... ")
        ->textbox();
echo Form()
        ->id('study_program')
        ->title(lang('member.study_program'))
        ->formLayout('form-horizontal')
        ->setclass('fa fa-eye')
        ->tooltipTitleButton(lang('general.view'))
//                ->data($data_study_program)
        ->openLOV();
echo Form()
        ->title(lang('member.graduation_year'))
        ->id('graduation_year')
        ->formLayout('form-horizontal')
        ->placeholder(lang('member.graduation_year') . " ... ")
        ->textbox();

?>

<?= Form()->formFooter(null,null,"postFormAjaxPostSetContent('".$this->insertUrl."','form-message');"); ?>
<script>
    $(function () {
//        postFormAjaxPostSetContent();
        $('#province').change();
    });
</script>