    
<button type="button" onclick="chooseFile()" class="btn btn-primary" id="chooseFile">
    <i class="fa fa-check"></i> Choose Image
</button>
<input type="hidden" name="file_path" id="file_path" readonly="readonly" class="form-control"/>
<br/>
<br/>
<div class="row" id="pageMedia">

</div>

<script>
//    location.reload(true);
    $(function () {
        $('#deleteFile').hide();
        ajaxPostManual('<?= URL(getAdminTheme() . '/list-get-media'); ?>', 'pageMedia', 'path=contents/');
    });

    function chooseFile() {
        $('#myModal_self').modal('hide');
        var cekFile = $('#cekFile').val();
        var path = $('#file_path').val();
        var target = '<?= $_POST['target']; ?>';
        
        var split_target = target.split(',');
        for (var no = 0; no < split_target.length; no++) {
            var checkTag = $('#' + split_target[no]).prop("tagName").toLowerCase();
            if (checkTag == 'div') {
                var file_path_name = '<?=URL();?>/'+path+cekFile;
                $('#' + split_target[no]).html(file_path_name);
            } else if (checkTag == 'span') {
                var file_path_name = '<?=URL();?>/'+path+cekFile;
                $('#' + split_target[no]).html(file_path_name);
            } else {
                var replace = path.replace("contents/","");
                var file_path_name = replace+cekFile;
                $('#' + split_target[no]).val(file_path_name);
            }
        }
//        alert($('#'+target).prop("tagName").toLowerCase());
//        alert("ok");
    }
</script>