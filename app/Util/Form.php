<?php

/*
  @project Tala Indonesia.
  @since 09/09/2016 02:21 AM
  @author <a href = "sfandrianah2@gmail.com">Syahrial Fandrianah</a>
  description Form Component
 */

namespace app\Util;

class Form {

//    public $style = null;
//    public $title = null;
//    public $placeholder = null;
//    public $required = true;
//    public $id;
//    public $msg_required_error = null;
//    public $manual_attribute = null;

    protected $formOption = array(
        'STYLE' => null,
        'TITLE' => null,
        'TOOLTIP_TITLE' => null,
        'CLASS' => null,
        'NOTIF' => null,
        'PLACEHOLDER' => '',
        'REQUIRED' => true,
        'NO_LABEL' => false,
        'TYPE' => null,
        'ID' => null,
        'HREF' => '',
        'NAME' => null,
        'LABEL' => '',
        'ATTR_BUTTON' => '',
        'TITLE_BUTTON' => '',
        'ONCLICK' => '',
        'ICON' => '',
        'VALUE' => null,
        'MINLENGTH' => null,
        'MAXLENGTH' => null,
        'FORM_LAYOUT' => 'vertical',
        'OPTION_LABEL_VALUE' => array(),
        'MESSAGE_REQUIRED_ERROR' => null,
        'MANUAL_ATTRIBUT' => null,
        'AUTO_COMPLETE' => true
    );
    public $response;

    public function __construct() {
//        echo 'masuk';
//        $this->ResetObject();
    }

    public function autocomplete($autocomplete) {
        return $this->setFormOption('AUTO_COMPLETE', $autocomplete);
    }

    public function attrBtn($attrBtn) {
        return $this->setFormOption('ATTR_BUTTON', $attrBtn);
    }

    public function titleBtn($titleBtn) {
        return $this->setFormOption('TITLE_BUTTON', $titleBtn);
    }

    public function formHeader() {
        $txt = '';
        $txt .= '<form role="form" id="form-newedit" action="#" onsubmit="return false;" method="POST" novalidate="novalidate">
    <div class="form-body">
    <div id="form-message">
    </div>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
        </div>';
        return $txt;
    }

