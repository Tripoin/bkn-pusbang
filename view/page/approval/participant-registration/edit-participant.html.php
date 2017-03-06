<?php

use app\Constant\IURLConstant;
?>
<?= Form()->formHeader(); ?>
<?php
if (!is_null($rs_registration_detail[0][$regDetail->getIsApproved()])) {
    if ($rs_registration_detail[0][$regDetail->getIsApproved()] == 1) {
        echo resultPageMsg('warning', lang('transaction.data_have_approved'), '');
    } else {
        echo resultPageMsg('warning', lang('transaction.data_have_rejected'), $rs_registration_detail[0][$regDetail->getApprovedMessage()]);
    }
}
if ($dt_participant_type[0][$m_participant_type->getCode()] == 'GOVERNMENT_AGENCY') {
    $potret_title = $dt_participant_type[0][$m_participant_type->getName()];
    $label_working_unit = lang('transaction.work_unit');
    $label_telephone_working_unit = lang('transaction.telephone_work_unit');
    $label_fax_working_unit = lang('transaction.fax_work_unit');
    $label_address_working_unit = lang('transaction.address_work_unit');
} else if ($dt_participant_type[0][$m_participant_type->getCode()] == 'PRIVATE_AGENCY') {
    $potret_title = $dt_participant_type[0][$m_participant_type->getName()];
    $label_working_unit = lang('transaction.office_name');
    $label_telephone_working_unit = lang('transaction.office_telephone');
    $label_fax_working_unit = lang('transaction.office_fax');
    $label_address_working_unit = lang('transaction.office_address');
}
?>
<div class="row">
    <div class="col-md-6">
        <?php
        $detailSubject = lang('transaction.tentative');
        $due = strtotime($dt_activity[0][$m_act->getStartActivity()]);
        if ($due != strtotime('0000-00-00')) {
            $detailSubject = '' . subMonth($dt_activity[0][$m_act->getStartActivity()]) . ' - ' . subMonth($dt_activity[0][$m_act->getEndActivity()]) . '';
        } else if ($dt_activity[0][$m_act->getStartActivity()] == null) {
            $detailSubject = lang('transaction.tentative');
        }

        echo Form()
                ->title(lang('transaction.subject_name'))
                ->label($data_subject[0]['label'])
                ->formLayout('horizontal')->labels();
        echo Form()
                ->title(lang('transaction.execution_time'))
                ->label($detailSubject)
                ->formLayout('horizontal')->labels();
        echo Form()
                ->title(lang('transaction.participant_category'))
                ->label($dt_mst_participant_type[0][$masterParticipantType->getName()])
                ->formLayout('horizontal')->labels();
        echo Form()
                ->title(lang('transaction.work_unit'))
                ->label($rs_registration[0][$transactionRegistration->getWorkingUnitName()])
                ->formLayout('horizontal')->labels();
        if (!empty($rs_registration[0][$transactionRegistration->getGovernmentAgencies()])) {
            echo Form()
                    ->title(lang('transaction.instansi'))
                    ->label($rs_registration[0][$transactionRegistration->getGovernmentAgencies()])
                    ->formLayout('horizontal')->labels();
        }

        echo Form()
                ->title(lang('transaction.participant_name'))
                ->label($rs_registration_detail[0][$regDetail->getFrontDegree()] . " " . $rs_registration_detail[0][$regDetail->getName()] . " " . $rs_registration_detail[0][$regDetail->getBehindDegree()])
                ->formLayout('horizontal')->labels();

        echo Form()
                ->title(lang('transaction.no_id'))
                ->label($rs_registration_detail[0][$regDetail->getIdNumber()])
                ->formLayout('horizontal')->labels();

        echo Form()
                ->title(lang('transaction.place_of_birth'))
                ->label($rs_registration_detail[0][$regDetail->getPob()])
                ->formLayout('horizontal')->labels();
        echo Form()
                ->title(lang('transaction.birthdate'))
                ->label(subMonth($rs_registration_detail[0][$regDetail->getDob()]))
                ->formLayout('horizontal')->labels();


        $religionName = "";
        if (isset($dt_religion[0][$masterReligion->getName()])) {
            $religionName = $dt_religion[0][$masterReligion->getName()];
        }
        echo Form()
                ->title(lang('transaction.religion'))
                ->label($religionName)
                ->formLayout('horizontal')->labels();
        echo Form()
                ->title(lang('transaction.gender'))
                ->label(convertGender($rs_registration_detail[0][$regDetail->getGender()]))
                ->formLayout('horizontal')->labels();
        echo Form()
                ->title(lang('transaction.status'))
                ->label(convertMaritalStatus($rs_registration_detail[0][$regDetail->getMaritalStatus()]))
                ->formLayout('horizontal')->labels();
        $email = "";
        if (isset($rs_registration_detail[0][$regDetail->getEmail()])) {
            $email = $rs_registration_detail[0][$regDetail->getEmail()];
        }
        echo Form()
                ->title(lang('transaction.email'))
                ->label($email)
                ->formLayout('horizontal')->labels();
        ?>
    </div>
    <div class="col-md-6">
        <?php
        $fax = "";
        if (isset($rs_registration_detail[0][$regDetail->getFax()])) {
            $fax = $rs_registration_detail[0][$regDetail->getFax()];
        }
        echo Form()
                ->title(lang('transaction.fax'))
                ->label($fax)
                ->formLayout('horizontal')->labels();
        $phoneNumber = "";
        if (isset($rs_registration_detail[0][$regDetail->getPhoneNumber()])) {
            $phoneNumber = $rs_registration_detail[0][$regDetail->getPhoneNumber()];
        }
        echo Form()
                ->title(lang('transaction.telephone'))
                ->label($phoneNumber)
                ->formLayout('horizontal')->labels();
        $address = "";
        if (isset($rs_registration_detail[0][$regDetail->getAddress()])) {
            $address = $rs_registration_detail[0][$regDetail->getAddress()];
        }
        echo Form()
                ->title(lang('transaction.address'))
                ->label($address)
                ->formLayout('horizontal')->labels();



        echo Form()
                ->title(lang('transaction.postal_code'))
                ->label($rs_registration_detail[0][$regDetail->getZipCode()])
                ->formLayout('horizontal')->labels();

        $govClass = "";
        if (isset($dt_gov_class[0][$mGovClass->getName()])) {
            $govClass = $dt_gov_class[0][$mGovClass->getName()];
        }
        echo Form()
                ->title(lang('transaction.class'))
                ->label($govClass)
                ->formLayout('horizontal')->labels();

        echo Form()
                ->title(lang('transaction.position'))
                ->label($rs_registration_detail[0][$regDetail->getJsonOccupation()])
                ->formLayout('horizontal')->labels();
        echo Form()
                ->title(lang('transaction.degree'))
                ->label($rs_registration_detail[0][$regDetail->getDegree()])
                ->formLayout('horizontal')->labels();
        echo Form()
                ->title(lang('transaction.school/university'))
                ->label($rs_registration_detail[0][$regDetail->getCollege()])
                ->formLayout('horizontal')->labels();
        echo Form()
                ->title(lang('transaction.faculty'))
                ->label($rs_registration_detail[0][$regDetail->getFaculity()])
                ->formLayout('horizontal')->labels();
        echo Form()
                ->title(lang('transaction.study_program'))
                ->label($rs_registration_detail[0][$regDetail->getStudyProgram()])
                ->formLayout('horizontal')->labels();
        echo Form()
                ->title(lang('transaction.graduation_year'))
                ->label($rs_registration_detail[0][$regDetail->getGraduationYear()])
                ->formLayout('horizontal')->labels();
        ?>
    </div>
