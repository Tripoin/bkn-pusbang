<?php

use app\Model\MasterCategoryAssess;
use app\Model\LinkSubjectAssess;
use app\Model\TransactionActivity;
use app\Model\TransactionSurvey;
use app\Model\TransactionSurveyDetails;
use app\Model\MasterUserMain;
use app\Model\MasterUserAssignment;
use app\Util\Database;

$db = new Database();
$db->connect();
$masterCategoryAssess = new MasterCategoryAssess();
$linkSubjectAssess = new LinkSubjectAssess();
$transactionActivity = new TransactionActivity();
$transactionSurveyDetails = new TransactionSurveyDetails();
$transactionSurvey = new TransactionSurvey();

$masterUserMain = new MasterUserMain();
$masterUserAssignment = new MasterUserAssignment();
$data_user = getUserMember();
//        echo $data_user[$masterUserMain->getEntity()][$masterUserMain->getId()];
$data_user_assign = $db->selectByID($masterUserAssignment, ""
        . $masterUserAssignment->getUser_main_id() . equalToIgnoreCase($data_user[$masterUserMain->getEntity()][$masterUserMain->getId()])
        . " AND " . $masterUserAssignment->getActivity_id() . equalToIgnoreCase($this->data_activity[0][$transactionActivity->getId()]));
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
<?php
//print_r($this->data_parent_subject_assess);
?>
<ul class="nav nav-tabs">
    <!--<li class="active"><a data-toggle="tab" href="#home">Home</a></li>-->
    <?php
    $no = 0;
    foreach ($this->data_parent_subject_assess as $data_parent) {
        $no+=1;
        $active = '';
        if ($no == 1) {
            $active = 'class="active"';
        }
        ?>
        <li <?= $active; ?>><a data-toggle="tab" href="#<?= $data_parent['id']; ?>"><?= $data_parent['name']; ?></a></li>
    <?php } ?>
</ul>
<div class="tab-content" style="margin-top:20px;">
    <?php
    $no = 0;
    foreach ($this->data_parent_subject_assess as $data_parent) {
        $no+=1;
        $active = '';
        if ($no == 1) {
            $active = '  in active';
        }
        ?>

        <div id="<?= $data_parent['id']; ?>" class="tab-pane fade <?= $active; ?>">
            <?php
            $db->select($linkSubjectAssess->getEntity(), ""
                    . $masterCategoryAssess->getEntity() . DOT . $masterCategoryAssess->getName() . " as name,"
                    . $masterCategoryAssess->getEntity() . DOT . $masterCategoryAssess->getCode() . " as code,"
                    . $masterCategoryAssess->getEntity() . DOT . $masterCategoryAssess->getId() . " as id", array(
                $masterCategoryAssess->getEntity()
                    ), ""
                    . $linkSubjectAssess->getEntity() . DOT . $linkSubjectAssess->getCategoryAssessId() . EQUAL . $masterCategoryAssess->getEntity() . DOT . $masterCategoryAssess->getId()
                    . " AND " . $linkSubjectAssess->getEntity() . DOT . $linkSubjectAssess->getSubjectId() . equalToIgnoreCase($this->data_activity[0][$transactionActivity->getSubjectId()])
                    . " AND " . $linkSubjectAssess->getEntity() . DOT . $linkSubjectAssess->getCategoryAssessParentId() . equalToIgnoreCase($data_parent['id'])
            );
            $data_subject_assess = $db->getResult();
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width:70%;"><?= lang('member.description_field'); ?></th>
                        <th><?= lang('member.total_evaluator'); ?></th>
                        <th><?= lang('member.value'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    $total_all_value = 0;
//                    $average_value = 0;
                    foreach ($data_subject_assess as $value) {
                        $no += 1;
                        $db->select($transactionSurveyDetails->getEntity(), 'COUNT(' . $transactionSurvey->getUserAssignmentId() . ') as total', array($transactionSurvey->getEntity()), $transactionSurvey->getEntity() . DOT . $transactionSurvey->getId() . EQUAL . $transactionSurveyDetails->getEntity() . DOT . $transactionSurveyDetails->getSurveyId()
                                . " AND " . $transactionSurvey->getEntity() . DOT . $transactionSurvey->getTargetSurveyId() . equalToIgnoreCase($this->data_activity[0][$transactionActivity->getId()])
                                . " AND " . $transactionSurveyDetails->getEntity() . DOT . $transactionSurveyDetails->getCategoryAssessId() . equalToIgnoreCase($value['id'])
                                . " AND " . $transactionSurvey->getEntity() . DOT . $transactionSurvey->getUserAssignmentId() . equalToIgnoreCase($data_user_assign[0][$masterUserAssignment->getId()]));
//                        echo $db->querySql();
                        $rs_count_evaluator = $db->getResult();

                        $db->select($transactionSurveyDetails->getEntity(), 'SUM(' . $transactionSurveyDetails->getEntity() . DOT . $transactionSurveyDetails->getValue() . ') as total_nilai', array($transactionSurvey->getEntity()), $transactionSurvey->getEntity() . DOT . $transactionSurvey->getId() . EQUAL . $transactionSurveyDetails->getEntity() . DOT . $transactionSurveyDetails->getSurveyId()
                                . " AND " . $transactionSurvey->getEntity() . DOT . $transactionSurvey->getTargetSurveyId() . equalToIgnoreCase($this->data_activity[0][$transactionActivity->getId()])
                                . " AND " . $transactionSurveyDetails->getEntity() . DOT . $transactionSurveyDetails->getCategoryAssessId() . equalToIgnoreCase($value['id'])
                                . " AND " . $transactionSurvey->getEntity() . DOT . $transactionSurvey->getUserAssignmentId() . equalToIgnoreCase($data_user_assign[0][$masterUserAssignment->getId()]));
//                         
                        $rs_total_value = $db->getResult();

                        $total_value = number_format((float) $rs_total_value[0]['total_nilai'], 0, '.', '');
                        $total_all_value += $total_value;
//                        echo $db->querySql();
//                        print_r($rs_count_evaluator);
                        ?>



                        <tr>
                            <td><?= $value['name']; ?></td>
                            <td><?= $rs_count_evaluator[0]['total']; ?></td>
                            <td><?= $total_value; ?></td>
                        </tr>


                        <?php
                        /* echo Form()->formLayout(HORIZONTAL)
                          ->type('number')
                          ->attr('onkeyup="this.onchange()" onchange="calculateAll(' . $data_parent['id'] . ')" tripoin="number"')
                          ->id($value['id'])
                          ->name($value['code'])
                          ->title($value['name'])
                          ->label(0)
                          ->labels();
                         * 
                         */
                    }
                    $average_value = $total_all_value / $no;
                    $total_average_value = number_format((float) $average_value, 2, '.', '');
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" style="text-align: right;font-weight: bold;"><?= lang('member.total_value'); ?></td>
                        <td><?= $total_all_value; ?></td>
                    </tr>
                     <tr>
                        <td colspan="2" style="text-align: right;font-weight: bold;"><?= lang('member.average_value'); ?></td>
                        <td><?= $average_value; ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    <?php } ?>
</div>
<input type="hidden" id="id" name="id" value="<?= $_POST['id']; ?>"/>

<?= $Form->formFooter(null, ' '); ?>
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
