
<fieldset id="account">

    <?php
    $exp_name = explode(" ", $cek_user_profile[0][$up->getName()]);
    $lastname = "";
    if (isset($exp_name[1])) {
        $lastname = $exp_name[1];
    }
    ?>
    <legend><?= lang('general.your_personal_details'); ?></legend>
    <?= Form()->id('firstname')->value($exp_name[0])->title(lang('general.first_name'))->placeholder(lang('general.first_name') . ' ....')->textbox(); ?>
    <?= Form()->id('lastname')->required(false)->value($lastname)->title(lang('general.last_name'))->placeholder(lang('general.last_name') . ' ....')->textbox(); ?>
    <?= Form()->id('email')->value($user[0][$su->getEmail()])->title(lang('general.email'))->placeholder(lang('general.email') . ' ....')->textbox(); ?>
    <?= Form()->id('telephone')->value($contact)->title(lang('general.telephone'))->placeholder(lang('general.telephone') . ' ....')->textbox(); ?>
    <?= Form()->id('place')->value($cek_user_profile[0][$up->getPlace()])->title(lang('user.place_of_birth'))->placeholder(lang('user.place_of_birth') . ' ....')->textbox(); ?>
    <?= Form()->id('birthdate')->value($cek_user_profile[0][$up->getBirthdate()])->title(lang('user.birthdate'))->placeholder(lang('user.birthdate') . ' ....')->datepicker(); ?>
    <?= Form()->id('upload_img')->required(false)->value($cek_user_profile[0][$up->getPathimage()])->title(lang('user.change_profile_img'))->placeholder($cek_user_profile[0][$up->getPathimage()])->fileinput(); ?>


</fieldset>

<button id="btn_signup" type="submit" onsubmit="return false;" 
        onclick="return postAjax('form-user', 'form-user')" class="btn btn-danger"><?= lang('general.save'); ?></button>
<script>
    $(function () {
        
    })
</script>

