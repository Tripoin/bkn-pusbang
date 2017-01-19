<?php

use app\Util\Database;
use app\Model\MasterLanguage;

$db = new Database();
$language = new MasterLanguage();
?>
<div class="header_area">
    <div class="container">
        <div class="row">
            <!-- header  logo --> 
            <div class="col-md-4 col-sm-3 col-xs-12">
                <div class="logo">
                    <a href="<?=URL();?>">
                        <?php if (getSystemParameter('GENERAL_LOGO') == "") { ?>
                            <span style="font-size: 40px;"> <?= LOGO_TEXT; ?></span>
                        <?php } else { ?>
                            <?php if (getSystemParameter('GENERAL_LOGO_TYPE') == 1) { ?>
                                <span style="font-size: 40px;"> <?= getSystemParameter('GENERAL_LOGO'); ?></span>
                            <?php } else if (getSystemParameter('GENERAL_LOGO_TYPE') == 2) { ?>
                                <img src="<?= URLUPLOAD(getSystemParameter('GENERAL_LOGO')); ?>" alt="" />
                            <?php } ?>
                        <?php } ?>

                    </a>
                </div>
            </div>
            <!-- end header  logo --> 
            <div class="col-md-8 col-sm-9 col-xs-12">
                <div>
                    <div class="form pull-right">
                        <div class="language">
                            <select class="form-lan" onchange="changeLanguage('<?= URL('?' . LANGUAGE_SESSION . '='); ?>', this)">
                                <?php
                                $db->connect();
                                $db->select($language->getEntity());
                                $language_data = $db->getResult();
                                $count_lang = count($language_data);
                                $res_language = '';
                                $no_lang = 0;
                                $pipe_lang = '';
                                foreach ($language_data as $val_lang) {
                                    $no_lang += 1;

                                    if ($count_lang == $no_lang) {
                                        $pipe_lang = '';
                                    } else {
                                        $pipe_lang = ' <span class="fg-color-white">| </span> ';
                                    }
                                    if (isset($_SESSION[LANGUAGE_SESSION])) {
                                        if ($_SESSION[LANGUAGE_SESSION] == $val_lang[$language->getCode()]) {
                                            echo '<option value="' . $val_lang[$language->getCode()] . '" selected>' . $val_lang[$language->getName()] . '</option>';
//                                            $res_language .= strtoupper($val_lang[$language->getCode()]) . $pipe_lang;
                                        } else {
                                            echo '<option value="' . $val_lang[$language->getCode()] . '">' . $val_lang[$language->getName()] . '</option>';
//                                            $res_language .= '<a href="' . URL('?' . LANGUAGE_SESSION . '=' . $val_lang[$language->getCode()]) . '">' . strtoupper($val_lang[$language->getCode()]) . '</a>' . $pipe_lang;
                                        }
                                    } else {
                                        if (getSystemParameter('GENERAL_LANGUAGE_DEFAULT') == $val_lang[$language->getCode()]) {
                                            echo '<option value="' . $val_lang[$language->getCode()] . '" selected>' . $val_lang[$language->getName()] . '</option>';
//                                            $res_language .= strtoupper(LANGUAGE_DEFAULT) . $pipe_lang;
                                        } else {
                                            echo '<option value="' . $val_lang[$language->getCode()] . '">' . $val_lang[$language->getName()] . '</option>';
//                                            $res_language .= '<a href="' . URL('?' . LANGUAGE_SESSION . '=' . $val_lang[$language->getCode()]) . '">' . strtoupper($val_lang[$language->getCode()]) . '</a>' . $pipe_lang;
                                        }
                                    }
                                }
//                                echo $res_language;
                                ?>

                                <!--<option value="english">Arabic</option>-->
                            </select>
                        </div>
                    </div>
                    <div class="social_icon pull-right">
                        <p>
                            <a target="_blank" href="<?= getSystemParameter('GENERAL_FACEBOOK'); ?>" class="icon-set"><i class="fa fa-facebook"></i></a> 
                            <a target="_blank" href="<?= getSystemParameter('GENERAL_TWITTER'); ?>" class="icon-set"><i class="fa fa-twitter"></i></a> 
                            <a target="_blank" href="<?= getSystemParameter('GENERAL_LINKEDIN'); ?>" class="icon-set"><i class="fa fa-linkedin"></i></a>
                        </p>
                    </div>				
                </div>
                <div class="phone_address pull-right clear">
                    <p class="no-margin">
                        <small>
                            <span class="text-msg"><?=lang('general.have_any_question');?></span>
                            <span class="icon-set"><i class="fa fa-phone"></i> <?= getSystemParameter('CONTACT_PHONE'); ?></span> 
                            <span class="icon-set"><i class="fa fa-envelope"></i> <?= getSystemParameter('CONTACT_EMAIL'); ?></span> 
                        </small>
                    </p>				
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function changeLanguage(page, e) {
        window.location = page + e.value;
    }
</script>