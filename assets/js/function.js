/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



function upPlus(id) {
    var jumlah = $('#' + id).val();
    if (isNaN(jumlah)) {
        $('#' + id).val(0);
    }
    $('#' + id).val(parseInt($('#' + id).val(), 10) + 1);
}

function downMinus(id) {
    var jumlah = $('#' + id).val();
    if (isNaN(jumlah)) {
        $('#' + id).val(0);
    }
    if (jumlah <= 0) {

    } else {
        $('#' + id).val(parseInt($('#' + id).val(), 10) - 1);
    }
}

$("[type='number']").keypress(function (e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
//        $("#errmsg").html("Digits Only").show().fadeOut("slow");
        return false;
    }
});

$(document).keydown(function (e) {
    var event = window.event ? window.event : e;
//    alert(event.keyCode);
    if (event.keyCode == 116) {
        location.reload(true);
    }
//    alert('hello world'+event.keyCode);
});

function URL(url) {
    var urls = $('#url_self').val();
    var sub_urls = url.substring(0, 1);
    var str_url = '';
    if (sub_urls == '/')
        str_url = url;
    else
        str_url = '/' + url;

    return urls + str_url;
}

function searchByName(e) {
    var event = window.event ? window.event : e;
    if (event.keyCode == 13) {
        searchByName2();
    }
}

function searchByName2() {
    var searchName = $('#searchName').val();
    var table = $('#tablechatuser > tbody > tr');

    for (var no = 0; no < table.length; no++) {
        var findname = table.eq(no).find('td').find('span').html();

        if (findname.toLowerCase().indexOf(searchName) >= 0) {
//        alert(searchName);    
            table.eq(no).show();
        } else {
            table.eq(no).hide();
        }
    }
//    var tableRow = $("td").filter(function () {
//        return $(this).text() == searchName;
//    }).closest("tr");
//    alert(tableRow.html());
}


function openLiveChat() {

    $('#totalNotif').html('');
    var rpltitle = $('title').html();
    rpltitle = rpltitle.replace(/(.*)/, '');
    $('title').html(rpltitle);
    var heightchat = $("#modal-body-chat");
    $("#modal-body-chat").animate({scrollTop: heightchat.height() - heightchat.height()});
//    var objDiv = document.getElementById("modal-body-chat");
//    objDiv.scrollTop = objDiv.scrollHeight;
    $('#modal-live-chat').css("display", "block");
    $('#btn-live-chat').css("display", "none");
    var urladmin = $('#urladmin').val();
    loadLiveChatParentUser(urladmin);
}

function closeLiveChat() {
    $('#modal-live-chat').css("display", "none");
    $('#btn-live-chat').css("display", "block");

}
function sendLiveChat2(url, e) {
    var event = window.event ? window.event : e;
    if (event.keyCode == 13) {
        sendLiveChat(url);
    }
}
function speechText(type, username, chat, time) {
    var txt = '<div class="bubble-chat chat-' + type + '"><span style="font-weight: bold;">' + username + '</span><br/>' + chat + '<br/><span style="font-size: 8px;color:#8b7b8b;">' + time + '</span></div>';
    return txt;
}
function sendLiveChat(url) {
    var message = $('#chatMessage').val();
    if (message != "") {
//    var data = 'admin=' + $('#chatMessage').val();
        var data = 'message=' + message + '&admin=' + $('#usernameadmin').val();
        ;
        $.ajax({
//            url: url + '/' + month.val() + '/' + years.val(),
            url: url,
            data: data,
            type: 'post',
            success: function (result) {
                var json = JSON.parse(result);
                $('#chatMessage').val('');
                $('#modal-body-chat').append(speechText('me', json[0].fullname, json[0].chat, json[0].time));
//            $('#totalchat').val(json.no);
                srollendchat();
//            alert(result);
            },
            error: function (xhr, status, error) {
//                $('#content').html(xhr.responseText);
            }
        });
    }
}

function loadLiveChatUser(url, admin) {
    $('#textbox-chat-search-name').hide();
    $('#modal-body-chat').append(loadingChat());
    var urladmin = $('#urladmin').val();
    $('#usernameadmin').val(admin);
    var data = 'admin=' + admin;

    $.ajax({
//            url: url + '/' + month.val() + '/' + years.val(),
        url: url,
        data: data,
        type: 'post',
        success: function (result) {

//            $('#chatMessage').val('');
            $('#posisichat').val(2);
            $('#textbox-chat').show();
            var titlechat = $('#text-title-chat').html();
//            var titlechat = 'admin';
            $('#modal-title-chat').html('<i class="fa fa-arrow-left" style="cursor:pointer" onclick="loadLiveChatParentUser2(\'' + urladmin + '\')"></i> ' + titlechat);

            $('#modal-body-chat').html(result);
            srollendchat();
//            $('#totalchat').val(json.no);

//            alert(result);
        },
        error: function (xhr, status, error) {
//                $('#content').html(xhr.responseText);
        }
    });
}

function loadLiveChatParentUser2(url) {
    $('#posisichat').val(1);
    $('#modal-body-chat').html(loadingChat());
    loadLiveChatParentUser(url);
}

