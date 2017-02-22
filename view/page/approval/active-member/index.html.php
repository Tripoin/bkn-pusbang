<?= contentPage(); ?>
<?= pageBody(); ?>
<?php
//print_r($data_user);
$time_period = '[';
for ($no = 1; $no <= 12; $no++) {
    $time_period .= '{"id":"' . $no . '","label":"' . $no . '"},';
}
$time_period = rtrim($time_period, ",");
$time_period .= ']';
$dec_time_periode = json_decode($time_period);
?>
<div class="row" id="allPageMemberPay">
    <div id="allPageMemberPayMsg">

    </div>
    <div class="col-md-6">
        <?php echo $Form->id('code')->attr('onchange="checkMember(this,\'' . URL('page/approval/active-member/check-member') . '\')"')->title(lang('activemember.member_name'))->data($json_data_users)->combobox(); ?>
        <div id="pageMembers">
        </div>
    </div>
    <div class="col-md-6" id="pageMemberPay">

        <?php echo $Form->id('time_period')->attr('onchange="getSaldoUser(this)"')->title(lang('activemember.time_period_message'))->data($dec_time_periode)->combobox(); ?>
        <div id="pageMemberPays">
            <?php echo $Form->id('priceMember')->attr('onchange="calculateDisc()"')
                    ->title(lang('master.price'))->data($data_price)->combobox(); ?>
            <?php
            echo $Form->id('discount')->attr('onkeyup="calculateDisc()"')
                    ->title(lang('activemember.discount'))->value(0)->textbox();
            ?>
            <?php
            echo $Form->id('amount')->attr('readonly="readonly"')
                    ->title(lang('activemember.amount'))->value(0)->textbox();
            ?>
            <?php
            echo $Form->id('last_amount')->attr('readonly="readonly"')
                    ->title(lang('activemember.last_balance'))->value(0)->textbox();
            ?>
        </div>

    </div>
    <?php
    $action_approved = $Button->onClick('savePaymentMember(this,\'' . URL('page/approval/active-member/save') . '\')')
                    ->icon('fa fa-check')->setClass('btn-success')
                    ->alertTitle(lang("general.alert_title"))
                    ->alertMsg(lang("general.alert_msg_save"))
                    ->alertBtnMsg(lang("general.alert_button_save"))
                    ->label(lang("general.save"))
                    ->title(lang("general.save"))->buttonManual();
    ?>
    <?= $Form->formFooter('', $action_approved); ?>
</div>
<!--<input type="hidden" id="priceMember" value="<?= PRICE_PER_MONTH; ?>"/>-->

<script>
    $(function () {
        $('.select2').select2();
        $('#pageMemberPay').hide();
        $('#pageMemberPays').hide();
        $('#actionHeader').remove();
        $('#formFooter').hide();
//        location.reload(true);
//        postAjaxPagination();
    });
    function getSaldoUser(e) {
        $('#pageMemberPays').show();
        var priceMember = $('#priceMember').val();
        var discount = $('#discount').val();
//        alert('0.' + parseFloat(discount));
//        alert(parseFloat(priceMember) * parseFloat(e.value));
        var totalAmountMember = parseFloat(priceMember) * parseFloat(e.value);
        var total_disc = parseFloat('0.' + discount) * totalAmountMember;
        var total_last = totalAmountMember - total_disc;
        $('#amount').val(total_last);

        var last_balance = $('#last_balance').val();
        var total_last_balance = amountToStr(last_balance);
        var amount = $('#amount').val();
        $('#last_amount').val(total_last_balance - amount);
        $('#formFooter').show();

    }

    function calculateDisc() {
        getSaldoUser(document.getElementById('time_period'));
    }

    function checkMember(e, page) {
//        var content = 'bodyPage';
        var contents = $('#pageMembers');
        contents.append(highlightLoader());
        $.ajax({
            type: "POST",
            url: page,
            data: "id=" + e.value,
            success: function (data) {
                try {
                    $('#pageMembers').html(data);
                    $('.background-overlay').remove();
                    $('#pageMemberPay').show();
                } catch (e) {
                    $('#pageMembers').html(data);
                    $('.background-overlay').remove();
                    $('#pageMemberPay').show();
                }
            }, error: function (jqXHR, textStatus, errorThrown) {
//                alert(jqXHR.responseText);
                contents.html(jqXHR.responseText);
                $('#pageMemberPay').show();
            }
        });
//    }
    }

    function savePaymentMember(e, page) {
        var title = $(e).attr('alert-title');
        var message = $(e).attr('alert-message');
        var buttonTitle = $(e).attr('alert-button-title');
        swal({
            title: title,
            text: message,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: buttonTitle,
            closeOnConfirm: false
        },
                function () {
                    swal.close();
                    var content = 'allPageMemberPay';
                    var contents = $('#' + content);
                    contents.append(highlightLoader());

                    var code = $('#code');
                    var time_period = $('#time_period');
                    var discount = $('#discount');
                    var last_balance = $('#last_balance');

                    $.ajax({
                        type: "POST",
                        url: page,
                        data: 'code=' + code.val() + '&last_balance=' + last_balance.val() + '&time_period=' + time_period.val() + '&discount=' + discount.val(),
//                        data: new FormData(ti),
//                        contentType: false,
//                        cache: false,
//                        processData: false,
                        success: function (data) {
                            try {
                                var json = JSON.parse(data);
                                if (json.result == 1) {
                                    $('#allPageMemberPayMsg').html(data);
//                                    toastr.success(json.message, json.title);
//                            $('#delete' + id).closest("td").closest("tr").remove();
//                                    postAjaxPagination();
                                } else {
                                    $('#allPageMemberPayMsg').html(data);
//                                    toastr.error(json.message, json.title);
                                }
                            } catch (e) {
                                $('#allPageMemberPayMsg').html(data);
//                                toastr.error(e.message, "Failed");
                            }
                            $('.background-overlay').remove();
                        }, error: function (jqXHR, textStatus, errorThrown) {
//                alert(jqXHR.responseText);
                            $('#allPageMemberPayMsg').html(jqXHR.responseText);
//                        contents.html(jqXHR.responseText);
                        }
                    });

                });
    }
</script>
<?= endPageBody(); ?>
<?= endContentPage(); ?>
