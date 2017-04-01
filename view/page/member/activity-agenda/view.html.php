<div id="pageListActivity">
    <?=$data_activity[0][$activity->getSubjectName()];?>
    :
    <?=subMonth($data_activity[0][$activity->getStartActivity()]) . ' - ' . subMonth($data_activity[0][$activity->getEndActivity()]);?>
    <table border="0" id="table-manual" class="table table-striped table-bordered order-column dataTable" width="100%">
        <thead>
            <tr>
                <th style="text-align: center" width="22%"><?= lang("transaction.day/date"); ?></th>
                <th style="text-align: center" width="13%"><?= lang("transaction.time"); ?></th>
                <th style="text-align: center" width="38%"><?= lang("transaction.material"); ?></th>
                <th style="text-align: center" width="11%"><?= lang("transaction.lesson_time"); ?></th>
                <th style="text-align: center" width="16%"><?= lang("transaction.trainer"); ?></th>
            </tr>
        </thead>
        <tbody>

            <?php
            foreach ($data_activity_details as $value) {
                $startTime = date('H:i', strtotime($value[$activityDetails->getStartTime()]));
                $endTime = date('H:i', strtotime($value[$activityDetails->getEndTime()]));

                echo '<tr>';
                echo "<td>" . fullDateString($value[$activityDetails->getStartTime()]) . "</td>";
                echo "<td style=\"text-align: center\">" . $startTime . " - " . $endTime . "</td>";
                echo "<td>" . $value[$activityDetails->getMaterialName()] . "</td>";
                if($value[$activityDetails->getDuration()] == 0 || $value[$activityDetails->getDuration()] == null)
                    echo "<td></td>";
                else
                    echo "<td style=\"text-align: center\">" . $value[$activityDetails->getDuration()] . "</td>";
                echo "<td>" . $value[$activityDetails->getUserMainName()] . "</td>";
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    <button id="btn_signup" class="btn btn-danger" type="submit" 
            onsubmit="return false;" onclick="postAjaxPaginationManual('pageListActivity')" 
            class="btn">
        <i class="fa fa-arrow-circle-left"></i> <?= lang('general.back'); ?>
    </button>
</div>