function loadLiveChatParentUser(url) {
    $('#textbox-chat-search-name').show();
    $('#searchName').val('');
    var posisi = $('#posisichat').val();
//    var admin = $('#chatMessage').val();
//    var data = 'admin=' + admin;
    $.ajax({
//            url: url + '/' + month.val() + '/' + years.val(),
        url: url,
//        data: data,
        type: 'post',
        success: function (result) {
            var json = JSON.parse(result);
//            $('#chatMessage').val('');




            if (posisi != 2) {
                var titlechat = $('#text-title-chat').html();
                $('#modal-title-chat').html(titlechat);
                $('#posisichat').val(1);
                $('#textbox-chat').hide();
                if ($('#tablechatuser')) {
                    var total_user_chat = $('#tablechatuser > tbody').length;
                    if (total_user_chat != json.item.length) {
                        var table = '<table class="table table-hover" id="tablechatuser" style="width:300px;margin-left: -15px;margin-top: -15px;">';
                        table += '<tbody>';
                        for (var no = 0; no < json.item.length; no++) {
                            table += '<tr class="success" style="cursor: pointer" onclick="loadLiveChatUser(\'' + URL('chat/load/user') + '\',\'' + json.item[no].username + '\')">';
                            table += '<td width="50"><img src="' + URL(json.item[no].path_img) + '" onerror="this.src=\'' + URL('/assets/img/business_man_blue.png') + '\'" width="45" height="45" class="img-circle"/></td>';
                            table += '<td style="font-size: 12px;">';
                            var last_total = '';
                            if (json.item[no].last_total != 0) {
                                last_total = json.item[no].last_total;
                            }
                            table += '<span style="font-weight: bold;"  id="chatFullname">' + json.item[no].fullname + ''
                                    + '</span><span class="label label-danger img-circle" id="totalNotifParent' + json.item[no].username + '">' + last_total + '</span>';
                            table += '<br/>';
                            table += '<span style="font-weight: normal;font-size:10px;" id="last_chat' + json.item[no].username + '">' + json.item[no].last_chat + '</span>';
                            table += '</td></tr>';
                        }


                        table += '</tbody>';
                        table += '</table>';
                        $('#modal-body-chat').html(table);
                    }
                }
            }
//            srollendchat();
//            $('#totalchat').val(json.no);

//            alert(result);
        },
        error: function (xhr, status, error) {
//                $('#content').html(xhr.responseText);
        }
    });
}

function loadLiveChat(url, title) {
    var totalchat = $('#totalchat').val();
    var usernamechat = $('#usernamechat').val();
    var posisi = $('#posisichat').val();
    var data = 'total=' + totalchat + '&usernamechat=' + usernamechat + '&posisi=' + posisi;

//    var totalNotif = $('#totalNotif').html();
    $.ajax({
//            url: url + '/' + month.val() + '/' + years.val(),
        url: url,
        data: data,
        type: 'post',
        success: function (result) {
//            alert(result);
            try {
                var url_music = $('#url_music_notif').val();
                var path_audio = url_music;
                var json = JSON.parse(result);
                var totalnotif = $('#totalnotif1').val();
                var totalchat = $('#totalchat').val();
                if (json.total >= 1) {
//                    if (totalnotif != 0) {
                    if (json.total > totalnotif) {

                        var audio = new Audio(path_audio);
                        audio.play();
                    }
                    if (json.total_chat > totalchat) {

                        var audio = new Audio(path_audio);
                        audio.play();
                        srollendchat();
                    }
//                    }
                }
                if (json.total == 0) {
//                    var title = $('title').html();
                    $('#totalNotif').html('');
                    $('title').html(title);
                    $('#totalnotif1').val(0);
                    $('#totalchat').val(0);
                } else {
                    $('#totalnotif1').val(json.total);
                    $('#totalchat').val(json.total_chat);
                    $('title').html('(' + json.total + ')' + title);

//                    var hitung = parseFloat(totalNotif) + total;
                    $('#totalNotif').html(json.total);

                }
                for (var no = 0; no < json.item.length; no++) {
                    if (json.item[no].last_total >= 1) {
                        var totalNotifParent = $('#totalNotifParent' + json.item[no].username);
                        var parent = totalNotifParent.closest('td').closest('tr');
                        var tbody = totalNotifParent.closest('td').closest('tr').closest('tbody');
                        tbody.prepend(parent.prop('outerHTML'));
                        parent.remove();
                        $('#totalNotifParent' + json.item[no].username).html(json.item[no].last_total);
                        $('#last_chat' + json.item[no].username).html(json.item[no].last_chat);
                    }
                }


//            }
                setTimeout(loadLiveChat, 2000, url, title);
                if (posisi == 2) {
                    loadChatStaging(url + '/staging');
                }

                if (posisi == 1) {

                }
            } catch (e) {
                setTimeout(loadLiveChat, 2000, url, title);

            }
//            alert(result);
        },
        error: function (xhr, status, error) {
            setTimeout(loadLiveChat, 6000, url, title);
//                $('#content').html(xhr.responseText);
        }
    });
}

function loadChatStaging(url) {
//    var message = $('#chatMessage').val();
//    var data = 'admin=' + $('#chatMessage').val();
    var data = 'admin=' + $('#usernameadmin').val();
    ;
    $.ajax({
//            url: url + '/' + month.val() + '/' + years.val(),
        url: url,
        data: data,
        type: 'post',
        success: function (result) {
//            var json = JSON.parse(result);
//            $('#chatMessage').val('');
            $('#modal-body-chat').append(result);
//            $('#totalchat').val(json.no);
//            srollendchat();
//            alert(result);
        },
        error: function (xhr, status, error) {
//                $('#content').html(xhr.responseText);
        }
    });
}

function srollendchat() {
    if ($("#modal-body-chat")) {
        var heightchat = $("#modal-body-chat");
        $('#modal-body-chat').scrollTop(heightchat[0].scrollHeight);
    }
}

function getModal() {
    $('#myModal').modal({backdrop: 'static', keyboard: false});
}

function spinnerLoader() {
    /*
     var txt = '<svg class="spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">';
     txt += '<circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>';
     txt += '</svg>';
     */
    var txt = '<div class="page-spinner-bar"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>';

    return txt;
}

