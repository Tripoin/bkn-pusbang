<?=$Form->headListPostMember($this);?>
    <?php foreach ($list_gallery as $value) { ?>
        <?=$Form->listMemberPost($this,$memberPost,$value);?>
<!--            <li class="views-row box col-lg-8 col-md-8 col-sm-24 col-xs-24">
                <div class="row" style="background: url(<?= URL($this->upload_path_member . $_SESSION[SESSION_USERNAME] . '/' . $value[$memberPost->getImg()]); ?>); background-repeat: no-repeat;
                     /*background-attachment: fixed;*/
                     background-position: center;
                     background-size: 650px; 220px;">
                    <img class="base img-responsive" src="<?= URL('assets/images/blank.gif'); ?>" alt="">
                    <img class="thumb img-responsive" onerror="this.src='<?= URL('assets/img/no-photo_1.png'); ?>';" src="<?= URL($this->upload_path_member . $_SESSION[SESSION_USERNAME] . '/' . $value[$memberPost->getImg()]); ?>">
                    <div class="transparency">
                    </div>
                    <div class="tag"><?= $value[$memberPost->getTitle()]; ?>                            </div>
                    <div class="holder ">
                        <div class="hover_text noselect">
                            <div class="text text-center">
                                <h2>
                                    <?= $value[$memberPost->getTitle()]; ?><br/>
                                    <small class="text-info" style="color:white;"><?= $value[$memberPost->getSubtitle()]; ?></small>
                                </h2>
                            </div>
                            <div class="text text-center">
                                <button class="btn btn-circle btn-warning " onclick="postAjaxValue('<?= URL($this->edit_url); ?>', 'article_view_gallery', 'newEditGallery', 'id=<?= $value[$memberPost->getId()]; ?>')" title="<?= lang('general.edit'); ?>" rel="tooltip"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-circle btn-info "  onclick="postAjaxValue('<?= URL($this->view_url); ?>', 'article_view_gallery', 'newEditGallery', 'id=<?= $value[$memberPost->getId()]; ?>')" title="<?= lang('general.view'); ?>" rel="tooltip"><i class="fa fa-eye"></i></button>
                                <button class="btn btn-circle btn-danger " delete-title-alert="<?=lang('general.title_alert_delete');?>" delete-message-alert="<?=lang('general.message_alert_delete');?>"  delete-button-alert="<?=lang('general.button_alert_delete');?>" onclick="deleteMemberPost(this,'<?= URL($this->delete_url); ?>','article_view_gallery',<?= $value[$memberPost->getId()]; ?>)" title="<?= lang('general.delete'); ?>" rel="tooltip"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </li>-->
        <?php } ?>
<?=$Form->footerListPostMember($this,$pagination);?>