<?php

use app\Util\Database;
use app\Model\SecurityFunctionAssignment;
use app\Model\SecurityLanguage;

$db = new Database();
$sfa = new SecurityFunctionAssignment();
$language = new SecurityLanguage();

$db->connect();
$db->select(
        $sfa->getEntity(), $sfa->getFunction()->getEntity() . ".*," . $sfa->getEntity() . DOT . $sfa->getId() . " as fa_id", array($sfa->getFunction()->getEntity(), $sfa->getGroup()->getEntity()), $sfa->getFunction()->getEntity() . DOT . $sfa->getFunction()->getId() . EQUAL . $sfa->getEntity() . DOT . $sfa->getFunctionId()
        . " AND " . $sfa->getGroup()->getEntity() . DOT . $sfa->getGroup()->getId() . EQUAL . $sfa->getEntity() . DOT . $sfa->getGroupId()
        . " AND " . $sfa->getEntity() . DOT . $sfa->getStatus() . EQUAL . "1"
        . " AND " . $sfa->getEntity() . DOT . $sfa->getGroupId() . EQUAL . $_POST['id']
        . " AND " . $sfa->getFunction()->getEntity() . DOT . $sfa->getFunction()->getLevel() . EQUAL . "0"
        , $sfa->getFunctionAssignmentOrder() . ' ASC'
);
$function_parent = $db->getResult();
$adminthemeurl = getAdminTheme();
//print_r($function_parent);
//LOGGER($function_parent);
//LOGGER($db->getSql());
?>
<?= $Form->formHeader(); ?>

<?php echo $Form->id('code')->attr('disabled')->title(lang('general.code'))->value($get_data[$data->getCode()])->placeholder(lang('general.code') . ' ....')->textbox(); ?>
<?php echo $Form->id('name')->attr('disabled')->title(lang('general.name'))->value($get_data[$data->getName()])->placeholder(lang('general.name') . ' ....')->textbox(); ?>


<!--<div class="row">
    <div class="col-md-4">
        <select type="text" class="form-control select2">
            <option  value="tes">test</option>
        </select>
    </div>
    <div class="col-md-4">
        <div class="mt-checkbox-inline">
            <label class="mt-checkbox">
                <input type="checkbox" id="inlineCheckbox21" value="option1"> Checkbox 1
                <span></span>
            </label>
            <label class="mt-checkbox">
                <input type="checkbox" id="inlineCheckbox22" value="option2"> Checkbox 2
                <span></span>
            </label>
            <label class="mt-checkbox mt-checkbox-disabled">
                <input type="checkbox" id="inlineCheckbox23" value="option3" disabled=""> Disabled
                <span></span>
            </label>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>-->

<input type="hidden" id="id" name="id" value="<?= $_POST['id']; ?>"/>

