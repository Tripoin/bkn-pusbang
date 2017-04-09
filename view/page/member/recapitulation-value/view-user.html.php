<?php

use app\Model\MasterUserAssignment;
use app\Model\MasterUserMain;
use app\Model\TransactionActivity;
use app\Model\TransactionActivityDetails;
use app\Model\TransactionEvaluationDetails;
use app\Model\MasterCategoryAssess;
use app\Util\Database;

$db = new Database();
$db->connect();
$transactionActivity = new TransactionActivity();
$transactionActivityDetails = new TransactionActivityDetails();
$transactionEvaluationDetails = new TransactionEvaluationDetails();
$masterUserMain = new MasterUserMain();
$masterUserAssignment = new MasterUserAssignment();
$masterCategoryAssess = new MasterCategoryAssess();
$data_user_main = $db->selectByID($masterUserMain, $masterUserMain->getId() . 
        equalToIgnoreCase($data_user_assignment[0][$masterUserAssignment->getUser_main_id()]));

$sql_assess = SELECT . 'mca1.' . $masterCategoryAssess->getId() . ',' . 'mca1.' . $masterCategoryAssess->getName() . ',' . 'mca1.' . $masterCategoryAssess->getCode() . ''
        . FROM . $masterCategoryAssess->getEntity() . ' as mca1 '
        . '' . JOIN . $masterCategoryAssess->getEntity() . ' as mca2' . ON . ''
        . ' mca1.' . $masterCategoryAssess->getParentId() . EQUAL . 'mca2.' . $masterCategoryAssess->getId()
        . ' WHERE mca2.' . $masterCategoryAssess->getCode() . equalToIgnoreCase('ET');
$db->sql($sql_assess);

$data_category_asses = $db->getResult();
//print_r($data_category_asses);
?>

<?= Form()->formHeader(); ?>

<?php
echo Form()->formLayout(HORIZONTAL)
        ->title(lang('member.subject_name'))
        ->label($this->data_activity[0][$transactionActivity->getName()])
        ->labels();
?>
<?php
echo Form()->formLayout(HORIZONTAL)
        ->title(lang('member.execution_time'))
        ->label(subMonth($this->data_activity[0][$transactionActivity->getStartActivity()]) . " - " . subMonth($this->data_activity[0][$transactionActivity->getEndActivity()]))
        ->labels();
?>
<?php
echo Form()->formLayout(HORIZONTAL)
        ->title(lang('member.participant_name'))
        ->label($data_user_main[0][$masterUserMain->getFront_degree()] . ' ' . $data_user_main[0][$masterUserMain->getName()] . ' ' . $data_user_main[0][$masterUserMain->getBehind_degree()])
        ->labels();
?>
<?php
echo Form()->formLayout(HORIZONTAL)
        ->title(lang('transaction.no_id'))
        ->label($data_user_main[0][$masterUserMain->getIdNumber()])
        ->labels();
?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Aspek Penilaian</th>
            <th><?=lang('member.value');?></th>
        </tr>
    </thead>
    <tbody>
        
    
<?php
$total_value = 0;
$no = 0;
foreach ($data_category_asses as $value) {
    $no += 1;
    echo '<tr>';
    $evaluation_id = '';
    if(isset($this->data_evaluation[0][$transactionEvaluation->getId()])){
        $evaluation_id = $this->data_evaluation[0][$transactionEvaluation->getId()];
    }
    $data_value = $db->selectByID($transactionEvaluationDetails, $transactionEvaluationDetails->getEvaluationId() . equalToIgnoreCase($evaluation_id)
            . " AND " . $transactionEvaluationDetails->getCategoryAssessId() . equalToIgnoreCase($value[$masterCategoryAssess->getId()]));
    if (empty($data_value)) {
        echo '<td>'.$value[$masterCategoryAssess->getName()].'</td>';
        echo '<td>0</td>';
    } else {
        $total_value += $data_value[0][$transactionEvaluationDetails->getValue()];
        echo '<td>'.$value[$masterCategoryAssess->getName()].'</td>';
        echo '<td>'.intval($data_value[0][$transactionEvaluationDetails->getValue()]).'</td>';
    }
    echo '</tr>';
}
$rate_value = $total_value / $no;
?>
        <tr>
            <td><?=lang('member.total_value');?></td>
            <td><?=$total_value;?></td>
        </tr>
        <tr>
            <td><?=lang('member.average_value');?></td>
            <td><?=$rate_value;?></td>
        </tr>
        
        </tbody>
</table>
        <?php
/*echo Form()->formLayout(HORIZONTAL)
        ->attr('readonly="readonly"')
        ->id('total')
        ->title(lang('general.total'))
        ->value(0)
        ->textbox();
echo Form()->formLayout(HORIZONTAL)
        ->id('average')
        ->attr('readonly="readonly"')
        ->title(lang('general.average'))
        ->value(0)
        ->textbox();
 * 
 */
?>

<?php
//print_r($this->data_parent_subject_assess);
?>
<input type="hidden" id="id" name="id" value="<?= $this->data_activity_details[0][$transactionActivityDetails->getId()]; ?>"/>
<input type="hidden" id="id_user_assignment" name="id_user_assignment" value="<?= $data_user_assignment[0][$masterUserAssignment->getId()]; ?>"/>

<?= Form()->formFooter(null, ' '); ?>
<script>
    $(function () {
        calculateAll();
        $('#buttonBack').attr("onclick", "postAjaxEdit('<?= $this->urlListUser; ?>','activity_details_id=<?= $this->data_activity_details[0][$transactionActivityDetails->getId()]; ?>&id=<?= $this->data_activity_details[0][$transactionActivityDetails->getActivityId()]; ?>')");
    });

    function calculateAll() {
        var all = $(':input[tripoin="number"]');
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
        $('#total').val(total);
        $('#average').val(average);
//      console.log(values);
//        alert("masuk");
    }
</script>
