<?php

use app\Util\Database;
use app\Constant\IURLConstant;
use app\Model\TransactionRegistrationDetails;
use app\Model\LinkRegistration;
use app\Model\MasterApproval;

$db = new Database;
$db->connect();

$regDetail = new TransactionRegistrationDetails();
$linkRegistration = new LinkRegistration();
$masterApproval = new MasterApproval();

$db->select($masterApproval->getEntity(), $regDetail->getEntity() . ".*"
        . "," . $masterApproval->getEntity() . DOT . $masterApproval->getCreatedOn() . " as created_date_approval"
        . "," . $linkRegistration->getEntity() . DOT . $linkRegistration->getId() . " as link_registration_id"
        . "", array($linkRegistration->getEntity(), $regDetail->getEntity()), ""
        . "  " . $masterApproval->getEntity() . DOT . $masterApproval->getApprovalDetailId() . EQUAL . $linkRegistration->getEntity() . DOT . $linkRegistration->getId()
        . " AND " . $linkRegistration->getEntity() . DOT . $linkRegistration->getRegistrationDetailsId() . EQUAL . $regDetail->getEntity() . DOT . $regDetail->getId() . ""
        . " AND " . $linkRegistration->getEntity() . DOT . $linkRegistration->getRegistrationDetailsId() . " is not null"
        . " AND " . $linkRegistration->getEntity() . DOT . $linkRegistration->getActivityId() . equalToIgnoreCase($rs_link_registration[0][$linkRegistration->getActivityId()]) . ""
        . " AND " . $linkRegistration->getEntity() . DOT . $linkRegistration->getRegistrationId() . equalToIgnoreCase($rs_link_registration[0][$linkRegistration->getRegistrationId()]) . ""
        . "", null, null);
//echo $db->getSql();
$rs_reg_detail = $db->getResult();
//print_r($rs_reg_detail);
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
echo Form()->attr('style="width:50%;"')
        ->title(lang('transaction.participant_category'))
        ->label($dt_mst_participant_type[0][$masterParticipantType->getName()])
        ->formLayout('horizontal')->labels();
echo Form()->attr('style="width:50%;"')
        ->title(lang('transaction.work_unit'))
        ->label($rs_registration[0][$transactionRegistration->getWorkingUnitName()])
        ->formLayout('horizontal')->labels();
if (!empty($rs_registration[0][$transactionRegistration->getGovernmentAgencies()])) {
    echo Form()->attr('style="width:50%;"')
            ->title(lang('transaction.agencies'))
            ->label($rs_registration[0][$transactionRegistration->getGovernmentAgencies()])
            ->formLayout('horizontal')->labels();
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
<table border="0" id="table-manual" class="table table-striped table-bordered order-column dataTable" width="100%">
    <thead>

        <tr>
            <th style="text-align:center;width:5%;"><?= lang('general.no'); ?></th>
            <th style=""><?= lang('approval.registration_code'); ?></th>
            <th style=""><?= lang('transaction.participant_name'); ?></th>
            <th style=""><?= lang('approval.detail'); ?></th>
            <th style=""><?= lang('general.status'); ?></th>
            <th style=""><?= lang('approval.time'); ?></th>
        </tr>
    </thead>
    <tbody id="table-manual-body">
        <?php
        $no = 0;
        foreach ($rs_reg_detail as $value) {
            $no++;
            $detail = "";
            $status = "";
            $detail = '<a href="javascript:void(0)" '
                    . 'onclick="postAjaxEdit(\'' . URL(getAdminTheme() . IURLConstant::APPROVAL_PARTICIPANT_REGISTRATION_INDEX_URL . '/edit-participant') . '\',\'link_registration_id=' . $value['link_registration_id'] . '&approval_id=' . $id.'\')">' . lang("general.detail") . '</a>';
            if (is_null($value[$regDetail->getIsApproved()])) {
                $status = '';
            } else if ($value[$regDetail->getIsApproved()] == 1) {
                $status = '<span class="text-success">' . lang('general.approve') . '</span>';
            } else if ($value[$regDetail->getIsApproved()] == 0) {
                $status = '<span class="text-danger">' . lang('general.reject') . '</span>';
            }
            ?>
            <tr onclick="checkCollectionRow(this)" class="collection" style="cursor:pointer">
                <td style="text-align:center;width:5%;"><?= $no; ?></td>
                <td style=""><?= $value[$regDetail->getCode()]; ?></td>
                <td style=""><?= $value[$regDetail->getFrontDegree()] . " " . $value[$regDetail->getName()] . " " . $value[$regDetail->getBehindDegree()]; ?></td>
                <td style=""><?= $detail; ?></td>
                <td style=""><?= $status; ?></td>
                <td style="width:200px;"><?= $value['created_date_approval']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot></tfoot>
</table>

<?php
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
<?= Form()->formFooter(null, ' '); ?>
<script>
    $(function () {
        $('#buttonBack').attr("onclick", "postAjaxPagination()");
    });
</script>