<div class="dd" id="nestable_list_3">
    <h4>Structure Menu</h4>
    <ol class="dd-list">
        <?php
        $id_parent = '';
        foreach ($function_parent as $value_function_parent) {

            $id_parent .= $value_function_parent[$sfa->getFunction()->getId()] . ',';
            ?>
            <?php
            $db->sql(SELECT . "COUNT(" . $sfa->getFunction()->getEntity() . DOT . $sfa->getFunction()->getId() . ") as count" .
//                            $sfa->getFunction()->getEntity().DOT.$sfa->getFunction()->getUrl().",".$sfa->getFunction()->getEntity().DOT.$sfa->getFunction()->getId().
                    FROM . $sfa->getEntity() . JOIN . $sfa->getFunction()->getEntity() .
                    ON . $sfa->getFunction()->getEntity() . DOT . $sfa->getFunction()->getId() . EQUAL . $sfa->getEntity() . DOT . $sfa->getFunctionId() .
                    WHERE . $sfa->getFunction()->getParent() . EQUAL . $value_function_parent[$sfa->getFunction()->getId()] . ""
                    . " AND " . $sfa->getGroupId() . EQUAL . $_POST['id']
            );
            $sf_item = $db->getResult();
//            LOGGER($sf_item);
//                        print_r($sf_item);
            $countitem = intval($sf_item[0]['count']);

            $db->sql(SELECT . "COUNT(" . $sfa->getFunction()->getId() . ") as count_function_parent " .
                    FROM . $sfa->getFunction()->getEntity() .
                    WHERE . $sfa->getFunction()->getParent() . EQUAL . $value_function_parent[$sfa->getFunction()->getId()]);
            $sf_count_parent = $db->getResult();
            $count_function_parent = intval($sf_count_parent[0]['count_function_parent']);

            $db->select(
                    $sfa->getEntity(), $sfa->getFunction()->getEntity() . ".*," . $sfa->getEntity() . DOT . $sfa->getId() . " as fa_id ", array($sfa->getFunction()->getEntity(), $sfa->getGroup()->getEntity()), $sfa->getFunction()->getEntity() . DOT . $sfa->getFunction()->getId() . EQUAL . $sfa->getEntity() . DOT . $sfa->getFunctionId()
                    . " AND " . $sfa->getGroup()->getEntity() . DOT . $sfa->getGroup()->getId() . EQUAL . $sfa->getEntity() . DOT . $sfa->getGroupId()
                    . " AND " . $sfa->getEntity() . DOT . $sfa->getStatus() . EQUAL . "1"
                    . " AND " . $sfa->getEntity() . DOT . $sfa->getGroupId() . EQUAL . $_POST['id']
                    . " AND " . $sfa->getFunction()->getEntity() . DOT . $sfa->getFunction()->getParent() . EQUAL . $value_function_parent[$sfa->getFunction()->getId()]
                    , $sfa->getFunctionAssignmentOrder() . ' ASC'
            );
            $function_child = $db->getResult();
            LOGGER("tes");
            LOGGER($function_child);
            ?>
            <li class="dd-item dd3-item"  data-id="<?= $value_function_parent['fa_id']; ?>" id="id-menu<?= $value_function_parent['fa_id']; ?>">
                <div class="dd-handle dd3-handle"> </div>
                <div class="dd3-content" id="content-menu"> 
                    <span id="text-menu<?= $value_function_parent['fa_id']; ?>"><?= $value_function_parent[$sfa->getFunction()->getName()]; ?> </span>
                    <!--<div class="pull-right">-->
                    <?php if ($count_function_parent != 0) { ?>
                        <i class="fa fa-plus text-warning" onclick="addEditMenu(this, '&id=<?= $value_function_parent['fa_id']; ?>&id_group=<?= $_POST['id']; ?>&id_function=<?= $value_function_parent[$sfa->getFunction()->getId()]; ?>&id_function_assignment=<?= $value_function_parent['fa_id']; ?>', 'Add Menu', '<?= URL($adminthemeurl . '/security/function-assignment/add-function'); ?>')" rel="tooltip" data-original-title="Add" style="cursor:pointer"></i>
                    <?php } ?>
                    <i class="fa fa-pencil text-primary" rel="tooltip" data-original-title="Edit" style="cursor:pointer"
                       id="btn-edit-menu<?= $value_function_parent['fa_id']; ?>"
                       onclick="addEditMenu(this, '&id=0&id_function=<?= $value_function_parent[$sfa->getFunction()->getId()]; ?>&id_group=<?= $_POST['id']; ?>&id_function_parent=0&id_parent=0&id_function_assignment=<?= $value_function_parent['fa_id']; ?>', 'Edit Menu', '<?= URL($adminthemeurl . '/security/function-assignment/edit-function'); ?>')"
                       ></i>

                    <i class="fa fa-minus text-danger" rel="tooltip" 
                       alert-title="Delete Data" alert-button-delete="Yes, Delete it." 
                       alert-message="Are you sure Delete this Data??" 
                       onclick="deleteFunction(this, '<?= URL($adminthemeurl . '/security/function-assignment/delete-function'); ?>',<?= $value_function_parent['fa_id']; ?>)" data-original-title="Delete" style="cursor:pointer"></i>
                    <!--<i class="fa fa-minus text-danger" rel="tooltip" data-original-title="Delete" style="cursor:pointer"></i>-->
                    <!--</div>-->

                </div>
                <?php echo getSubMenu($countitem, $count_function_parent, $value_function_parent, $function_child, $_POST['id']); ?>
            </li>
            <?php
        }
        $id_parent = rtrim($id_parent, ",");
        ?>
        <li class="dd-item dd3-item" id="addMenuParent" onclick="addEditMenu(this, '&id=0&id_function_parent=0&id_parent=0&id_group=<?= $_POST['id']; ?>', 'Add Menu', '<?= URL($adminthemeurl . '/security/function-assignment/add-function'); ?>')" >
            <!--<div class="dd-handle dd3-handle"> </div>-->
            <div class="dd3-content" style="cursor:pointer;"> <i class="fa fa-plus text-warning" rel="tooltip" data-original-title="Add" style="cursor:pointer"></i> Add Menu
                <!--<div class="pull-right">-->
                    <!--<i class="fa fa-plus text-warning" rel="tooltip" data-original-title="Add" style="cursor:pointer"></i>-->
                    <!--<i class="fa fa-pencil text-primary" rel="tooltip" data-original-title="Edit" style="cursor:pointer"></i>-->
                    <!--<i class="fa fa-minus text-danger" rel="tooltip" data-original-title="Delete" style="cursor:pointer"></i>-->
                <!--</div>-->
            </div>
        </li>

    </ol>
