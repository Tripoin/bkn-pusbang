<?php

use app\Constant\IURLConstant;
?>
<?= Form()->formHeader(); ?>
<?php
if (!is_null($dt_approval[0][$masterApproval->getStatus()])) {
    if ($dt_approval[0][$masterApproval->getStatus()] == 1) {
        echo resultPageMsg('warning', lang('transaction.data_have_approved'), '');
    } else {
        echo resultPageMsg('warning', lang('transaction.data_have_rejected'), $rs_registration[0][$transactionRegistration->getApprovedMessage()]);
    }
}
echo Form()->attr('style="width:50%;"')
        ->title(lang('transaction.subject_name'))
        ->label($data_subject[0]['label'])
        ->formLayout('horizontal')->labels();
echo Form()->attr('style="width:50%;"')
        ->title(lang('transaction.execution_time'))
        ->label($dt_activity[0][$m_act->getStartActivity()] . " - " . $dt_activity[0][$m_act->getEndActivity()])
        ->formLayout('horizontal')->labels();

if($dt_participant_type[0][$m_participant_type->getCode()]=='GOVERNMENT_AGENCY'){
    $potret_title = $dt_participant_type[0][$m_participant_type->getName()];
    $label_working_unit = lang('transaction.work_unit');
    $label_telephone_working_unit = lang('transaction.telephone_work_unit');
    $label_fax_working_unit = lang('transaction.fax_work_unit');
    $label_address_working_unit = lang('transaction.address_work_unit');
} else if($dt_participant_type[0][$m_participant_type->getCode()]=='PRIVATE_AGENCY'){
    $potret_title = $dt_participant_type[0][$m_participant_type->getName()];
    $label_working_unit = lang('transaction.office_name');
    $label_telephone_working_unit = lang('transaction.office_telephone');
    $label_fax_working_unit = lang('transaction.office_fax');
    $label_address_working_unit = lang('transaction.office_address');
}

?>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-home"></i> <?= $potret_title; ?></div>
        <div class="tools">
            <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
            <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>
            <a href="" class="fullscreen" data-original-title="" title=""> </a>
            <a href="javascript:;" class="reload" data-original-title="" title=""> </a>
        </div>
    </div>
    <div class="portlet-body"> 
        <?php
        $attach = '<a href="' . URL('uploads/' . $rs_attachment[0][$masterAttachment->getName()]) . '" target="_blank">Download</a>';
        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.recommend_letter'))
                ->label($attach)
                ->formLayout('horizontal')->labels();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.pic_name'))
                ->label($rs_registration[0][$transactionRegistration->getDelegationName()])
                ->formLayout('horizontal')->labels();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.pic_email'))
                ->label($rs_registration[0][$transactionRegistration->getDelegationEmail()])
                ->formLayout('horizontal')->labels();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.pic_telephone'))
                ->label($rs_registration[0][$transactionRegistration->getDelegationPhoneNumber()])
                ->formLayout('horizontal')->labels();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.pic_fax'))
                ->label($rs_registration[0][$transactionRegistration->getDelegationFax()])
                ->formLayout('horizontal')->labels();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.pic_address'))
                ->label($rs_registration[0][$transactionRegistration->getDelegationAddress()])
                ->formLayout('horizontal')->labels();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('transaction.agencies'))
                ->label($rs_registration[0][$transactionRegistration->getGovernmentAgencies()])
                ->formLayout('horizontal')->labels();
        echo Form()->attr('style="width:50%;"')
                ->title($label_working_unit)
                ->label($rs_registration[0][$transactionRegistration->getWorkingUnitName()])
                ->formLayout('horizontal')->labels();
        echo Form()->attr('style="width:50%;"')
                ->title($label_telephone_working_unit)
                ->label($rs_registration[0][$transactionRegistration->getWuPhoneNumber()])
                ->formLayout('horizontal')->labels();
        echo Form()->attr('style="width:50%;"')
                ->title($label_fax_working_unit)
                ->label($rs_registration[0][$transactionRegistration->getWuFax()])
                ->formLayout('horizontal')->labels();
        echo Form()->attr('style="width:50%;"')
                ->title($label_address_working_unit)
                ->label($rs_registration[0][$transactionRegistration->getWuAddress()])
                ->formLayout('horizontal')->labels();
        ?>
    </div>
</div>
<?php
echo Form()->attr('style="width:50%;"')
        ->title(lang('transaction.title'))
        ->label($rs_registration[0][$transactionRegistration->getMessageTitle()])
        ->formLayout('horizontal')->labels();
echo Form()->attr('style="width:50%;"')
        ->title(lang('transaction.message'))
        ->label($rs_registration[0][$transactionRegistration->getMessageContent()])
        ->formLayout('horizontal')->labels();
$button_reject = "";
$button_approve = "";
if (is_null($dt_approval[0][$masterApproval->getStatus()])) {
    $button_reject = Button()->id('btn-reject')
            ->onClick('ajaxPostModalManual(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_PIC_REGISTRATION_INDEX_URL . '/' . $dt_activity[0][$m_act->getId()] . '/reject-detail') . '\', \'approval_category_id=1&registration_id=' . $dt_approval[0][$masterApproval->getApprovalDetailId()] . '&id=' . $id . '\')')
            ->label(lang('general.reject'))
            ->setClass('btn btn-warning')
            ->icon('fa fa-times')
            ->buttonManual();
    $button_approve = Button()->id('btn-approve')
            ->onClick('postAjaxByAlertManual(this,\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_PIC_REGISTRATION_INDEX_URL . '/' . $dt_activity[0][$m_act->getId()] . '/approve') . '\', \'approval_category_id=1&registration_id=' . $dt_approval[0][$masterApproval->getApprovalDetailId()] . '&id=' . $id . '\')')
            ->label(lang('general.approve'))
            ->alertTitle(lang('general.approve'))
            ->alertMsg(lang('member.notif_approved_candidates'))
            ->alertBtnMsg(lang('member.yes'))
            ->setClass('btn btn-success')
            ->icon('fa fa-thumbs-up')
            ->buttonManual();
}
?>


<input type="hidden" id="id" name="id" value="<?= $_POST['id']; ?>"/>
<?= Form()->formFooter(null, $button_reject . ' ' . $button_approve); ?>