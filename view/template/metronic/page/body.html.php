<?php

use app\Model\MemberPost;
use app\Util\Database;
use app\Model\SecurityUser;
use app\Model\SecurityUserProfile;
use app\Model\MasterUserAssignment;
use app\Model\MasterUserMain;
use app\Model\TransactionEvaluation;
use app\Model\TransactionEvaluationDetails;
use app\Model\SecurityRole;
use app\Model\LinkRegistration;
use app\Model\TransactionRegistrationDetails;

$db = new Database();
$memberPost = new MemberPost();
$user = new SecurityUser();
$userProfile = new SecurityUserProfile();
$masterUserAssignment = new MasterUserAssignment();
$masterUserMain = new MasterUserMain();
$securityRole = new SecurityRole();
$transactionEvaluation = new TransactionEvaluation();
$transactionEvaluationDetails = new TransactionEvaluationDetails();
$regDetail = new TransactionRegistrationDetails();
$linkRegistration = new LinkRegistration();
$admin_url = getAdminTheme();
$db->connect();

$totalmonthyears = '';
$totalparticipant = '';
$totalwidyaiswara = '';
$totalorganizer = '';
for ($urut = 12; $urut >= 1; $urut--) {
    $newmonth = date("m", strtotime("-" . $urut . " months"));
    $newyears = date("Y", strtotime("-" . $urut . " months"));

    $db->select($masterUserAssignment->getEntity(), "COUNT(" . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getId() . ") as total", array($securityRole->getEntity()), ""
            . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getRoleId() . EQUAL . $securityRole->getEntity() . DOT . $securityRole->getId()
            . " AND " . $securityRole->getEntity() . DOT . $securityRole->getCode() . equalToIgnoreCase('PARTICIPANT')
            . " AND " . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getStatus() . equalToIgnoreCase(1)
            . " AND MONTH(" . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getCreatedOn() . ")" . equalToIgnoreCase($newmonth)
            . " AND YEAR(" . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getCreatedOn() . ")" . equalToIgnoreCase($newyears)
    );
    $rs_data_participant = $db->getResult();
    $totalparticipant .= $rs_data_participant[0]['total'] . ',';

    $db->select($masterUserAssignment->getEntity(), "COUNT(" . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getId() . ") as total", array($securityRole->getEntity()), ""
            . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getRoleId() . EQUAL . $securityRole->getEntity() . DOT . $securityRole->getId()
            . " AND " . $securityRole->getEntity() . DOT . $securityRole->getCode() . equalToIgnoreCase('ORGANIZER')
            . " AND " . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getStatus() . equalToIgnoreCase(1)
            . " AND MONTH(" . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getCreatedOn() . ")" . equalToIgnoreCase($newmonth)
            . " AND YEAR(" . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getCreatedOn() . ")" . equalToIgnoreCase($newyears)
    );
    $rs_data_organizer = $db->getResult();
    $totalorganizer .= $rs_data_organizer[0]['total'] . ',';

    $db->select($masterUserAssignment->getEntity(), "COUNT(" . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getId() . ") as total", array($securityRole->getEntity()), ""
            . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getRoleId() . EQUAL . $securityRole->getEntity() . DOT . $securityRole->getId()
            . " AND " . $securityRole->getEntity() . DOT . $securityRole->getCode() . equalToIgnoreCase('TRAINER')
            . " AND " . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getStatus() . equalToIgnoreCase(1)
            . " AND MONTH(" . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getCreatedOn() . ")" . equalToIgnoreCase($newmonth)
            . " AND YEAR(" . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getCreatedOn() . ")" . equalToIgnoreCase($newyears)
    );
    $rs_data_widyaiswara = $db->getResult();
    $totalwidyaiswara .= $rs_data_widyaiswara[0]['total'] . ',';

    $totalmonthyears .= "'" . getMonth($newmonth) . ' ' . $newyears . "',";
//    print_r($rs_data_participant);
}

$selectmonth = date("m");
$selectyears = date("Y");
if (isset($_GET['month']) && isset($_GET['years'])) {
    $selectmonth = $_GET['month'];
    $selectyears = $_GET['years'];
}

