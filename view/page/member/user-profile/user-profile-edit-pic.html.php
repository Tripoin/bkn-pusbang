<?php

use app\Model\MasterGovernmentAgencies;
use app\Model\TransactionRegistration;
use app\Model\MasterWorkingUnit;
use app\Model\MasterAddress;
use app\Model\MasterContact;
use app\Util\Database;

$db = new Database();
$db->connect();
$masterAddress = new MasterAddress();
$masterContact = new MasterContact();
$masterWorkingUnit = new MasterWorkingUnit();
$masterGovernmentAgency = new MasterGovernmentAgencies();
$transactionRegistration = new TransactionRegistration();
$government_name = "";
$encode_data_government = "";
if ($data_registration[0][$transactionRegistration->getParticipantTypeId()] == 2) {
    $db->select($masterGovernmentAgency->getEntity(), $masterGovernmentAgency->getId() . ","
            . $masterGovernmentAgency->getName(), array());
    $data_government = $db->getResult();
    $encode_data_government = json_encode($data_government);
} else {
    
}

$wu_agencies = "";
$wu_name = "";
$wu_phone_number = "";
$wu_fax = "";
$wu_address = "";
$wu_province = "";
$wu_city = "";
$wu_district = "";
$wu_village = "";
$wu_zipcode = "";
if (is_null($data_registration[0][$transactionRegistration->getWorkingUnitId()])) {
    if ($data_registration[0][$transactionRegistration->getParticipantTypeId()] == 2) {
        
    } else {
        $wu_agencies = $data_registration[0][$transactionRegistration->getWorkingUnitName()];;
    }
    $wu_phone_number = $data_registration[0][$transactionRegistration->getWuPhoneNumber()];
    $wu_fax = $data_registration[0][$transactionRegistration->getWuFax()];
    $wu_address = $data_registration[0][$transactionRegistration->getWuAddress()];
    $wu_province = $data_registration[0][$transactionRegistration->getWuProvinceId()];
    $wu_city = $data_registration[0][$transactionRegistration->getWuCityId()];
    $wu_district = $data_registration[0][$transactionRegistration->getWuDistrictId()];
    $wu_village = $data_registration[0][$transactionRegistration->getWuVillageId()];
    $wu_zipcode = $data_registration[0][$transactionRegistration->getWuZipCode()];
} else {
    $data_working_unit = $db->selectByID($masterWorkingUnit, $masterWorkingUnit->getId() . equalToIgnoreCase($data_registration[0][$transactionRegistration->getWorkingUnitId()]));
    if (!empty($data_working_unit)) {
        $wu_name = $data_working_unit[0][$masterWorkingUnit->getName()];
        $data_address = $db->selectByID($masterAddress, $masterAddress->getId() . equalToIgnoreCase($data_working_unit[0][$masterWorkingUnit->getAddress_id()]));
        if (!empty($data_address)) {
            $wu_address = $data_address[0][$masterAddress->getName()];
            $wu_province = $data_address[0][$masterAddress->getProvinceId()];
            $wu_city = $data_address[0][$masterAddress->getCityId()];
            $wu_district = $data_address[0][$masterAddress->getDistrictId()];
            $wu_village = $data_address[0][$masterAddress->getVillageId()];
            $wu_zipcode = $data_address[0][$masterAddress->getZipCode()];
        }

        $data_contact = $db->selectByID($masterContact, $masterContact->getId() . equalToIgnoreCase($data_working_unit[0][$masterWorkingUnit->getContact_id()]));
        if (!empty($data_contact)) {
            $wu_phone_number = $data_contact[0][$masterContact->getPhoneNumber1()];
            $wu_fax = $data_contact[0][$masterContact->getFax()];
        }
        $data_government_agencies = $db->selectByID($masterGovernmentAgency, $masterGovernmentAgency->getId() . equalToIgnoreCase($data_working_unit[0][$masterWorkingUnit->getGovernment_agency_id()]));
        if (!empty($data_government_agencies)) {
            $wu_agencies = $data_government_agencies[0][$masterGovernmentAgency->getName()];
        }
    }
}
//echo $encode_data_government; 
?>
<form id="form-newedit" action="<?= URL('/page/member/user-profile/save') ?>" method="POST" class="form" onsubmit="return false;">
    <div id="form-message"></div>
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#accountTab" data-toggle="tab"><?= lang('general.your_personal_details'); ?></a></li>
        <li role="presentation"><a href="#agencyTab" data-toggle="tab"><?= lang('general.agency'); ?></a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="accountTab">
            <fieldset id="account">

                <?= Form()->id('name')->value($userMember[$up->getEntity()][$up->getName()])->title(lang('general.name'))->placeholder(lang('general.first_name') . ' ....')->textbox(); ?>
                <?= Form()->id('email')->value($userMember[$su->getEntity()][$su->getEmail()])->title(lang('general.email'))->placeholder(lang('general.email') . ' ....')->textbox(); ?>
                <?=
                        Form()->id('telephone')->required(FALSE)
                        ->value($userMember[$masterContact->getEntity()][$masterContact->getPhoneNumber1()])->title(lang('general.telephone'))->placeholder(lang('general.telephone') . ' ....')->textbox();
                ?>
                <?=
                        Form()->id('birthdate')->required(FALSE)
                        ->value($userMember[$up->getEntity()][$up->getBirthdate()])->title(lang('user.birthdate'))->placeholder(lang('user.birthdate') . ' ....')->datepicker();
                ?>
                <?= Form()->id('place')->value($userMember[$up->getEntity()][$up->getPlace()])->title(lang('user.place_of_birth'))->placeholder(lang('user.place_of_birth') . ' ....')->textbox(); ?>
                <?=
                        Form()->id('gender')->value($userMember[$up->getEntity()][$up->getGender()])
                        ->data($data_denger)->title(lang('general.gender'))->placeholder(lang('general.gender') . ' ....')->combobox();
                ?>
                <?=
                        Form()->id('religion')->value($userMember[$up->getEntity()][$up->getReligionId()])->title(lang('general.religion'))
                        ->data($data_religion)->placeholder(lang('general.religion') . ' ....')->combobox();
                ?>
                <?=
                        Form()->id('maritalStatus')->required(FALSE)
                        ->value($userMember[$up->getEntity()][$up->getMarriage()])->title(lang('member.marital_status'))->data($data_maritalStatus)->placeholder(lang('member.marital_status') . ' ....')->combobox();
                ?>

                <?php
                $val_province = null;
                $val_city = null;
                $val_district = null;
                $val_village = null;
                ?>
                <?php
                echo Form()->id('province')->title(lang('general.province'))
                        ->data($data_province)->placeholder(lang('general.province') . ' ....')
                        ->autocomplete(false)->value($userMember[$masterAddress->getEntity()][$masterAddress->getProvinceId()])->required(FALSE)
                        ->attr('onchange="ajaxCombobox(\'province\',\'' . URL('selected?action=city') . '\', \'city\', \'\',\'' . $userMember[$masterAddress->getEntity()][$masterAddress->getCityId()] . '\');"')
                        ->combobox();
                ?>
                <?php
                echo Form()->id('city')->title(lang('general.city'))->placeholder(lang('general.city') . ' ....')
                        ->autocomplete(false)->value($userMember[$masterAddress->getEntity()][$masterAddress->getCityId()])->required(FALSE)
                        ->attr('onchange="ajaxCombobox(\'city\',\'' . URL('selected?action=district') . '\', \'district\', \'\',\'' . $userMember[$masterAddress->getEntity()][$masterAddress->getDistrictId()] . '\');"')
                        ->combobox();
                ?>
                <?php
                echo Form()->id('district')->title(lang('general.district'))->placeholder(lang('general.district') . ' ....')
                        ->autocomplete(false)->value($userMember[$masterAddress->getEntity()][$masterAddress->getDistrictId()])->required(FALSE)
                        ->attr('onchange="ajaxCombobox(\'district\',\'' . URL('selected?action=village') . '\', \'village\', \'\',\'' . $userMember[$masterAddress->getEntity()][$masterAddress->getVillageId()] . '\');"')
                        ->combobox();
                ?>
                <?= Form()->id('village')->required(FALSE)->value($userMember[$masterAddress->getEntity()][$masterAddress->getVillageId()])->title(lang('general.village'))->placeholder(lang('general.village') . ' ....')->combobox(); ?>
                <?= Form()->id('zipCode')->required(FALSE)->value($userMember[$masterAddress->getEntity()][$masterAddress->getZipCode()])->title(lang('general.zipCode'))->placeholder(lang('general.zipCode') . ' ....')->textbox(); ?>
                <?php // echo Form()->id('upload_img')->required(false)->value($cek_user_profile[0][$up->getPathimage()])->title(lang('user.change_profile_img'))->placeholder($cek_user_profile[0][$up->getPathimage()])->fileinput();   ?>
            </fieldset>
        </div>
        <div class="tab-pane" id="agencyTab">
            <fieldset id="agency">
                <?php
                if ($data_registration[0][$transactionRegistration->getParticipantTypeId()] == 2) {
                    ?>
                <div class="form-group">
                    <label class="control-label" for="focusedinput">
                        <span style="color:red;">*</span><?= lang('general.agency'); ?>
                    </label>
                    <div id="comp_agencies" class="">
                        <input type="text" placeholder="<?= lang('general.agency'); ?>" 
                               name="agencies_name" id="agencies_name" required="" value="<?= $wu_agencies; ?>" 
                               class="form-control typeahead" autocomplete="off">
                    </div>
                    <span class="material-input"></span>
                </div>

                <div class="form-group">
                    <label class="control-label" for="focusedinput">
                        <span style="color:red;">*</span><?= lang('member.working_unit'); ?>
                    </label>
                    <div id="comp_working_unit" class="">
                        <input type="text" placeholder="<?= lang('member.working_unit'); ?>" 
                               value="<?= $wu_name; ?>"
                               name="working_unit" id="working_unit" required="" value="" 
                               class="form-control" value=""  autocomplete="off">
                    </div>
                    <span class="material-input"></span>
                </div>
                <?php } else { ?>
                <?=
                        Form()->id('agencies_name')->required(FALSE)->value($wu_agencies)
                        ->title(lang('general.agency'))->placeholder(lang('general.agency') . ' ....')->textbox();
                ?>
                <?php } ?>
                <?=
                        Form()->id('wu_phone_number')->required(FALSE)->value($wu_phone_number)
                        ->title(lang('member.office_telephone'))->placeholder(lang('member.office_telephone') . ' ....')->textbox();
                ?>

                <?=
                        Form()->id('wu_fax')->required(FALSE)->value($wu_fax)
                        ->title(lang('member.office_fax'))->placeholder(lang('member.office_fax') . ' ....')->textbox();
                ?>
                <?=
                        Form()->id('wu_address')->required(FALSE)->value($wu_address)
                        ->title(lang('member.address_instansi'))->placeholder(lang('member.address_instansi') . ' ....')->textarea();
                ?>


                <?php
                echo Form()->id('wu_province')->title(lang('general.province'))
                        ->data($data_province)->placeholder(lang('general.province') . ' ....')
                        ->autocomplete(false)->value($wu_province)->required(FALSE)
                        ->attr('onchange="ajaxCombobox(\'wu_province\',\'' . URL('selected?action=city') . '\', \'wu_city\', \'\',\'' . $wu_city . '\');"')
                        ->combobox();
                ?>
                <?php
                echo Form()->id('wu_city')->title(lang('general.city'))->placeholder(lang('general.city') . ' ....')
                        ->autocomplete(false)->value($wu_city)->required(FALSE)
                        ->attr('onchange="ajaxCombobox(\'wu_city\',\'' . URL('selected?action=district') . '\', \'wu_district\', \'\',\'' . $wu_district . '\');"')
                        ->combobox();
                ?>
                <?php
                echo Form()->id('wu_district')->title(lang('general.district'))->placeholder(lang('general.district') . ' ....')
                        ->autocomplete(false)->required(FALSE)
                        ->attr('onchange="ajaxCombobox(\'wu_district\',\'' . URL('selected?action=village') . '\', \'wu_village\', \'\',\'' . $wu_village . '\');"')
                        ->combobox();
                ?>
                <?= Form()->id('wu_village')->required(FALSE)->title(lang('general.village'))->placeholder(lang('general.village') . ' ....')->combobox(); ?>
                <?= Form()->id('wu_zipCode')->required(FALSE)->value($wu_zipcode)->title(lang('general.zipCode'))->placeholder(lang('general.zipCode') . ' ....')->textbox(); ?>
            </fieldset>
        </div>


    </div>

    <button id="btn_signup" type="submit" onsubmit="return false;" 
            onclick="return postFormAjaxPostSetContent('<?= URL('/page/member/user-profile/save') ?>', 'form-newedit')" class="btn btn-danger"><?= lang('general.save'); ?>
    </button>
