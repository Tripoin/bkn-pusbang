<?= $Form->formHeader(); ?>
<div>
    <ul class="nav nav-tabs">
        <?php
        $all_language = '';
        foreach ($this->data_lang as $val_lang) {
            $active = '';
            if ($val_lang[$this->lang->getCode()] == 'id') {
                $active = 'active';
            } else {
                $all_language .= $val_lang[$this->lang->getCode()] . ',';
            }
            ?>
            <li  class="<?= $active; ?>">
                <a href="#<?= $val_lang[$this->lang->getCode()]; ?>" data-toggle="tab" aria-expanded="false"> <?= $val_lang[$this->lang->getName()]; ?> </a>
            </li>
            <?php
        }
        $all_language = rtrim($all_language, ',');
        ?>
    </ul>
    <div class="tab-content">
        <?php echo $Form->id('code')->attr('readonly')->title(lang('posting.code'))->placeholder(lang('posting.code') . ' ....')->textbox(); ?>
        <?php
        foreach ($this->data_lang as $val_lang) {
            $active = '';
            $keyup = '';
            if ($val_lang[$this->lang->getCode()] == 'id') {
                $active = 'active';
                $keyup = 'onkeyup="autoCodeByTitle(this)"  onchange="autoCodeByTitle(this)"';
            }
            ?>
            <div class="tab-pane <?= $active; ?>" id="<?= $val_lang[$this->lang->getCode()]; ?>">
                <?php if ($val_lang[$this->lang->getCode()] == 'id') { ?>
                    <?php echo $Form->id('title_' . $val_lang[$this->lang->getCode()])->attr($keyup)->title(lang('posting.title'))->placeholder(lang('posting.title') . ' ....')->required(true)->textbox(); ?>
                    <?php echo $Form->id('subtitle_' . $val_lang[$this->lang->getCode()])->title(lang('posting.subtitle'))->placeholder(lang('posting.subtitle') . ' ....')->required(true)->textbox(); ?>
                    <?php echo $Form->id('description_' . $val_lang[$this->lang->getCode()])->title(lang('general.description'))->placeholder(lang('general.description') . ' ....')->required(true)->ckeditor(); ?>
                <?php } else { ?>
                    <?php echo $Form->id('title_' . $val_lang[$this->lang->getCode()])->attr($keyup)->title(lang('posting.title'))->placeholder(lang('posting.title') . ' ....')->required(false)->textbox(); ?>
                    <?php echo $Form->id('subtitle_' . $val_lang[$this->lang->getCode()])->title(lang('posting.subtitle'))->placeholder(lang('posting.subtitle') . ' ....')->required(false)->textbox(); ?>
                    <?php echo $Form->id('description_' . $val_lang[$this->lang->getCode()])->title(lang('general.description'))->placeholder(lang('general.description') . ' ....')->required(false)->ckeditor(); ?>
                <?php } ?>

            </div>
        <?php } ?>


        <?php echo $Form->id('author')->autocomplete(false)->title(lang('posting.author'))->data($this->data_author)->combobox(); ?>
        <div class="row" id="pageUploadImgThumb">
            <div class="col-md-6" id="pageThumb">
                <?php echo $Form->id('thumbnail')->title(lang('posting.thumbnail'))->fileinputimage(); ?>
                <div class="input-group" id="input-media-thumb">
                    <div class="input-icon">
                        <!--<i class="fa fa-lock fa-fw"></i>-->
                        <input class="form-control" type="text" 
                               name="media-thumbnail" id="media-thumbnail"> 
                    </div>
                    <span class="input-group-btn">
                        <button id="chooseMediaThumbnail" 
                                onclick="getMedia('<?= URL(getAdminTheme() . '/get-media'); ?>', 'media-thumbnail')" 
                                class="btn btn-success" type="button">
                            <i class="fa fa-picture-o fa-fw"></i> Random</button>
                    </span>
                </div>
            </div>
            <div class="col-md-6" id="pageImg">
                <?php echo $Form->id('image')->title(lang('posting.image'))->fileinputimage(); ?>
                <div class="input-group" id="input-media-image">
                    <div class="input-icon">
                        <!--<i class="fa fa-lock fa-fw"></i>-->
                        <input class="form-control" type="text" 
                               name="media-image" id="media-image"> 
                    </div>
                    <span class="input-group-btn">
                        <button id="chooseMediaThumbnail" 
                                onclick="getMedia('<?= URL(getAdminTheme() . '/get-media'); ?>', 'media-image')" 
                                class="btn btn-success" type="button">
                            <i class="fa fa-picture-o fa-fw"></i> Random</button>
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                From Media : <input style="cursor:pointer" value="true" onchange="setFromMediaThumb(this)" type="checkbox" id="from_media_thumb" name="from_media_thumb" />
            </div>
            <div class="col-md-6">
                From Media : <input style="cursor:pointer" value="true" onchange="setFromMediaImg(this)" type="checkbox" id="from_media_image" name="from_media_image" />
            </div>
        </div>
        <div class="form-group">
            No Image and No Thumbnail : <input style="cursor:pointer" value="true" onchange="setNoImageThumbPost(this)" type="checkbox" id="no_image" name="no_image" />
        </div>
        <input type="hidden" value="<?= $all_language; ?>" id="all_language" name="all_language"/>
        <?= $Form->formFooter($this->insertUrl, null, "postFormAjaxPost('" . $this->insertUrl . "')"); ?>
    </div>
</div>
<script>
    $(function () {
        $('#input-media-thumb').hide();
        $('#input-media-image').hide();
    });
    function setNoImageThumbPost(e) {
        if (e.checked) {
            $('#pageUploadImgThumb').hide();
        } else {
            $('#pageUploadImgThumb').show();
        }
    }

    function setFromMediaThumb(e) {
        if (e.checked) {
            $('#fileinput-thumbnail').hide();
            $('#input-media-thumb').show();
        } else {
            $('#fileinput-thumbnail').show();
            $('#input-media-thumb').hide();
        }
    }
    
    function setFromMediaImg(e) {
        if (e.checked) {
            $('#fileinput-image').hide();
            $('#input-media-image').show();
        } else {
            $('#fileinput-image').show();
            $('#input-media-image').hide();
        }
    }
    function autoCodeByTitle(e) {
        var val = e.value;
        var s = val.replace(/\ /g, '-');
        $('#code').val(s.toLowerCase());
    }
</script>