function spinnerLoader_2() {
    var txt = '<svg class="spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">';
    txt += '<circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>';
    txt += '</svg>';

    return txt;
}

function highlightLoader() {
    var panel = '<div class="background-overlay" align="center">' + spinnerLoader() + '</div>';
    return panel;


}

function loadingChat() {
    return '<div class="background-overlay" align="center"><i class="fa fa-circle-o-notch fa-spin" style="font-size:24px;margin-top:70%;"></i></div>';
}
function findPostRead(url) {
    var month = $('#select_month');
    var years = $('#select_year');
    if ((month.val() == 0 && years.val() == 0) || month.val() != 0 && years.val() != 0) {
        $('#content-post').html(spinnerLoader());
        $.ajax({
            url: url + '/' + month.val() + '/' + years.val(),
            type: 'post',
            success: function (result) {
//            alert(result);
                $('#content-post').html(result);
//            $("[rel='tooltip']").tooltip();
            },
            error: function (xhr, status, error) {
                $('#content-post').html(xhr.responseText);
            }
        });
    }
}

function findReservation(url) {
    var category = $('#category');
    var date = $('#date');
    var visitor = $('#visitor');
    $('[data-toggle="tooltip"]').tooltip('hide');
//    var url = '';
    $('#pageFindReservation').html(spinnerLoader());
    var resultdata = '{"page":""}';
//    $('#pageFindReservation').append('<div class="panel-loading"><div class="panel-loader-circular"></div></div>');
    $.ajax({
        url: url + '/' + category.val() + '/' + date.val() + '/' + visitor.val(),
//        data: JSON.parse(resultdata),
        type: 'post',
        success: function (result) {
            $('#pageFindReservation').html(result);
            $("[rel='tooltip']").tooltip();
        },
        error: function (xhr, status, error) {
            $('#pageFindReservation').html(xhr.responseText);
        }
    });

//   window.open(url+'/'+category.val()+'/'+date.val()+'/'+visitor.val(),'_self',false);
}

function delList(page, id, e) {
    $('[data-toggle="tooltip"]').tooltip('hide');
    var resultdata = '{"id":"' + id + '"}';
    if (confirm('Are you sure delete this data ?')) {
        $.ajax({
            url: page,
            data: JSON.parse(resultdata),
            type: 'post',
            success: function (result) {
//                alert(result);
                var parseJson = JSON.parse(result);

                if (parseJson.response == 1) {
                    alertNotif(parseJson.title, parseJson.message, parseJson.type);
                    $(e).closest("tr").remove();
                } else {
//                    alert("masuk gagal");
                    alertNotif(parseJson.title, parseJson.message, parseJson.type);
                }
            },
            error: function (result) {
                alertNotif('Delete Failed', result.responseText, 'danger');
            }
        });
    } else {
        return true;
    }
}

function alertNotif(title, desc, type) {
    $.notify({
        title: '<strong>' + title + '</strong>',
        message: desc
    }, {
        type: type
    });
}

function postModal(id) {
    $('#myModal_self').modal({backdrop: 'static', keyboard: false});
    var form = $("#" + id);
    $('#modal-body-self').html(spinnerLoader());

    var datastring = form.serialize();
    var page = form.attr("action");
    $.ajax({
        type: "POST",
        url: page,
        data: datastring,
        success: function (data) {
//            alert(data);
            $('#modal-body-self').html(data);
//            alert('Data send');

        }
    });
}



function ajaxPostModal(page, title) {
    $('#modal-title-self').html(title);
    $('#myModal_self').modal({backdrop: 'static', keyboard: false});
//    var form = $("#" + id);

    $('#modal-body-self').html(highlightLoader());


//    var datastring = form.serialize();
//    var page = form.attr("action");
    $.ajax({
        type: "POST",
        url: page,
        success: function (data) {
//            alert(data);
            $('#modal-body-self').html(data);
//            alert('Data send');

        }
    });
}

function getMedia(page, target) {
    $('#modal-title-self').html('Media');
    $('#myModal_self').modal({backdrop: 'static', keyboard: false});
    $('#modal-body-self').html(highlightLoader());
    $.ajax({
        type: "POST",
        url: page,
        data: 'target=' + target,
        success: function (data) {
            $('#modal-body-self').html(data);
        }
    });
}

function ajaxPostModalByValue(page, title, value) {
    $('#modal-title-self').html(title);
    $('#myModal_self').modal({backdrop: 'static', keyboard: false});
//    var form = $("#" + id);

    $('#modal-body-self').html(highlightLoader());


//    var datastring = form.serialize();
//    var page = form.attr("action");
    $.ajax({
        type: "POST",
        url: page,
        data: value,
        success: function (data) {
//            alert(data);
            $('#modal-body-self').html(data);
//            alert('Data send');

        }
    });
}

function ajaxPostModalByValueHide(page, value) {
//    $('#myModal_self').modal({backdrop: 'static', keyboard: false});
//    var form = $("#" + id);

    $('#modal-body-self').html(highlightLoader());


//    var datastring = form.serialize();
//    var page = form.attr("action");
    $.ajax({
        type: "POST",
        url: page,
        data: value,
        success: function (data) {
//            alert(data);
            $('#modal-body-self').html(data);
//            alert('Data send');

        }
    });
}


