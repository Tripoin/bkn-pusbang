<?php

use app\Util\Database;
use app\Model\MasterSlider;

$db = new Database();
$slider = new MasterSlider();

$data_slider = $db->selectByID($slider, $slider->getStatus() . EQUAL . ONE);
?>
<div class="slider-wrap home-1-slider" id="home">
    <div id="mainSlider" class="nivoSlider slider-image">
        <?php foreach ($data_slider as $val_slider) { ?>
            <img src="<?= URLUPLOAD($val_slider[$slider->getImg()]); ?>" alt="<?= $val_slider[$slider->getTitle()]; ?>" title="#<?= $val_slider[$slider->getCode()]; ?>"/>
        <?php } ?>
    </div>
    <?php foreach ($data_slider as $val_slider) { ?>
    <div id="<?= $val_slider[$slider->getCode()]; ?>" class="nivo-html-caption slider-caption-1">
            <div class="slider-progress"></div>	
            <div class="container">
                <div class="row">
                    <div class="col-md-12">						
                        <div class="slide1-text slide-text">
                            <div class="middle-text">
                                <div class="left_sidet1">
                                    <div  style="margin-top:300px;" class="cap-title wow slideInRight"data-wow-duration=".9s" data-wow-delay="0s">
                                        <h1><?= $val_slider[$slider->getTitle()]; ?></h1>
                                    </div>
                                    <div  style="margin-top:0;" class="cap-dec wow slideInRight" data-wow-duration="1s" data-wow-delay=".5s">
                                        <h2><?= $val_slider[$slider->getSubtitle()]; ?></h2>
                                    </div>	
                                    <?php if (!ctype_space($val_slider[$slider->getTextButton()])) { ?>
                                        <div class="cap-readmore animated fadeInUpBig" data-wow-duration="2s" data-wow-delay=".5s">
                                            <a href="<?= $val_slider[$slider->getLink()]; ?>" ><?= $val_slider[$slider->getTextButton()]; ?></a>
                                        </div>
                                    <?php } ?>
                                </div>				
                            </div>	
                        </div>		
                    </div>
                </div>
            </div>					
        </div>
    <?php } ?>

</div>

<script>
    $(function () {
        $('#mainSlider').nivoSlider({
            directionNav: true,
            animSpeed: 500,
            effect: 'random',
            slices: 15,
            pauseTime: 6000,
            pauseOnHover: true,
            controlNav: false,
            prevText: '<i class="fa fa-angle-left nivo-prev-icon"></i>',
            nextText: '<i class="fa fa-angle-right nivo-next-icon"></i>'
        });
        new WOW().init();
    });
</script>