<form id="form-gallery" action="<?= URL($this->save_url); ?>" method="POST" class="form" onsubmit="return false;">
    <div class="alert alert-warning">
        <strong><?= lang('general.notes'); ?>:</strong> <?= lang('topupsaldo.notes_message_header'); ?>
    </div>
    <fieldset id="account">
        <legend>
            <?= $this->title_create; ?>
            <div class="col-md-2 pull-right">
                <button class="btn btn-danger " onclick="backMemberPostList()" title="<?= lang('general.back'); ?>" rel="tooltip"><i class="fa fa-arrow-left"></i> <?= lang('general.back'); ?></button>
            </div>
        </legend>
        <!--<? $Form->id('invoice_number')->value('')->title(lang('member.invoice_number'))->placeholder(lang('member.invoice_number_holder') . ' ....')->textbox(); ?>-->
        <?= $Form->id('title')->value('')->title(lang('member.title'))->placeholder(lang('member.title') . ' ....')->textbox(); ?>
        <?= $Form->id('subtitle')->value('')->title(lang('member.subtitle'))->placeholder(lang('member.subtitle') . ' ....')->textbox(); ?>
        <?= $Form->id('date')->value(date("Y-m-d"))->title(lang('member.date'))->datepicker(); ?>
        <?= $Form->id('upload_image')->value('')->title(lang('member.input_image'))->placeholder(lang('member.input_image') . ' ....')->fileinput(); ?> 
        <?= $Form->id('description')->value('')->attr('style="height:200px;"')->title(lang('member.description'))->placeholder(lang('member.description') . ' ....')->textarea(); ?> 
    </fieldset>
    <button id="btn_signup" type="submit" onsubmit="return false;" onclick="return postAjaxUpload('form-gallery', 'form-gallery')" class="btn"><?= lang('general.save'); ?></button>
</form>

<script>
    $(function () {

        CKEDITOR.replace('description', {
            height: 200,
            // By default, some basic text styles buttons are removed in the Standard preset.
            // The code below resets the default config.removeButtons setting.
            removeButtons: ''
        });
        $('#newEditGallery').show();
        $('#article_view_gallery').hide();

        $('#upload_image').change(function () {
            var selected_file_name = $(this).val();
            if (selected_file_name.length > 0) {
                /* Some file selected */
                var filename = $('#upload_image').val();
                var splitname = filename.split('\\');
                var lengthsplit = parseFloat(splitname.length) - 1;
//            alert(filename);
                $('#valupload_image').html(splitname[lengthsplit]);
            } else {
                /* No file selected or cancel/close
                 dialog button clicked */
                /* If user has select a file before,
                 when they submit, it will treated as
                 no file selected */
            }

        });
    });
    function backMemberPostList() {
        $('#newEditGallery').html('');
        $('#article_view_gallery').show();
    }
</script>