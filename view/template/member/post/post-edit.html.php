<form id="form-gallery" action="<?= URL($this->update_url); ?>" method="POST" class="form" onsubmit="return false;">
    <div class="alert alert-warning">
        <strong><?= lang('general.notes'); ?>:</strong> <?= lang('topupsaldo.notes_message_header'); ?>
    </div>
    <fieldset id="account">
        <legend>
            <?= $this->title_edit; ?>
            <div class="col-md-2 pull-right">
                <button class="btn btn-danger " onclick="backMemberPostList()" title="<?= lang('general.back'); ?>" rel="tooltip"><i class="fa fa-arrow-left"></i> <?= lang('general.back'); ?></button>
            </div>
        </legend>
        <?= $Form->id('title')->value($sg[$memberPost->getTitle()])->title(lang('member.title'))->placeholder(lang('member.title') . ' ....')->textbox(); ?>
        <?= $Form->id('subtitle')->value($sg[$memberPost->getSubtitle()])->title(lang('member.subtitle'))->placeholder(lang('member.subtitle') . ' ....')->textbox(); ?>
        <?= $Form->id('date')->value(date($sg[$memberPost->getDate()]))->title(lang('member.date'))->datepicker(); ?>
        <?= $Form->id('upload_image')->value($sg[$memberPost->getImg()])->title(lang('member.input_image'))->placeholder($sg[$memberPost->getImg()])->fileinput(); ?> 
        <?= $Form->id('description')->value($sg[$memberPost->getContent()])->attr('style="height:200px;"')->title(lang('member.description'))->placeholder(lang('member.description') . ' ....')->textarea(); ?> 
    </fieldset>
    <input type="hidden"  name="id" id="id" value="<?= $sg[$memberPost->getId()]; ?>"/>
    <button id="btn_signup" type="submit" onsubmit="return false;" onclick="return postAjaxUpload('form-gallery', 'form-gallery')" class="btn"><?= lang('general.update'); ?></button>
</form>

<script>
    $(function () {
        CKEDITOR.replace('description', {
            height: 200,
            removeButtons: ''
        });
        $('#newEditGallery').show();
        $('#article_view_gallery').hide();

        $('#upload_image').change(function () {
            var selected_file_name = $(this).val();
            if (selected_file_name.length > 0) {
                var filename = $('#upload_image').val();
                var splitname = filename.split('\\');
                var lengthsplit = parseFloat(splitname.length) - 1;
//            alert(filename);
                $('#valupload_image').html(splitname[lengthsplit]);
            } else {

            }
        });

    });
    function backMemberPostList() {
        $('#newEditGallery').html('');
        $('#article_view_gallery').show();
    }
</script>