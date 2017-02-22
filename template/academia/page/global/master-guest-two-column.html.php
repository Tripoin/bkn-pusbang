<!doctype html>
<html lang="en">
    <?= contentPage(); ?>
    <div id="content" class="container-fluid" style="padding-top: 130px;">
        <?= breadCrumb($list_post_function[0][$sf->getName()]); ?>
        <div class="row <?=$trim_parent_url;?>_page">
            <div class="hidden-xs hidden-sm col-md-offset-3 col-lg-offset-3 col-md-6 col-lg-6 sidebar">
                
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
                    $getTitle = $list_post_function[0][$mpf->getPost()->getTitle()];
                    $getSubTitle = $list_post_function[0][$mpf->getPost()->getSubtitle()];
                    $getContent = $list_post_function[0][$mpf->getPost()->getContent()];
                }
                ?>
                
                <ul id="<?=$trim_parent_url;?>_content">
                </ul>
            </div>
            <div class="col-md-12 col-lg-12 ">
                <div class="project_content" id="<?=$trim_parent_url;?>_contents">
                    <?php if (!empty($list_post_function)) { ?>
                        <div class="exceprt">
                            <?= $getTitle; ?>
                        </div>
                        <?= html_entity_decode($getContent); ?>
                    <?= shareSocMed(); ?>
                    <?php } ?>
                </div>
            </div>             
        </div>
    </div>

    <?= endContentPage(); ?>
    <script>
        $(function () {
            var menu_project = $('#<?=$trim_parent_url;?>').html();
            $('#<?=$trim_parent_url;?>_content').html(menu_project);
             if($('[id="<?=$list_post_function[0][$mpf->getFunction()->getCode()];?>"]')){
                    var uls = $('[id="<?=$list_post_function[0][$mpf->getFunction()->getCode()];?>"] > a').html();
                $('[id="<?=$list_post_function[0][$mpf->getFunction()->getCode()];?>"]').html(uls);
            
                
            }
            $("#<?=$trim_parent_url;?>_contents img").each(function () {
                var imgsrc = $(this).attr('src');
                var subsrcimg = imgsrc.substring(0,4);
                var rs_img = '';
                if(subsrcimg == 'http'){
                    rs_img = imgsrc;
                } else {
                    rs_img = '<?= URL(); ?>/' + imgsrc;
                }
                
                $(this).attr('src', rs_img);
//          images.push($(this).attr('src'))
//            alert($(this).attr('src'))
            })
            
        });
    </script>
</html>