<?= Form()->formHeader(); ?>



<?php
echo Form()->title(lang('master.subject_description'))->id('subject_description')->textarea();
?>
<?php // echo Form()->textbox();?>
<?= Form()->formFooter($this->insertUrl); ?>
<script>
    $(function () {
        initDetails();
    });
    </script>
