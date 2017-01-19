<?php

use app\Util\Database;
use app\Model\SecurityFunctionAssignment;
use app\Model\SecurityLanguage;

$db = new Database();
$sfa = new SecurityFunctionAssignment();
$language = new SecurityLanguage();
//LOGGER('tes');
?>
<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>
            <!-- END SIDEBAR TOGGLER BUTTON -->
            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
            <li class="sidebar-search-wrapper">
                <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                <form class="sidebar-search  " action="page_general_search_3.html" method="POST">
                    <a href="javascript:;" class="remove">
                        <i class="icon-close"></i>
                    </a>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <a href="javascript:;" class="btn submit">
                                <i class="icon-magnifier"></i>
                            </a>
                        </span>
                    </div>
                </form>
                <!-- END RESPONSIVE QUICK SEARCH FORM -->
            </li>
            <?php
            $db->connect();
            $db->select(
                    $sfa->getEntity(), $sfa->getFunction()->getEntity() . ".*,".$sfa->getFunctionId(), array(
                $sfa->getFunction()->getEntity(),
                $sfa->getGroup()->getEntity()), $sfa->getFunction()->getEntity() . DOT . $sfa->getFunction()->getId() . EQUAL . $sfa->getEntity() . DOT . $sfa->getFunctionId()
                    . " AND " . $sfa->getGroup()->getEntity() . DOT . $sfa->getGroup()->getId() . EQUAL . $sfa->getEntity() . DOT . $sfa->getGroupId()
                    . " AND " . $sfa->getEntity() . DOT . $sfa->getStatus() . EQUAL . ONE
                    . " AND " . $sfa->getEntity() . DOT . $sfa->getGroupId() . EQUAL . $_SESSION[SESSION_GROUP]
                    . " AND " . $sfa->getFunction()->getEntity() . DOT . $sfa->getFunction()->getLevel() . EQUAL . ZERO
                    , $sfa->getFunctionAssignmentOrder() . ' ASC'
            );
            $function_parent = $db->getResult();
            
//            LOGGER($db->getSql());
//            $utfEncodedArray = array_map("utf8_encode", $inputArray );
//            LOGGER($function_parent);
//                    print_r($function_parent);
//                    echo json_encode($db->getResult());
            $data_function = array();
            $parent_child = "";
            foreach ($function_parent as $value) {
//                        $sf_item = $db->selectByID($sfa->getFunction(), $sfa->getFunction()->getParent() . EQUAL . $value[$sfa->getFunction()->getId()]);
                /* $sf_item = $db->sql('SELECT COUNT(security_function.function_id) as count FROM `security_function_assignment` JOIN security_function 
                  ON security_function.function_id=security_function_assignment.function_id
                  WHERE security_function.function_parent_id=6;'); */
                $db->sql(SELECT . "COUNT(" . $sfa->getFunction()->getEntity() . DOT . $sfa->getFunction()->getId() . ") as count" .
//                            $sfa->getFunction()->getEntity().DOT.$sfa->getFunction()->getUrl().",".$sfa->getFunction()->getEntity().DOT.$sfa->getFunction()->getId().
                        FROM . $sfa->getEntity() . JOIN . $sfa->getFunction()->getEntity() .
                        ON . $sfa->getFunction()->getEntity() . DOT . $sfa->getFunction()->getId() . EQUAL . $sfa->getEntity() . DOT . $sfa->getFunctionId() .
                        WHERE . $sfa->getFunction()->getParent() . EQUAL . $value[$sfa->getFunction()->getId()]
//                        ." ORDER BY ".$sfa->getFunctionAssignmentOrder() . ' ASC'
                );
                $sf_item = $db->getResult();
//                        print_r($sf_item);
//                LOGGER($sf_item);
                $countitem = intval($sf_item[0]['count']);
//                        echo $countitem;
                $arrow = "";
                $url_fix = "";
                $class = '';
                if ($countitem != 0) {
//                    echo 'masuk';
                    $arrow = '<span class="arrow"></span>';
                    $url_fix = 'javascript:;';
                    $class = 'nav-link nav-toggle';
                } else {
                    $url_fix = URL(getAdminTheme().$value[$sfa->getFunction()->getUrl()]);
                    $class = 'nav-link';
                }
//                        print_r($value);
                ?>
                <li id='<?= $value[$sfa->getFunction()->getCode()]; ?>' class="nav-item start " >

                    <a href='<?= $url_fix; ?>' title='<?= $value[$sfa->getFunction()->getName()]; ?>'  class="<?= $class; ?>">
                        <i class="<?= $value[$sfa->getFunction()->getStyle()]; ?>"></i>
                        <?= $value[$sfa->getFunction()->getName()]; ?>
                        <?= $arrow; ?>
                    </a>
                    <?php
                    $db->select(
                            $sfa->getEntity(), $sfa->getFunction()->getEntity() . ".*", 
                            array($sfa->getFunction()->getEntity(), $sfa->getGroup()->getEntity()), 
                            $sfa->getFunction()->getEntity() . DOT . $sfa->getFunction()->getId() . EQUAL . $sfa->getEntity() . DOT . $sfa->getFunctionId()
                            . " AND " . $sfa->getGroup()->getEntity() . DOT . $sfa->getGroup()->getId() . EQUAL . $sfa->getEntity() . DOT . $sfa->getGroupId()
                            . " AND " . $sfa->getEntity() . DOT . $sfa->getStatus() . EQUAL . ONE
                            . " AND " . $sfa->getEntity() . DOT . $sfa->getGroupId() . EQUAL . $_SESSION[SESSION_GROUP]
                            . " AND " . $sfa->getFunction()->getEntity() . DOT . $sfa->getFunction()->getParent() . EQUAL . $value[$sfa->getFunctionId()]
//                            . " AND " . $sfa->getFunction()->getEntity() . DOT . $sfa->getFunction()->getLevel() . EQUAL . ONE
                            , $sfa->getFunctionAssignmentOrder() . ' ASC'
                    );
                    $function_child = $db->getResult();
//                    LOGGER($function_child);
                    ?>

                    <ul class="sub-menu">
                        <?php foreach ($function_child as $value_child) { ?>
                            <li class="nav-item start ">
                                <a href="<?= URL(getAdminTheme().$value_child[$sfa->getFunction()->getUrl()]); ?>" class="nav-link">
                                    <i class="<?= $value_child[$sfa->getFunction()->getStyle()]; ?>"></i>
                                    <span class="title"><?= $value_child[$sfa->getFunction()->getName()]; ?></span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>

                </li>
                <?php
            }
            $db->disconnect();
            ?>
            <!--            <li class="nav-item start ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-home"></i>
                                <span class="title">Dashboard<?= $_SESSION[SESSION_GROUP]; ?></span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item start ">
                                    <a href="index.html" class="nav-link ">
                                        <i class="icon-bar-chart"></i>
                                        <span class="title">Dashboard 1</span>
                                    </a>
                                </li>
                                <li class="nav-item start ">
                                    <a href="dashboard_2.html" class="nav-link ">
                                        <i class="icon-bulb"></i>
                                        <span class="title">Dashboard 2</span>
                                        <span class="badge badge-success">1</span>
                                    </a>
                                </li>
                                <li class="nav-item start ">
                                    <a href="dashboard_3.html" class="nav-link ">
                                        <i class="icon-graph"></i>
                                        <span class="title">Dashboard 3</span>
                                        <span class="badge badge-danger">5</span>
                                    </a>
                                </li>
                            </ul>
                        </li>-->

        </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>