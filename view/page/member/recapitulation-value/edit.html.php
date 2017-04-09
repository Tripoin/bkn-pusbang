<?php
use app\Constant\IURLMemberConstant;
use app\Model\MasterCategoryAssess;
use app\Model\LinkSubjectAssess;
use app\Model\TransactionActivity;
use app\Model\TransactionActivityDetails;
use app\Model\MasterUserAssignment;
use app\Model\MasterUserMain;
use app\Model\TransactionEvaluation;
use app\Util\Database;

$db = new Database();
$db->connect();
$masterCategoryAssess = new MasterCategoryAssess();
$linkSubjectAssess = new LinkSubjectAssess();
$transactionActivity = new TransactionActivity();
$transactionActivityDetails = new TransactionActivityDetails();
$masterUserAssignment = new MasterUserAssignment();
$transactionEvaluation = new TransactionEvaluation();
$masterUserMain = new MasterUserMain();

$data_user_member = getUserMember();

$dt_user_assignment = $db->selectByID($masterUserAssignment, ""
        . $masterUserAssignment->getActivity_id() . equalToIgnoreCase($this->data_activity[0][$transactionActivity->getId()])
        . " AND " . $masterUserAssignment->getUser_main_id() . equalToIgnoreCase($data_user_member[$masterUserMain->getEntity()][$masterUserMain->getId()])
);
?>

<?= $Form->formHeader(); ?>
<?php
echo Form()->formLayout(HORIZONTAL)
        ->title(lang('member.subject_name'))
        ->label($get_data[$data->getName()])
        ->labels();
?>
<?php
echo Form()->formLayout(HORIZONTAL)
        ->title(lang('member.generation'))
        ->label($get_data[$data->getGeneration()])
        ->labels();
?>
<?php
echo Form()->formLayout(HORIZONTAL)
        ->title(lang('member.execution_time'))
        ->label(subMonth($get_data[$data->getStartActivity()]) . " - " . subMonth($get_data[$data->getEndActivity()]))
        ->labels();
?>
<table border="0" id="table-manual" class="table table-striped table-bordered order-column dataTable" width="100%">
    <thead>

        <tr>
            <th style="text-align:center;width:20%;"><?= lang('member.day_of_date'); ?></th>
            <th style="text-align:center;width:15%;"><?= lang('member.time'); ?></th>
            <th style="text-align:center;width:20%;"><?= lang('member.material'); ?></th>
            <th style="text-align:center;width:8%;"><?= lang('member.lesson_time'); ?></th>
            <th style="text-align:center;width:10%;"><?= lang('member.trainer_activities'); ?></th>
            <th style="text-align:center;width:8%;"><?= lang('member.total_value'); ?></th>
        </tr>
    </thead>
    <tbody id="table-manual-body">
        <?php
        foreach ($this->data_activity_details as $value) {

            $db->select($transactionEvaluation->getEntity(), "*", array(), ""
                    . $transactionEvaluation->getActivityDetailsId() . equalToIgnoreCase($value[$transactionActivityDetails->getId()])
                    . " AND ".$transactionEvaluation->getUserAssignmentId().  equalToIgnoreCase($dt_user_assignment[0][$masterUserAssignment->getId()])
                    );
            $rs_total = $db->getResult();
            
            $total = 0;
            if(!empty($rs_total)){
                $total = $rs_total[0][$transactionEvaluation->getRateValue()];
            }
            ?>
            <tr>
                <td style=""><?= fullDateString($value[$transactionActivityDetails->getStartTime()]); ?></td>
                <td style=""><?= subTimeOnly($value[$transactionActivityDetails->getStartTime()]); ?> - <?= subTimeOnly($value[$transactionActivityDetails->getEndTime()]); ?></td>
                <td><?= $value[$transactionActivityDetails->getMaterialName()]; ?></td>
                <td style="text-align:center;"><?= $value[$transactionActivityDetails->getDuration()]; ?></td>
                <td style="text-align:center;"><?= $value[$transactionActivityDetails->getUserMainName()]; ?></td>
                <td style="">
                    <a href="javascript:void(0)" 
                       onclick="postAjaxEdit('<?=URL(IURLMemberConstant::REKAPITULASI_NILAI_URL.'/create');?>', 
                                   'id=<?=$value[$transactionActivityDetails->getId()];?>&id_user_assignment=<?=$dt_user_assignment[0][$masterUserAssignment->getId()];?>')">
                       <?=  number_format($total,2);?></a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?= $Form->formFooter(null,' '); ?>
<script>
    function calculateAll(id) {
        var all = $('#' + id + ' :input[tripoin="number"]');
//        console.log($('#' + id + ' :input[tripoin="number"]'));
        var values = all
                .map(function () {
                    return $(this).val();
                }).get();

        var total = 0;
        for (var no = 0; no < values.length; no++) {
            total += parseFloat(values[no]);
        }
        var average = total / parseInt(values.length);
        $('#total' + id).val(total);
        $('#average' + id).val(average);
//      console.log(values);
//        alert("masuk");
    }
</script>