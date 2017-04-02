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
$data_user_main = $db->selectByID($masterUserMain, $masterUserMain->getId() . equalToIgnoreCase($this->data_activity_details[0][$transactionActivityDetails->getUserMainId()]));

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

<?php
foreach ($data_category_asses as $value) {
    $evaluation_id = '';
    if(isset($this->data_evaluation[0][$transactionEvaluation->getId()])){
        $evaluation_id = $this->data_evaluation[0][$transactionEvaluation->getId()];
    }
    $data_value = $db->selectByID($transactionEvaluationDetails, $transactionEvaluationDetails->getEvaluationId() . equalToIgnoreCase($evaluation_id)
            . " AND " . $transactionEvaluationDetails->getCategoryAssessId() . equalToIgnoreCase($value[$masterCategoryAssess->getId()]));
    if (empty($data_value)) {
        echo Form()->formLayout(HORIZONTAL)
                ->type('number')
                ->id($value[$masterCategoryAssess->getCode()])
                ->attr('onkeyup="this.onchange()" onchange="calculateAll()" tripoin="number" min="0"')
                ->title($value[$masterCategoryAssess->getName()])
                ->value(0)
                ->textbox();
    } else {
        echo Form()->formLayout(HORIZONTAL)
                ->type('number')
                ->id($value[$masterCategoryAssess->getCode()])
                ->attr('onkeyup="this.onchange()" onchange="calculateAll()" tripoin="number" min="0"')
                ->title($value[$masterCategoryAssess->getName()])
                ->value(intval($data_value[0][$transactionEvaluationDetails->getValue()]))
                ->textbox();
    }
}
echo Form()->formLayout(HORIZONTAL)
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
?>

<?php
//print_r($this->data_parent_subject_assess);
?>
<input type="hidden" id="id" name="id" value="<?= $this->data_activity_details[0][$transactionActivityDetails->getId()]; ?>"/>

<?= Form()->formFooter(null, null, "postFormAjaxPostSetContent('" . $this->urlSaveUser . "','form-message')"); ?>
<script>
    $(function () {
        calculateAll();
        $('#buttonBack').attr("onclick", "postAjaxEdit('<?= $this->urlListUser; ?>','id=<?= $this->data_activity_details[0][$transactionActivityDetails->getActivityId()]; ?>')");
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
