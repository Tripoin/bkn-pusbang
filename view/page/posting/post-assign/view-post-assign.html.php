<?php
$path = URL(DIR_WEB . 'contents/images/post/');
?>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-12">
            <h4>
                <?= $data[0][$masterPost->getTitle()]; ?><br/>
                <small><?= $data[0][$masterPost->getSubtitle()]; ?></small>
            </h4>
            <img src="<?=$path.$data[0][$masterPost->getImg()];?>" height="300"/>
            <p>
                <?= html_entity_decode($data[0][$masterPost->getContent()]); ?>
            </p>
        </div>
    </div>
</div>