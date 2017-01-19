
<?php

use app\Model\SecurityUser;
use app\Model\SecurityUserProfile;
use app\Util\Database;

$db = new Database();
$sup = new SecurityUserProfile();
$su = new SecurityUser();

$rs_user = $db->selectByID($su, $su->getCode() . "='" . $_SESSION[SESSION_USERNAME] . "'");
$rs_user_profile = $db->selectByID($sup, $sup->getUser()->getId() . "='" . $rs_user[0][$sup->getUser()->getId()] . "'");
?>
<?= contentPage(); ?>
<?= pageBody(); ?>
<?= $Form->formHeader(); ?>

<?php echo $Form->id('code')->attr('disabled')->title(lang('security.username'))->value($_SESSION[SESSION_USERNAME])->textbox(); ?>
<?php echo $Form->id('fullname')->title(lang('security.fullname'))->value($rs_user_profile[0][$sup->getFullname()])->textbox(); ?>
<?php echo $Form->id('email')->title(lang('security.email'))->value($rs_user_profile[0][$sup->getEmail()])->textbox(); ?>
<?php echo $Form->id('placeOfBirth')->title(lang('security.place_of_birth'))->value($rs_user_profile[0][$sup->getPlace()])->textbox(); ?>
<?php echo $Form->id('birthdate')->title(lang('security.birthdate'))->value($rs_user_profile[0][$sup->getBirthdate()])->datepicker(); ?>
<input type="hidden" value="<?=$rs_user[0][$su->getId()];?>" id="id" name="id"/>
<?= $Form->formFooter(null, null, "postFormAjaxPost('".  FULLURL('/update')."')"); ?>
<script>
    $(function () {
        
        $('#buttonBack').remove();
        $('.datepicker').datepicker();
        
    })
</script>
<?= endPageBody(); ?>
<?= endContentPage(); ?>