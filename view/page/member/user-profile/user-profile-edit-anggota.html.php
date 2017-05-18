<form id="form-user" action="<?= URL('/page/member/user-profile/save') ?>" method="POST" class="form" onsubmit="return false;">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#accountTab" data-toggle="tab"><?= lang('general.your_personal_details'); ?></a></li>
        <li role="presentation"><a href="#contactTab" data-toggle="tab"><?= lang('general.your_contact'); ?></a></li>
        <li role="presentation"><a href="#educationTab" data-toggle="tab"><?= lang('general.your_education'); ?></a></li>
        <li role="presentation"><a href="#companyTab" data-toggle="tab"><?= lang('general.your_company'); ?></a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="accountTab">
            <fieldset id="account">
                <?= Form()->id('name')->value($cek_user_profile[0][$up->getName()])->title(lang('general.name'))->placeholder(lang('general.first_name') . ' ....')->textbox(); ?>
                <?= Form()->id('idNumber')->value($user[0][$su->getEmail()])->title(lang('general.email'))->placeholder(lang('general.email') . ' ....')->textbox(); ?>
                <?= Form()->id('birthdate')->required(FALSE)->value($cek_user_profile[0][$up->getBirthdate()])->title(lang('user.birthdate'))->placeholder(lang('user.birthdate') . ' ....')->datepicker(); ?>
                <?= Form()->id('place')->value($cek_user_profile[0][$up->getPlace()])->title(lang('user.place_of_birth'))->placeholder(lang('user.place_of_birth') . ' ....')->textbox(); ?>
                <?= Form()->id('gender')->value($cek_user_profile[0][$up->getGender()])->data($data_denger)->title(lang('general.gender'))->placeholder(lang('general.gender') . ' ....')->combobox(); ?>
                <?= Form()->id('religion')->value($religion)->title(lang('general.religion'))->data($data_religion)->placeholder(lang('general.religion') . ' ....')->combobox(); ?>
                <?= Form()->id('maritalStatus')->required(FALSE)->value($cek_user_profile[0][$up->getMarriage()])->title(lang('general.maritalStatus'))->data($data_maritalStatus)->placeholder(lang('general.maritalStatus') . ' ....')->combobox(); ?>
                <?= Form()->id('upload_img')->required(false)->value($cek_user_profile[0][$up->getPathimage()])->title(lang('user.change_profile_img'))->placeholder($cek_user_profile[0][$up->getPathimage()])->fileinput(); ?>
            </fieldset>
        </div>
        <div class="tab-pane" id="contactTab">
            <fieldset id="contact">
                <?= Form()->id('email')->value($user[0][$su->getEmail()])->title(lang('general.email'))->placeholder(lang('general.email') . ' ....')->textbox(); ?>
                <?= Form()->id('telephone')->required(FALSE)->value($phone1)->title(lang('general.telephone'))->placeholder(lang('general.telephone') . ' ....')->textbox(); ?>
                <?= Form()->id('telephone2')->required(FALSE)->value($phone2)->title(lang('general.telephone2'))->placeholder(lang('general.telephone2') . ' ....')->textbox(); ?>
                <?= Form()->id('addressName')->required(FALSE)->value($addressName)->title(lang('general.addressName'))->placeholder(lang('general.addressName') . ' ....')->textbox(); ?>
                <?php echo Form()->id('province')->title(lang('general.province'))
                        ->data($data_province)->placeholder(lang('general.province') . ' ....')
                        ->autocomplete(false)->value($province)->required(FALSE)
                        ->attr('onchange="ajaxCombobox(\'province\',\'' . URL('selected?action=city') . '\', \'city\', \'\',\''.$city.'\');"')
                        ->combobox(); ?>
                <?php echo Form()->id('city')->title(lang('general.city'))->placeholder(lang('general.city') . ' ....')
                        ->autocomplete(false)->value($city)->required(FALSE)
                        ->attr('onchange="ajaxCombobox(\'city\',\'' . URL('selected?action=district') . '\', \'district\', \'\',\''.$district.'\');"')
                        ->combobox(); ?>
                <?php echo Form()->id('district')->title(lang('general.district'))->placeholder(lang('general.district') . ' ....')
                        ->autocomplete(false)->value($district)->required(FALSE)
                        ->attr('onchange="ajaxCombobox(\'district\',\'' . URL('selected?action=village') . '\', \'village\', \'\',\''.$village.'\');"')
                        ->combobox(); ?>
                <?= Form()->id('village')->required(FALSE)->value($village)->data($data_village)->title(lang('general.village'))->placeholder(lang('general.village') . ' ....')->combobox(); ?>
                <?= Form()->id('zipCode')->required(FALSE)->value($zipCode)->title(lang('general.zipCode'))->placeholder(lang('general.zipCode') . ' ....')->textbox(); ?>
            </fieldset>
        </div>
        <div class="tab-pane" id="educationTab">
            <fieldset id="education">
                <?= Form()->id('companyName')->value($company_name)->data($data_company)->title(lang('general.your_company'))->placeholder(lang('general.your_company') . ' ....')->attr('disabled')->combobox(); ?>
                <?= Form()->id('companyUnit')->value($company_unit)->title(lang('general.company_unit'))->placeholder(lang('general.company_unit') . ' ....')->attr('disabled')->textbox(); ?>
                <?= Form()->id('companyAddress')->required(FALSE)->value($company_address)->title(lang('general.company_address'))->placeholder(lang('general.company_address') . ' ....')->attr('disabled')->textbox(); ?>
                <?= Form()->id('companyProvince')->required(FALSE)->value($company_province)->data($data_province)->title(lang('general.company_province'))->placeholder(lang('general.company_province') . ' ....')->attr('disabled')->combobox(); ?>
                <?= Form()->id('companyCity')->required(FALSE)->value($company_city)->data($data_city)->title(lang('general.company_city'))->placeholder(lang('general.company_city') . ' ....')->attr('disabled')->combobox(); ?>
                <?= Form()->id('companyDistrict')->required(FALSE)->value($company_district)->data($data_district_company)->title(lang('general.company_district'))->placeholder(lang('general.company_district') . ' ....')->attr('disabled')->combobox(); ?>
                <?= Form()->id('companyVillage')->required(FALSE)->value($company_village)->data($data_village_company)->title(lang('general.company_village'))->placeholder(lang('general.company_village') . ' ....')->attr('disabled')->combobox(); ?>
                <?= Form()->id('companyZipCode')->required(FALSE)->value($company_zip_code)->title(lang('general.company_zip_code'))->placeholder(lang('general.company_zip_code') . ' ....')->attr('disabled')->textbox(); ?>
            </fieldset>
        </div>
        <div class="tab-pane" id="companyTab">
            <fieldset id="company">
                <?= Form()->id('companyName')->value($company_name)->data($data_company)->title(lang('general.your_company'))->placeholder(lang('general.your_company') . ' ....')->attr('disabled')->combobox(); ?>
                <?= Form()->id('companyUnit')->value($company_unit)->title(lang('general.company_unit'))->placeholder(lang('general.company_unit') . ' ....')->attr('disabled')->textbox(); ?>
                <?= Form()->id('companyAddress')->required(FALSE)->value($company_address)->title(lang('general.company_address'))->placeholder(lang('general.company_address') . ' ....')->attr('disabled')->textbox(); ?>
                <?= Form()->id('companyProvince')->required(FALSE)->value($company_province)->data($data_province)->title(lang('general.company_province'))->placeholder(lang('general.company_province') . ' ....')->attr('disabled')->combobox(); ?>
                <?= Form()->id('companyCity')->required(FALSE)->value($company_city)->data($data_city)->title(lang('general.company_city'))->placeholder(lang('general.company_city') . ' ....')->attr('disabled')->combobox(); ?>
                <?= Form()->id('companyDistrict')->required(FALSE)->value($company_district)->data($data_district_company)->title(lang('general.company_district'))->placeholder(lang('general.company_district') . ' ....')->attr('disabled')->combobox(); ?>
                <?= Form()->id('companyVillage')->required(FALSE)->value($company_village)->data($data_village_company)->title(lang('general.company_village'))->placeholder(lang('general.company_village') . ' ....')->attr('disabled')->combobox(); ?>
                <?= Form()->id('companyZipCode')->required(FALSE)->value($company_zip_code)->title(lang('general.company_zip_code'))->placeholder(lang('general.company_zip_code') . ' ....')->attr('disabled')->textbox(); ?>
            </fieldset>
        </div>
    </div>

    <button id="btn_signup" type="submit" onsubmit="return false;" 
            onclick="return postAjax('form-user', 'form-user')" class="btn btn-danger"><?= lang('general.save'); ?>
    </button>
</form>


<script>
    $(function () {
$('#province').change();
    })
</script>
