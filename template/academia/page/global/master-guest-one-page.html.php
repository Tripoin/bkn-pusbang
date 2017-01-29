<?php include_once getTemplatePath('page/content-page.html.php'); ?>
<?php
$getTitle = '';
$getSubTitle = '';
$getContent = '';
//                print_r($mp_lang);
if (!empty($mp_lang)) {
//                    $post_function_lang = $mp_lang;
    $getTitle = $mp_lang[0][$mpl->getTitle()];
    $getSubTitle = $mp_lang[0][$mpl->getSubtitle()];
    $getContent = $mp_lang[0][$mpl->getContent()];
} else {
    $getTitle = $post[$mpf->getPost()->getTitle()];
    $getSubTitle = $post[$mpf->getPost()->getSubtitle()];
    $getContent = $post[$mpf->getPost()->getContent()];
}


if (substr($post[$mpf->getPost()->getImg()], 0, 7) == "http://") {
    $url = $post[$mpf->getPost()->getImg()];
} else if (substr($post[$mpf->getPost()->getImg()], 0, 8) == "https://") {
    $url = $post[$mpf->getPost()->getImg()];
} else {
    $url = URL('contents/' . $post[$mpf->getPost()->getImg()]);
}
?>
<div class="faq_area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title">
                    <h3 class="module-title notice">
                        <span><?= $getTitle; ?></span>
                    </h3>					
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 margin-bottom">
                <div class="row">
                    <!-- single new_bulletin item -->
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="news_content news_buletin_pra">
                            <h2>
                                <!--<a href="single-blog.html">-->
                                <?= $getSubTitle; ?>
                                <!--</a>-->
                            </h2>
                            <p class="date">
                                <span><i class="fa fa-calendar"></i> <?= $post[$mpf->getPost()->getPublishOn()] ?></span>
                                <span><i class="fa fa-eye"></i> Hits: <?= $post[$mpf->getPost()->getReadCount()]; ?></span>
                            </p>								
                            <!--<p>Aliquam pellentesque velit et augue viverra dapibus. Cras tempus ultrices iaculis. Fusce feugiat, arcu condimentum malesuada sodales, quam elit porttitor neque, quis dictum felis lectus adipiscing ante.</p>-->
                            <?php if ($post[$mpf->getPost()->getNoImg()] != '1') { ?>
                                <div class="news_single_thumb">
                                    <img src="<?= $url; ?>" alt="">
                                    <!--<p class="img_caption">Aliquam pellentesque velit et augue viverra dapibus</p>-->
                                </div>
                            <?php } ?>
                            <div class="print prin_s">
                                <ul>
                                    <li><i class="fa fa-cog"></i><span><i class="fa fa-angle-down"></i></span>
                                        <ul class="print_drop">
                                            <li><a href="#"><i class="fa fa-print"></i> <span>Print</span></a></li>
                                            <li><a href="#"><i class="fa fa-envelope"></i><span>Email</span></a></li>
                                        </ul>									
                                    </li>
                                </ul>
                            </div>
                            <?= html_entity_decode($getContent); ?>
                            <?= shareSocMed(); ?>
                        </div>				
                    </div>				
                </div>
            </div>
            <!-- end single new_bulletin item -->
        </div>
    </div>
</div>


<?php include_once getTemplatePath('page/end-content-page.html.php'); ?>