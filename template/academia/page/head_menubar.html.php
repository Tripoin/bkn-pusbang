<?php

use app\Util\Database;
use app\Model\SecurityFunctionAssignment;
use app\Model\MasterLanguage;
use app\Model\SecurityFunctionLanguage;

$db = new Database();
$secFuncAssg = new SecurityFunctionAssignment();
$language = new MasterLanguage();
$sfLanguage = new SecurityFunctionLanguage();
?>
<div class="nav_area">
    <div class="container">
        <div class="row">
            <!--nav item-->
            <div class="col-md-12 col-sm-12 col-xs-12">
                <!--  nav menu-->
                <nav class="menu">
                    <ul class="navid pull-left">
                        <?php
                        $db->connect();
                        $db->select(
                                $secFuncAssg->getEntity(), $secFuncAssg->getFunction()->getEntity() . ".*", array($secFuncAssg->getFunction()->getEntity(), $secFuncAssg->getGroup()->getEntity()), $secFuncAssg->getFunction()->getEntity() . DOT . $secFuncAssg->getFunction()->getId() . EQUAL . $secFuncAssg->getEntity() . DOT . $secFuncAssg->getFunctionId()
                                . " AND " . $secFuncAssg->getGroup()->getEntity() . DOT . $secFuncAssg->getGroup()->getId() . EQUAL . $secFuncAssg->getEntity() . DOT . $secFuncAssg->getGroupId()
                                . " AND " . $secFuncAssg->getEntity() . DOT . $secFuncAssg->getStatus() . EQUAL . ONE
                                . " AND " . $secFuncAssg->getFunction()->getEntity() . DOT . $secFuncAssg->getStatus() . EQUAL . ONE
                                . " AND " . $secFuncAssg->getEntity() . DOT . $secFuncAssg->getGroupId() . EQUAL . ONE
                                . " AND " . $secFuncAssg->getFunction()->getEntity() . DOT . $secFuncAssg->getFunction()->getTypeId() . EQUAL . ONE
                                . " AND " . $secFuncAssg->getFunction()->getEntity() . DOT . $secFuncAssg->getFunction()->getLevel() . EQUAL . ZERO
                                . " AND " . $secFuncAssg->getGroup()->getEntity() . DOT . $secFuncAssg->getGroup()->getId() . EQUAL . ONE, $secFuncAssg->getFunctionAssignmentOrder() . ASC
                        );
//                        echo $db->getSql();
                        $function_parent = $db->getResult();
