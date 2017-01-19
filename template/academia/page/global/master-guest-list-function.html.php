<!doctype html>
<html lang="en">
    <?= contentPage(); ?>
    <div id="content" class="container-fluid" style="padding-top: 85px;">
        <div class="row" id="breadcrumb">
            <!--<? breadCrumb($list_post_function[0][$mpf->getPost()->getTitle()]); ?>-->
            <?= breadCrumbV2($breadcrumb); ?>
        </div>
        <?php
        foreach ($list_function as $value) {
            $db->select($mpf->getEntity(), "*", array($mp->getEntity()), $mpf->getEntity().DOT.$mpf->getPost()->getId().EQUAL.$mp->getEntity().DOT.$mp->getId()." AND "
                    . "".$mpf->getEntity().DOT.$mpf->getFunction()->getId() . EQUAL . $value[$sf->getId()], $mpf->getPost()->getCreatedOn() . " AND "
                    .$mpf->getPost()->getPostStatus()."='published'". " DESC", "0,1");
            $last_post = $db->getResult();
//            echo $last_post[0][$mp->getImg()];
//            print_r($last_post);
            ?>
            <div class="row">
                <div class="col-xs-24 background_column" style="background: url(<?=URL('/contents/images/post/' . $last_post[0][$mp->getImg()]);?>)">
                     <!--<img src="http://localhost/talaindonesia/themes/default/../../contents/images/column/TALA-COLUMN_02.jpg"class="img-responsive"/>--> 
                    <div class="content_column col-md-offset-15 col-md-9 col-sm-12 col-xs-24 zeropad">
                        <a class="title_column" href="<?= URL($value[$sfa->getFunction()->getUrl()]); ?>"><?= $value[$sfa->getFunction()->getName()]; ?></a>
                        <br>
                        <label class="author_column">by <?= html_entity_decode($last_post[0][$mp->getAuthorName()]);?></label>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<?= endContentPage(); ?>
</html>