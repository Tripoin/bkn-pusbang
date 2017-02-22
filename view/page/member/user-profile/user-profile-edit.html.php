<form id="form-user" action="<?= URL('/page/member/user-profile/save') ?>" method="POST" class="form" onsubmit="return false;">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#accountTab" data-toggle="tab"><?= lang('general.your_personal_details'); ?></a></li>
        <li role="presentation"><a href="#contactTab" data-toggle="tab"><?= lang('general.your_contact'); ?></a></li>
        <li role="presentation"><a href="#addressTab" data-toggle="tab"><?= lang('general.your_address'); ?></a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="accountTab">
            <fieldset id="account">
                <?= Form()->id('name')->value($cek_user_profile[0][$up->getName()])->title(lang('general.name'))->placeholder(lang('general.first_name') . ' ....')->textbox(); ?>
                <?= Form()->id('place')->value($cek_user_profile[0][$up->getPlace()])->title(lang('user.place_of_birth'))->placeholder(lang('user.place_of_birth') . ' ....')->textbox(); ?>
                <?= Form()->id('birthdate')->value($cek_user_profile[0][$up->getBirthdate()])->title(lang('user.birthdate'))->placeholder(lang('user.birthdate') . ' ....')->datepicker(); ?>
                <?= Form()->id('email')->value($user[0][$su->getEmail()])->title(lang('general.email'))->placeholder(lang('general.email') . ' ....')->textbox(); ?>
                <?= Form()->id('gender')->value($cek_user_profile[0][$up->getGender()])->title(lang('general.gender'))->placeholder(lang('general.gender') . ' ....')->textbox(); ?>
                <?= Form()->id('upload_img')->required(false)->value($cek_user_profile[0][$up->getPathimage()])->title(lang('user.change_profile_img'))->placeholder($cek_user_profile[0][$up->getPathimage()])->fileinput(); ?>
            </fieldset>
        </div>
        <div class="tab-pane" id="contactTab">
            <fieldset id="contact">
                <?= Form()->id('telephone')->value($phone1)->title(lang('general.telephone'))->placeholder(lang('general.telephone') . ' ....')->textbox(); ?>
                <?= Form()->id('telephone2')->value($phone2)->title(lang('general.telephone2'))->placeholder(lang('general.telephone2') . ' ....')->textbox(); ?>
                <?= Form()->id('email1')->value($email1)->title(lang('general.email1'))->placeholder(lang('general.email1') . ' ....')->textbox(); ?>
                <?= Form()->id('email2')->value($email2)->title(lang('general.email2'))->placeholder(lang('general.email2') . ' ....')->textbox(); ?>
            </fieldset>
        </div>
        <div class="tab-pane" id="addressTab">
            <fieldset id="address">
                content address
            </fieldset>
        </div>
    </div>

    <button id="btn_signup" type="submit" onsubmit="return false;" 
            onclick="return postAjax('form-user', 'form-user')" class="btn btn-danger"><?= lang('general.save'); ?>
    </button>
</form>


<script>
    $(function () {

    })
</script>

