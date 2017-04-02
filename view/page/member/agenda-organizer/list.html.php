<?php

use app\Constant\IURLMemberConstant;
use app\Model\MasterWaitingList;
use app\Model\MasterUserAssignment;
use app\Model\SecurityRole;
use app\Util\Database;

$db = new Database();
$waitingList = new MasterWaitingList();
$userAssignment = new MasterUserAssignment();
$securityRole = new SecurityRole();

$data_role = $db->selectByID($securityRole, $securityRole->getCode() . equalToIgnoreCase('PARTICIPANT'));
$db->connect();
?>
<?php
//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "text-align:center;width:100px;"));
$Datatable->header(array(lang("general.no"), lang("member.activity_type"),
//    lang("general.name"),
    lang("member.alumni"),
    lang("member.budget_of_type"),
    lang("member.execution_time"),
    lang("member.participant"),
        //lang("general.status")
));
$no = $list_data['from'];


foreach ($list_data['item'] as $value) {

//    $action_delete = $Button->url($this->deleteUrl)->value($value[$data->getId()])->buttonDelete();
//    $action_edit = $Button->url($this->editUrl)->value($value[$data->getId()])->buttonEdit();
    //$approval = '<a href="javascript:void(0)" onclick="viewAgendaOrganizer(' . $value[$data->getId()] . ')">' . lang('member.approval') . '</a>';
    $db->sql("SELECT COUNT(" . $userAssignment->getId() . ") as count FROM " . $userAssignment->getEntity() . ""
            . " WHERE " . $userAssignment->getActivity_id() . EQUAL . $value[$data->getId()]
//            . " AND ".$userAssignment->getRoleId() . EQUAL . $data_role[0][$securityRole->getId()]
    );
    $rs_assign = $db->getResult();
    $panitia = '<a href="javascript:void(0)" onclick="pageAssignment(' . $value[$data->getId()] . ')">' . lang("transaction.organizer") . '</a>';
    $list_peserta = '<a href="javascript:void(0)" onclick="pageListPeserta(' . $value[$data->getId()] . ')">' . $rs_assign[0]['count'] . "/" . $value[$data->getQuota()] . '</a>';
    $detailSubject = '<a href="javascript:void(0)" onclick="pageDetails(' . $value[$data->getId()] . ')">' . subMonth($value[$data->getStartActivity()]) . ' - ' . subMonth($value[$data->getEndActivity()]) . '</a>';
    $Datatable->body(array(
        $no,
        $value[$data->getSubjectName()],
        $value[$data->getGeneration()],
        $value[$data->getBudgetTypeName()],
        $detailSubject,
        $list_peserta,
//        $panitia,
            //$approval
    ));
    $no += 1;
}

echo $Datatable->show();
?>

<script>
    $(function () {
        $('#account > legend').html('<?= lang('member.agenda_organizer'); ?>');
        $('#buttonBack').remove();
        initPage();
    });
    function initPage() {
        $('#list_search_by').attr("class", "input-sm input-xsmall input-inline");
        $('#search_pagination').attr("class", "form-control");
        $('#search_pagination').attr("style", "height:18px;");
        $('.pagination').attr("style", "margin-top:0");
    }

    function viewAgendaOrganizer(activity) {
        $('#urlPage').val('<?= URL(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/view/'); ?>' + activity);
        postAjaxPagination();
    }

    function pageAssignment(activity) {
        $('#urlPage').val('<?= URL(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/assignment/'); ?>' + activity);
        postAjaxPagination();
    }
    function pageListPeserta(activity) {
        $('#urlPage').val('<?= URL(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/list-peserta/'); ?>' + activity);
//        setTimeout(postAjaxPagination, 3000);
        postAjaxPagination();
    }
    function pageDetails(activity) {
        $('#urlPage').val('<?= URL(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/details/'); ?>' + activity);
        postAjaxPagination();
    }
    function pageParent() {
        $('#urlPage').val('<?= URL(IURLMemberConstant::AGENDA_ORGANIZER_URL . '/list'); ?>');
        postAjaxPagination();
    }
</script>
<!--<script>location.reload(true);</script>-->
