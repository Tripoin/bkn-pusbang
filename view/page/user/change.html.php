<!doctype html>
<html lang="en">
    <?= contentPage(); ?>
    <div class="row">
        <div class="col-sm-12" style="margin-top: 20px;">
            <div class="col-sm-3">
                <?= getMenuUser(end($explode_uri)); ?>

            </div>
            <div class="col-sm-9">
                <!--      Wizard container        -->
                <!--<div class="wizard-container">-->

                <div class="card card-contact card-raised" id="wizardProfile">
                    <div class="header header-raised header-danger text-center">
                        <h4 class="card-title"><?= lang('general.change_profile'); ?></h4>
                    </div>
                    <form class="form" method="" action="">
                        <?php
                        
                        ?>
                        <div class="col-lg-6">
                            <?php
                            echo $Form->id('firstname')->title(lang('general.first_name'))->placeholder(lang('general.first_name') . ' ....')->textbox();
                            echo $Form->id('firstname')->title(lang('general.first_name'))->placeholder(lang('general.first_name') . ' ....')->datepicker();
                            ?>
                        </div>

                        <div class="col-lg-6">
                            <?php
                            echo $Form->id('birthdate')->title(lang('general.last_name'))->placeholder(lang('general.last_name') . ' ....')->textbox();
                            ?>
                        </div>                    
                      
                    </form>
                </div>
                <!--</div>-->
            </div>
        </div>
    </div>
    <?php include FILE_PATH('view/page/user/layout/change.html.php'); ?>


    <?= endContentPage(); ?>
    <script>
        $(function () {
            
            $('.menu-vertical').attr("class", "menu-vertical");
            $('.form-group').attr("style", "margin-top:-5px;");
        });
    </script>

</html>