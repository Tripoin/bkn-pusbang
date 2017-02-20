<div id="pageListActivity">
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
                $startTime = date('h:i', strtotime($value[$activityDetails->getStartTime()]));
                $endTime = date('h:i', strtotime($value[$activityDetails->getEndTime()]));

                echo '<tr>';
                echo "<td>" . fullDateString($value[$activityDetails->getStartTime()]) . "</td>";
                echo "<td>" . $startTime . " - " . $endTime . "</td>";
                echo "<td>" . $value[$activityDetails->getMaterialName()] . "</td>";
                echo "<td>" . $value[$activityDetails->getDuration()] . "</td>";
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