function postVeritrans(id) {
//    $('#myModal_self').modal({backdrop: 'static', keyboard: false});
    var form = $("#" + id);
//    $('#modal-body-self').html(spinnerLoader());

    var datastring = form.serialize();
    var page = form.attr("action");
    $.ajax({
        type: "POST",
        url: page,
        data: datastring,
        success: function (data) {
//            alert(data);
//            alert(data);
//            $('#modal-body-self').html(data);
            snap.pay(data, {
//          env: 'sandbox',
                onSuccess: function (result) {
                    alert(result);
                    changeResult('success', result)
                },
                onPending: function (result) {
                    changeResult('pending', result)
                },
                onError: function (result) {
                    changeResult('error', result)
                }
            });
//            alert('Data send');

        }
    });
}

function getFormUser(page, no) {
    $('#myModal_self').modal({backdrop: 'static', keyboard: false});
//    var form = $("#" + id);
    $('#modal-body-self').html(spinnerLoader());

//    var datastring = form.serialize();
//    var page = form.attr("action");
    $.ajax({
        type: "POST",
        url: page,
        data: 'no=' + no,
        success: function (data) {
//            alert(data);
            $('#modal-body-self').html(data);
//            alert('Data send');

        }
    });

}

function getFormUser_2(page) {
    $('#myModal_self').modal({backdrop: 'static', keyboard: false});
//    var form = $("#" + id);
    var form = $("#form-reservation");
    $('#modal-body-self').html(spinnerLoader());
    var datastring = form.serialize();
//    var datastring = form.serialize();
//    var page = form.attr("action");
    $.ajax({
        type: "POST",
        url: page,
        data: datastring,
        success: function (data) {
//            alert(data);
            $('#modal-body-self').html(data);
//            alert('Data send');

        }
    });

}

function changeResult(type, result, datastring) {



    $('#modal-body-self').html('<div class="row"><div class="text-center">' + highlightLoader() + '</div></div>');
    var page = $('#url-payment-update').val();
    var sending = 'type=' + type + '&result=' + encodeURIComponent(JSON.stringify(result)) + '&' + datastring;
    $.ajax({
        type: "POST",
        url: page,
        data: sending,
        success: function (data) {
//            alert(data);
            $('#modal-body-self').html(data);
//            alert('Data send');

        }
    });
//    return str;
}
function notifPay(type, msg) {
    var str = '<div class="text-center"><h3 class="text-' + type + ' text-center">' + msg + '</h3><a href="javascript:void(0)" onclick="location.reload();" class="btn btn-danger btn-sm">Close</a></div>';

    return str;
}
function postVeritransRow(id, no) {
//    $('#myModal_self').modal({backdrop: 'static', keyboard: false});
    var form = $("#" + id);
    if (form.valid()) {
        var datastring = '';
        datastring += form.serialize();
        for (var n = 1; n <= 3; n++) {
            var visitor = $("#visitor" + no + n).val();
            datastring = datastring + '&visitor' + n + '=' + visitor;
        }

        var category = $("#category" + no).val();
        var category_type = $("#category_type" + no).val();
        var bucket_id = $("#bucket_id" + no).val();
        datastring = datastring + '&count=3';
        datastring = datastring + '&category_type=' + category_type;
        datastring = datastring + '&category=' + category;
        datastring = datastring + '&bucket_id=' + bucket_id;

//    var datastring = 'adult=' + adult + '&child=' + child + '&infant=' + infant;
        var page = form.attr("action");
        $.ajax({
            type: "POST",
            url: page,
            data: datastring,
            success: function (data) {
                snap.pay(data, {
                    onSuccess: function (result) {
                        changeResult('success', result, datastring);
                    },
                    onPending: function (result) {
                        changeResult('pending', result, datastring);
                    },
                    onError: function (result) {
                        changeResult('error', result, datastring);
                    }
                });
            }
        });
    }
}

function postVeritransRow_2(id, no) {
//    $('#myModal_self').modal({backdrop: 'static', keyboard: false});
    var form = $("#" + id);
    if (form.valid()) {
        var datastring = '';
        datastring += form.serialize();

//    var datastring = 'adult=' + adult + '&child=' + child + '&infant=' + infant;
        var page = form.attr("action");
        $.ajax({
            type: "POST",
            url: page,
            data: datastring,
            success: function (data) {
                snap.pay(data, {
//          env: 'sandbox',
                    onSuccess: function (result) {
                        changeResult('success', result, datastring);
                    },
                    onPending: function (result) {
                        changeResult('pending', result, datastring);
                    },
                    onError: function (result) {
                        changeResult('error', result, datastring);
                    }
                });
            }
        });
    }
}

function checkLogin(id, type) {
    var modalLogin = $('#modal-body-login');
    var form = $("#" + id);
//    form.validate();
//    alert(form.valid());
    if (form.valid() || type == 2) {
        modalLogin.append(highlightLoader());
        var spinner = $('.panel-loading');
        spinner.attr("style", "position: absolute;left: 50%;top: 50%;margin-top: -40px;margin-left: -40px;");
//    $('#modal-body-login').hide();
//    $('#modal-body-login').html(spinnerLoader());
        var datastring = form.serialize();
//        alert('type='+type+'&'+datastring);
        var page = form.attr("action");
        $.ajax({
            type: "POST",
            url: page + '?type=' + type,
            data: 'type=' + id + '&' + datastring,
            success: function (data) {
//            alert(data);
                $('#modal-body-login > h5').remove();
                $('#modal-body-login > h6').remove();
                $('#modal-body-login').prepend(data);
                $('#modal-body-login > .panel-loading').remove();

//            alert('Data send');

            }
        });

    }
}

function checkLoginFacebook(id, type) {
    var form = $("#" + id);
    var page = form.attr("action");
    window.open(page + '?type=' + type, "Facebook", "width=500,height=500");
    var modalLogin = $('#modal-body-login');
    modalLogin.append(highlightLoader());
    var spinner = $('.spinner');
    spinner.attr("style", "position: absolute;left: 50%;top: 50%;margin-top: -40px;margin-left: -40px;");



}

