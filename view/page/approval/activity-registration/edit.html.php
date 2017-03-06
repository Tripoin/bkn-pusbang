<?php

use app\Constant\IURLConstant;
?>
<?= Form()->formHeader(); ?>
<?php
if (!is_null($dt_approval[0][$masterApproval->getStatus()])) {
    if ($dt_approval[0][$masterApproval->getStatus()] == 1) {
        echo resultPageMsg('warning', lang('transaction.data_have_approved'), '');
    } else {
        echo resultPageMsg('warning', lang('transaction.data_have_rejected'), $dt_waiting_list[0][$masterWaitingList->getApprovedMessage()]);
    }
}
?>
<div class="row">
    <div class="col-md-6">
        <?php
        echo Form()
                ->attr('style="width:50%;"')
                ->title(lang('transaction.subject_name'))
                ->label($data_subject[0]['label'])
                ->formLayout('horizontal')->labels();

        echo Form()
                ->attr('style="width:50%;"')
                ->title(lang('transaction.execution_time'))
                ->label($dt_activity[0][$m_act->getStartActivity()] . " - " . $dt_activity[0][$m_act->getEndActivity()])
                ->formLayout('horizontal')->labels();

        echo Form()
                ->attr('style="width:50%;"')
                ->title(lang('transaction.participant_category'))
                ->label($dt_participant_type[0][$m_participant_type->getName()])
                ->formLayout('horizontal')->labels();

        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.working_unit'))
                ->label($dt_working_unit[0][$m_working_unit->getName()])
                ->formLayout('horizontal')->labels();

        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.instansi'))
                ->label($dt_gov_agencies[0][$m_gov_agencies->getName()])
                ->formLayout('horizontal')->labels();

        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.participant_name'))
                ->label($dt_user_main[0][$m_user_main->getFront_degree()] . " " . $dt_user_main[0][$m_user_main->getName()] . " " . $dt_user_main[0][$m_user_main->getBehind_degree()])
                ->formLayout('horizontal')->labels();

        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.no_id'))
                ->label($dt_user_main[0][$m_user_main->getIdNumber()])
                ->formLayout('horizontal')->labels();

        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.place_of_birth'))
                ->label($dt_user_profile[0][$userProfile->getPlace()])
                ->formLayout('horizontal')->labels();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.birthdate'))
                ->label(subMonth($dt_user_profile[0][$userProfile->getBirthdate()]))
                ->formLayout('horizontal')->labels();


        $religionName = "";
        if (isset($dt_religion[0][$masterReligion->getName()])) {
            $religionName = $dt_religion[0][$masterReligion->getName()];
        }
        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.religion'))
                ->label($religionName)
                ->formLayout('horizontal')->labels();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.gender'))
                ->label(convertGender($dt_user_profile[0][$userProfile->getGender()]))
                ->formLayout('horizontal')->labels();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.status'))
                ->label($dt_user_profile[0][$userProfile->getMarriage()])
                ->formLayout('horizontal')->labels();
        $email = "";
        if (isset($dt_contact[0][$masterContact->getEmail1()])) {
            $email = $dt_contact[0][$masterContact->getEmail1()];
        }
        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.email'))
                ->label($email)
                ->formLayout('horizontal')->labels();
        $fax = "";
        if (isset($dt_contact[0][$masterContact->getFax()])) {
            $fax = $dt_contact[0][$masterContact->getFax()];
        }
        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.fax'))
                ->label($fax)
                ->formLayout('horizontal')->labels();
        $phoneNumber = "";
        if (isset($dt_contact[0][$masterContact->getPhoneNumber1()])) {
            $phoneNumber = $dt_contact[0][$masterContact->getPhoneNumber1()];
        }
        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.telephone'))
                ->label($phoneNumber)
                ->formLayout('horizontal')->labels();
        ?>
    </div>
    <div class="col-md-6">
        <?php
        $address = "";
        if (isset($dt_address[0][$masterAddress->getName()])) {
            $address = $dt_address[0][$masterAddress->getName()];
        }
        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.address'))
                ->label($address)
                ->formLayout('horizontal')->labels();

        $province = "";
        if (isset($dt_province[0][$masterProvince->getName()])) {
            $province = $dt_province[0][$masterProvince->getName()];
        }
        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.province'))
                ->label($province)
                ->formLayout('horizontal')->labels();

        $city = "";
        if (isset($dt_city[0][$masterCity->getName()])) {
            $city = $dt_city[0][$masterCity->getName()];
        }
        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.city'))
                ->label($city)
                ->formLayout('horizontal')->labels();

        $district = "";
        if (isset($dt_district[0][$masterDistrict->getName()])) {
            $district = $dt_district[0][$masterDistrict->getName()];
        }
        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.district'))
                ->label($district)
                ->formLayout('horizontal')->labels();

        $village = "";
        if (isset($dt_village[0][$masterVillage->getName()])) {
            $village = $dt_village[0][$masterVillage->getName()];
        }
        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.village'))
                ->label($village)
                ->formLayout('horizontal')->labels();

        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.postal_code'))
                ->label($dt_address[0][$masterAddress->getZipCode()])
                ->formLayout('horizontal')->labels();

        $govClass = "";
        if (isset($dt_gov_class[0][$mGovClass->getName()])) {
            $govClass = $dt_gov_class[0][$mGovClass->getName()];
        }
        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.class'))
                ->label($govClass)
                ->formLayout('horizontal')->labels();

        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.position'))
                ->label($dt_user_main[0][$m_user_main->getJsonOccupation()])
                ->formLayout('horizontal')->labels();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.degree'))
                ->label($dt_user_main[0][$m_user_main->getDegree()])
                ->formLayout('horizontal')->labels();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.school/university'))
                ->label($dt_user_main[0][$m_user_main->getCollege()])
                ->formLayout('horizontal')->labels();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.faculty'))
                ->label($dt_user_main[0][$m_user_main->getFaculty()])
                ->formLayout('horizontal')->labels();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.study_program'))
                ->label($dt_user_main[0][$m_user_main->getStudyProgram()])
                ->formLayout('horizontal')->labels();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.graduation_year'))
                ->label($dt_user_main[0][$m_user_main->getGraduationYear()])
                ->formLayout('horizontal')->labels();
        ?>
    </div>
