<?= contentPage(); ?>
<?= pageBody(); ?>

<div class="fileinput fileinput-new col-md-12">
    <div class="col-md-1">
        <label class="control-label">Path : </label>
    </div>
    <div class="col-md-4">
        <input type="text" id="path" readonly="readonly" class="form-control"/>
    </div>
    <div class="col-md-2">
        <form id="form-upload" onsubmit="return false;">
            <span class="btn green btn-file">
                <span class="fileinput-new"><i class="fa fa-plus"></i>  Add Files </span>
                <input type="file" name="file_name[]" onchange="uploadFile();" multiple=""> </span>
            <span class="fileinput-filename"> </span> &nbsp;
            <input type="hidden" name="action" value="upload"/>
            <input type="hidden" name="file_path" id="file_path" readonly="readonly" class="form-control"/>

        </form>
    </div>
    <button type="button" onclick="deleteFile()" class="btn btn-danger" id="deleteFile"><i class="fa fa-times"></i> Delete</button>
    <button type="button" onclick="inputFolderPage()" class="btn btn-warning" id="addFolder"><i class="fa fa-plus"></i> Add Folder</button>

</div>
<br/>
<br/>
<div class="row" id="pageMedia">

</div>

<script>
//    location.reload(true);
    $(function () {
        $('#deleteFile').hide();
        ajaxPostManual('<?= FULLURL(); ?>', 'pageMedia', 'path=contents/');
    });
</script>
<div class="modal fade" id="imagemodal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="modal-content-img">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-11">
                            <h4 class="modal-title" id="myModalLabel">Image preview</h4>

                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-circle btn-icon-only pull-right" data-dismiss="modal">
                                <i class="fa fa-times" ></i>
                            </button>

                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-body" id="modal-body-img">
                <img src="" id="imagepreview" style="width: 100%; height: 100%;" >
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="foldermodal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="modal-content-folder">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-11">
                            <h4 class="modal-title" id="myModalLabelFolder">Add Folder</h4>

                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-body" id="modal-body-folder">
                <input type="text" id="folder-name" name="folder-name" value="" class="form-control"/>
            </div>
            <div class="modal-footer" class="text-left">
                <button type="button" onclick="addFolder()" 
                        class="btn btn-warning"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>
    </div>
</div>
<?= endPageBody(); ?>
<?= endContentPage(); ?>