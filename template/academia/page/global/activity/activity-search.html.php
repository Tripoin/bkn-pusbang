<table border="0" class="table table-bordered">
    <tr style="background: #D01C24;color: #FFF">
        <th><?= lang('transaction.subject_name'); ?></th>
        <th><?= lang('transaction.batch'); ?></th>
        <th><?= lang('transaction.excecution_time'); ?></th>
        <th><?= lang('general.status'); ?></th>
    </tr>
    <?php
    $map_activity = array();
    $map_activity1 = array();
    foreach ($rs_activity as $data) {
        $data_subject = valueComboBoxParent($masterSubject->getEntity(), $masterSubject->getId(), $masterSubject->getName(), $masterSubject->getParentId(), $masterSubject->getId() . equalToIgnoreCase($data[$transActivity->getSubjectId()]));
//                print_r($data_subject);
//                print_r($data_subject);
        if (!empty($data_subject)) {
            $exp_subject = explode(">", $data_subject[0]['label']);
//                    echo end($exp_subject) . "<br/>";
            $str_replace_subject = str_replace(" >" . end($exp_subject), "", $data_subject[0]['label']);
//                echo $str_replace_subject."<br/>";
            if (in_array($str_replace_subject, $map_activity1)) {
                $map_activity1[$str_replace_subject][] = array(
                    "label" => end($exp_subject),
                    "id" => $data['id'],
                    "generation" => $data['generation'],
                    "budget_type_name" => $data['budget_type_name'],
                    "start_activity" => $data['start_activity'],
                    "end_activity" => $data['end_activity'],
                    "status" => $data['status'],
                );
            } else {
                $map_activity[] = array("label" => $str_replace_subject, "item" => [end($exp_subject)]);
                $map_activity1[] = $str_replace_subject;
                $map_activity1[$str_replace_subject][] = array(
                    "label" => end($exp_subject),
                    "id" => $data['id'],
                    "generation" => $data['generation'],
                    "budget_type_name" => $data['budget_type_name'],
                    "start_activity" => $data['start_activity'],
                    "end_activity" => $data['end_activity'],
                    "status" => $data['status'],
                );
            }
            ?>


            <?php
        }
    }
    for ($no = 0; $no < count($map_activity1); $no++) {
        if (isset($map_activity1[$no])) {
//                    echo $map_activity1[$no] . '<br/>';
            ?>
            <tr>
                <th colspan="4" style="background: #e6e6e6"><?php echo $map_activity1[$no]; ?></th>
            </tr>
            <?php
            for ($nos = 0; $nos < count($map_activity1[$map_activity1[$no]]); $nos++) {
//                        echo $map_activity1[$map_activity1[$no]][$nos]['label'] . '<br/>';
//                echo $map_activity1[$map_activity1[$no]][$nos]['start_activity']."<br/>";
                $exTime = lang('transaction.tentative');
                $due = strtotime($map_activity1[$map_activity1[$no]][$nos]['start_activity']);
                if ($due != strtotime('0000-00-00')) {
                    $exTime = subMonth($map_activity1[$map_activity1[$no]][$nos]['start_activity']) . " s/d " . subMonth($map_activity1[$map_activity1[$no]][$nos]['end_activity']);
                } else if ($map_activity1[$map_activity1[$no]][$nos]['start_activity'] == null) {
                    $exTime = lang('transaction.tentative');
                }
                ?>
                <tr>
                    <th><?php echo $map_activity1[$map_activity1[$no]][$nos]['label']; ?></th>
                    <th><?php echo $map_activity1[$map_activity1[$no]][$nos]['generation']; ?></th>
                    <th><?php echo $exTime ?></th>
                    <th>
                        <?php
                        $status = $map_activity1[$map_activity1[$no]][$nos]['status'];
                        if ($status == 1) {
                            $status = "Penuh";
                        } else {
                            $status = "<a href='" . URL('/activity/' . $map_activity1[$map_activity1[$no]][$nos]['id'] . '/register') . "'>Daftar</a>";
                        }

                        echo $status;
                        ?>
                    </th>
                </tr>
                <?php
            }
        }
    }
//            print_r($map_activity1);
//            echo json_encode($map_activity);
    ?>
</table>