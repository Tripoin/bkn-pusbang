<?php

use app\Model\MasterCategoryAssess;
use app\Model\LinkSubjectAssess;
use app\Model\TransactionActivity;
use app\Model\TransactionActivityDetails;
use app\Util\Database;

$db = new Database();
$db->connect();
$masterCategoryAssess = new MasterCategoryAssess();
$linkSubjectAssess = new LinkSubjectAssess();
$transactionActivity = new TransactionActivity();
$transactionActivityDetails = new TransactionActivityDetails();

$db->select($transactionActivityDetails->getEntity(), ""
        . $transactionActivityDetails->getEntity() . "." . $transactionActivityDetails->getId() . " as id,"
        . $transactionActivityDetails->getEntity() . "." . $transactionActivityDetails->getCode() . " as code,"
        . $transactionActivityDetails->getEntity() . "." . $transactionActivityDetails->getStartTime() . ","
        . $transactionActivityDetails->getEntity() . "." . $transactionActivityDetails->getEndTime() . ","
        . $transactionActivityDetails->getEntity() . "." . $transactionActivityDetails->getDuration() . ","
        . $transactionActivityDetails->getEntity() . "." . $transactionActivityDetails->getMaterialName() . ","
        . $transactionActivityDetails->getEntity() . "." . $transactionActivityDetails->getUserMainId() . ","
        . $transactionActivityDetails->getEntity() . "." . $transactionActivityDetails->getUserMainName() . ","
        . $transactionActivityDetails->getEntity() . "." . $transactionActivityDetails->getActivityId() . ","
        . $transactionActivityDetails->getEntity() . "." . $transactionActivityDetails->getDescription() . " as description,"
        . $transactionActivityDetails->getEntity() . "." . $transactionActivityDetails->getName() . " as name", array($transactionActivity->getEntity()), $transactionActivityDetails->getEntity() . DOT . $transactionActivityDetails->getActivityId() . EQUAL . $transactionActivity->getEntity() . DOT . $transactionActivity->getId()
        . " AND " . $transactionActivityDetails->getEntity() . DOT . $transactionActivityDetails->getActivityId() . equalToIgnoreCase($this->data_activity[0][$transactionActivity->getId()]));
$data_activity_details = $db->getResult();
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
        ->title(lang('member.execution_time'))
        ->label(subMonth($get_data[$data->getStartActivity()]) . " - " . subMonth($get_data[$data->getEndActivity()]))
        ->labels();
?>
<table border="0" id="table-manual" class="table table-striped table-bordered order-column dataTable" width="100%">
    <thead>
        <tr>
            <th><?= lang("transaction.day/date"); ?></th>
            <th><?= lang("transaction.time"); ?></th>
            <th><?= lang("transaction.material"); ?></th>
            <th><?= lang("transaction.lesson_time"); ?></th>
            <th><?= lang("transaction.trainer"); ?></th>
        </tr>
    </thead>
    <tbody>

        <?php
        foreach ($data_activity_details as $value) {
            $materialName = $value[$transactionActivityDetails->getMaterialName()];
            if($value[$transactionActivityDetails->getUserMainName()] != null){
                $materialName = '<a href="javascript:void(0)" '
                . 'onclick="postAjaxEdit(\'' . $this->urlListUser . '\',\'id=' . $value[$transactionActivityDetails->getActivityId()] . '\')">' .$value[$transactionActivityDetails->getMaterialName()].'</a>';
            }
            $startTime = date('h:i', strtotime($value[$transactionActivityDetails->getStartTime()]));
            $endTime = date('h:i', strtotime($value[$transactionActivityDetails->getEndTime()]));

            echo '<tr>';
            echo "<td>" . fullDateString($value[$transactionActivityDetails->getStartTime()]) . "</td>";
            echo "<td>" . $startTime . " - " . $endTime . "</td>";
            echo "<td>" . $materialName . "</td>";
            echo "<td>" . $value[$transactionActivityDetails->getDuration()] . "</td>";
            echo "<td>" . $value[$transactionActivityDetails->getUserMainName()] . "</td>";
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<?php
//print_r($this->data_parent_subject_assess);
?>

<input type="hidden" id="id" name="id" value="<?= $_POST['id']; ?>"/>

<?= $Form->formFooter(null,' '); ?>
<script>
    $(function(){
       $('#buttonBack').attr("onclick","postAjaxPagination()");
    });
</script>
