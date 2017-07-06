<?php

use app\Util\Database;
use app\Model\MasterQuestionCategory;
use app\Model\MasterQuestion;

$masterQuestionCategory = new MasterQuestionCategory();
$masterQuestion = new MasterQuestion();
$db = new Database();
$db->connect();

$db->select($masterQuestionCategory->getEntity(), "*", array(), $masterQuestionCategory->getStatus() . equalToIgnoreCase(1), $masterQuestionCategory->getCode() . " ASC ");
$data_question_category = $db->getResult();
?>

<style>
    #page-table-akd > tbody > tr{
        height: 30px;
    }
</style>
<?= Form()->formHeader(); ?>
<div class="col-md-12">
    <div class="title">
        <p class="lead" style="font-weight: bold;">
            KEBUTUHAN DIKLAT
        </p>
    </div>

    <?php
    $width_question = "48%";
    $width_answer = "13%";
    $border_color = "#e0e0e0";
    $no = 0;
    foreach ($data_question_category as $value_question_category) {
        $no++;
        ?>
        <p>
            <strong>
                <?php
                echo numberToRomawi($no) . ". ";
                echo $value_question_category[$masterQuestionCategory->getName()];
                ?>
            </strong>
            <?php
            $db->select($masterQuestion->getEntity(), "*", array(), ""
                    . $masterQuestion->getStatus() . equalToIgnoreCase(1) .
                    " AND " . $masterQuestion->getQuestionCategoryId() . equalToIgnoreCase($value_question_category[$masterQuestionCategory->getId()]), $masterQuestion->getId() . " ASC ");
            $data_question = $db->getResult();
            ?>
        <table border="0" style="width: 100%" id="page-table-akd">

            <?php
            $noQuestion = 0;
            $isMulMultipledLevelAKD = 0;
            foreach ($data_question as $value_question) {
                $noQuestion++;

                if ($value_question[$masterQuestion->getAnswerCategoryId()] == 2) {
                    $isMulMultipledLevelAKD++;
                } else {
                    $isMulMultipledLevelAKD = 0;
                }
                ?>
                <?php if ($isMulMultipledLevelAKD == 1) { ?>
                    <tr>
                        <td ></td>
                        <td colspan="2" style="border:1px <?=$border_color;?> solid;text-align: center;">
                            Tingkat Penguasaan Materi
                        </td>
                        <td colspan="2" style="border:1px <?=$border_color;?> solid;text-align: center;">
                            Tingkat Kepentingan Diklat
                        </td>
                    </tr>
                    <tr>
                        <td style="width: <?= $width_question; ?>"> </td>
                        <td style="width: <?= $width_answer; ?>;border:1px <?=$border_color;?> solid;text-align: center;">
                            Menguasai
                        </td>
                        <td style="width: <?= $width_answer; ?>;border:1px <?=$border_color;?> solid;text-align: center;">
                            Tidak Menguasai
                        </td>
                        <td style="width: <?= $width_answer; ?>;border:1px <?=$border_color;?> solid;text-align: center;">
                            Penting
                        </td>
                        <td style="width: <?= $width_answer; ?>;border:1px <?=$border_color;?> solid;text-align: center;">
                            Tidak Penting
                        </td>
                    </tr>
                <?php } ?>
                <?php if ($value_question[$masterQuestion->getAnswerCategoryId()] == 2) { ?>
                    <tr>
                        <td style="width: <?= $width_question; ?>"> <?php
                            echo $noQuestion . ". ";
                            echo $value_question[$masterQuestion->getDescription()];
                            ?></td>
                        <td style="width: <?= $width_answer; ?>;border:1px <?=$border_color;?> solid;text-align: center;">
                            <input type="radio" value="1"
                                   
                                   id="<?= $value_question_category[$masterQuestionCategory->getCode()]; ?><?= $value_question[$masterQuestion->getCode()]; ?>1" 
                                   name="<?= $value_question_category[$masterQuestionCategory->getCode()]; ?><?= $value_question[$masterQuestion->getCode()]; ?>1">
                        </td>
                        <td style="width: <?= $width_answer; ?>;border:1px <?=$border_color;?> solid;text-align: center;">
                            <input type="radio" value="0"
                                   id="<?= $value_question_category[$masterQuestionCategory->getCode()]; ?><?= $value_question[$masterQuestion->getCode()]; ?>1" 
                                   name="<?= $value_question_category[$masterQuestionCategory->getCode()]; ?><?= $value_question[$masterQuestion->getCode()]; ?>1">
                        </td>
                        <td style="width: <?= $width_answer; ?>;border:1px <?=$border_color;?> solid;text-align: center;">
                            <input type="radio" value="1"
                                   
                                   id="<?= $value_question_category[$masterQuestionCategory->getCode()]; ?><?= $value_question[$masterQuestion->getCode()]; ?>2" 
                                   name="<?= $value_question_category[$masterQuestionCategory->getCode()]; ?><?= $value_question[$masterQuestion->getCode()]; ?>2">
                        </td>
                        <td style="width: <?= $width_answer; ?>;border:1px <?=$border_color;?> solid;text-align: center;">
                            <input type="radio" value="0"
                                   id="<?= $value_question_category[$masterQuestionCategory->getCode()]; ?><?= $value_question[$masterQuestion->getCode()]; ?>2" 
                                   name="<?= $value_question_category[$masterQuestionCategory->getCode()]; ?><?= $value_question[$masterQuestion->getCode()]; ?>2">
                        </td>
                    </tr>
                <?php } else if ($value_question[$masterQuestion->getAnswerCategoryId()] == 1) { ?>
                    <tr>
                        <td style="width: <?= $width_question; ?>"> <?php
                            echo $noQuestion . ". ";
                            echo $value_question[$masterQuestion->getDescription()];
                            ?></td>
                        <td colspan="4"> 
                            <textarea 
                                id="<?= $value_question_category[$masterQuestionCategory->getCode()]; ?><?= $value_question[$masterQuestion->getCode()]; ?>" 
                                name="<?= $value_question_category[$masterQuestionCategory->getCode()]; ?><?= $value_question[$masterQuestion->getCode()]; ?>"
                                class="form-control" placeholder=""></textarea>
                        </td>
                    <?php } ?>
                    <?php
                }
                ?>
        </table>
    </p>
    <?php
}
?>
<input type="hidden" value="<?= $_SESSION[SESSION_CODE_AKD_GUEST]; ?>" id="requestCode" name="requestCode" />
</div>
<?= Form()->formFooter(null, '<button type="submit" onclick="postFormAjaxPostSetContent(\'' . URL('akd/submit-akd') . '\',\'form-newedit\')" class="read_more buttonc">submit</button>'); ?>
<div class="row">
    <div class="col-md-8">
        <div class="title">
            <p class="lead">
                <a href="javascript:void(0)" onclick="ajaxGetPage('<?= URL('akd/page-email-request-code'); ?>', 'pageAKD')">Kembali</a>

            </p>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('.alert-danger').hide();
    });

</script>