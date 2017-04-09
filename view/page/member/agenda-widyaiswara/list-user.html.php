<?php

use app\Model\MasterUserAssignment;
use app\Model\MasterUserMain;
use app\Model\TransactionActivity;
use app\Model\TransactionActivityDetails;
use app\Util\Database;
use app\Model\TransactionEvaluation;

$db = new Database();
$db->connect();
$transactionActivity = new TransactionActivity();
$transactionActivityDetails = new TransactionActivityDetails();
$masterUserMain = new MasterUserMain();
$masterUserAssignment = new MasterUserAssignment();
$transactionEvaluation = new TransactionEvaluation();

$db->select($masterUserAssignment->getEntity()
        , ""
        . $transactionActivityDetails->getEntity() . DOT . $transactionActivityDetails->getId() . ' as activity_details_id,'
        . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getId() . ' as id_user_assignment,'
        . $masterUserMain->getEntity() . DOT . $masterUserMain->getIdNumber() . ' as id_number,'
        . $masterUserMain->getEntity() . DOT . $masterUserMain->getFront_degree() . ' as front_degree,'
        . $masterUserMain->getEntity() . DOT . $masterUserMain->getBehind_degree() . ' as behind_degree,'
        . $masterUserMain->getEntity() . DOT . $masterUserMain->getName() . ' as participant_name'
        , array($masterUserMain->getEntity(), $transactionActivityDetails->getEntity())
        , ""
        . "" . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getUser_main_id() . EQUAL . $masterUserMain->getEntity() . DOT . $masterUserMain->getId()
        . " AND " . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getActivity_id() . EQUAL . $transactionActivityDetails->getEntity() . DOT . $transactionActivityDetails->getActivityId()
        . " AND " . $transactionActivityDetails->getEntity() . DOT . $transactionActivityDetails->getId() . equalToIgnoreCase($_POST['activity_details_id'])
        . " AND " . $masterUserAssignment->getRoleId() . equalToIgnoreCase(1)
        . " AND " . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getActivity_id() . equalToIgnoreCase($this->data_activity[0][$transactionActivity->getId()])
);
/* $db->select($transactionActivityDetails->getEntity(), ""
  . $transactionActivityDetails->getEntity() . DOT . $transactionActivityDetails->getId() . ' as activity_details_id,'
  . $masterUserMain->getEntity() . DOT . $masterUserMain->getIdNumber() . ' as id_number,'
  . $masterUserMain->getEntity() . DOT . $masterUserMain->getName() . ' as participant_name'
  . "", array($masterUserMain->getEntity()), ""
  . $transactionActivityDetails->getEntity() . DOT . $transactionActivityDetails->getUserMainId() . EQUAL . $masterUserMain->getEntity() . DOT . $masterUserMain->getId()
  . " AND " . $transactionActivityDetails->getEntity() . DOT . $transactionActivityDetails->getActivityId() . equalToIgnoreCase($this->data_activity[0][$transactionActivity->getId()]));
 * 
 */
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
            <th><?= lang("general.average"); ?></th>
            <th><?= lang("general.action"); ?></th>
        </tr>
    </thead>
    <tbody>

        <?php
        $no = 0;
        foreach ($data_user_main as $value) {
            $rs_total = $db->selectByID($transactionEvaluation, 
                    $transactionEvaluation->getActivityDetailsId().  equalToIgnoreCase($value['activity_details_id'])
                    ." AND ".$transactionEvaluation->getUserAssignmentId().  equalToIgnoreCase($value['id_user_assignment'])
                    );
            $total = 0;
            if(!empty($rs_total)){
                $total = $rs_total[0]['rate_value'];
            }
            $no+=1;
            $action = '<a href="javascript:void(0)" '
                    . 'onclick="postAjaxEdit(\'' . $this->urlEditUser . '\',\'id_user_assignment=' . $value['id_user_assignment'] . '&id=' . $value['activity_details_id'] . '\')">' . lang('general.edit') . '</a>';

            echo '<tr>';
            echo "<td>" . $no . "</td>";
            echo "<td>" . $value['id_number'] . "</td>";
            echo "<td>" . $value['front_degree'] . " " . $value['participant_name'] . " " . $value['behind_degree'] . "</td>";
            echo "<td>" . number_format($total ,2). "</td>";
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