</div>
<?php
echo Form()
        ->title(lang('transaction.title'))
        ->label($rs_registration[0][$transactionRegistration->getMessageTitle()])
        ->formLayout('horizontal')->labels();
echo Form()
        ->title(lang('transaction.message'))
        ->label($rs_registration[0][$transactionRegistration->getMessageContent()])
        ->formLayout('horizontal')->labels();
$button_reject = "";
$button_approve = "";

if (is_null($rs_registration_detail[0][$regDetail->getIsApproved()])) {
    $button_reject = Button()->id('btn-reject')
            ->onClick('ajaxPostModalManual(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_PARTICIPANT_REGISTRATION_INDEX_URL . '/edit-participant/reject-detail') . '\', \'link_registration_id=' . $linkRegistrationId . '&approval_id=' . $approvalId . '\')')
            ->label(lang('general.reject'))
            ->setClass('btn btn-warning')
            ->icon('fa fa-times')
            ->buttonManual();
    $button_approve = Button()->id('btn-approve')
            ->onClick('postAjaxByAlertManual(this,\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_PARTICIPANT_REGISTRATION_INDEX_URL . '/edit-participant/approve') . '\', \'link_registration_id=' . $linkRegistrationId . '&approval_id=' . $approvalId . '\')')
            ->label(lang('general.approve'))
            ->alertTitle(lang('general.approve'))
            ->alertMsg(lang('member.notif_approved_candidates'))
            ->alertBtnMsg(lang('member.yes'))
            ->setClass('btn btn-success')
            ->icon('fa fa-thumbs-up')
            ->buttonManual();
}
?>
<?= Form()->formFooter(null, $button_reject . ' ' . $button_approve); ?>
<script>
    $(function () {
        $('#buttonBack').attr("onclick", "postAjaxEdit('<?= URL(getAdminTheme() . IURLConstant::APPROVAL_PARTICIPANT_REGISTRATION_INDEX_URL . '/edit'); ?>','id=<?= $approvalId; ?>')");
    });
</script>