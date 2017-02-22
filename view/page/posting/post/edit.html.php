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
        <?php echo $Form->id('code')->attr('readonly')->title(lang('posting.code'))->value($get_data[$data->getCode()])->placeholder(lang('posting.code') . ' ....')->textbox(); ?>
        <?php
        foreach ($this->data_lang as $val_lang) {
            $active = '';
            $keyup = '';
            if ($val_lang[$this->lang->getCode()] == 'id') {
                $active = 'active';
                $keyup = 'onkeyup="autoCodeByTitle(this)"';
                ?>
                <div class="tab-pane <?= $active; ?>" id="<?= $val_lang[$this->lang->getCode()]; ?>">
                    <?php echo $Form->id('title_' . $val_lang[$this->lang->getCode()])->value($get_data[$data->getTitle()])->title(lang('posting.title'))->placeholder(lang('posting.title') . ' ....')->textbox(); ?>
                    <?php echo $Form->id('subtitle_' . $val_lang[$this->lang->getCode()])->value($get_data[$data->getSubtitle()])->title(lang('posting.subtitle'))->placeholder(lang('posting.subtitle') . ' ....')->textbox(); ?>
                    <?php echo $Form->id('description_' . $val_lang[$this->lang->getCode()])->value($get_data[$data->getContent()])->title(lang('general.description'))->placeholder(lang('general.description') . ' ....')->ckeditor(); ?>
                </div>
                <?php
            } else {
                $dt_mstPostLang = $this->db->selectByID($this->masterPostLang, $this->masterPostLang->getPostId() . EQUAL . $_POST['id']
                        . " AND " . $this->masterPostLang->getLanguageId() . "='" . $val_lang[$this->lang->getId()] . "'");
//                print_r($dt_mstPostLang);
                if (!empty($dt_mstPostLang)) {
                    $title_lang = $dt_mstPostLang[0][$data->getTitle()];
                    $subtitle_lang = $dt_mstPostLang[0][$data->getSubtitle()];
                    $content_lang = $dt_mstPostLang[0][$data->getContent()];
                } else {
                    $title_lang = $get_data[$data->getTitle()];
                    if ($title_lang == "") {
                        if (isset($dt_mstPostLang[0][$data->getTitle()])) {
                            $title_lang = $dt_mstPostLang[0][$data->getTitle()];
                        } else {
                            $title_lang = '';
                        }
                    }
                    $subtitle_lang = $get_data[$data->getSubtitle()];
                    if ($subtitle_lang == "") {
                        if (isset($dt_mstPostLang[0][$data->getSubtitle()])) {
                            $subtitle_lang = $dt_mstPostLang[0][$data->getSubtitle()];
                        } else {
                            $subtitle_lang = '';
                        }
//                        $subtitle_lang = $dt_mstPostLang[0][$data->getSubtitle()];
                    }
                    $content_lang = $get_data[$data->getContent()];
                    if ($content_lang == "") {
                        if (isset($dt_mstPostLang[0][$data->getSubtitle()])) {
                            $content_lang = $dt_mstPostLang[0][$data->getContent()];
                        } else {
                            $content_lang = '';
                        }
//                        $content_lang = $dt_mstPostLang[0][$data->getContent()];
                    }
                }
                ?>
                <div class="tab-pane <?= $active; ?>" id="<?= $val_lang[$this->lang->getCode()]; ?>">
                    <?php echo $Form->id('title_' . $val_lang[$this->lang->getCode()])->value($title_lang)->title(lang('posting.title'))->placeholder(lang('posting.title') . ' ....')->textbox(); ?>
                    <?php echo $Form->id('subtitle_' . $val_lang[$this->lang->getCode()])->value($subtitle_lang)->title(lang('posting.subtitle'))->placeholder(lang('posting.subtitle') . ' ....')->textbox(); ?>
                    <?php echo $Form->id('description_' . $val_lang[$this->lang->getCode()])->value($content_lang)->title(lang('general.description'))->placeholder(lang('general.description') . ' ....')->ckeditor(); ?>
                </div>
            <?php } ?>
        <?php } ?>
        <?php // echo $Form->id('title')->title(lang('posting.title'))->value($get_data[$data->getTitle()])->placeholder(lang('posting.title') . ' ....')->textbox(); ?>
        <?php // echo $Form->id('subtitle')->title(lang('posting.subtitle'))->value($get_data[$data->getSubtitle()])->placeholder(lang('posting.subtitle') . ' ....')->textbox(); ?>
        <?php // echo $Form->id('description')->value($get_data[$data->getContent()])->title(lang('general.description'))->placeholder(lang('general.description') . ' ....')->ckeditor(); ?>

        <?php echo $Form->id('author')->autocomplete(false)->value($get_data[$data->getAuthorId()])->title(lang('posting.author'))->data($this->data_author)->combobox(); ?>
        <div class="row" id="pageUploadImgThumb">
            <div class="col-md-6" id="pageThumb">
                <?php echo $Form->id('thumbnail')->title(lang('posting.thumbnail'))->value(URL(DIR_WEB . $this->path_upload . $get_data[$data->getThumbnail()]))->fileinputimage(); ?>
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
                <?php echo $Form->id('image')->title(lang('posting.image'))->value(URL(DIR_WEB . $this->path_upload . $get_data[$data->getImg()]))->fileinputimage(); ?>
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
        <input type="hidden" id="id_post" name="id_post" value="<?= $_POST['id']; ?>"/>
        <input type="hidden" value="<?= $all_language; ?>" id="all_language" name="all_language"/>
        <?= $Form->formFooter($this->updateUrl, null, "postFormAjaxPost('" . $this->updateUrl . "')"); ?>
    </div>
</div>
<script>
    $(function () {
        <?php if ($get_data[$data->getNoImg()] == 1) { ?>
            $('#pageUploadImgThumb').hide();
            document.getElementById('no_image').checked = true;
        <?php } ?>
            $('#input-media-thumb').hide();
        $('#input-media-image').hide();
    })
    function setNoImageThumbPost(e) {
        if (e.checked) {
//            alert("No Image");
            $('#pageUploadImgThumb').hide();
        } else {
//            alert("Image");
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
</script>