//                        print_r($function_parent);
                        $data_function = array();
                        $parent_child = "";
                        $langId = getSystemParameter('GENERAL_LANGUAGE_DEFAULT');
                        if (isset($_SESSION[LANGUAGE_SESSION])) {
                            $langId = getIdLanguageByCode($_SESSION[LANGUAGE_SESSION]);
                        }

                        foreach ($function_parent as $value) {

                            /*  $db->sql(SELECT . "COUNT(" . $secFuncAssg->getFunction()->getEntity() . DOT . $secFuncAssg->getFunction()->getId() . ") as count" .
                              //                            $secFuncAssg->getFunction()->getEntity().DOT.$secFuncAssg->getFunction()->getUrl().",".$secFuncAssg->getFunction()->getEntity().DOT.$secFuncAssg->getFunction()->getId().
                              FROM . $secFuncAssg->getEntity() . JOIN . $secFuncAssg->getFunction()->getEntity() .
                              ON . $secFuncAssg->getFunction()->getEntity() . DOT . $secFuncAssg->getFunction()->getId() . EQUAL . $secFuncAssg->getEntity() . DOT . $secFuncAssg->getFunction()->getId() .
                              WHERE . $secFuncAssg->getFunction()->getParent() . EQUAL . $value[$secFuncAssg->getFunction()->getId()]
                              );
                             * 
                             */
                            $db->select(
                                    $secFuncAssg->getEntity(), $secFuncAssg->getFunction()->getEntity() . ".*", array($secFuncAssg->getFunction()->getEntity(), $secFuncAssg->getGroup()->getEntity()), $secFuncAssg->getFunction()->getEntity() . DOT . $secFuncAssg->getFunction()->getId() . EQUAL . $secFuncAssg->getEntity() . DOT . $secFuncAssg->getFunctionId()
                                    . " AND " . $secFuncAssg->getGroup()->getEntity() . DOT . $secFuncAssg->getGroup()->getId() . EQUAL . $secFuncAssg->getEntity() . DOT . $secFuncAssg->getGroupId()
                                    . " AND " . $secFuncAssg->getEntity() . DOT . $secFuncAssg->getStatus() . EQUAL . ONE
                                    . " AND " . $secFuncAssg->getFunction()->getEntity() . DOT . $secFuncAssg->getStatus() . EQUAL . ONE
                                    . " AND " . $secFuncAssg->getEntity() . DOT . $secFuncAssg->getGroupId() . EQUAL . ONE
                                    . " AND " . $secFuncAssg->getGroup()->getEntity() . DOT . $secFuncAssg->getGroup()->getId() . EQUAL . ONE
                                    . " AND " . $secFuncAssg->getFunction()->getEntity() . DOT . $secFuncAssg->getFunction()->getParent() . EQUAL . $value[$secFuncAssg->getFunction()->getId()], $secFuncAssg->getFunctionAssignmentOrder() . ASC
                            );
//                            echo $db->getSql();
                            $sf_item = $db->getResult();
//                            $countitem = $sf_item[0]['count'];
                            $countitem = count($sf_item);
//                            echo $countitem;
                            $class = "";
                            if ($countitem != 0) {
                                $class = '<i class="fa fa-angle-down"></i>';
                            }

                            $convertLangFunction = $db->selectByID($sfLanguage, $sfLanguage->getFunctionId() . EQUAL . $value[$secFuncAssg->getFunction()->getId()]
                                    . " AND " . $sfLanguage->getLanguageId() . EQUAL . "'" . $langId . "'");
                            $functionName = $value[$secFuncAssg->getFunction()->getName()];
//                            print_r($convertLangFunction);
                            if (!empty($convertLangFunction)) {
                                $functionName = $convertLangFunction[0][$sfLanguage->getName()];
                            }
                            ?>
                            <li>
                                <a href="<?= URL($value[$secFuncAssg->getFunction()->getUrl()]); ?>"><?= $functionName; ?>
                                    <?= $class; ?>
                                </a>
                                <ul>
                                    <?php
                                    foreach ($sf_item as $value_child) {
                                        $convertLangFunctionChild = $db->selectByID($sfLanguage, $sfLanguage->getFunctionId() . EQUAL . $value_child[$secFuncAssg->getFunction()->getId()]
                                                . " AND " . $sfLanguage->getLanguageId() . EQUAL . "'" . $langId . "'");
                                        $functionNameChild = $value_child[$secFuncAssg->getFunction()->getName()];
//                            print_r($convertLangFunction);
                                        if (!empty($convertLangFunctionChild)) {
                                            $functionNameChild = $convertLangFunctionChild[0][$sfLanguage->getName()];
                                        }
                                        ?>
                                        <li><a href="<?= URL($value_child[$secFuncAssg->getFunction()->getUrl()]) ?>"><?= $functionNameChild; ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </nav>
                <!--end  nav menu-->

                <?php
                $data_user_login = checkUserLogin();
                if (empty($data_user_login)) {
                    ?>

                    <div class="search pull-right" id="btnUserLogin">
                        <div class="search-box">
                            <span class="search-open">
                                <i class="fa fa-user" rel="tooltip" onclick="ajaxPostModal('<?= URL('member/login'); ?>', 'E-PORTAL')" title="<?= lang('general.sign_in'); ?>"></i>
                            </span>
                        </div>
                    </div>
                <?php } else { ?>
                    <nav class="menu">
                        <ul class="navid pull-right">
                            <li>
                                <a href="#"><i class="fa fa-home" style="font-size: 20px;"></i></a>
                                <?php
                                $db->connect();
                                $db->select(
                                        $secFuncAssg->getEntity(), $secFuncAssg->getFunction()->getEntity() . ".*", array($secFuncAssg->getFunction()->getEntity(), $secFuncAssg->getGroup()->getEntity()), $secFuncAssg->getFunction()->getEntity() . DOT . $secFuncAssg->getFunction()->getId() . EQUAL . $secFuncAssg->getEntity() . DOT . $secFuncAssg->getFunctionId()
                                        . " AND " . $secFuncAssg->getGroup()->getEntity() . DOT . $secFuncAssg->getGroup()->getId() . EQUAL . $secFuncAssg->getEntity() . DOT . $secFuncAssg->getGroupId()
                                        . " AND " . $secFuncAssg->getEntity() . DOT . $secFuncAssg->getStatus() . EQUAL . ONE
                                        . " AND " . $secFuncAssg->getFunction()->getEntity() . DOT . $secFuncAssg->getStatus() . EQUAL . ONE
                                        . " AND " . $secFuncAssg->getEntity() . DOT . $secFuncAssg->getGroupId() . EQUAL . $_SESSION[SESSION_GROUP_GUEST]
                                        . " AND " . $secFuncAssg->getFunction()->getEntity() . DOT . $secFuncAssg->getFunction()->getTypeId() . EQUAL . ONE
                                        . " AND " . $secFuncAssg->getFunction()->getEntity() . DOT . $secFuncAssg->getFunction()->getLevel() . EQUAL . ZERO
                                        . " AND " . $secFuncAssg->getGroup()->getEntity() . DOT . $secFuncAssg->getGroup()->getId() . EQUAL . $_SESSION[SESSION_GROUP_GUEST], $secFuncAssg->getFunctionAssignmentOrder() . ASC
                                );
//                        echo $db->getSql();
                                $function_parent_member = $db->getResult();
//                                print_r($_SESSION[SESSION_GROUP_GUEST]);
                                ?>
                                <ul>
                                    <li>
                                        <a href="<?= URL('/page/member/dashboard'); ?>">
                                            <i class="fa fa-pie-chart"></i>
                                            <?=lang('general.dashboard');?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= URL('/page/logout'); ?>">
                                            <i class="fa fa-sign-out"></i>
                                            <?= lang('general.sign_out'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                <?php } ?>

                <div class="search pull-right">
                    <div class="search-box">
                        <input type="text" class="form_control" placeholder="<?= lang('general.search'); ?>" />
                        <span class="search-open"><i class="fa fa-search search"></i><i class="fa fa-close hidden close"></i></span>
                    </div>


                </div>

            </div>
            <!--end nav item -->
        </div>	
    </div>

</div>
<script>
    $(function () {
        $('[rel="tooltip"]').tooltip();
    })
</script>