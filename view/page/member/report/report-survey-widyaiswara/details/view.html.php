<?php

use app\Constant\IURLMemberConstant;
use app\Model\TransactionSurvey;
use app\Model\TransactionSurveyDetails;
use app\Util\Database;

$db = new Database();
$db->connect();
$transactionSurvey = new TransactionSurvey();
$transactionSurveyDetails = new TransactionSurveyDetails();
?>

<?= $Form->formHeader(); ?>

<?php
echo Form()->attr('style="width:50%;"')
        ->title(lang('transaction.trainer'))
        ->label($dataActDetail[0]['user_main_name'])
        ->formLayout('horizontal')->labels();

echo Form()->attr('style="width:50%;"')
        ->title(lang('survey.material_name'))
        ->label($dataActDetail[0]['material_name'])
        ->formLayout('horizontal')->labels();

echo Form()->attr('style="width:50%;"')
        ->title(lang('transaction.execution_time'))
        ->label(fullDateString($dataActDetail[0]['start_time']) . ' ' . subTimeOnly($dataActDetail[0]['start_time']) . ' - ' . subTimeOnly($dataActDetail[0]['end_time']))
        ->formLayout('horizontal')->labels();

echo Form()->attr('style="width:50%;"')
        ->title(lang('transaction.subject_name'))
        ->label($dataAct[0]['subject_name'])
        ->formLayout('horizontal')->labels();
?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Aspek Penilaian</th>
            <th><?= lang('member.value'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_value = 0;
        $no = 0;
        foreach ($dataCtrAssess as $fieldLabel) {
            $no += 1;
            $db->select($transactionSurvey->getEntity(), "SUM(" . $transactionSurveyDetails->getEntity() . DOT . $transactionSurveyDetails->getValue() . ") as total_value", array($transactionSurveyDetails->getEntity()), ""
                    . $transactionSurveyDetails->getEntity() . DOT . $transactionSurveyDetails->getSurveyId() . EQUAL . $transactionSurvey->getEntity() . DOT . $transactionSurvey->getId()
                    . " AND " . $transactionSurvey->getEntity() . DOT . $transactionSurvey->getTargetSurveyId() . equalToIgnoreCase($_POST['id'])
                    . " AND " . $transactionSurvey->getEntity() . DOT . $transactionSurvey->getSurveyCategoryId() . equalToIgnoreCase(1)
                    . " AND " . $transactionSurveyDetails->getEntity() . DOT . $transactionSurveyDetails->getCategoryAssessId() . equalToIgnoreCase($fieldLabel['id'])
            );
            $rs_survey = $db->getResult();

//            print_r($rs_survey);
            $total_value += $rs_survey[0]['total_value'];
            echo '<tr>';
            if (empty($rs_survey)) {
                echo '<td>' . $fieldLabel['name'] . '</td>';
                echo '<td>0</td>';
            } else {
                echo '<td>' . $fieldLabel['name'] . '</td>';
                echo '<td>' . number_format($rs_survey[0]['total_value'],2) . '</td>';
            }

            /* echo Form()
              ->title($fieldLabel['name'])
              ->id($fieldLabel['code'])
              ->type('number')
              ->value(0)
              ->attr('style="width:30%;" tripoin="spinner" min="0" onchange="testFunction();" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"')
              ->formLayout('horizontal')->textbox();
             * 
             */
            echo '</tr>';
        }
        $rate_value = $total_value / $no;
        ?>
        <tr>
            <td><?= lang('member.total_value'); ?></td>
            <td><?= $total_value; ?></td>
        </tr>
        <tr>
            <td><?= lang('member.average_value'); ?></td>
            <td><?= $rate_value; ?></td>
        </tr>

    </tbody>
</table>

<input type="hidden" id="id" name="id" value="<?= $idActivityDetail; ?>"/>
<?= Form()->formFooter(null, ' '); ?>
<script>
    function testFunction() {
//        alert($('[name="spinner"]').attr());
        var values = [];
        $('[tripoin="spinner"]').each(function () {
            values.push($(this).val());
        });
        var calc = 0;
        var avg = 0;
        var ttlField = values.length;
        for (var no = 0; no < values.length; no++) {
            calc += parseInt(values[no]);
            avg = calc / ttlField;
        }

        $('#total').val(calc);
        $('#average').val(avg);
    }
    $(function () {

//        initDetails();
        $('#buttonBack').attr("onclick", "postAjaxEdit('<?= URL(IURLMemberConstant::REPORT_SURVEY_WIDYAISWARA_URL . '/create'); ?>','id=<?= $_POST['id_activity']; ?>')");
        $('#buttonCreate').hide();
    });


//location.reload(true);
</script>