function postAjax(id, content) {
    var modalLogin = $('#' + content);
    var form = $("#" + id);
//    form.attr("onsubmit", "return false;");
//    form.validate();
//    alert(form.valid());
    if (form.valid()) {
        modalLogin.append(highlightLoader());
        modalLogin.append('<div class="background-overlay"></div>');
        var spinner = $('.panel-loading');
        spinner.attr("style", "position: absolute;left: 50%;top: 50%;margin-top: 0px;margin-left: -40px;");
//    $('#modal-body-login').hide();
//    $('#modal-body-login').html(spinnerLoader());
//        var datastring = form.serialize();
//        var formData = getJsonFromUrl(datastring);
        var datastring = document.getElementById(id);
        var page = form.attr("action");
        $.ajax({
            type: "POST",
            url: page,
//            data: datastring,
            data: new FormData(datastring),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
//            alert(data);
                $('#' + content).html(data);



//            alert('Data send');

            }, error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus.responseText);
            }
        });
    }
}

function postAjaxGetValue(page, content, value) {
    $('#' + content).html(highlightLoader());
    var data_value = JSON.parse(value);
    $.ajax({
        type: "POST",
        url: page,
        success: function (data) {
            $('#' + content).html(data);
            $.each(data_value, function (k, v) {
                $('#' + k).val(v);
            })
        }
    });
}

function getJsonFromUrl(query) {
//  var query = location.search.substr(1);
    var result = {};
    query.split("&").forEach(function (part) {
        var item = part.split("=");
        result[item[0]] = decodeURIComponent(item[1]);
    });
    return result;
}

function historyBackNoReset() {
    alert('tes');
}

function loginPostAjax(id, content) {
    var modalLogin = $('#' + content);
    var form = $("#" + id);
//    form.attr("onsubmit", "return false;");
//    form.validate();
//    alert(form.valid());
    if (form.valid()) {
        modalLogin.append(highlightLoader());
//        modalLogin.append('<div class="background-overlay"></div>');
//        var spinner = $('.panel-loading');
//        spinner.attr("style", "position: absolute;left: 50%;top: 50%;margin-top: 0px;margin-left: -40px;");
//    $('#modal-body-login').hide();
//    $('#modal-body-login').html(spinnerLoader());
        var datastring = form.serialize();
        var formData = getJsonFromUrl(datastring);
//                alert(formData);
        var page = form.attr("action");
        $.ajax({
            type: "POST",
            url: page,
            data: datastring,
            success: function (data) {
                try {
                    var parse = JSON.parse(data);
                    if (parse.result == "success") {
                        $(".alert-danger").hide();
                        $(".alert-success").show();
                        $(".alert-success").html("<div align='center'><b>" + parse.title + "</b><br/>" + parse.message + "</div>");
                        window.location.href = parse.nexturl;
                    } else {
                        $(".alert-success").hide();
                        $(".alert-danger").show();
                        $(".alert-danger").html("<div align='center'><b>" + parse.title + "</b><br/>" + parse.message + "</div>");
                    }
//            alert(data);
//                $('#' + content).remove;
                    $('.background-overlay').remove();
                } catch (e) {
//                    alert(e);
                    $(".alert-danger").show();
                    $(".alert-danger").html(data);
                    $('.background-overlay').remove();
                }

            }, error: function (jqXHR, textStatus, errorThrown) {
//                alert(jqXHR.responseText);
                $(".alert-danger").html(jqXHR.responseText);
                $('.background-overlay').remove();
            }
        });
    }
}

function currentPagePagination(urut) {
    $('#currentPage').val(urut);
    var pagination_manual = $('#pagination_manual').val();
    if (typeof pagination_manual == 'undefined') {
//    if ($('#pagination_manual')) {
        postAjaxPagination();
    } else {
        postAjaxPaginationManual();
    }
}
function paginationPerPage() {
    var pagination_manual = $('#pagination_manual').val();
    if (typeof pagination_manual == 'undefined') {
//    if ($('#pagination_manual')) {
        postAjaxPagination();
    } else {
        postAjaxPaginationManual();
    }
}

function searchPagination(e) {
    if (e.which == 13) {
        var pagination_manual = $('#pagination_manual').val();
        if (typeof pagination_manual == 'undefined') {
//    if ($('#pagination_manual')) {
            postAjaxPagination();
        } else {
            postAjaxPaginationManual();
        }
        $('#currentPage').val(1);
    }
}

function comButtonCreate(title, classbtn, classicon, url) {
    var str = '<a class="btn ' + classbtn + '" id="buttonCreate" rel="tooltip" title="' + title + '" href="javascript:void(0)" onclick="postAjaxCreate(\'' + url + '\')"> ';
    str += '<i class="fa ' + classicon + '"></i> ' + title;
    str += '</a>';

    return str;
}

function comButtonList(title, classbtn, classicon) {
    var str = '<a class="btn ' + classbtn + '"  id="buttonList" rel="tooltip" title="' + title + '" href="javascript:void(0)" onclick="postAjaxDeleteCollection()"> ';
    str += '<i class="fa ' + classicon + '"></i> ' + title;
    str += '</a>';

    return str;
}

function comButtonBack(title, classbtn, classicon) {
    var str = '<a class="btn ' + classbtn + '"  id="buttonBack" rel="tooltip" title="' + title + '" href="javascript:void(0)" onclick="postAjaxPagination()"> ';
    str += '<i class="fa ' + classicon + '"></i> ' + title;
    str += '</a>';

    return str;
}