</form>


<script>
    $(function () {
        $('#province').change();
        $('#wu_province').change();
<?php if ($wu_agencies != "") { ?>
            getWUbyName('<?= $wu_agencies; ?>');
<?php } ?>
        var $input = $("#agencies_name");
        $input.typeahead({
            source: <?= $encode_data_government; ?>,
            autoSelect: true
        });
        $("#comp_agencies > ul > li").click(function () {
            alert("click");
            $("#agencies_name").val(this.innerHTML);
        });
        $input.change(function () {
//            getWUbyName($input.val());
            var current = $input.typeahead("getActive");
//            
//            getWUbyName(current.name);
            if (current) {
                getWUbyName($input.val());
//                $input.val(current.name);
                // Some item from your model is active!
                if (current.name == $input.val()) {
//                    alert("tes");
                    // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
                } else {
                    // This means it is only a partial match, you can either add a new item
                    // or take the active if you don't want new items
//                    alert("tes2");
                }
            } else {
//                alert("tes1");
                // Nothing is active so it is a new value (or maybe empty value)
            }
        });
    });

    function getWUbyName(value) {
        var page = '<?= URL('search/wu'); ?>';
        var contents = $('body');
        var datastring = 'action=list&name=' + value;
//alert(form.valid());
        contents.append('<div class="background-overlay" style="padding: 50%;"><div class="overlay-spinner2"></div></div>');
        $.ajax({
            type: "POST",
            url: page,
            data: datastring,
            success: function (data) {
                var parse = [];
                try {
                    parse = JSON.parse(data);
                } catch (err) {
                }
//                alert(parse.length);
                $('#working_unit').off();
                $('#working_unit').data('typeahead', (data = null))
                if (parse.length == 0) {

                } else {
                    var $input = $("#working_unit");
                    $input.typeahead({
                        source: parse,
                        autoSelect: true
                    });
                    $input.change(function () {
                        var current = $input.typeahead("getActive");
                        if (current) {
                            getSelectWUbyName($input.val());

                            // Some item from your model is active!
                            if (current.name == $input.val()) {
                                // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
                            } else {
                                // This means it is only a partial match, you can either add a new item
                                // or take the active if you don't want new items
                            }
                        } else {
                            // Nothing is active so it is a new value (or maybe empty value)
                        }
                    });
                }
                $('.background-overlay').remove();

            }, error: function (jqXHR, textStatus, errorThrown) {
                $('.background-overlay').remove();
            }
        });
    }

    function getSelectWUbyName(value) {
        var page = '<?= URL('search/wu'); ?>';
        var contents = $('body');
        var datastring = 'action=select&name=' + value;
//alert(form.valid());
        contents.append('<div class="background-overlay" style="padding: 50%;"><div class="overlay-spinner2"></div></div>');
        $.ajax({
            type: "POST",
            url: page,
            data: datastring,
            success: function (data) {
                var parse = [];
                try {
                    parse = JSON.parse(data);
                } catch (err) {
                }
                var wuPhoneNumber = $('#wu_phone_number');
                var wuFax = $('#wu_fax');
                var wuAddress = $('#wu_address');
                var wuProvince = $('#wu_province');
                var wuCity = $('#wu_city');
                var wuDistrict = $('#wu_district');
                var wuVillage = $('#wu_village');
                var wuZipcode = $('#wu_zipCode');
                if (parse.length != 0) {


                    wuPhoneNumber.val(parse.wuPhoneNumber);
                    wuFax.val(parse.wuFax);
                    wuAddress.val(parse.wuAddress);
                    wuProvince.val(parse.wuProvince);
                    wuCity.val(parse.wuCity);
                    wuDistrict.val(parse.wuDistrict);
                    wuVillage.val(parse.wuVillage);

                    wuProvince.attr("onchange", "ajaxCombobox('wu_province', '<?= URL('selected?action=city'); ?>', 'wu_city', '', '" + parse.wuCity + "');");
                    $('#wu_province').change();
                    wuCity.attr("onchange", "ajaxCombobox('wu_city', '<?= URL('selected?action=district'); ?>', 'wu_district', '', '" + parse.wuDistrict + "');");
                    $('#wu_city').change();
                    wuDistrict.attr("onchange", "ajaxCombobox('wu_district', '<?= URL('selected?action=village'); ?>', 'wu_village', '','" + parse.wuVillage + "');");
                    $('#wu_district').change();
                    wuZipcode.val(parse.wuZipcode);


                    wuPhoneNumber.attr("readonly", "readonly");
                    wuFax.attr("readonly", "readonly");
                    wuAddress.attr("readonly", "readonly");
                    wuProvince.attr("disabled", "disabled");
                    wuCity.attr("disabled", "disabled");
                    wuDistrict.attr("disabled", "disabled");
                    wuVillage.attr("disabled", "disabled");
                    wuZipcode.attr("readonly", "readonly");

//                     wuProvince.select2("enable", false);; 
//                     wuCity.select2("enable", false);; 
//                     wuDistrict.select2("enable", false);; 
//                     wuZipcode.select2('disabled'); 
//                    wuAddress.val(parse.wuAddress);
                } else {
                    wuPhoneNumber.removeAttr("readonly");
                    wuFax.removeAttr("readonly");
                    wuAddress.removeAttr("readonly");
                    wuProvince.removeAttr("disabled");
                    wuCity.removeAttr("disabled");
                    wuDistrict.removeAttr("disabled");
                    wuVillage.removeAttr("disabled");
                    wuZipcode.removeAttr("readonly");

                    wuPhoneNumber.val("");
                    wuFax.val("");
                    wuAddress.val("");
                    wuProvince.val("");
                    wuProvince.attr("onchange", "ajaxCombobox('wu_province', '<?= URL('selected?action=city'); ?>', 'wu_city', '', '');");
                    $('#wu_province').change();
                    wuCity.attr("onchange", "ajaxCombobox('wu_city', '<?= URL('selected?action=district'); ?>', 'wu_district', '', '');");
                    $('#wu_city').change();
                    wuDistrict.attr("onchange", "ajaxCombobox('wu_district', '<?= URL('selected?action=village'); ?>', 'wu_village', '','');");
                    $('#wu_district').change();
                    wuZipcode.val("");
                }


                $('.background-overlay').remove();

            }, error: function (jqXHR, textStatus, errorThrown) {
                $('.background-overlay').remove();
            }
        });
    }
</script>
