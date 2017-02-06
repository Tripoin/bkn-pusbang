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
    echo imageManagerList('Back', URL('assets/img/back.png'), $path_back, 1);
}
foreach ($folders as $folder) {
    echo imageManagerList($folder, URL('assets/img/folders.png'), $trim_path . '/' . $folder . '/', 1);
}
foreach ($files as $file) {
    echo imageManagerList($file, URL($trim_path . '/' . $file), '', 2);
}

$str_replace = str_replace('contents', '', $trim_path);
?>
<input type="hidden" value="" id="cekFile"/>
<script>
    $(function () {
        $('#chooseFile').hide();
        $('#file_path').val('<?= $_POST['path']; ?>');
    });

    function viewPicture(url) {
//        checkFile(this);
    }

    function checkFile(e) {
        var cekFile = $('#cekFile').val();
        var value = $(e).attr("value");
        if (cekFile == "") {
            $(e).attr("style", "text-align:center;background:#95D1E6;color:white;border-color:#337ab7;");
            $('#chooseFile').show();
//            $(e).attr("value-type", 1);
            $('#cekFile').val(value);

        } else {
            $('[value="' + cekFile + '"]').attr("style", "text-align:center;");
            if (cekFile == value) {
                $('#cekFile').val(value);
                $(e).attr("style", "text-align:center;");
                $('#chooseFile').hide();
            } else {
                $('#cekFile').val(value);
                $(e).attr("style", "text-align:center;background:#95D1E6;color:white;border-color:#337ab7;");
            }
        }
    }
    function getFolder(v, e) {
        var action = $(v).attr('action');
        ajaxPostManual('<?= FULLURL(); ?>', 'pageMedia', 'path=' + action);
    }
</script>