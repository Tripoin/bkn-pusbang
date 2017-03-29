<?php

use app\Constant\IURLMemberConstant;
use app\Model\TransactionRegistrationDetails;

$regDetail = new TransactionRegistrationDetails();

//print_r($data_reg_detail);
$participant_name = "";
$noidType = "";
$idNumber = "";
$front_degree = "";
$behind_degree = "";
$place_of_birth = "";
$date_of_birth = "";
$religion = "";
$gender = "";
$marital_status = "";
$email = "";
$telephone = "";
$fax = "";
$address = "";
$zip_code = "";
$government_classification = "";
$json_occupation = "";
$degree = "";
$college_name = "";
$college = "";
$faculity = "";
$study_program_name = "";
$study_program = "";
$graduation_year = "";
$registration_detail_id = "";
$province_id = "";
$city_id = "";
$district_id = "";
$village_id = "";
if (!empty($data_reg_detail)) {
    $province_id = $data_reg_detail[0][$regDetail->getProvinceId()];
    $city_id = $data_reg_detail[0][$regDetail->getCityId()];
    $district_id = $data_reg_detail[0][$regDetail->getDistrictId()];
    $village_id = $data_reg_detail[0][$regDetail->getVillageId()];
    $participant_name = $data_reg_detail[0][$regDetail->getName()];
    $noidType = $data_reg_detail[0][$regDetail->getNoidTypeId()];
    $idNumber = $data_reg_detail[0][$regDetail->getIdNumber()];
    $front_degree = $data_reg_detail[0][$regDetail->getFrontDegree()];
    $behind_degree = $data_reg_detail[0][$regDetail->getBehindDegree()];
    $place_of_birth = $data_reg_detail[0][$regDetail->getPob()];
    $date_of_birth = $data_reg_detail[0][$regDetail->getDob()];
    $religion = $data_reg_detail[0][$regDetail->getReligionId()];
    $gender = $data_reg_detail[0][$regDetail->getGender()];
    $marital_status = $data_reg_detail[0][$regDetail->getMaritalStatus()];
    $email = $data_reg_detail[0][$regDetail->getEmail()];
    $telephone = $data_reg_detail[0][$regDetail->getPhoneNumber()];
    $fax = $data_reg_detail[0][$regDetail->getFax()];
    $address = $data_reg_detail[0][$regDetail->getAddress()];
    $zip_code = $data_reg_detail[0][$regDetail->getZipCode()];
    $government_classification = $data_reg_detail[0][$regDetail->getGovernmentClassificationId()];
    $json_occupation = $data_reg_detail[0][$regDetail->getJsonOccupation()];
    $degree = $data_reg_detail[0][$regDetail->getDegree()];
    $college_name = $data_reg_detail[0][$regDetail->getCollege()];
    $college = $data_reg_detail[0][$regDetail->getCollegeId()];
    $faculity = $data_reg_detail[0][$regDetail->getFaculity()];
    $study_program_name = $data_reg_detail[0][$regDetail->getStudyProgram()];
    $study_program = $data_reg_detail[0][$regDetail->getStudyProgramId()];
    $graduation_year = $data_reg_detail[0][$regDetail->getGraduationYear()];
    $registration_detail_id = $data_reg_detail[0][$regDetail->getId()];
}
?>