</div>
<input type="hidden" id="list_id_parent" value="<?= $id_parent; ?>"/>
<?= $Form->formFooter($this->updateUrl, ' '); ?>

<script>
    $(function () {
//        var idparent = $('#nestable_list_3 > ol li').attr('data-id');

//        alert(id);
//        alert(idparent);

        $('.dd').nestable({
            dropCallback: function (details) {
//                alert(details.sourceId);

//                console.log(details.sourceId);
//                console.log("destId:" + details.destId);
//                console.log("destParent:" + JSON.stringify(details.destParent));
//                console.log(details.destParent);
//                console.log("sourceEl:" + JSON.stringify(details.sourceEl));
//                console.log("destRoot:" + JSON.stringify(details.destRoot));
                var id = '';
                $('#nestable_list_3 > ol > li').each(function (i) {
                    var dataid = $(this).attr('data-id');
                    if (typeof dataid != 'undefined') {
                        id += dataid + ",";
                    }
//            alert($(this).attr('data-id')); // This is your rel value
                });
                $.ajax({
                    type: "POST",
                    url: '<?= URL($adminthemeurl . '/security/function-assignment/sorting-function'); ?>',
                    data: 'all_id=' + id,
                    success: function (data) {
                        $('#modal-body-self').html(data);
                    }
                });
//                console.log(id);
            }
        });
        $('#pageAddMenu').hide();

    })

    function addEditMenu(e, value, title, page) {
        $('#modal-title-self').html(title);
        $('#myModal_self').modal({backdrop: 'static', keyboard: false});

        $('#modal-body-self').html(highlightLoader());
        var list_id_parent = $('#list_id_parent').val();

        $.ajax({
            type: "POST",
            url: page,
            data: 'list_id_parent=' + list_id_parent + value,
            success: function (data) {
//            alert(data);
                $('#modal-body-self').html(data);
//            alert('Data send');

            }, error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText);
//                contents.html(jqXHR.responseText);
            }
        });
    }

    function editMenu(e, value, title, page) {
        $('#modal-title-self').html(title);
        $('#myModal_self').modal({backdrop: 'static', keyboard: false});

        $('#modal-body-self').html(highlightLoader());
        var list_id_parent = $('#list_id_parent').val();

        $.ajax({
            type: "POST",
            url: page,
            data: 'list_id_parent=' + list_id_parent + value,
            success: function (data) {
//            alert(data);
                $('#modal-body-self').html(data);
//            alert('Data send');

            }
        });
    }

    function postAjaxFunctionActionType(page, content, value) {

        var contents = $('#' + content);
        contents.append(highlightLoader());
        var id = value.value;
        $.ajax({
            type: "POST",
            url: page,
            data: 'id=' + id,
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

    function saveMenu(id_parent, page) {
        var id = $('#id').val();
        var action_type = $("input[name=action_type]:checked").map(function () {
            return this.value;
        }).get().join(",");
        var functions = $('#function').val();
        if (functions == "") {
            $('#form-message-function').html('<div class="alert alert-danger">Please Input Field Function</div>');
            return true;
        } else {
            $('#form-message-function').html('');
        }
        var contents = $('#myModal_self');
        contents.append(highlightLoader());
        $.ajax({
            type: "POST",
            url: page,
            data: 'id=' + id + '&id_parent=' + id_parent + '&function=' + functions + '&action_type=' + action_type,
            success: function (data) {
                if (id_parent == 0) {
                    try {
                        $("#addMenuParent").before(data);
                        $('.background-overlay').remove();
                    } catch (e) {
//                    $('#' + content).html(data);
                        $("#addMenuParent").before(data);
                        $('.background-overlay').remove();
                    }
                } else {
                    try {
                        var menu = $("#menu-parent-child" + id_parent).html();
                        if (typeof menu != 'undefined') {
//                        if ($("#menu-parent-child" + id_parent)) {
                            $("#menu-parent-child" + id_parent).append(data);
                        } else {
//                            alert("masuk");
                            $('#id-menu' + id_parent).prepend('<button data-action="collapse" type="button">Collapse</button><button data-action="expand" type="button" style="display: none;">Expand</button>');
                            $("#id-menu" + id_parent).append('<ol class="dd-list" id="menu-parent-child' + id_parent + '"></ol>');
                            $("#menu-parent-child" + id_parent).append(data);

                        }

                        $('.background-overlay').remove();
                    } catch (e) {
//                    $('#' + content).html(data);
                        $("#addMenuParent").before(data);
                        $('.background-overlay').remove();
                    }
                }
                $('#myModal_self').modal('hide');
            }, error: function (jqXHR, textStatus, errorThrown) {
//                alert(jqXHR.responseText);
                contents.html(jqXHR.responseText);
            }
        });
//    }
    }

    function updateMenu(value, page) {
//        var id = $('#id').val();
        var action_type = $("input[name=action_type]:checked").map(function () {
            return this.value;
        }).get().join(",");
        var functions = $('#function').val();
        if (functions == "") {
            $('#form-message-function').html('<div class="alert alert-danger">Please Input Field Function</div>');
            return true;
        } else {
            $('#form-message-function').html('');
        }
        var contents = $('#myModal_self');
        contents.append(highlightLoader());
        $.ajax({
            type: "POST",
            url: page,
            data: 'function=' + functions + '&action_type=' + action_type + value,
            success: function (data) {

                try {
                    var json = JSON.parse(data);
                    if (json.result == 1) {
                        toastr.success(json.message, json.title);
                        $('#btn-edit-menu' + json.id_function_assignment).attr("onclick", "addEditMenu(this,'" + json.referrer_event + "','" + json.referrer_title + "','" + json.referrer_url + "')");
                        $('#text-menu' + json.id_function_assignment).html(json.function_name);
                    } else {
                        toastr.error(json.message, json.title);
                    }
//                    $("#addMenuParent").before(data);
//                    $('.background-overlay').remove();
                } catch (e) {
//                    $('#' + content).html(data);
//                    $("#addMenuParent").before(data);
//                    $('.background-overlay').remove();
                    toastr.error(data, "Error");
                }

                $('.background-overlay').remove();
                $('#myModal_self').modal('hide');
            }, error: function (jqXHR, textStatus, errorThrown) {
//                alert(jqXHR.responseText);
//                contents.html(jqXHR.responseText);
                toastr.error(jqXHR.responseText, "Failed");
            }
        });
//    }
    }

    function deleteFunction(e, page, id) {
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
                    $.ajax({
                        type: "POST",
                        url: page,
                        data: 'id=' + id,
                        success: function (data) {
                            var json = JSON.parse(data);
                            try {
                                if (json.result == 1) {
                                    toastr.success(json.message, json.title);
                                    $("#id-menu" + id).remove();
                                } else {
                                    toastr.error(json.message, json.title);
                                }
                                $('.background-overlay').remove();
                            } catch (e) {
//                    $('#' + content).html(data);
                                toastr.error("Delete Failed", "Delete Failed");
//                                $("#addMenuParent").before(data);
                                $('.background-overlay').remove();
                            }
                            $('#myModal_self').modal('hide');
                        }, error: function (jqXHR, textStatus, errorThrown) {
//                alert(jqXHR.responseText);
//                            contents.html(jqXHR.responseText);
                            toastr.error(jqXHR.responseText, "Delete Failed");
                        }
                    });
                });
    }
    function checkAllActionType() {
        $("input[name=action_type]").prop('checked', true);
    }
    function unCheckAllActionType() {
        $("input[name=action_type]").prop('checked', false);
    }
</script>
