<?php

use app\Model\MasterDocumentation;
use app\Model\TransactionActivity;
use app\Model\LinkDocumentationFunction;
use app\Util\Database;

$transactionActivity = new TransactionActivity();
$masterDocumentation = new MasterDocumentation();
$linkDocumentationFunction = new LinkDocumentationFunction();
$db = new Database();
$db->connect();
$db->select($transactionActivity->getEntity(), "*", null, null, $transactionActivity->getCreatedOn() . " DESC ");
$rest_activity = $db->getResult();

$idDocM = "";
foreach ($dtLinkDocFunct as $valueLink) {
    $idDocM .= $valueLink[$linkDocumentationFunction->getDocumentationId()] . ",";
}
$trimIdDoc = rtrim($idDocM, ",");
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

            <?php
//                print_r($dtLinkDocFunct);
            if (!empty($dtLinkDocFunct)) {
                $no = 0;
                $modulus = 0;
                foreach ($rest_activity as $value) {

//                        echo $modulus;
                    $db->select($masterDocumentation->getEntity(), $masterDocumentation->getEntity() . ".*", array($linkDocumentationFunction->getEntity()), $masterDocumentation->getEntity() . DOT . $masterDocumentation->getId() . EQUAL . $linkDocumentationFunction->getEntity() . DOT . $linkDocumentationFunction->getDocumentationId() .
                            " AND " . $masterDocumentation->getEntity() . DOT . $masterDocumentation->getActivity_id() . EQUAL . $value[$transactionActivity->getId()] .
//                                " AND " . $masterDocumentation->getEntity() . DOT . $masterDocumentation->getId() . equalToIgnoreCase($dtLinkDocFunct[0][$linkDocumentationFunction->getDocumentationId()]), 
                            " AND " . $masterDocumentation->getEntity() . DOT . $masterDocumentation->getId() . " IN(" . $trimIdDoc . ")", $masterDocumentation->getCreatedOn() . " DESC ", "0,1");
                    $res_doc = $db->getResult();
//                    LOGGER();
                    $url = '';
                    if ($res_doc != null) {
                        $no++;
                        $modulus = $no % 4;
                        if ($modulus == 1) {
                            echo '<div class="col-sm-12 margin-bottom">';
                        }
                        if (substr($res_doc[0][$masterDocumentation->getDocumentation_image_url()], 0, 7) == "http://") {
                            $url = $res_doc[0][$masterDocumentation->getDocumentation_image_url()];
                        } else if (substr($res_doc[0][$masterDocumentation->getDocumentation_image_url()], 0, 8) == "https://") {
                            $url = $res_doc[0][$masterDocumentation->getDocumentation_image_url()];
                        } else {
                            $url = URL('contents/' . $res_doc[0][$masterDocumentation->getDocumentation_image_url()]);
                        }
                        $img_url = $url;
        $file_parts = pathinfo($res_doc[0][$masterDocumentation->getDocumentation_image_url()]);
        if ($file_parts['extension'] == "pdf") {
            $img_url = URL("assets/img/pdf.png");
        }
                        ?>
                        <div class="col-md-3 col-sm-3">
                            <div class="single_gellary_item">
                                <div class="gellary_thumb">
                                    <a href="javascript:void(0)" 
                                       onclick="ajaxPostModalGallery('<?= FULLURL(); ?>', '#galleria', 'id=<?= $value[$transactionActivity->getId()]; ?>&name=<?= $value[$transactionActivity->getName()]; ?>')"><img src="<?= $img_url; ?>" alt=""></a>						
                                </div>
                                <p><a  href="javascript:void(0)" onclick="ajaxPostModalGallery('<?= FULLURL(); ?>', '#galleria', 'id=<?= $value[$transactionActivity->getId()]; ?>&name=<?= $value[$transactionActivity->getName()]; ?>')"><?= $value[$transactionActivity->getName()]; ?></a></p>					
                            </div>
                        </div>
                        <?php
                        if ($modulus == 0) {
                            echo '</div>';
                        }
                    }
                }
            }
            ?>


            <!-- end single new_bulletin item -->
        </div>
    </div>
</div>

<?php include_once getTemplatePath('page/end-content-page.html.php'); ?>