<?= formLayoutHead(lang('payment.payment_confirm')); ?>
<div class="alert alert-warning">
    <div class="container">
        <div class="alert-icon">
            <i class="material-icons">error_outline</i>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="material-icons">clear</i></span>
        </button>
        <b style="color:red;font-weight:bold;"><?=lang('payment.notes');?>:</b> <?=lang('payment.notes_message');?>
    </div>
</div>
<form class="form" onsubmit="return false;" id="formCheckOrder" method="POST" action="<?= URL('/page/reservation/check-order/search'); ?>" style="margin: 20px;">
    <div class="col-lg-6">
        <?php
        echo $Form->id('no_invoice')->title(lang('payment.no_invoice'))->placeholder(lang('general.input') . ' ' . lang('payment.no_invoice'))->textbox();
        echo $Form->id('email')->title(lang('payment.email'))->placeholder(lang('general.input') . ' ' . lang('payment.email') . ' ' . lang('general.you'))->textbox();
        $data = '[{"id":"1","label":"BCA(87812321312) a/n PT.SIGMA CIPTA CARAKA"},{"id":"2","label":"BNI(1234123123) a/n PT.SIGMA CIPTA CARAKA"}]';
        $json_data = json_decode($data);
        echo $Form->id('bank_destination')->data($json_data)->title(lang('payment.bank_destination'))->placeholder(lang('general.choose') . ' ' . lang('payment.bank_destination'))->combobox();
        echo $Form->id('bank_sender')->title(lang('payment.bank_sender'))->placeholder(lang('general.example') . ' : BCA')->textbox();
        echo $Form->id('sender_account_number')->title(lang('payment.sender_account_number'))->placeholder(lang('general.input') . ' : ' . lang('payment.sender_account_number'))->textbox();
        echo $Form->id('sender_name')->title(lang('payment.sender_name'))->placeholder(lang('general.input') . ' : ' . lang('payment.sender_name'))->textbox();
        ?>
    </div>
    <div class="col-lg-6">
        <?php
        echo $Form->id('transfer_date')->title(lang('payment.transfer_date'))->placeholder(lang('general.input') . ' ' . lang('payment.transfer_date'))->textbox();
        echo $Form->id('transfer_amount')->title(lang('payment.transfer_amount'))->placeholder(lang('general.input') . ' ' . lang('payment.transfer_amount'))->textbox();
        echo $Form->id('upload_proof_payment')->title(lang('payment.upload_proof_payment'))->placeholder(lang('general.input') . ' ' . lang('payment.upload_proof_payment'))->fileinput();
        echo $Form->id('notes')->title(lang('payment.notes'))->attr(' rows="4"')->placeholder(lang('general.input') . ' ' . lang('payment.notes'))->textarea();
        ?>

    </div>

    <div class="col-lg-12" style="margin-top:50px;">
        <div class="col-lg-8">
        </div>
        <div class="col-lg-4">
            <?php
            echo $Form->id('findBooking')->onclick("postAjax('formCheckOrder','pageCheckOrder')")->setclass('btn-sm')->label(lang('payment.confirm_now'))->button();
            ?>
        </div>
    </div>                    
</form>
<div class="col-lg-12" id="pageCheckOrder" style="margin-bottom:100px;">
</div>
<?= formLayoutFooter(); ?>
<script>
</script>