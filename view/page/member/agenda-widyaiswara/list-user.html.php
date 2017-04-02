<?php

use app\Model\MasterUserAssignment;
use app\Model\MasterUserMain;
use app\Model\TransactionActivity;
use app\Model\TransactionActivityDetails;
use app\Util\Database;

$db = new Database();
$db->connect();
$transactionActivity = new TransactionActivity();
$transactionActivityDetails = new TransactionActivityDetails();
$masterUserMain = new MasterUserMain();
$masterUserAssignment = new MasterUserAssignment();

$db->select($transactionActivityDetails->getEntity(), ""
        . $transactionActivityDetails->getEntity() . DOT . $transactionActivityDetails->getId() . ' as activity_details_id,'
        . $masterUserMain->getEntity() . DOT . $masterUserMain->getIdNumber() . ' as id_number,'
        . $masterUserMain->getEntity() . DOT . $masterUserMain->getName() . ' as participant_name'
        . "", array($masterUserMain->getEntity()), ""
        . $transactionActivityDetails->getEntity() . DOT . $transactionActivityDetails->getUserMainId() . EQUAL . $masterUserMain->getEntity() . DOT . $masterUserMain->getId()
        . " AND " . $transactionActivityDetails->getEntity() . DOT . $transactionActivityDetails->getActivityId() . equalToIgnoreCase($this->data_activity[0][$transactionActivity->getId()]));
$data_user_main = $db->getResult();
//print_r($data_user_main);
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
<table border="0" id="table-manual" class="table table-striped table-bordered order-column dataTable" width="100%">
    <thead>
        <tr>
            <th><?= lang("general.no"); ?></th>
            <th><?= lang("transaction.no_id"); ?></th>
            <th><?= lang("transaction.participant_name"); ?></th>
            <th><?= lang("member.total_value"); ?></th>
            <th><?= lang("general.action"); ?></th>
        </tr>
    </thead>
    <tbody>

        <?php
        $no = 0;
        foreach ($data_user_main as $value) {
            $no+=1;
            $action = '<a href="javascript:void(0)" '
                    . 'onclick="postAjaxEdit(\'' . $this->urlEditUser . '\',\'id=' . $value['activity_details_id'] . '\')">' . lang('general.edit') . '</a>';

            echo '<tr>';
            echo "<td>" . $no . "</td>";
            echo "<td>" . $value['id_number'] . "</td>";
            echo "<td>" . $value['participant_name'] . "</td>";
            echo "<td>" . ZERO . "</td>";
            echo "<td>" . $action . "</td>";
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<?php
//print_r($this->data_parent_subject_assess);
?>

<input type="hidden" id="id" name="id" value="<?= $_POST['id']; ?>"/>

<?= Form()->formFooter(null, ' '); ?>
<script>
    $(function () {
        $('#buttonBack').attr("onclick", "postAjaxEdit('<?= $this->editUrl; ?>','id=<?= $_POST['id']; ?>')");
    });
</script>
