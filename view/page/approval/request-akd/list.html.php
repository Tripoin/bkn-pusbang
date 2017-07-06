
<?php
//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleColumn(array("text-align:center;width:5%;", "", ""));
$Datatable->header(array(lang("general.no"), lang("general.name"),
    lang("general.email"),
    lang("alumnus.agencies"),
    lang("member.json_occupation"),
    lang("general.action")));
$no = $list_data['from'];


foreach ($list_data['item'] as $value) {

    $action_delete = Button()->url($this->deleteUrl)->value($value[$data->getId()])->buttonDelete();
    $action_approved = Button()->url($this->editUrl)
            ->alertBtnMsg(lang('general.button_alert_approved'))
            ->alertMsg(lang('general.message_alert_approved'))
            ->alertTitle(lang('general.title_alert_approved'))
            ->icon('fa fa-check')
            ->onClick("postAjaxByAlertFormManual(this,'".$this->updateUrl."','bodyPage','id=".$value[$data->getId()]."&type=approved')")
            ->setClass('btn btn-success')
            ->title(lang('general.approve'))
            ->buttonCircleManual();
    
    $action_rejected = Button()->url($this->editUrl)
            ->alertBtnMsg(lang('general.button_alert_rejected'))
            ->alertMsg(lang('general.message_alert_rejected'))
            ->alertTitle(lang('general.title_alert_rejected'))
            ->icon('fa fa-times')
            ->onClick("postAjaxByAlertFormManual(this,'".$this->updateUrl."','bodyPage','id=".$value[$data->getId()]."&type=rejected')")
            ->setClass('btn btn-warning')
            ->title(lang('general.reject'))
            ->buttonCircleManual();

    $is_actived = '<span class="label label-success label-sm">'.lang('general.approved').'</span>';
    if ($value[$data->getIsActived()] == 0) {
//        $is_actived = '<span class="label label-danger label-sm">Belum Di Approved</span>';
        $is_actived = $action_approved .$action_rejected. $action_delete;
    } else if ($value[$data->getIsActived()] == 2) {
        $is_actived = '<span class="label label-warning label-sm">'.lang('general.rejected').'</span>';
    } 
    
//    $str_action = $is_actived;
    $Datatable->body(array($no,
        $value[$data->getParticipantName()],
        $value[$data->getEmail()],
        $value[$data->getAgencyName()],
        $value[$data->getOccupationName()],
        $is_actived
            ));
    $no += 1;
}

echo $Datatable->show();
?>
<script>
//postAjaxByAlertFormManual()(e,page,id);
</script>
