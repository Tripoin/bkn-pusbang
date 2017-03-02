<?php

use app\Constant\IURLMemberConstant;
use app\Model\MasterWaitingList;
use app\Model\MasterUserAssignment;
use app\Util\Database;

$db = new Database();
$waitingList = new MasterWaitingList();
$userAssignment = new MasterUserAssignment();
$db->connect();
?>
<div id="pageListPeserta">
    <div class="row">
        <div class="col-md-7">
            <?= $data_activity[0][$modelActivity->getSubjectName()]; ?>
            :
            <?= subMonth($data_activity[0][$modelActivity->getStartActivity()]) . ' - ' . subMonth($data_activity[0][$modelActivity->getEndActivity()]); ?>
        </div>
        <div class="col-md-5" style="margin-bottom: 20px;" id="pageBtnHeader">

            <button id="buttonBack" title="<?= lang('general.back'); ?>" 
                    rel="tooltip"
                    class="btn btn-danger btn-sm pull-right" type="submit" 
                    onsubmit="return false;" onclick="pageParent()" 
                    style="margin-left: 10px;"
                    class="btn">
                <i class="fa fa-arrow-circle-left"></i> <?= lang('general.back'); ?>
            </button>

            <button id="btnChoose"  title="<?= lang('member.choose_participant'); ?>" 
                    rel="tooltip" style="margin-left: 10px;"
                    class="btn btn-warning btn-sm pull-right" type="submit" 
                    onsubmit="return false;" onclick="pageParent()" 
                    class="btn">
                <i class="fa fa-plus"></i> <?= lang('member.choose_participant'); ?>
            </button>
            <button id="btnAdd" title="<?= lang('member.add_participant'); ?>" 
                    rel="tooltip"
                    class="btn btn-warning btn-sm pull-right" type="submit" 
                    onsubmit="return false;" onclick="ajaxPostManual('<?= URL(IURLMemberConstant::ACTIVITY_REGISTRATION_TEMP_URL . '/list-user/' . $data_activity[0][$modelActivity->getId()] . '/create'); ?>', 'pageListPeserta', 'registration_id=<?= $_GET['registration_id']; ?>')" 
                    class="btn">
                <i class="fa fa-plus"></i> <?= lang('member.add_participant'); ?>
            </button>
        </div>
    </div>
    <div class="col-md-12">
        <?php
//    $Datatable->createButton(false);
        $Datatable->deleteCollection(false);
        $Datatable->backButton(true);

//    $Datatable->styleHeader(array("text-align:center;"));
        $Datatable->styleColumn(array("text-align:center;width:5%;", "", "", "", "", "text-align:center;width:10px;", "text-align:center;width:80px;"));
        $Datatable->header(array(lang("general.no"),
            lang("member.no_id"),
            lang("member.participant_name"),
            lang("member.time"),
            lang("general.status"),
            lang("general.detail"),
        ));
        $no = $list_data['from'];
        foreach ($list_data['item'] as $value) {
            $status = "";
            $detail = "";
            $Datatable->body(array($no,
                $value[$data->getIdNumber()],
                $value[$data->getName()],
                $value[$data->getCreatedOn()],
                $status,
                $detail));
            $no += 1;
        }


        echo $Datatable->show();
        ?>
    </div>

    <script>
        $(function () {
            $('.member-page > span').html('<?= lang('member.participant_registration'); ?>');
            initPage();
        });

        function initPage() {
            $('#list_search_by').attr("class", "input-sm input-xsmall input-inline");
            $('#search_pagination').attr("class", "form-control");
            $('#search_pagination').attr("style", "height:18px;");
            $('.pagination').attr("style", "margin-top:0");
        }
    </script>
</div>
<!--<script>location.reload(true);</script>-->