function comButtonDeleteCollection(title, classbtn, classicon) {
    var str = '<a class="btn ' + classbtn + '"  id="deleteCollection" rel="tooltip" title="' + title + '" href="javascript:void(0)" onclick="postAjaxDeleteCollection()"> ';
    str += '<i class="fa ' + classicon + '"></i> ' + title;
    str += '</a>';

    return str;
}

function checkCollectionRow(e) {

    var checkbox = $(e).find('td').find('#checkboxdelete');

    if (checkbox) {
        if (checkbox.prop("checked") == true) {
            $(e).attr("style", "cursor:pointer;");
            $(e).find('td').find('#checkboxdelete').prop("checked", false);

        } else {
            $(e).find('td').find('#checkboxdelete').prop("checked", true);
            $(e).attr("style", "cursor:pointer;background:#FFFF96");
//            someObj.checkcollection.push($(e).find('td').find('#checkboxdelete').attr("value"));
        }
        var getAll = getCheckedValue('checkboxdelete');
        if (getAll.length == 0) {
            $('#deleteCollection').remove();
        } else {
//            if ($('#deleteCollection') == false) {
            if (typeof $('#deleteCollection').html() == 'undefined') {
                $('#actionHeader').append(comButtonDeleteCollection('Delete', 'btn-danger', 'fa-trash'));
            }
        }
//        console.log(getAll);

    }
    $('[rel="tooltip"]').tooltip();

//    alert("LENGTH: " + someObj.checkcollection.length);
//    alert("CHECKED: " + someObj.checkcollection);
//    alert($(e).find('td').find('#checkboxdelete').val());
}

function getCheckedValue(getAll) {
    var someObj = {};
    someObj.checkcollection = [];
    $('input:checkbox[id^="' + getAll + '"]:checked').each(function () {
        if ($(this).is(":checked")) {
            someObj.checkcollection.push($(this).attr("value"));
        } else {
//            someObj.fruitsDenied.push($(this).attr("id"));
        }
    });
    return someObj.checkcollection;
}
function postAjaxPagination() {
//    var content = $('#idContentPage').val();
    var content = 'bodyPage';
    var page = $('#urlPage').val();

    var per_page = $('#pagination_per_page').val();
    if (typeof per_page == 'undefined') {
        per_page = "";
    }
    var search_pagination = $('#search_pagination').val();
    if (typeof search_pagination == 'undefined') {
        search_pagination = "";
    }

    var form_search = $('#form-search');
    var datastringform = "";
    if (typeof form_search == 'undefined') {
        datastringform = "";
    } else {
        datastringform = form_search.serialize();
    }
    var search_by = $('#list_search_by').val();
    if (typeof search_by == 'undefined') {
        search_by = "";
    }
    var contents = $('#' + content);
    contents.append(highlightLoader());

    var currentPage = $('#currentPage').val();
    if (typeof currentPage == 'undefined') {
        currentPage = 1;
    }
    var datastring = datastringform + '&search_by=' + search_by + '&current_page=' + currentPage + '&per_page=' + per_page + '&search_pagination=' + search_pagination;
    $.ajax({
        type: "POST",
        url: page,
        data: datastring,
        success: function (data) {
            try {
//                alert(search_pagination);
                $('#' + content).html(data);
                $('.background-overlay').remove();
                $('#search_pagination').val(search_pagination);
                $('#search_pagination').focus();
                if (search_by != "") {
                    $('#list_search_by').val(search_by);
                }

                $('[rel="tooltip"]').tooltip();
            } catch (e) {
                $('#' + content).html(data);
                $('.background-overlay').remove();

            }
        }, error: function (jqXHR, textStatus, errorThrown) {
//                alert(jqXHR.responseText);
            contents.html(jqXHR.responseText);
        }
    });
//    }
}



function currentPagePaginationManual(urut, ctn) {
    $('#currentPage-' + ctn).val(urut);
    postAjaxPaginationManual(ctn);
}
function paginationPerPageManual(ctn) {
    postAjaxPaginationManual(ctn);
}

function searchPaginationManual(e, ctn) {
    if (e.which == 13) {
        postAjaxPaginationManual(ctn);
        $('#currentPage-' + ctn).val(1);
    }
}

function postAjaxPaginationManual(ctn) {
    var content = ctn;
//    var content = 'bodyPageManual';
    var page = $('#urlPageManual-' + content).val();

    var per_page = $('#pagination_per_page-' + content).val();
    if (typeof per_page == 'undefined') {
        per_page = "";
    }
    var search_pagination = $('#search_pagination-' + content).val();
    if (typeof search_pagination == 'undefined') {
        search_pagination = "";
    }
    var search_by = $('#list_search_by-' + content).val();
    if (typeof search_by == 'undefined') {
        search_by = "";
    }
    var contents = $('#' + content);
    contents.append(highlightLoader());

    var currentPage = $('#currentPage-' + content).val();
    if (typeof currentPage == 'undefined') {
        currentPage = 1;
    }
    var pagination_param = '';
    if ($('#pagination_parameter-' + content)) {
        var s = $('#pagination_parameter-' + content).val();
        pagination_param = s;
    }
    var datastring = 'search_by=' + search_by + '&current_page=' + currentPage + '&per_page=' + per_page + '&search_pagination=' + search_pagination;
    $.ajax({
        type: "POST",
        url: page,
        data: datastring + pagination_param,
        success: function (data) {
            try {
//                alert(search_pagination);
                $('#' + content).html(data);
                $('.background-overlay').remove();
                $('#search_pagination-' + content).val(search_pagination);
                if (search_by != "") {
                    $('#list_search_by-' + content).val(search_by);
                }

                $('[rel="tooltip"]').tooltip();
            } catch (e) {
                $('#' + content).html(data);
                $('.background-overlay').remove();

            }
        }, error: function (jqXHR, textStatus, errorThrown) {
//                alert(jqXHR.responseText);
            contents.html(jqXHR.responseText);
        }
    });
//    }
}