    public function formFooter($btn_save_url =null, $manual_button = null, $event = null) {
        $txt = '';
        $txt .= '</div>
    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9" id="formFooter">';
        if ($manual_button == null) {
            $str_event = 'postFormAjax(\'' . $btn_save_url . '\', this)';
            if ($event != null) {
                $str_event = $event;
            }
            $txt .= '<button type="submit" onclick="'.$str_event.'" class="btn green">' . lang('general.save') . '</button>
                <button type="reset" class="btn default">' . lang('general.reset') . '</button>';
        } else {
            $txt .= $manual_button;
        }
        $txt .= '</div>
        </div>
    </div>
</form>';
        $txt .= "<script>
    $(function () {
        $('#actionHeader').html(comButtonBack('" . lang('general.back') . "', 'btn-danger', 'fa-arrow-left'));
            $(\"[rel='tooltip']\").tooltip();
        var e = $(\"#form-newedit\"),
                r = $(\".alert-danger\", e),
                i = $(\".alert-success\", e);
        e.validate({
            errorElement: \"span\",
            errorClass: \"help-block help-block-error\",
            focusInvalid: !1,
            ignore: \"\",
            invalidHandler: function (e, t) {
                i.hide(), r.show(), App.scrollTo(r, -200)
            },
            errorPlacement: function (e, r) {
                var i = $(r).parent(\".input-group\");
                i ? i.after(e) : r.after(e)
            },
            highlight: function (e) {
                $(e).closest(\".form-group\").addClass(\"has-error\")
            },
            unhighlight: function (e) {
                $(e).closest(\".form-group\").removeClass(\"has-error\")
            },
            success: function (e) {
                e.closest(\".form-group\").removeClass(\"has-error\")
            },
            submitHandler: function (e) {
                i.show(), r.hide()
            }
        })
    });
</script>";
        return $txt;
    }

    public function style($style) {
        return $this->setFormOption('STYLE', $style);
    }

    public function href($href) {
        return $this->setFormOption('HREF', $href);
    }

    public function minlength($length) {
        return $this->setFormOption('MINLENGTH', $length);
    }

    public function label($label) {
        return $this->setFormOption('LABEL', $label);
    }

    public function icon($icon) {
        return $this->setFormOption('ICON', $icon);
    }

    public function maxlength($length) {
        return $this->setFormOption('MAXLENGTH', $length);
    }

    public function onclick($onclick) {
        return $this->setFormOption('ONCLICK', $onclick);
    }

    public function type($type) {//email,number
        return $this->setFormOption('TYPE', $type);
    }

    public function formLayout($style) {
        return $this->setFormOption('FORM_LAYOUT', $style);
    }

    public function noLabel($noLabel = false) {
        return $this->setFormOption('NO_LABEL', $noLabel);
    }

    public function setclass($class = "") {
        return $this->setFormOption('CLASS', $class);
    }

    public function placeholder($placeholder) {
        return $this->setFormOption('PLACEHOLDER', $placeholder);
    }

    public function required($required) {
        return $this->setFormOption('REQUIRED', $required);
    }

    public function msgRequired($msgRequired) {
        return $this->setFormOption('MESSAGE_REQUIRED_ERROR', $msgRequired);
    }

    public function id($id) {
        return $this->setFormOption('ID', $id);
    }

    public function data($data = array()) {
        return $this->setFormOption('OPTION_LABEL_VALUE', $data);
    }

    public function name($name) {
        return $this->setFormOption('NAME', $name);
    }

    public function attr($manualattribut) {
        return $this->setFormOption('MANUAL_ATTRIBUT', $manualattribut);
    }

    public function value($value) {
        return $this->setFormOption('VALUE', $value);
    }

    public function title($title) {
        return $this->setFormOption('TITLE', $title);
    }

    protected function defaultOption() {
        $required = $this->formOption['REQUIRED'];
        if ($required == true) {
            $required = 'required';
        } else {
            $required = '';
        }
        $this->setFormOption('REQUIRED', $required);

        $name = $this->formOption['NAME'];
        if ($name == null) {
            $name = $this->formOption['ID'];
        }
        $this->setFormOption('NAME', $name);
    }

    public function onlyButton() {
        $title = $this->formOption['TITLE'];
        $notif = $this->formOption['NOTIF'];
        $class = $this->formOption['CLASS'];
        $rs .= '<a rel="tooltip" 
            title="Delete Collection" 
            notif="' . $notif . '" 
            class="btn btn-default DTTT_button_text" 
            id="ToolTables_crudtable_2">
            <i class="fa fa-times"></i> 
            <span>' . $title . '</span></a>';

        return $rs;
    }

    public function textboxicon() {
        $this->defaultOption();
        $type = 'text';
        if ($this->formOption['TYPE'] != null) {
            $type = $this->formOption['TYPE'];
        }

        $minlength = "";
        $maxlength = "";
        if ($this->formOption['MINLENGTH'] != null) {
            $minlength = ' minlength="' . $this->formOption['MINLENGTH'] . '"';
        }

        if ($this->formOption['MAXLENGTH'] != null) {
            $maxlength = ' maxlength="' . $this->formOption['MAXLENGTH'] . '"';
        }
        $textbox = '<div class="form-group">';
        if ($this->formOption['TITLE'] != null) {
            $textbox .= '<label class="control-label" style="margin-left: 55px;font-weight: bold;">' . $this->formOption['TITLE'] . '</label>';
        }
        $textbox .= '<div class="input-group">
                        <span
                                   class="input-group-addon"> <i class="material-icons">' . $this->formOption['CLASS'] . '</i>
                            </span>
                            <input ' . $this->formOption['REQUIRED'] . '  type="' . $type . '" ' . $minlength . $maxlength . ' id="' . $this->formOption['ID'] . '" name="' . $this->formOption['NAME'] . '"
                                   class="form-control" placeholder="' . $this->formOption['PLACEHOLDER'] . '"> 
                        </div>
                    </div>';
        $textbox .= '';
        $this->ResetObject();
        return $textbox;
    }

    public function textbox() {
        $this->defaultOption();
        $textbox = '';
//        $textbox = '<div class="col-xs-3">';
        $type = 'text';
        if ($this->formOption['TYPE'] != null) {
            $type = $this->formOption['TYPE'];
        }

        $minlength = "";
        $maxlength = "";
        if ($this->formOption['MINLENGTH'] != null) {
            $minlength = ' minlength="' . $this->formOption['MINLENGTH'] . '"';
        }

        if ($this->formOption['MAXLENGTH'] != null) {
            $maxlength = ' maxlength="' . $this->formOption['MAXLENGTH'] . '"';
        }
        $textbox .= '<input type="' . $type . '" 
            placeholder="' . $this->formOption['PLACEHOLDER'] . '" 
            name="' . $this->formOption['NAME'] . '" 
            id="' . $this->formOption['ID'] . '" 
            ' . $this->formOption['REQUIRED'] . ' 
            ' . $this->formOption['MANUAL_ATTRIBUT'] . ' 
            value="' . $this->formOption['VALUE'] . '"
            ' . $minlength . $maxlength . '
            class="form-control">';
//        $textbox .= '<div>';
        $rs = $this->formGroup($textbox);
        $this->ResetObject();
        return $rs;
    }

    public function fileinput() {
        $this->defaultOption();
        $textbox = '';
//        $textbox = '<div class="col-xs-3">';
        $type = 'text';
        if ($this->formOption['TYPE'] != null) {
            $type = $this->formOption['TYPE'];
        }

        $minlength = "";
        $maxlength = "";
        if ($this->formOption['MINLENGTH'] != null) {
            $minlength = ' minlength="' . $this->formOption['MINLENGTH'] . '"';
        }

        if ($this->formOption['MAXLENGTH'] != null) {
            $maxlength = ' maxlength="' . $this->formOption['MAXLENGTH'] . '"';
        }
        $textbox .= '<div class="box">
            <input type="file"  name="' . $this->formOption['NAME'] . '[]" id="' . $this->formOption['ID'] . '" class="inputfile inputfile-6" data-multiple-caption="{count} files selected" multiple />
            <label for="' . $this->formOption['ID'] . '"><span></span> <strong><i class="fa fa-upload"></i> Choose a file &hellip;</strong></label>
        </div>';
//        $textbox .= '<div>';
        $rs = $this->formGroup($textbox);
        $this->ResetObject();
        return $rs;
    }

    public function textboxicongroup() {
        $this->defaultOption();
        $type = 'text';
        if ($this->formOption['TYPE'] != null) {
            $type = $this->formOption['TYPE'];
        }

        $minlength = "";
        $maxlength = "";
        if ($this->formOption['MINLENGTH'] != null) {
            $minlength = ' minlength="' . $this->formOption['MINLENGTH'] . '"';
        }

        if ($this->formOption['MAXLENGTH'] != null) {
            $maxlength = ' maxlength="' . $this->formOption['MAXLENGTH'] . '"';
        }
        $textbox = '<div class="input-group">
                            <input ' . $this->formOption['REQUIRED'] . '  type="' . $type . '" ' . $minlength . $maxlength . ' id="' . $this->formOption['ID'] . '" name="' . $this->formOption['NAME'] . '"
                                   class="form-control" value="' . $this->formOption['VALUE'] . '" placeholder="' . $this->formOption['PLACEHOLDER'] . '"> 
                                       
                                       <div
                                   class="input-group-btn" > 
                                   <button type="button" ' . $this->formOption['ATTR_BUTTON'] . ' id="btn-' . $this->formOption['ID'] . '" class="btn btn-danger">
                                   <i class="' . $this->formOption['CLASS'] . '"></i>
                                       ' . $this->formOption['TITLE_BUTTON'] . '
                                       </button>
                                   
                            </div>
                        </div>
                    ';
        $textbox .= '';
        $rs = $this->formGroup($textbox);
        $this->ResetObject();
        return $rs;
    }

    public function fileinputimage() {
        $this->defaultOption();
        $textbox = '';
//        $textbox = '<div class="col-xs-3">';
        $type = 'text';
        if ($this->formOption['TYPE'] != null) {
            $type = $this->formOption['TYPE'];
        }

        $minlength = "";
        $maxlength = "";
        if ($this->formOption['MINLENGTH'] != null) {
            $minlength = ' minlength="' . $this->formOption['MINLENGTH'] . '"';
        }

        if ($this->formOption['MAXLENGTH'] != null) {
            $maxlength = ' maxlength="' . $this->formOption['MAXLENGTH'] . '"';
        }
        /* $textbox .= '<input type="' . $type . '" 
          placeholder="' . $this->formOption['PLACEHOLDER'] . '"
          name="' . $this->formOption['NAME'] . '"
          id="' . $this->formOption['ID'] . '"
          ' . $this->formOption['REQUIRED'] . '
          ' . $this->formOption['MANUAL_ATTRIBUT'] . '
          value="' . $this->formOption['VALUE'] . '"
          ' . $minlength . $maxlength . '
          class="form-control">';
         */
        $value = '';
        if ($this->formOption['VALUE'] != '') {
            $value = '<img src="' . $this->formOption['VALUE'] . '" alt="" />';
        }
        $textbox .= '<div class="fileinput fileinput-new" id="fileinput-' . $this->formOption['ID'] . '" data-provides="fileinput">
                        <div class="fileinput-preview thumbnail" id="view-' . $this->formOption['ID'] . '" data-trigger="fileinput" style="width: 200px; height: 150px;"> 
                        ' . $value . '
                        </div>
                            <div>
                                <span class="btn red btn-outline btn-file">
                                <span class="fileinput-new"> Select image </span>
                                <span class="fileinput-exists"> Change </span>
                                <input ' . $this->formOption['MANUAL_ATTRIBUT'] . ' id="' . $this->formOption['ID'] . '"  type="file" name="' . $this->formOption['NAME'] . '"> </span>
                            <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                        </div>
                    </div>';
//        $textbox .= '<div>';
        $rs = $this->formGroup($textbox);
        $this->ResetObject();
        return $rs;
    }

    public function datepicker() {
        $this->defaultOption();
        $textbox = '';
//        $textbox = '<div class="col-xs-3">';
        $textbox .= '<input type="text" 
            placeholder="' . $this->formOption['PLACEHOLDER'] . '" 
            name="' . $this->formOption['NAME'] . '" 
            id="' . $this->formOption['ID'] . '" 
            ' . $this->formOption['REQUIRED'] . ' 
            ' . $this->formOption['MANUAL_ATTRIBUT'] . ' 
            value="' . $this->formOption['VALUE'] . '"
            data-date-format="' . DATE_FORMAT . '"
            class="form-control datepicker">';
//        $textbox .= '<div>';
        $rs = $this->formGroup($textbox);
        $this->ResetObject();
        return $rs;
    }

    public function textbox_hidden() {
        $this->defaultOption();
        $textbox = '';
        $textbox .= '<input type="hidden" 
            placeholder="' . $this->formOption['PLACEHOLDER'] . '" 
            name="' . $this->formOption['NAME'] . '" 
            id="' . $this->formOption['ID'] . '" 
            ' . $this->formOption['REQUIRED'] . ' 
            ' . $this->formOption['MANUAL_ATTRIBUT'] . ' 
            value="' . $this->formOption['VALUE'] . '"
            class="form-control">';
        $rs = $this->formGroup($textbox);
        $this->ResetObject();
        return $rs;
    }

    public function textpassword() {
        $this->defaultOption();
        $textbox = '';
//        $textbox = '<div class="col-xs-3">';
        $minlength = "";
        $maxlength = "";
        if ($this->formOption['MINLENGTH'] != null) {
            $minlength = ' minlength="' . $this->formOption['MINLENGTH'] . '"';
        }

        if ($this->formOption['MAXLENGTH'] != null) {
            $maxlength = ' maxlength="' . $this->formOption['MAXLENGTH'] . '"';
        }
        $textbox .= '<input type="password"
            placeholder="' . $this->formOption['PLACEHOLDER'] . '"
            name="' . $this->formOption['NAME'] . '"
            id="' . $this->formOption['ID'] . '"
            ' . $this->formOption['REQUIRED'] . '
            ' . $this->formOption['MANUAL_ATTRIBUT'] . '
            value="' . $this->formOption['VALUE'] . '"
            ' . $minlength . $maxlength . '
             class="form-control">';
//        $textbox .= '<div>';
        $rs = $this->formGroup($textbox);
        $this->ResetObject();
        return $rs;
    }

    public function textarea() {
        $this->defaultOption();
        $minlength = "";
        $maxlength = "";
        if ($this->formOption['MINLENGTH'] != null) {
            $minlength = ' minlength="' . $this->formOption['MINLENGTH'] . '"';
        }

        if ($this->formOption['MAXLENGTH'] != null) {
            $maxlength = ' maxlength="' . $this->formOption['MAXLENGTH'] . '"';
        }
        $textarea = '<textarea type="text" 
            placeholder="' . $this->formOption['PLACEHOLDER'] . '" 
            name="' . $this->formOption['NAME'] . '" 
            id="' . $this->formOption['ID'] . '" 
            ' . $this->formOption['REQUIRED'] . ' 
            ' . $this->formOption['MANUAL_ATTRIBUT'] . '
            value="' . $this->formOption['VALUE'] . '"  
            ' . $minlength . $maxlength . '
            class="form-control">' . $this->formOption['VALUE'] . '</textarea>';
        $rs = $this->formGroup($textarea);
        $this->ResetObject();
        return $rs;
    }

    public function ckeditor() {
        $this->defaultOption();
        $minlength = "";
        $maxlength = "";
        if ($this->formOption['MINLENGTH'] != null) {
            $minlength = ' minlength="' . $this->formOption['MINLENGTH'] . '"';
        }

        if ($this->formOption['MAXLENGTH'] != null) {
            $maxlength = ' maxlength="' . $this->formOption['MAXLENGTH'] . '"';
        }
        $textarea = '<textarea type="text" 
            placeholder="' . $this->formOption['PLACEHOLDER'] . '" 
            name="' . $this->formOption['NAME'] . '" 
            id="' . $this->formOption['ID'] . '" 
            ' . $this->formOption['REQUIRED'] . ' 
            ' . $this->formOption['MANUAL_ATTRIBUT'] . '
            value="' . $this->formOption['VALUE'] . '"  
            ' . $minlength . $maxlength . '
            class="form-control">' . $this->formOption['VALUE'] . '</textarea>';
        $textarea .= '<script>$(function(){ CKEDITOR.replace(\'' . $this->formOption['ID'] . '\', {height: 200,removeButtons: \'\'});});</script>';
        $rs = $this->formGroup($textarea);
        $this->ResetObject();
        return $rs;
    }

    public function defaultdate() {
        $this->defaultOption();
        $defaultdate = '<input id="datepicker"
            placeholder="' . $this->formOption['PLACEHOLDER'] . '"
            name="' . $this->formOption['NAME'] . '"
            id="' . $this->formOption['ID'] . '"
            ' . $this->formOption['REQUIRED'] . '
            ' . $this->formOption['MANUAL_ATTRIBUT'] . '
            value="' . $this->formOption['VALUE'] . '"
            class="form-control">' . $this->formOption['VALUE'] . '</textarea>';
        $rs = $this->formGroup($defaultdate);
        $this->ResetObject();
        return $rs;
    }

    public function disablepastdate() {
        $this->defaultOption();
        $defaultdate = '<div id="datepicker-pastdisabled" class="input-group date">
            <span class="input-group-addon">
            <i class="material-icons">date_range</i></span>
            <input type="text" class="form-control"
            placeholder="' . $this->formOption['PLACEHOLDER'] . '"
            name="' . $this->formOption['NAME'] . '"
            id="' . $this->formOption['ID'] . '"
            ' . $this->formOption['REQUIRED'] . '
            ' . $this->formOption['MANUAL_ATTRIBUT'] . '
            value=' . $this->formOption['VALUE'] . ' '
                . $this->formOption['VALUE'] . '></div>';
        $rs = $this->formGroup($defaultdate);
        return $rs;
    }

    /*
     * THIS IS COMPONENT COMBOBOX
     * EXAMPLE : 
     * $data = '[{"id":"1","label":"EXAMPLE VALUE"},{"id":"2","label":"EXAMPLE VALUE"}]'
     * $json_data = json_decode($data);
     * $Form->title('Combobox Example')->id('combobox')->data($json_data)->combobox();
     */

    public function combobox() {
        $this->defaultOption();
        $combobox = '<select type="text" 
            name="' . $this->formOption['NAME'] . '" 
            id="' . $this->formOption['ID'] . '" 
            ' . $this->formOption['REQUIRED'] . ' 
            ' . $this->formOption['MANUAL_ATTRIBUT'] . '
            value="' . $this->formOption['VALUE'] . '"
            class="form-control select2">';
        $data = $this->formOption['OPTION_LABEL_VALUE'];
        if ($this->formOption['PLACEHOLDER'] == '') {
            $combobox .= '<option value="">Select ...</option>';
        } else {
            $combobox .= '<option value="">' . $this->formOption['PLACEHOLDER'] . '</option>';
        }
        foreach ($data as $value) {
            if ($this->formOption['VALUE'] == $value->id) {
                $combobox .= '<option value="' . $value->id . '" selected="selected">' . $value->label . '</option>';
            } else {
                $combobox .= '<option value="' . $value->id . '">' . $value->label . '</option>';
            }
        }
        $plchldr = '';
        if ($this->formOption['PLACEHOLDER'] != null) {
            $plchldr = '{
                    placeholder: "' . $this->formOption['PLACEHOLDER'] . '"
                }';
        }
        $combobox .= '</select>';
        $combobox .= '<div id="msg' . $this->formOption['ID'] . '">';
        $combobox .= '</div>';
//        $combobox .= '<script>$(function(){ $(\'#' . $this->formOption['ID'] . '\').select2(' . $plchldr . '); });</script>';
        if ($this->formOption['AUTO_COMPLETE'] == true) {
            $combobox .= '<script>$(function(){ $(\'#' . $this->formOption['ID'] . '\').select2(); });</script>';
        }
        $rs = $this->formGroup($combobox);
        $this->data(array());
        $this->ResetObject();
        return $rs;
    }

    function ResetObject() {
        $new = new $this;
        $this->formOption = $new->formOption;
//        foreach ($this->formOption as $key => $value) {
//            unset($this->formOption->$key);
//        }
    }

    protected function formGroup($component) {
        $msg_rq_tx = $this->formOption['MESSAGE_REQUIRED_ERROR'];
        $rq_tx = $this->formOption['REQUIRED'];
        $rq_l = '';
        if ($msg_rq_tx == null) {
            if ($rq_tx != false) {
                $msg_rq_tx = 'Field Wajib Diisi';
            }
        }
        if ($rq_tx != false) {
            $rq_l = '<span style="color:red;">*</span>';
        }


        $title = $this->formOption['TITLE'];
        if ($title == null) {
            $title = 'DEFAULT';
        }
        $noLbl = $this->formOption['NO_LABEL'];
        if ($noLbl == false) {
            if ($this->formOption['FORM_LAYOUT'] == 'vertical') {
                $rs = '<div class="form-group">
                <label class="control-label" for="focusedinput">' . $rq_l . $title . '</label>
                ';
                $rs .= '<div id="comp' . $this->formOption['ID'] . '">' . $component . '</div>';
//            $rs .= '<p class="help-block">' . $msg_rq_tx . '</p>';
                $rs .= '<span class="material-input"></span>
    </div>';
            } else {
                $rs = '<div class="form-group">
                <label class="col-md-3 control-label" for="focusedinput">' . $title . '</label>
                <div class="col-md-9" id="comp' . $this->formOption['ID'] . '">';
                $rs .= $component;
                $rs .= '</div>';
//            $rs .= '<div class="col-sm-2">
//            <p class="help-block">' . $msg_rq_tx . '</p>
//        </div>';
                $rs .= '<span class="material-input"></span>';
                $rs .= '</div>';
            }
        } else {
            $rs .= $component;
        }

        return $rs;
    }

    public function labels() {
        $rs = '';
        if ($this->formOption['FORM_LAYOUT'] == 'vertical') {
            $rs .= '<div class="form-vertical">
            <label class="control-label" style="color:black;font-weight: bold;">
                ' . $this->formOption['TITLE'] . '
            </label>
            <div id="comp' . $this->formOption['ID'] . '">' . $this->formOption['LABEL'] . '</div>
        </div>';
        } else {
            $rs .= '<div class="form-horizontal" style="padding-bottom:30px;">
            <label class="control-label col-md-4" style="text-align:left;color:black;font-size:12px;font-weight: bold;margin-top: -3.5px;">
                ' . $this->formOption['TITLE'] . '
            </label>
            <div class="col-md-8" style="color:black;text-align: left;">' . $this->formOption['LABEL'] . '</div>
        </div>';
        }

        return $rs;
    }

    protected function setFormOption($key, $value) {
        $this->formOption[$key] = $value;
        return $this;
    }

    function groupTextBox($title, $id_textbox, $placeholder, $required = true, $msg_required_error = null, $manual_attribute = null) {
        $rq_tx = 'required';
        if ($required == false) {
            $rq_tx = '';
        }
        $msg_rq_tx = 'Field Wajib Diisi';
        if ($msg_required_error != null) {
            $msg_rq_tx = '';
        }
        $textbox = '<input type="text" placeholder="' . $placeholder . '" name="' . $id_textbox . '" id="' . $id_textbox . '" ' . $rq_tx . ' ' . $manual_attribute . ' class="form-control">';
        $rs = $this->divGroup(
                $title, $msg_rq_tx, $textbox);
        return $rs;
    }

    function button() {
        $rs = '';
        $rs .= '<button ' . $this->formOption['MANUAL_ATTRIBUT'] . ' onclick="' . $this->formOption['ONCLICK'] . '" type="submit" id="' . $this->formOption['ID'] . '" style="' . $this->formOption['STYLE'] . '" class="btn btn-danger btn-block ' . $this->formOption['CLASS'] . '"><i class="material-icons">' . $this->formOption['ICON'] . '</i> ' . $this->formOption['LABEL'] . '</button>';
        return $rs;
    }

    function link() {
        $rs = '';
        $rs .= '<a ' . $this->formOption['MANUAL_ATTRIBUT'] . ' href="' . $this->formOption['HREF'] . '" id="' . $this->formOption['ID'] . '" style="' . $this->formOption['STYLE'] . '" class="btn btn-danger btn-block ' . $this->formOption['CLASS'] . '"><i class="material-icons">' . $this->formOption['ICON'] . '</i> ' . $this->formOption['LABEL'] . '</a>';
        return $rs;
    }

    function divGroup($title, $msg_rq_tx, $component) {
        $rs = '<div class="form-group is-empty">
                <label class="col-sm-2 control-label" for="focusedinput">' . $title . '</label>
                <div class="col-sm-8">';
        $rs .= $component;
        $rs .= '</div>
        <div class="col-sm-2">
            <p class="help-block">' . $msg_rq_tx . '</p>
        </div>
        <span class="material-input"></span>
    </div>';

        return $rs;
    }

    function groupSelectBox($title, $id_selectbox, $array_value_label, $required = true, $msg_required_error = null, $manual_attribute = null) {
        $rq_tx = 'required';
        if ($required == false) {
            $rq_tx = '';
        }
        $msg_rq_tx = 'Field Wajib Diisi';
        if ($msg_required_error != null) {
            $msg_rq_tx = '';
        }
        $rs = '<div class="form-group is-empty">
                <label class="col-sm-2 control-label" for="focusedinput">' . $title . '</label>
                <div class="col-sm-8">';
        $rs .= '<select class="form-control select_box" data="selectbox" ' . $rq_tx . ' ' . $manual_attribute . '  id="' . $id_selectbox . '">';

        foreach ($array_value_label as $key) {
//            echo $key['value'];
            $rs .= '<option value="' . $key['value'] . '">' . $key['label'] . '</option>';
        }
        $rs .='</select>';
        $rs .= '</div>
        <div class="col-sm-2">
            <p class="help-block">' . $msg_rq_tx . '</p>
        </div>
        <span class="material-input"></span>
    </div>';

        return $rs;
    }

    function SaveUpdateNotifJson($title, $json) {
        if ($json == '2') {
            return $this->successNotif($title, trans('pip.success-insert-single-data'));
        } else if ($json == '3') {
            return $this->successNotif($title, trans('pip.success-update-single-data'));
        } else if ($json == '4') {
            return $this->successNotif($title, trans('pip.success-delete-single-data'));
        } else if ($json == '5') {
            return $this->successNotif($title, trans('pip.success-insert-collection-data'));
        } else if ($json == '6') {
            return $this->successNotif($title, trans('pip.success-update-collection-data'));
        } else if ($json == '7') {
            return $this->successNotif($title, trans('pip.success-delete-collection-data'));
        } else if ($json == '-1') {
            return $this->errorNotif($title, trans('pip.error-credential-is-empty'));
        } else if ($json == '-2') {
            return $this->errorNotif($title, trans('pip.error-invalid-credential'));
        } else if ($json == '-3') {
            return $this->errorNotif($title, trans('pip.error-could-not-create-token'));
        } else if ($json == '-4') {
            return $this->errorNotif($title, trans('pip.error-could-not-log-out'));
        } else if ($json == '-5') {
            return $this->errorNotif($title, trans('pip.error-could-not-fetch-record'));
        } else if ($json == '-6') {
            return $this->errorNotif($title, trans('pip.error-no-content'));
        } else if ($json == '-7') {
            return $this->errorNotif($title, trans('pip.error-invalid-json-format'));
        } else if ($json == '-8') {
            return $this->errorNotif($title, trans('pip.error-insert-single-data'));
        } else if ($json == '-9') {
            return $this->errorNotif($title, trans('pip.error-update-single-data'));
        } else if ($json == '-10') {
            return $this->errorNotif($title, trans('pip.error-delete-single-data'));
        } else {
            return $this->errorNotif($title, trans('pip.error-unknown'));
        }
    }

    function AfterSaveUpdateNotifJson() {
        $rs = '';
//        $rs = '<script>';
//        $rs .="$(function () { setPage('list') });";
//        $rs .= '</script>';
        return $rs;
    }

    function successNotif($title, $message) {
        $rs = '<script>';
//        $rs .='window.alert("tes");';
        $rs .= "$(function () {
                    new PNotify({
                    title: '" . $title . " " . trans('pip.success') . "',
                    text: '" . $message . "',
                    type: 'success',
                    icon: 'ti ti-check',
                    styling: 'fontawesome',
                    delay: 2500
        });
        });";

        $rs .= '</script>';

        return $rs;
    }

    function errorNotif($title, $message) {
        $rs = '<script>';
        $rs .= "$(function () {
                    new PNotify({
                     title: '" . $title . " " . trans('pip.error') . "',
                    text: '" . $message . "',
                    type: 'error',
                    icon: 'ti ti-check',
                    styling: 'fontawesome',
                    delay: 2500
        });
        });";

        $rs .= '</script>';

        return $rs;
    }

    function setValue($id, $value) {
        $rs = '<script>';

        $rs .= '$(function () {
                    $("#' . $id . '").val("' . $value . '");
                });
            ';

        $rs .= '</script>';
        return $rs;
    }

    protected function result($response) {
        $this->response = $response;
        return $this;
    }

}
