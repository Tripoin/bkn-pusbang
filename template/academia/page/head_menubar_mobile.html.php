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
<div class="mobile_memu_area">
    <div class="container">
        <div class="row">
            <!--nav item-->
            <div class="col-md-12 col-sm-12 col-xs-12">
                <!--  nav menu-->

                <div class="mobile_memu">

                    <nav>
                        <ul class="navid">
                            <?php
                            $db->connect();


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
                                        . " AND " . $secFuncAssg->getFunction()->getEntity() . DOT . $secFuncAssg->getFunction()->getTypeId() . EQUAL . ONE
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
                                            <li><a href="<?= URL($value_child[$secFuncAssg->getFunction()->getUrl()]); ?>"><?= $functionNameChild; ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                        <div class="search pull-right">
                            <div class="search-box">
                                <span class="search-open"><i class="fa fa-user" rel="tooltip" onclick="ajaxPostModal('<?= URL('member/login'); ?>', 'LOGIN PAGE')" title="<?= lang('general.sign_in'); ?>"></i></span>
                            </div>
                        </div>
                    </nav>
                    <!--end  nav menu-->	
                    <?php // echo json_encode($db->getResult());  ?>

                </div>
            </div>
            <!--end nav item -->
        </div>	
    </div>

</div>