function postAjaxCreate(page) {
//    var content = $('#idContentPage').val();
//    var page = $('#urlPage').val();
//    var per_page = $('#pagination_per_page').val();
//    var search_pagination = $('#search_pagination').val();
    var content = 'bodyPage';
    var contents = $('#' + content);
    contents.append(highlightLoader());

//    var currentPage = $('#currentPage').val();
//    var datastring = 'current_page=' + currentPage+'&per_page='+per_page+'&search_pagination='+search_pagination;
    $.ajax({
        type: "POST",
        url: page,
//        data: datastring,
        success: function (data) {
            try {
                $('#' + content).html(data);
                $('.background-overlay').remove();
            } catch (e) {
                $('#' + content).html(data);
                $('.background-overlay').remove();
            }
        }, error: function (jqXHR, textStatus, errorThrown) {
//                alert(jqXHR.responseText);
            contents.html(jqXHR.responseText);
        }
    });
//    }
}

function postAjaxDeleteCollection() {
    var urlDeleteCollection = $('#url_delete_collection').val();
    var getAll = getCheckedValue('checkboxdelete');
    var toStringArray = getAll + ' ';
    swal({
        title: "Are you sure?",
        text: "Deleted Collection this data",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it Data Collection!",
        closeOnConfirm: false
    },
            function () {
                swal.close();
                var content = 'bodyPage';
                var contents = $('#' + content);
                contents.append(highlightLoader());
                $.ajax({
                    type: "POST",
                    url: urlDeleteCollection,
                    data: 'id=' + toStringArray,
                    success: function (data) {
                        console.log(data);
                        if (data == 1) {
                            toastr.success('Data Collection Has been Deleted Successfully!', 'Deleted Success');

//                            $('#' + content).html(data);
                            postAjaxPagination();
                        } else {
                            toastr.error('Data Collection Has been Deleted Failed!', 'Deleted Failed!');
                        }
                        $('.background-overlay').remove();
                    }, error: function (jqXHR, textStatus, errorThrown) {
//                alert(jqXHR.responseText);
//                        contents.html(jqXHR.responseText);
                    }
                });

            });
}

function postAjaxDelete(page, id) {

    swal({
        title: "Are you sure?",
        text: "Deleted this data",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    },
            function () {
                swal.close();
                var content = 'bodyPage';
                var contents = $('#' + content);
                contents.append(highlightLoader());
                $.ajax({
                    type: "POST",
                    url: page,
                    data: 'id=' + id,
                    success: function (data) {
                        if (data == 1) {
                            toastr.success('Data Has been Deleted Successfully!', 'Deleted Success');
                            $('#delete' + id).closest("td").closest("tr").remove();
                            $('#deleteCollection').remove();
                        } else {
                            toastr.error('Data Has been Deleted Failed!', 'Deleted Failed!');
                        }
                        $('.background-overlay').remove();
                    }, error: function (jqXHR, textStatus, errorThrown) {
//                alert(jqXHR.responseText);
//                        contents.html(jqXHR.responseText);
                    }
                });

            });
}

function postAjaxDeleteV2(page, value, id) {

    swal({
        title: "Are you sure?",
        text: "Deleted this data",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    },
            function () {
                swal.close();
                var content = 'bodyPage';
                var contents = $('#' + content);
                contents.append(highlightLoader());
                $.ajax({
                    type: "POST",
                    url: page,
                    data: value,
                    success: function (data) {
                        if (data == 1) {
                            toastr.success('Data Has been Deleted Successfully!', 'Deleted Success');
//                            $('#delete' + id).closest("td").closest("tr").remove();
//                            $('#deleteCollection').remove();
                            paginationPerPageManual(id);
                        } else {
                            toastr.error('Data Has been Deleted Failed!', 'Deleted Failed!');
                        }
                        $('.background-overlay').remove();
                    }, error: function (jqXHR, textStatus, errorThrown) {
//                alert(jqXHR.responseText);
//                        contents.html(jqXHR.responseText);
                    }
                });

            });
}

function postAjaxByAlert(e, page, id) {
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
                var content = 'bodyPage';
                var contents = $('#' + content);
                contents.append(highlightLoader());
                var ti = document.getElementById(id);
                $.ajax({
                    type: "POST",
                    url: page,
//                    data: 'id=' + id,
                    data: new FormData(ti),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        try {
                            var json = JSON.parse(data);
                            if (json.result == 1) {
                                toastr.success(json.message, json.title);
//                            $('#delete' + id).closest("td").closest("tr").remove();
                                postAjaxPagination();
                            } else {
                                toastr.error(json.message, json.title);
                            }
                        } catch (e) {
                            toastr.error(e.message, "Failed");
                        }
                        $('.background-overlay').remove();
                    }, error: function (jqXHR, textStatus, errorThrown) {
//                alert(jqXHR.responseText);
//                        contents.html(jqXHR.responseText);
                    }
                });

            });
}

function postAjaxEdit(page, value) {
    var content = 'bodyPage';
    var contents = $('#' + content);
    contents.append(highlightLoader());
    $.ajax({
        type: "POST",
        url: page,
        data: value,
        success: function (data) {
            try {
                $('#' + content).html(data);
                $('.background-overlay').remove();
            } catch (e) {
                $('#' + content).html(data);
                $('.background-overlay').remove();
            }
        }, error: function (jqXHR, textStatus, errorThrown) {
//                alert(jqXHR.responseText);
            contents.html(jqXHR.responseText);
        }
    });
//    }
}


