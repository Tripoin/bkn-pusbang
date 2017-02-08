<?php

use app\Model\MasterDocumentation;
use app\Model\TransactionActivity;
use app\Util\Database;

$transactionActivity = new TransactionActivity();
$masterDocumentation = new MasterDocumentation();
$db = new Database();
$db->connect();
$db->select($transactionActivity->getEntity(), "*", null, null, $transactionActivity->getCreatedOn() . " DESC ");
$rest_activity = $db->getResult();
//print_r($rest_activity);
?>
<?php include_once getTemplatePath('page/content-page.html.php'); ?>
<?php ?>
<div class="faq_area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title">
                    <h3 class="module-title notice">
                        <span><?= $function[0][$mFunction->getName()] ?></span>
                    </h3>					
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 margin-bottom">
                <?php
                foreach ($rest_activity as $value) {
                    $db->select($masterDocumentation->getEntity(), "*", null, $masterDocumentation->getActivity_id() . EQUAL . $value[$transactionActivity->getId()], $masterDocumentation->getCreatedOn() . " DESC ", "0,1");
                    $res_doc = $db->getResult();
//                    LOGGER();
                    $url = '';
                    if (substr($res_doc[0][$masterDocumentation->getDocumentation_image_url()], 0, 7) == "http://") {
                        $url = $res_doc[0][$masterDocumentation->getDocumentation_image_url()];
                    } else if (substr($res_doc[0][$masterDocumentation->getDocumentation_image_url()], 0, 8) == "https://") {
                        $url = $res_doc[0][$masterDocumentation->getDocumentation_image_url()];
                    } else {
                        $url = URL('contents/' . $res_doc[0][$masterDocumentation->getDocumentation_image_url()]);
                    }
                    ?>
                    <div class="col-md-3 col-sm-3">
                        <div class="single_gellary_item">
                            <div class="gellary_thumb">
                                <a href="javascript:void(0)" onclick="ajaxPostModalGallery('<?= FULLURL(); ?>', '#galleria', 'id=<?= $value[$transactionActivity->getId()]; ?>&name=<?= $value[$transactionActivity->getName()]; ?>')"><img src="<?= $url; ?>" alt=""></a>						
                            </div>
                            <p><a  href="javascript:void(0)" onclick="ajaxPostModalGallery('<?= FULLURL(); ?>', '#galleria', 'id=<?= $value[$transactionActivity->getId()]; ?>&name=<?= $value[$transactionActivity->getName()]; ?>')"><?= $value[$transactionActivity->getName()]; ?></a></p>					
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- end single new_bulletin item -->
        </div>
    </div>
</div>

<?php include_once getTemplatePath('page/end-content-page.html.php'); ?>