<?php

use app\Model\MasterDocumentation;
use app\Model\TransactionActivity;
use app\Util\Database;

$transactionActivity = new TransactionActivity();
$masterDocumentation = new MasterDocumentation();
$db = new Database();
$db->connect();
$db->select($masterDocumentation->getEntity(), "*", null, $masterDocumentation->getActivityId() . EQUAL . $_POST['id'], $masterDocumentation->getCreatedOn() . " DESC ");
$rest_doc = $db->getResult();
?>
<style>
    .galleria{ width: 100%; height: 600px; background: #000 }
</style>
<div class="galleria" id="galleria">
    <?php
    foreach ($rest_doc as $value) {
        $url = '';
        if (substr($value[$masterDocumentation->getImageUrl()], 0, 7) == "http://") {
            $url = $value[$masterDocumentation->getImageUrl()];
        } else if (substr($value[$masterDocumentation->getImageUrl()], 0, 8) == "https://") {
            $url = $value[$masterDocumentation->getImageUrl()];
        } else {
            $url = URL('contents/' . $value[$masterDocumentation->getImageUrl()]);
        }
        ?>
        <a href="<?= $url; ?>"><img src="<?= $url; ?>" data-title="<?= $value[$masterDocumentation->getName()]; ?>" data-description="<?= $value[$masterDocumentation->getName()]; ?>"></a>
<?php } ?>
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