function postFormAjax(page, value) {
    var form = $('#form-newedit');
//    alert(form);
//    alert(v.serialize)
//    var datastring = form.serialize();
    var ti = document.getElementById('form-newedit');
    var content = 'bodyPage';
    var contents = $('#' + content);
//alert(form.valid());
    if (form.valid()) {
        contents.append(highlightLoader());
        $.ajax({
            type: "POST",
            url: page,
//            data: datastring,
            data: new FormData(ti),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                try {
                    $('#' + content).html(data);
                    $('.background-overlay').remove();
                } catch (e) {
                    $('#' + content).html(data);
                    $('.background-overlay').remove();
                }
            }, error: function (jqXHR, textStatus, errorThrown) {
//                alert(jqXHR.responseText);
                contents.html(jqXHR.responseText);
            }
        });
    }
}




function CKupdate() {
//    if (typeof CKEDITOR.instances != 'undefined') {
    if (typeof (CKEDITOR) !== "undefined") {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
//        CKEDITOR.instances[instance].setData('');
        }
    }
}

function amountToStr(amount) {
    var price = amount.split(',');
    var result = "";
    for (var i = 0; i < price.length; i++) {
        result += price[i];
    }
    return result;
}


function postFormAjaxPost(page) {

    CKupdate();
    var form = $('#form-newedit');
    var ti = document.getElementById('form-newedit');
    var content = 'bodyPage';
    var contents = $('#' + content);
//alert(form.valid());
    if (form.valid()) {
        contents.append(highlightLoader());
        $.ajax({
            type: "POST",
            url: page,
//            data: datastring,
            data: new FormData(ti),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                try {
                    $('#form-message').html(data);
                    $('.background-overlay').remove();
                } catch (e) {
                    $('#form-message').html(data);
                    $('.background-overlay').remove();
                }
            }, error: function (jqXHR, textStatus, errorThrown) {
//                alert(jqXHR.responseText);
                $('#form-message').html(jqXHR.responseText);
            }
        });
    }
}

function ajaxPostManual(page, target, value) {
    $('#' + target).html(highlightLoader());
    $.ajax({
        type: "POST",
        url: page,
        data: value,
        success: function (data) {
            $('#' + target).html(data);

//            $('#'+target).focus();
        },
        error: function (data) {
            $('#' + target).html(data.responseText);
        },
    });
}

function ajaxPostModalManual(page, value) {
//    $('#' + target).html(highlightLoader());
    $('#myModal_self').modal({backdrop: 'static', keyboard: false});
    $('#modal-body-self').html(spinnerLoader());
    $.ajax({
        type: "POST",
        url: page,
        data: value,
        success: function (data) {
            $('#modal-body-self').html(data);

//            $('#'+target).focus();
        },
        error: function (data) {
            $('#modal-body-self').html(data.responseText);
        },
    });
}

function postFormAjaxPostSetContent(page, content) {

    CKupdate();
    var form = $('#form-newedit');
    var ti = document.getElementById('form-newedit');
//    var content = 'bodyPage';
    var contents = $('#' + content);
//alert(form.valid());
    if (form.valid()) {
        contents.append(highlightLoader());
        $.ajax({
            type: "POST",
            url: page,
//            data: datastring,
            data: new FormData(ti),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                try {
                    $('#form-message').html(data);
                    $('.background-overlay').remove();
                } catch (e) {
                    $('#form-message').html(data);
                    $('.background-overlay').remove();
                }
            }, error: function (jqXHR, textStatus, errorThrown) {
//                alert(jqXHR.responseText);
                $('#form-message').html(jqXHR.responseText);
                $('.background-overlay').remove();
            }
        });
    }
}


function ajaxPostModalGallery(page, target, value) {
//    $('#' + target).html(highlightLoader());
    $('#myModal_self').modal({backdrop: 'static', keyboard: false});
    $('#modal-body-self').html(spinnerLoader());
    $.ajax({
        type: "POST",
        url: page,
        data: value,
        success: function (data) {
            $('#modal-body-self').html(data);
//            Galleria.run(target);
//            $('#'+target).focus();
        },
        error: function (data) {
            $('#modal-body-self').html(data.responseText);
        },
    });
}

function focusLayout(id) {
    $('html, body').animate({scrollTop: $(id).offset().top}, 'slow');
}

function postRegisterMember(page, content) {

    CKupdate();
    var form = $('#form-newedit');
    var ti = document.getElementById('form-newedit');
//    var content = 'bodyPage';
    var contents = $('#' + content);
//alert(form.valid());
    if (form.valid()) {
        contents.append('<div class="background-overlay" style="padding: 50%;"><div class="overlay-spinner2"></div></div>');
        $.ajax({
            type: "POST",
            url: page,
//            data: datastring,
            data: new FormData(ti),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                try {
                    $('#form-message').html(data);
                    $('.background-overlay').remove();
                } catch (e) {
                    $('#form-message').html(data);
                    $('.background-overlay').remove();
                }
            }, error: function (jqXHR, textStatus, errorThrown) {
//                alert(jqXHR.responseText);
                $('#form-message').html(jqXHR.responseText);
                $('.background-overlay').remove();
            }
        });
    }
}

function ajaxGetPage(page, id) {
    $('#' + id).html(highlightLoader());
    $.ajax({
        type: "POST",
        url: page,
        success: function (data) {
            $('#' + id).html(data);
            $("[rel='tooltip']").tooltip();
        }
    });
}