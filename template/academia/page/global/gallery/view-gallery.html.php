<?php

use app\Model\MasterDocumentation;
use app\Model\TransactionActivity;
use app\Util\Database;

$transactionActivity = new TransactionActivity();
$masterDocumentation = new MasterDocumentation();
$db = new Database();
$db->connect();
$idDocM = "";
foreach ($dtLinkDocFunct as $valueLink) {
    $idDocM .= $valueLink[$linkDocumentationFunction->getDocumentationId()] . ",";
}
$trimIdDoc = rtrim($idDocM, ",");
//$db->select($masterDocumentation->getEntity(), "*", null, 
//        $masterDocumentation->getActivity_id() . EQUAL . $_POST['id'], $masterDocumentation->getCreatedOn() . " DESC ");
$db->select($masterDocumentation->getEntity(), $masterDocumentation->getEntity() . ".*", array($linkDocumentationFunction->getEntity()), $masterDocumentation->getEntity() . DOT . $masterDocumentation->getId() . EQUAL . $linkDocumentationFunction->getEntity() . DOT . $linkDocumentationFunction->getDocumentationId() .
        " AND " . $masterDocumentation->getEntity() . DOT . $masterDocumentation->getActivity_id() . equalToIgnoreCase($_POST['id']) .
        " AND " . $masterDocumentation->getEntity() . DOT . $masterDocumentation->getId() . " IN(" . $trimIdDoc . ")", $masterDocumentation->getEntity() . DOT . $masterDocumentation->getCreatedOn() . " DESC ");
$rest_doc = $db->getResult();
if (empty($trimIdDoc)) {
    $rest_doc = array();
}
?>
<style>
    .galleria{ width: 100%; height: 600px; background: #000 }
</style>
<?php
//print_r($rest_doc);
?>
<div class="galleria" id="galleria">
    <?php
    $img_url = "";
    foreach ($rest_doc as $value) {
        $url = '';
        if (substr($value[$masterDocumentation->getDocumentation_image_url()], 0, 7) == "http://") {
            $url = $value[$masterDocumentation->getDocumentation_image_url()];
        } else if (substr($value[$masterDocumentation->getDocumentation_image_url()], 0, 8) == "https://") {
            $url = $value[$masterDocumentation->getDocumentation_image_url()];
        } else {
            $url = URL('contents/' . $value[$masterDocumentation->getDocumentation_image_url()]);
        }
        $img_url = $url;
        $file_parts = pathinfo($value[$masterDocumentation->getDocumentation_image_url()]);
        if ($file_parts['extension'] == "pdf") {
            $img_url = URL("assets/img/pdf.png");
        }
        ?>
        <a href="<?= $img_url; ?>">
            <img src="<?= $img_url; ?>" data-title="<?= $value[$masterDocumentation->getName()]; ?>" 
                 data-description="<?= $value[$masterDocumentation->getName()]; ?> || <a href='<?= $url; ?>'>Download File</a>"></a>
        <?php } ?>
    <!--<a href="<?= $img_url; ?>"><img src="<?= $img_url; ?>" data-title="<?= $value[$masterDocumentation->getName()]; ?>" data-description="<?= $value[$masterDocumentation->getName()]; ?>"></a>-->
</div>

<script>
    (function () {
        $('#modal-title-self').html('<?= $_POST['name']; ?>');
//  var Galleria = new Galleria;
        Galleria.loadTheme('<?= URL('/assets/plugins/galleria/classic/galleria.classic.js'); ?>');
        Galleria.run('#galleria', {
            flickrOptions: {
                // sort by interestingness
                sort: 'interestingness-desc'
            },
            showInfo: true,
            trueFullscreen: true,
        });

// $('#gallery').galleria(
    }());
</script>