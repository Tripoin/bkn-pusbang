<?php

use app\Util\RestClient\TripoinRestClient;
use app\Model\SecurityFunctionLanguage;
use app\Util\Database;

$db = new Database();
$sfl = new SecurityFunctionLanguage();

$db->connect();


$tripoinRestClient = new TripoinRestClient();
$res_icon = $tripoinRestClient->doGET(URL('icon.json'));
$dt_icon = $res_icon->getBody;
?>
<?= $Form->formHeader(); ?>

<?php // echo $Form->id('code')->title(lang('general.code'))->value($get_data[$data->getCode()])->placeholder(lang('general.code') . ' ....')->textbox(); ?>
<?php // echo $Form->id('name')->title(lang('general.name'))->value($get_data[$data->getName()])->placeholder(lang('general.name') . ' ....')->textbox(); ?>
<?php // echo $Form->id('url')->title(lang('function.url'))->value($get_data[$data->getUrl()])->placeholder(lang('function.url') . ' ....')->textbox();   ?>
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
    <div class="row">
        <div class="col-md-6">
            <div class="tab-content">
                <?php echo $Form->id('code')->value($get_data[$data->getCode()])->attr('readonly')->title(lang('general.code'))->placeholder(lang('general.code') . ' ....')->textbox(); ?>
                <?php
                foreach ($this->data_lang as $val_lang) {
                    $ms_lang = $db->selectByID($sfl, $sfl->getFunctionId() . EQUAL . $get_data[$data->getId()] . ""
                            . " AND " . $sfl->getLanguageId() . EQUAL . "'" . $val_lang[$this->lang->getId()] . "'");
                    $active = '';
                    $keyup = '';
                    if ($val_lang[$this->lang->getCode()] == 'id') {
                        $active = 'active';
                        $keyup = 'onkeyup="autoCodeByTitle(this)"';
                    }
                    ?>
                    <div class="tab-pane <?= $active; ?>" id="<?= $val_lang[$this->lang->getCode()]; ?>">
                        <?php if ($val_lang[$this->lang->getCode()] == 'id') { ?>
                            <?php echo $Form->id('name_' . $val_lang[$this->lang->getCode()])->value($get_data[$data->getName()])->title(lang('general.name'))->placeholder(lang('general.name') . ' ....')->textbox(); ?>
                        <?php } else { ?>
                            <?php
                            if (empty($ms_lang)) {
                                echo $Form->id('name_' . $val_lang[$this->lang->getCode()])->value($get_data[$data->getName()])->title(lang('general.name'))->placeholder(lang('general.name') . ' ....')->textbox();
                            } else {
                                echo $Form->id('name_' . $val_lang[$this->lang->getCode()])->value($ms_lang[0][$data->getName()])->title(lang('general.name'))->placeholder(lang('general.name') . ' ....')->textbox();
                            }
                            ?>
                    <?php } ?>
                    </div>
                <?php } ?>
                <?php
                $getParent = 0;
                if ($get_data[$data->getParent()] != null) {
                    $getParent = $get_data[$data->getParent()];
                }
                ?>
                <?php echo $Form->id('url')->required(false)->value($get_data[$data->getUrl()])->title(lang('security.url'))->placeholder(lang('security.url') . ' ....')->textbox(); ?>
<?php echo $Form->id('parent')->value($getParent)->title(lang('security.function'))->data($this->data_function)->combobox(); ?>


            </div>
        </div>
        <div class="col-md-6">
            <?php $div = '<div><div class="typeahead-inner"><div class="item-body"><p class="item-heading"><i class="{{name}}" ></i> {{name}}</p></div></div></div>'; ?>
            <?php echo $Form->id('actionParameter')->value($get_data[$data->getActionParameter()])->title(lang('security.action_parameter'))->data($this->data_action_parameter)->combobox(); ?>
            <?php echo $Form->id('typeUrl')->value($get_data[$data->getTypeUrl()])->title(lang('security.page_type'))->data($this->data_url_type)->combobox(); ?>
            <?php echo $Form->id('type')->value($get_data[$data->getTypeId()])->title(lang('security.menu_type'))->data($this->data_type)->combobox(); ?>
            <?php
            echo Form()->layoutTypeAhead($div)->id('style')
                    ->data($dt_icon)->title(lang('security.icon_menu'))
                    ->required(false)->placeholder(lang('security.icon_menu') . ' ....')
                    ->value($get_data[$data->getStyle()])
                    ->withButton(array(
                        "title" => "Cari",
                        "icon" => "fa fa-search",
                        "onclick" => "getIcon()"
                    ))->typeahead();
            ?>
        </div>

    </div>
</div>
<input type="hidden" id="id" name="id" value="<?= $_POST['id']; ?>"/>

<?= $Form->formFooter($this->updateUrl); ?>
<script>
    $(function () {

    });

    function searchIcon(e) {
        $("#page-icon > a[data-original-title!='" + e.value + "']").hide();
        $("#page-icon > a[data-original-title*='" + e.value + "']").show();
    }

    function setToStyle(e) {
        var text = $(e).attr('data-original-title');
        $('#style').val(text);
        $('#modal-icon').modal("hide");
//        
    }
    function getIcon() {
        $('#modal-icon').modal("show");
    }
</script>
<div class='modal fade' id="modal-icon" data-color="grey" aria-hidden="true"> 
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" id="modal-header-self">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-11">
                            <h4 class="modal-title" id="modal-title-self">
                                Pilih Icon
                            </h4>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-circle btn-icon-only pull-right" data-dismiss="modal"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body" id="modal-body-self">
                <input type="text" class="form-control" onkeyup="searchIcon(this)" placeholder="Search Icon ..."/>
                <br/>
                <div id="page-icon">
                    <?php
                    foreach (json_decode($dt_icon) as $value) {
                        ?>
                        <a href="javascript:void(0)" onclick="setToStyle(this)" title="<?= $value->name; ?>" rel="tooltip" style="margin-bottom: 3px;" class="btn btn-icon-only default">
                            <i class="<?= $value->name; ?>"></i>
                        </a>
<?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>