$db->select($transactionEvaluation->getEntity(),
//        "COUNT(".$transactionEvaluation->getId().") as total", 
//        "*", 
        $transactionEvaluation->getEntity() . DOT . $transactionEvaluation->getValue() . " as value ,"
        . $masterUserMain->getEntity() . DOT . $masterUserMain->getName() . " as name ", array($masterUserAssignment->getEntity(), $masterUserMain->getEntity()), ""
        . $transactionEvaluation->getEntity() . DOT . $transactionEvaluation->getUserAssignmentId() . EQUAL . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getId()
        . " AND " . $masterUserAssignment->getEntity() . DOT . $masterUserAssignment->getUser_main_id() . EQUAL . $masterUserMain->getEntity() . DOT . $masterUserMain->getId()
        . " AND MONTH(" . $transactionEvaluation->getEntity() . DOT . $transactionEvaluation->getCreatedOn() . ")" . equalToIgnoreCase($selectmonth)
        . " AND YEAR(" . $transactionEvaluation->getEntity() . DOT . $transactionEvaluation->getCreatedOn() . ")" . equalToIgnoreCase($selectyears)
        , null, '0,10');
//echo $db->getSql();
$rs_value_participant = $db->getResult();
$total_value_participant = 0;
$str_value_participant = "";

if (!empty($rs_value_participant)) {
    foreach ($rs_value_participant as $value) {
        $str_value_participant .= "['" . $value['name'] . "'," . $value['value'] . "],";
    }
} else {
    $str_value_participant .= "['Tidak ada Data',0]";
}

$db->select($linkRegistration->getEntity(), "COUNT(" . $regDetail->getEntity() . DOT . $regDetail->getId() . ") as total"
        . "", array($regDetail->getEntity()), ""
        . "  " . $linkRegistration->getEntity() . DOT . $linkRegistration->getRegistrationDetailsId() . EQUAL . $regDetail->getEntity() . DOT . $regDetail->getId() . ""
        . " AND " . $linkRegistration->getEntity() . DOT . $linkRegistration->getRegistrationDetailsId() . " is not null"
        . " AND " . $linkRegistration->getEntity() . DOT . $linkRegistration->getStatus() . " = 1 "
        . " AND " . $linkRegistration->getEntity() . DOT . $linkRegistration->getStatus() . " is not null "
        . " AND MONTH(" . $linkRegistration->getEntity() . DOT . $linkRegistration->getCreatedOn() . ")" . equalToIgnoreCase($selectmonth)
        . " AND YEAR(" . $linkRegistration->getEntity() . DOT . $linkRegistration->getCreatedOn() . ")" . equalToIgnoreCase($selectyears)
        . "", null, null);
//echo $db->getSql();
$rs_count_approve_participant = $db->getResult();
$str_jumlah_participant = "";
if (isset($rs_count_approve_participant[0]['total'])) {
    $str_jumlah_participant .= "['Approve'," . $rs_count_approve_participant[0]['total'] . "],";
} else {
    $str_jumlah_participant .= "['Approve',0],";
}

$db->select($linkRegistration->getEntity(), "COUNT(" . $regDetail->getEntity() . DOT . $regDetail->getId() . ") as total"
        . "", array($regDetail->getEntity()), ""
        . "  " . $linkRegistration->getEntity() . DOT . $linkRegistration->getRegistrationDetailsId() . EQUAL . $regDetail->getEntity() . DOT . $regDetail->getId() . ""
        . " AND " . $linkRegistration->getEntity() . DOT . $linkRegistration->getRegistrationDetailsId() . " is not null"
        . " AND " . $linkRegistration->getEntity() . DOT . $linkRegistration->getStatus() . " = 0 "
        . " AND " . $linkRegistration->getEntity() . DOT . $linkRegistration->getStatus() . " is not null "
        . " AND MONTH(" . $linkRegistration->getEntity() . DOT . $linkRegistration->getCreatedOn() . ")" . equalToIgnoreCase($selectmonth)
        . " AND YEAR(" . $linkRegistration->getEntity() . DOT . $linkRegistration->getCreatedOn() . ")" . equalToIgnoreCase($selectyears)
        . "", null, null);
