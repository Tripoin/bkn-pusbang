<div class="col-md-12">
    <button id="buttonBack" title="" rel="tooltip" class="btn btn-danger btn-sm pull-right" 
            type="submit" onsubmit="return false;" onclick="postAjaxPaginationManual('pageListParticipant');" 
            style="margin-left: 10px;" data-original-title="<?=lang('general.back');?>">
            <i class="fa fa-arrow-circle-left"></i> <?=lang('general.back');?>        
    </button>
</div>
<div class="col-md-12">
    <?=Form()->formLayout(HORIZONTAL)->id('participant_name')->title(lang('member.participant_name'))
                    ->label($data[0][$transactionRegistrationDetails->getFrontDegree()].' '.$data[0][$transactionRegistrationDetails->getName()].' '.$data[0][$transactionRegistrationDetails->getBehindDegree()])->labels();?>
    <?=Form()->formLayout(HORIZONTAL)->id('no_id')->title(lang('member.no_id'))->label($data[0][$transactionRegistrationDetails->getIdNumber()])->labels();?>
    <?=Form()->formLayout(HORIZONTAL)->title(lang('member.place_birth_of_date'))
            ->label($data[0][$transactionRegistrationDetails->getPob()].', '.$data[0][$transactionRegistrationDetails->getDob()])->labels();?>
    <?=Form()->formLayout(HORIZONTAL)->title(lang('member.religion'))->label($this->data_religion[0]->label)->labels();?>
    <?=Form()->formLayout(HORIZONTAL)->title(lang('member.gender'))->label(convertGender($data[0][$transactionRegistrationDetails->getGender()]))->labels();?>
    <?=Form()->formLayout(HORIZONTAL)->title(lang('member.marital_status'))->label(convertMaritalStatus($data[0][$transactionRegistrationDetails->getMaritalStatus()]))->labels();?>
    <?=Form()->formLayout(HORIZONTAL)->title(lang('member.email'))->label($data[0][$transactionRegistrationDetails->getEmail()])->labels();?>
    <?=Form()->formLayout(HORIZONTAL)->title(lang('member.telephone'))->label($data[0][$transactionRegistrationDetails->getPhoneNUmber()])->labels();?>
    <?=Form()->formLayout(HORIZONTAL)->title(lang('member.fax'))->label($data[0][$transactionRegistrationDetails->getFax()])->labels();?>
    <?=Form()->formLayout(HORIZONTAL)->title(lang('member.province'))->label($this->data_province[0]->label)->labels();?>
    <?=Form()->formLayout(HORIZONTAL)->title(lang('member.city'))->label($this->data_city[0]->label)->labels();?>
    <?=Form()->formLayout(HORIZONTAL)->title(lang('member.district'))->label($this->data_district[0]->label)->labels();?> 
    <?=Form()->formLayout(HORIZONTAL)->title(lang('member.village'))->label($this->data_village[0]->label)->labels();?>
    <?=Form()->formLayout(HORIZONTAL)->title(lang('member.zip_code'))->label($data[0][$transactionRegistrationDetails->getZipCode()])->labels();?>
    <?=Form()->formLayout(HORIZONTAL)->title(lang('member.government_classification'))->label($this->data_government_classification[0]->label)->labels();?>
    <?=Form()->formLayout(HORIZONTAL)->title(lang('member.json_occupation'))->label($data[0][$transactionRegistrationDetails->getJsonOccupation()])->labels();?>
    <?=Form()->formLayout(HORIZONTAL)->title(lang('member.college'))->label($data[0][$transactionRegistrationDetails->getCollege()])->labels();?>
    <?=Form()->formLayout(HORIZONTAL)->title(lang('member.faculity'))->label($data[0][$transactionRegistrationDetails->getFaculity()])->labels();?>
    <?=Form()->formLayout(HORIZONTAL)->title(lang('member.study_program'))->label($data[0][$transactionRegistrationDetails->getStudyProgram()])->labels();?>
    <?=Form()->formLayout(HORIZONTAL)->title(lang('member.graduation_year'))->label($data[0][$transactionRegistrationDetails->getGraduationYear()])->labels();?>
    
</div>