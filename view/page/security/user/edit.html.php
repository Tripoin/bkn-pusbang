<?= $Form->formHeader(); 

echo $Form->id('code')->title(lang('security.username'))->value($get_data[$data->getCode()])->textbox(); 
$getUser = $db->selectByID($this->userProfile, $this->userProfile->getUser()->getId() . EQUAL .$get_data[$data->getId()]);
echo $Form->id('fullname')->title(lang('security.fullname'))->value($getUser[0][$this->userProfile->getName()])->textbox(); 
echo $Form->id('email')->title(lang('security.email'))->value($get_data[$data->getEmail()])->textbox(); 
?>
<?php echo $Form->id('group')->title(lang('security.group'))->value($get_data[$data->getGroupId()])->data($this->data_group)->combobox(); ?>

<input type="hidden" id="id" name="id" value="<?= $_POST['id']; ?>"/>

<?= $Form->formFooter($this->updateUrl); ?>