<?= Form()->formHeader(); ?>
<div class="row">
    <div class="col-md-12" style="margin-bottom: 20px;">
        <button id="buttonBack" title="" rel="tooltip" class="btn btn-danger btn-sm pull-right" 
                type="submit" onsubmit="return false;" onclick="postAjaxPaginationManual('pageListParticipant');" 
                style="margin-left: 10px;" data-original-title="<?= lang('general.back'); ?>">
            <i class="fa fa-arrow-circle-left"></i> <?= lang('general.back'); ?>        
        </button>
    </div>
    <div class="col-md-12">
        <?php
        echo Form()
                ->title(lang('member.participant_name'))
                ->id('participant_name')
                ->formLayout('form-horizontal')
                ->value($participant_name)
                ->placeholder(lang('member.participant_name') . " ... ")
                ->textbox();
        $idNumber = '<div class="row">'
                . '<div class="col-md-9">' . Form()
                        ->title(lang('member.no_id'))
                        ->id('idNumber')
                        ->onlyComponent(true)
                        ->value($idNumber)
                        ->placeholder(lang('member.no_id') . " ... ")
                        ->textbox() . '</div>';
        $noType = '<div class="col-md-3">' . Form()->id('noidType')
                        ->onlyComponent(true)
                        ->autocomplete(false)
                        ->value($noidType)
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
                ->value($front_degree)
                ->id('front_degree')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.front_degree') . " ... ")
                ->textbox();
        echo Form()
                ->title(lang('member.behind_degree'))
                ->id('behind_degree')
                ->value($behind_degree)
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.behind_degree') . " ... ")
                ->textbox();
        echo Form()
                ->title(lang('member.place_of_birth'))
                ->value($place_of_birth)
                ->id('place_of_birth')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.place_of_birth') . " ... ")
                ->textbox();
        echo Form()->value($date_of_birth)
                ->title(lang('member.date_of_birth'))
                ->id('date_of_birth')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.date_of_birth') . " ... ")
                ->datepicker();
        echo Form()->id('religion')->title(lang('member.religion'))
                ->autocomplete(false)->value($religion)
                ->formLayout('form-horizontal')
                ->data($data_religion)
                ->combobox();
        echo Form()->id('gender')->title(lang('member.gender'))
                ->autocomplete(false)->value($gender)
                ->formLayout('form-horizontal')
                ->data($data_gender)
                ->radiobox();
        echo Form()->id('marital_status')->title(lang('member.marital_status'))
                ->autocomplete(false)->value($marital_status)
                ->formLayout('form-horizontal')
                ->data($data_marital_status)
                ->radiobox();
        echo Form()->value($email)
                ->title(lang('member.email'))
                ->id('email')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.email') . " ... ")
                ->textbox();
        echo Form()->value($telephone)
                ->title(lang('member.telephone'))
                ->id('telephone')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.telephone') . " ... ")
                ->textbox();
        echo Form()->value($faculity)
                ->title(lang('member.fax'))
                ->id('fax')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.fax') . " ... ")
                ->textbox();
        echo Form()->value($address)
                ->title(lang('member.address'))
                ->id('address')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.address') . " ... ")
                ->textarea();
        echo Form()->id('province')->placeholder('Selected ....')
                ->title(lang('member.province'))
                ->autocomplete(true)
                ->data($data_province)
                ->value($data_reg_detail[0][$regDetail->getProvinceId()])
                ->formLayout('form-horizontal')
                ->attr('onchange="ajaxCombobox(\'province\',\'' . URL('selected?action=city') . '\', \'city\', \'\',\''.$city_id.'\');"')
                ->combobox();
        echo Form()->id('city')->placeholder('Selected ....')
                ->title(lang('member.city'))
                ->autocomplete(false)
                ->formLayout('form-horizontal')
                ->attr('onchange="ajaxCombobox(\'city\',\'' . URL('selected?action=district') . '\', \'district\', \'\',\''.$district_id.'\');"')
                ->combobox();
        echo Form()->id('district')->placeholder('Selected ....')
                ->title(lang('member.district'))
                ->autocomplete(false)
                ->value($data_reg_detail[0][$regDetail->getDistrictId()])
                ->formLayout('form-horizontal')
                ->attr('onchange="ajaxCombobox(\'district\',\'' . URL('selected?action=village') . '\', \'village\', \'\',\''.$village_id.'\');"')
                ->combobox();
        echo Form()->id('village')->placeholder('Selected ....')
                ->title(lang('member.village'))
                ->autocomplete(false)
                ->value($data_reg_detail[0][$regDetail->getVillageId()])
                ->formLayout('form-horizontal')
                ->combobox();


        echo Form()->value($zip_code)
                ->title(lang('member.zip_code'))
                ->id('zip_code')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.zip_code') . " ... ")
                ->textbox();
        echo Form()->id('government_classification')->title(lang('member.government_classification'))
                ->autocomplete(false)->value($government_classification)
                ->formLayout('form-horizontal')
                ->data($data_government_class)
                ->combobox();
        echo Form()->value($json_occupation)
                ->title(lang('member.json_occupation'))
                ->id('json_occupation')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.json_occupation') . " ... ")
                ->textbox();
        echo Form()->value($degree)
                ->title(lang('member.degree'))
                ->id('degree')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.degree') . " ... ")
                ->textbox();
        echo Form()->id('college')->title(lang('member.college'))
                ->formLayout('form-horizontal')
                ->setclass('fa fa-eye')
                ->value($college)->valueName($college_name)
                ->tooltipTitleButton(lang('general.view'))
                ->openLOV();
        echo Form()->value($faculity)
                ->title(lang('member.faculity'))
                ->id('faculity')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.faculity') . " ... ")
                ->textbox();
        echo Form()->id('study_program')
                ->title(lang('member.study_program'))
                ->formLayout('form-horizontal')
                ->setclass('fa fa-eye')
                ->value($study_program)->valueName($study_program_name)
                ->tooltipTitleButton(lang('general.view'))
//                ->data($data_study_program)
                ->openLOV();
        echo Form()->value($graduation_year)
                ->title(lang('member.graduation_year'))
                ->id('graduation_year')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.graduation_year') . " ... ")
                ->textbox();
        ?>
        <input type="hidden" id="id" name="id" value="<?= $id; ?>"/>
    </div>
</div>
<?= Form()->formFooter(''); ?>
<script>
    $(function () {
        $('#province').change();
        $('.alert').remove();
//        postFormAjaxPostSetContent()
        //        postAjaxByAlertFormManual();
        $('#btn-save').attr("class", "btn btn-info");
        $('#btn-save').prepend('<i class="fa fa-save"></i> ');
        $('#btn-reset').attr("class", "btn btn-default");
        $('#btn-save').attr("onclick", "postFormAjaxPostSetContent('<?= URL(IURLMemberConstant::LIST_PARTICIPANT_UPDATE_URL); ?>','form-newedit')");
    });
</script>