</div>
<?php
if (is_null($dt_approval[0][$masterApproval->getStatus()])) {
    ?>
    <button id="btn_signup" class="btn btn-warning" type="submit" 
            onsubmit="return false;" onclick="ajaxPostModalManual('<?= URL(getAdminTheme() . IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/' . $dt_activity[0][$m_act->getId()] . '/reject-detail'); ?>', 'approval_category_id=3id=<?= $dt_waiting_list[0][$masterWaitingList->getId()]; ?>&user_main_id=<?= $dt_user_main[0][$m_user_main->getId()]; ?>')" 
            >
        <i class="fa fa-times"></i> <?= lang('general.reject'); ?>
    </button>

    <button id="btn_signup" class="btn btn-success" type="submit" 
            onsubmit="return false;"
            alert-title="<?= lang('general.approve'); ?>"
            alert-message="<?= lang('member.notif_approved_candidates'); ?><?= $dt_user_main[0][$m_user_main->getFront_degree()] . " " . $dt_user_main[0][$m_user_main->getName()] . " " . $dt_user_main[0][$m_user_main->getBehind_degree()]; ?>"
            alert-button-title="<?= lang('member.yes'); ?>"
            onclick="postAjaxByAlertManual(this, '<?= URL(getAdminTheme() . IURLConstant::APPROVAL_ACTIVITY_REGISTRATION_INDEX_URL . '/' . $dt_activity[0][$m_act->getId()] . '/approve'); ?>', 'approval_category_id=3&id=<?= $dt_waiting_list[0][$masterWaitingList->getId()]; ?>&user_main_id=<?= $dt_user_main[0][$m_user_main->getId()]; ?>')" 
            >
        <i class="fa fa-thumbs-up"></i> <?= lang('general.approve'); ?>
    </button>
<?php } ?>
<input type="hidden" id="id" name="id" value="<?= $_POST['id']; ?>"/>

<?= Form()->formFooter($this->updateUrl, ' '); ?>
