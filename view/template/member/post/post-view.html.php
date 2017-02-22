<div class="col-md-21">
    <h3>
        <?= $sg[$memberPost->getTitle()]; ?>
        <p>
            <small><?= $sg[$memberPost->getSubtitle()]; ?></small>
        </p>
    </h3>
    
    <small><?=lang('member.date');?> : <?= $sg[$memberPost->getDate()]; ?></small>
    <br/>
    <small>Author By : <?= $sg[$memberPost->getCreatedByUsername()]; ?></small>
</div>
<div class="col-md-2 pull-right">
    <button class="btn btn-danger " onclick="backMemberPostList()" title="<?= lang('general.back'); ?>" rel="tooltip"><i class="fa fa-arrow-left"></i> <?= lang('general.back'); ?></button>
</div>


<div class="col-md-24">
    <p>
        <img <?= notFoundImg(); ?> src="<?= URL($path . $sg[$memberPost->getImg()]); ?>"/>
        <br/>
        <?= html_entity_decode($sg[$memberPost->getContent()]) ?>
    </p>
</div>

<script>
    $(function () {
        $('#newEditGallery').show();
        $('#article_view_gallery').hide();

    });
    function backMemberPostList() {
        $('#newEditGallery').html('');
        $('#article_view_gallery').show();
    }
</script>