//echo $db->getSql();
$rs_count_reject_participant = $db->getResult();
if (isset($rs_count_reject_participant[0]['total'])) {
    $str_jumlah_participant .= "['Reject'," . $rs_count_reject_participant[0]['total'] . "]";
} else {
    $str_jumlah_participant .= "['Reject',0]";
}
?>
<script src="<?= URL('/assets/plugins/highchart/5.0.10/highcharts.js'); ?>" type="text/javascript"></script>
<script src="<?= URL('/assets/plugins/highchart/5.0.10/highcharts-3d.js'); ?>" type="text/javascript"></script>
<script src="<?= URL('/assets/plugins/highchart/5.0.10/modules/exporting.js'); ?>" type="text/javascript"></script>
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <h1 class="page-title"> <?= lang('general.dashboard'); ?>
            <!--<small>bootstrap inputs, input groups, custom checkboxes and radio controls and more</small>-->
        </h1>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12 ">
                <div class="portlet light bordered">

                    <div class="search-page search-content-2">
                        <div class="search-bar bordered">
                            <form id="form-search-dashboard" action="<?= URL($admin_url); ?>" method="GET" >
<?php
//                                print_r($rs_value_participant);
//                                echo $str_value_participant;
$currentDate = date('Y-m-d');
?>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="col-lg-5">
                                            <select type="text" class="form-control" id="month" name="month">
<?php
for ($no = 1; $no <= 12; $no++) {
    $currentMonth = date('m');
    if (isset($_GET['month']) && isset($_GET['years'])) {
        if (intval($_GET['month']) == $no) {
            echo '<option value="' . $no . '" selected="selected">' . getMonth($no) . '</option>';
        } else {
            echo '<option value="' . $no . '">' . getMonth($no) . '</option>';
        }
    } else if (intval($currentMonth) == $no) {
        echo '<option value="' . $no . '" selected="selected">' . getMonth($no) . '</option>';
    } else {
        echo '<option value="' . $no . '">' . getMonth($no) . '</option>';
    }
    ?>

                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-5">
                                            <select type="text" class="form-control" id="years" name="years">
<?php
for ($no = 0; $no <= 3; $no++) {
    $yearsmin = strtotime($currentDate . ' -' . $no . ' year');
    $listYear = date('Y', $yearsmin);
    if (isset($_GET['month']) && isset($_GET['years'])) {
        if (intval($_GET['years']) == $listYear) {
            echo '<option value="' . $listYear . '" selected="selected">' . $listYear . '</option>';
        } else {
            echo '<option value="' . $listYear . '">' . $listYear . '</option>';
        }
    } else if (date('Y') == $listYear) {
        echo '<option value="' . $listYear . '" selected="selected">' . $listYear . '</option>';
    } else {
        echo '<option value="' . $listYear . '">' . $listYear . '</option>';
    }
    ?>

                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-lg-2 extra-buttons">
                                            <button class="btn btn-success" type="submit">
                                                <i class="fa fa-search"></i> <?= lang('general.search'); ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="row">
                    <div class="col-md-6 ">
                        <div class="portlet light bordered">
                            <div id="content-result-internal-participant" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="portlet light bordered">
                            <div id="content-result-peserta" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

                        </div>
                    </div>
                </div>
                <div class="portlet light bordered">

                    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>

        </div>
        <!-- END CONTENT BODY -->
    </div>

    <script type="text/javascript">

        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Jumlah Peserta'
            },
            xAxis: {
                categories: [<?= $totalmonthyears; ?>]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah Peserta'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
            legend: {
                align: 'right',
                x: -30,
                verticalAlign: 'top',
                y: 25,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                    }
                }
            },
            series: [{
                    name: 'Widyaiswara',
                    data: [<?= $totalwidyaiswara; ?>]
                }, {
                    name: 'Panitia',
                    data: [<?= $totalorganizer; ?>]
                }, {
                    name: 'Peserta',
                    data: [<?= $totalparticipant; ?>]
                }]
        });

        Highcharts.chart('content-result-peserta', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45,
                    beta: 0
                }
            },
            title: {
                text: 'Nilai Peserta Tertinggi'
            },
            tooltip: {
                pointFormat: '{series.name}: {point.y} - <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    depth: 35,
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}'
                    }
                }
            },
            series: [{
                    type: 'pie',
                    name: 'Nilai Peserta',
                    data: [
<?= $str_value_participant; ?>
                    ]
                }]
        });
        Highcharts.setOptions({
            colors: ['#50B432', '#f60000']
        });
        Highcharts.chart('content-result-internal-participant', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45,
                    beta: 0
                }
            },
            title: {
                text: 'Data External Peserta yang mendaftar'
            },
            tooltip: {
                pointFormat: '{series.name}: {point.y} - <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    depth: 35,
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}'
                    }
                }
            },
            series: [{
                    type: 'pie',
                    name: 'Jumlah Peserta',
                    data: [
<?= $str_jumlah_participant; ?>
                    ]
                }]
        });
    </script>