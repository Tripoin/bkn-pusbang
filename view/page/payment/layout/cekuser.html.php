
<form action="<?= URL('/page/payment'); ?>" id="form-bucket" method="POST" class="form" onsubmit="return false;">
    <h3>Form Shipping</h3>
    <?php
    echo $Form->id('firstname')->placeholder(lang('general.first_name') . ' ....')->setclass('face')->textboxicon();
    echo $Form->id('lastname')->placeholder(lang('general.last_name') . ' ....')->setclass('face')->textboxicon();

    echo $Form->id('email')->placeholder(lang('general.email') . ' ....')->setclass('email')->textboxicon();
    echo $Form->id('handphone')->placeholder(lang('general.handphone') . ' ....')->setclass('phone')->textboxicon();
    echo $Form->id('city')->placeholder(lang('general.city') . ' ....')->setclass('location_city')->textboxicon();
    echo $Form->id('address')->placeholder(lang('general.address') . ' ....')->setclass('location_on')->textboxicon();
    ?>
    <input type="hidden" name="count" id="count" value="3">
    <input type="hidden" name="category" id="category" value="<?= $_POST['category']; ?>">
    <?php
    $visitor = "";
    for ($no = 0; $no <= 3; $no++) {
        if($no == 1){
            $visitor = "adult-".$_POST['visitor'.$no]."-30000";
        } else if($no == 2){
            $visitor = "child-".$_POST['visitor'.$no]."-15000";
        } else if($no == 3){
            $visitor = "infant-".$_POST['visitor'.$no]."-5000";
        }
//        $no += 1;
        ?>
        <input type="hidden" name="visitor<?=$no;?>" id="visitor<?=$no;?>" value="<?= $visitor; ?>">
    <?php } ?>
    <div class="wizard-footer text-right">
        <input type="submit" data-dismiss="modal" class="btn btn-fill btn-danger btn-wd" name="next" value="Close" />
        <input type="submit" onsubmit="return false;" onclick="return postVeritransRow_2('form-bucket')"  style="margin-right: 30px;" class="btn btn-fill btn-warning btn-wd" name="next" value="Lanjutkan Pembayaran" />
    </div>
</form>