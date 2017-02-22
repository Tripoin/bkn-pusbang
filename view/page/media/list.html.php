<?php
$files = array();
$folders = array();
if ($handle = opendir(FILE_PATH($_POST['path']))) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            $exp_name = explode(".", $entry);
            $file_name = '';
            foreach ($exp_name as $value) {
                if (end($exp_name) != $value) {
                    $file_name .= $value;
                }
            }
            if (count($exp_name) == 1) {
                $folders[] = $entry;
            } else {
                $files[] = $entry;
            }
        }
    }
    closedir($handle);
}
$trim_path = rtrim($_POST['path'], '/');
$exp_folder = explode("/", $trim_path);
if (count($exp_folder) >= 2) {
    array_pop($exp_folder);
    $path_back = implode('/', $exp_folder);
//    $exp_folder_1 = explode($file_name, $string);
    echo imageManager('Back', URL('assets/img/back.png'), $path_back, 3);
}
foreach ($folders as $folder) {
    echo imageManager($folder, URL('assets/img/folders.png'), $trim_path . '/' . $folder . '/', 1);
}
foreach ($files as $file) {
    echo imageManager($file, URL($trim_path . '/' . $file), '', 2);
}

$str_replace = str_replace('contents', '', $trim_path);
?>
<input type="hidden" value="" id="cekFile"/>
<script>
    $(function () {
        $('#deleteFile').hide();
        $('#path').val('<?= $str_replace; ?>/');
        $('#file_path').val('<?= $_POST['path']; ?>');


    });
    var touchtime = 0;
    function uploadFile() {
        var content = 'pageMedia';
        var contents = $('#' + content);
        contents.append(highlightLoader());
        var ti = document.getElementById('form-upload');
        var file_path = $('#path').val();
        $.ajax({
            type: "POST",
            url: '<?= FULLURL(); ?>',
//            data: 'action=delete&id=' + name + '&file_path=' + file_path,
            data: new FormData(ti),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    toastr.success('File Has been Uploaded Successfully!', 'Uploaded Success');
                    ajaxPostManual('<?= FULLURL(); ?>', 'pageMedia', 'path=contents' + file_path);
//                            $('#' + content).html(data);
                } else {
                    toastr.error('File Has been Uploaded Failed!', 'Uploaded Failed!');
                }
                $('.background-overlay').remove();
            }, error: function (jqXHR, textStatus, errorThrown) {
                toastr.error('File Has been Uploaded Failed!', 'Uploaded Failed!');
            }
        });

    }

    function inputFolderPage() {
        $('#foldermodal').modal('show');
    }

    function addFolder() {
        var file_path = $('#file_path').val();
        var name = $('#folder-name').val();
        $.ajax({
            type: "POST",
            url: '<?= FULLURL(); ?>',
            data: 'action=add-folder&name=' + name + '&file_path=' + file_path,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $('#foldermodal').modal('hide');
                    toastr.success('Folder Has been Added Successfully!', 'Add Folder Success');
                    ajaxPostManual('<?= FULLURL(); ?>', 'pageMedia', 'path=' + file_path);
//                            $('#' + content).html(data);
                } else {
                    toastr.error('Folder Has been Added Failed!', 'Add Folder Failed!');
                }
                $('.background-overlay').remove();
            }, error: function (jqXHR, textStatus, errorThrown) {
                toastr.error('Folder Has been Added Failed!', 'Add Folder Failed!');
            }
        });

    }

    function viewPicture(e, url) {

        if (touchtime == 0) {
            //set first click
            checkFile(e);
            touchtime = new Date().getTime();
        } else {
            //compare first click to this click and see if they occurred within double click threshold
            if (((new Date().getTime()) - touchtime) < 800) {
                //double click occurred
//                alert("double clicked");

                viewPicture2(url);
                touchtime = 0;
            } else {
                checkFile(e);
                //not a double click so set as a new first click
                touchtime = new Date().getTime();
            }
        }

    }

    function viewPicture2(url) {
        $('#imagemodal').modal('show');
        $('#imagepreview').attr("src", url);
    }
    function deleteFile() {
        var name = $('#cekFile').val();
        swal({
            title: "Are you sure?",
            text: "Deleted this file",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Delete File!",
            closeOnConfirm: false
        },
                function () {
                    swal.close();
                    var content = 'pageMedia';
                    var contents = $('#' + content);
                    contents.append(highlightLoader());
                    var file_path = $('#file_path').val();
                    $.ajax({
                        type: "POST",
                        url: '<?= FULLURL(); ?>',
                        data: 'action=delete&id=' + name + '&file_path=' + file_path,
                        success: function (data) {
                            console.log(data);
                            if (data == 1) {
                                toastr.success('File Has been Deleted Successfully!', 'Deleted Success');
                                ajaxPostManual('<?= FULLURL(); ?>', 'pageMedia', 'path=' + file_path);
//                            $('#' + content).html(data);
                            } else {
                                toastr.error('File Has been Deleted Failed!', 'Deleted Failed!');
                            }
                            $('.background-overlay').remove();
                        }, error: function (jqXHR, textStatus, errorThrown) {
                            toastr.error('File Has been Deleted Failed!', 'Deleted Failed!');
                        }
                    });

                });
    }

    function checkFile(e) {
        var type = $(e).attr("value-type");
        var cekFile = $('#cekFile').val();
        var value = $(e).attr("value");
        if (type == 0) {
            $(e).attr("style", "text-align:center;background:#95D1E6;color:white;border-color:#337ab7;");
            $('#deleteFile').show();
            $(e).attr("value-type", 1);
            $('#cekFile').val(cekFile + value + ",");

        } else {
            $(e).attr("style", "text-align:center;");
            $(e).attr("value-type", 0);
            var str_replace = cekFile.replace(value + ',', "");
            $('#cekFile').val(str_replace);
        }
        if ($('#cekFile').val() == "") {
            $('#deleteFile').hide();
        }
    }

    function getFolder2(v, e) {
        var action = $(v).attr('action');
        ajaxPostManual('<?= FULLURL(); ?>', 'pageMedia', 'path=' + action);
    }

    function getFolder(v, e) {
        if (touchtime == 0) {
            //set first click
            checkFile(v);
            touchtime = new Date().getTime();
        } else {
            //compare first click to this click and see if they occurred within double click threshold
            if (((new Date().getTime()) - touchtime) < 800) {
                //double click occurred
//                alert("double clicked");

                getFolder2(v, e)
                touchtime = 0;
            } else {
                //not a double click so set as a new first click
                checkFile(v);
                touchtime = new Date().getTime();
            }
        }
    }
</script>