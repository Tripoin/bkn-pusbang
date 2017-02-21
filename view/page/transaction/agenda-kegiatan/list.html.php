<?php

use app\Model\MasterWaitingList;
use app\Model\MasterUserAssignment;
use app\Util\Database;


$db = new Database();
$waitingList = new MasterWaitingList();
$userAssignment =  new MasterUserAssignment();
$db->connect();

//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "text-align:center;width:100px;"));
$Datatable->header(array(lang("general.no"), lang("transaction.type"),
//    lang("general.name"),
    lang("transaction.excecution_time"),
    lang("transaction.number_of_participants"),
    lang("transaction.assignment"),
    lang("general.action")));
$no = $list_data['from'];


foreach ($list_data['item'] as $value) {

    $action_delete = $Button->url($this->deleteUrl)->value($value[$data->getId()])->buttonDelete();
    $action_edit = $Button->url($this->editUrl)->value($value[$data->getId()])->buttonEdit();
    /* $t = getParentManual($this->modelSubject->getEntity(), $this->modelSubject->getId(), 
      $this->modelSubject->getName(), $this->modelSubject->getParentId(),
      $value[$this->modelSubject->getParentId()],
      $value[$this->modelSubject->getName()]); */
    $db->sql("SELECT COUNT(".$userAssignment->getId().") as count FROM ".$userAssignment->getEntity()." WHERE ".$userAssignment->getActivity_id().EQUAL.$value[$data->getId()]);
        $rs_assign = $db->getResult();
    
    $panitia = '<a href="javascript:void(0)" onclick="pageAssignment(' . $value[$data->getId()] . ')">' . lang("transaction.organizer") . '</a>';
    $list_peserta = '<a href="javascript:void(0)" onclick="pageListPeserta(' . $value[$data->getId()] . ')">' .$rs_assign[0]['count']."/". $value[$data->getQuota()] . '</a>';
    $detailSubject = '<a href="javascript:void(0)" onclick="pageDetails(' . $value[$data->getId()] . ')">' . subMonth($value[$data->getStartActivity()]) . ' - ' . subMonth($value[$data->getEndActivity()]) . '</a>';
    $Datatable->body(array(
        $no,
        $value[$data->getSubjectName()],
//        $value[$data->getName()],
        $detailSubject,
        $list_peserta,
        $panitia,
        $action_edit . $action_delete));
    $no += 1;
}

echo $Datatable->show();
?>

<script>
    $(function () {
        $('.portlet-title > div > span').html('<?=lang('transaction.agenda_subject');?>');
        $('#buttonBack').remove();
    });
    function pageAssignment(activity) {
        $('#urlPage').val('<?= URL(getAdminTheme() . $this->indexUrl . '/assignment/'); ?>' + activity);
        postAjaxPagination();
    }
    function pageListPeserta(activity) {
        $('#urlPage').val('<?= URL(getAdminTheme() . $this->indexUrl . '/list-peserta/'); ?>' + activity);
        postAjaxPagination();
    }
    function pageDetails(activity) {
        $('#urlPage').val('<?= URL(getAdminTheme() . $this->indexUrl . '/details/'); ?>' + activity);
        postAjaxPagination();
    }
    function pageParent() {
        $('#urlPage').val('<?= URL(getAdminTheme() . $this->indexUrl . '/list'); ?>');
        postAjaxPagination();
    }
</script>
<!--<script>location.reload(true);</script>-->
