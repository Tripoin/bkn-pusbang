<?php

/*
  @project Tala Indonesia.
  @since 09/09/2016 02:21 AM
  @author <a href = "sfandrianah2@gmail.com">Syahrial Fandrianah</a>
  description Form Component
 */

namespace app\Util;

use app\Util\TCaptcha\TCaptcha;

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
        'VALUE_NAME' => '',
        'TITLE_RIGHT' => null,
        'TOOLTIP_TITLE' => null,
        'CLASS' => null,
        'CLASS_COMP' => null,
        'NOTIF' => null,
        'PLACEHOLDER' => '',
        'ATTR_GROUP' => '',
        'SEARCH' => '',
        'REQUIRED' => true,
        'NO_LABEL' => false,
        'TYPE' => null,
        'ID' => null,
        'ID_RIGHT' => null,
        'HREF' => '',
        'NAME' => null,
        'LABEL' => '',
        'LABEL_RIGHT' => '',
        'TOOLTIP_TITLE_BUTTON' => '',
        'ATTR_BUTTON' => '',
        'WITH_BUTTON' => array(),
        'ALIGN_LABEL' => '',
        'TITLE_BUTTON' => '',
        'ONCLICK' => '',
        'ICON' => '',
        'ONLY_COMPONENT' => false,
        'VALUE' => null,
        'VALUE_RIGHT' => null,
        'MINLENGTH' => null,
        'MAXLENGTH' => null,
        'FORM_LAYOUT' => 'vertical',
        'OPTION_LABEL_VALUE' => array(),
        'OPTION_LABEL_VALUE_RIGHT' => array(),
        'MESSAGE_REQUIRED_ERROR' => null,
        'MANUAL_ATTRIBUT' => null,
        'AUTO_COMPLETE' => true,
        'LAYOUT_TYPEAHEAD'
    );
    public $response;

    public function __construct() {
//        echo 'masuk';
//        $this->ResetObject();
    }

    public function tooltipTitleButton($tooltipTitleButton) {
        return $this->setFormOption('TOOLTIP_TITLE_BUTTON', $tooltipTitleButton);
    }
    public function search($search) {
        return $this->setFormOption('SEARCH', $search);
    }

    /**
     * (PHP 4, PHP 5+)<br/>
     * Create Component listBoxAssignment
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param noparam<p>
     * </p>
     * @example :<p>
     * @data array(array("id" => 1, "label" => "Example 1"),array("id" => 2, "label" => "Example 2"),array("id" => 3, "label" => "Example 3"),array("id" => 4, "label" => "Example 4"),array("id" => 5, "label" => "Example 5"),);
     * @Form Form()->idLeft('code')->idRight('code2')->titleLeft(lang('general.code'))->titleRight(lang('general.code'))->valueLeft(array(1,3,5))->dataLeft($data)->listBoxAssignment();
      );<br/>
     * @return string setFormOption <i>$formOption</i>.
     * @version 1.0
     * @desc Sorry cuk masih belajar
     */
    public function listBoxAssignment() {
        $idLeft = $this->formOption['ID'];
        $idRight = $this->formOption['ID_RIGHT'];

        $labelLeft = $this->formOption['LABEL'];
        $labelRight = $this->formOption['LABEL_RIGHT'];

        $titleLeft = $this->formOption['TITLE'];
        $titleRight = $this->formOption['TITLE_RIGHT'];

        $valueLeft = $this->formOption['VALUE'];
        $valueRight = $this->formOption['VALUE_RIGHT'];

        $dataLeft = $this->formOption['OPTION_LABEL_VALUE'];
        $dataLeftArray = (array) $dataLeft;

        $dataRight = $this->formOption['OPTION_LABEL_VALUE_RIGHT'];
        $dataRightArray = (array) $dataRight;


        $txt = '';
        $txt = '<div class="row">
    <div class="col-md-12">
        <div class="col-md-5">
            <div class="form-group">
                <label class="control-label">' . $titleLeft . '</label>
                <select size="10" multiple="multiple" ondblclick="addGroupSelect(\'' . $idLeft . '\', \'' . $idRight . '\')" id="' . $idLeft . '" class="form-control">';
//        print_r($dataLeftArray);
        if (!empty($dataLeftArray)) {
            foreach ($dataLeftArray as $value) {
                if (is_array($valueLeft)) {

                    if (in_array($value['id'], $valueLeft)) {
                        $txt .= '<option value="' . $value['id'] . '" selected>' . $value['label'] . '</option>';
                    } else {
                        $txt .= '<option value="' . $value['id'] . '">' . $value['label'] . '</option>';
                    }
                } else {
//                    echo $value['id'];
                    if ($value['id'] == $valueLeft) {
                        $txt .= '<option value="' . $value['id'] . '" selected>' . $value['label'] . '</option>';
                    } else {
//                        echo $value['id'];
                        $txt .= '<option value="' . $value['id'] . '">' . $value['label'] . '</option>';
                    }
                }
            }
        }
        $txt .= '</select>
            </div>
        </div>
        <div class="col-md-2" style="text-align: center;margin-top: 35px;">
            <div class="col-md-12" style="margin-bottom: 10px;">
                <button type="button" onclick="addGroupSelect(\'' . $idLeft . '\', \'' . $idRight . '\')" class="btn btn-primary btn-sm">' . lang('general.add') . ' <i class="fa fa-arrow-right"></i></button>
            </div>
            <div class="col-md-12" style="margin-bottom: 10px;">
                <button type="button" onclick="addGroupSelect(\'' . $idRight . '\', \'' . $idLeft . '\')" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> ' . lang('general.remove') . '</button>
            </div>
            <div class="col-md-12" style="margin-bottom: 10px;">
                <button type="button" onclick="addAllGroupSelect(\'' . $idLeft . '\', \'' . $idRight . '\')"  class="btn btn-primary btn-sm">' . lang('general.add_all') . ' <i class="fa fa-forward"></i></button>
            </div>
            <div class="col-md-12" style="margin-bottom: 10px;">
                <button type="button" onclick="addAllGroupSelect(\'' . $idRight . '\', \'' . $idLeft . '\')" class="btn btn-primary btn-sm"><i class="fa fa-backward"></i> ' . lang('general.remove_all') . '</button>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label class="control-label">' . $titleRight . '</label>
                <select size="10" id="' . $idRight . '" multiple="multiple" 
                        ondblclick="addGroupSelect(\'' . $idRight . '\', \'' . $idLeft . '\')" class="form-control">';
        if (!empty($dataRightArray)) {
            foreach ($dataRightArray as $value) {
                if (is_array($valueRight)) {
                    if (in_array($value['id'], $valueRight)) {
                        $txt .= '<option value="' . $value['id'] . '" selected>' . $value['label'] . '</option>';
                    } else {
                        $txt .= '<option value="' . $value['id'] . '">' . $value['label'] . '</option>';
                    }
                } else {
                    if ($value['id'] == $valueRight) {
                        $txt .= '<option value="' . $value['id'] . '" selected>' . $value['label'] . '</option>';
                    } else {
                        $txt .= '<option value="' . $value['id'] . '">' . $value['label'] . '</option>';
                    }
                }
            }
        }
        $txt .= '</select>
            </div>
        </div>
    </div>
</div>';
        return $txt;
    }
    
    public function valueName($valueName) {
        return $this->setFormOption('VALUE_NAME', $valueName);
    }

    public function titleLeft($titleLeft) {
        return $this->setFormOption('TITLE', $titleLeft);
    }

    public function attrGroup($attrGroup) {
        return $this->setFormOption('ATTR_GROUP', $attrGroup);
    }

    public function titleRight($titleRight) {
        return $this->setFormOption('TITLE_RIGHT', $titleRight);
    }

    public function valueLeft($valueLeft) {
        return $this->setFormOption('VALUE', $valueLeft);
    }

    public function valueRight($valueRight) {
        return $this->setFormOption('VALUE_RIGHT', $valueRight);
    }

    public function labelRight($labelRight) {
        return $this->setFormOption('LABEL_RIGHT', $labelRight);
    }

    public function labelLeft($labelLeft) {
        return $this->setFormOption('LABEL', $labelLeft);
    }

    public function dataRight($dataRight) {
        return $this->setFormOption('OPTION_LABEL_VALUE_RIGHT', $dataRight);
    }

    public function dataLeft($dataLeft) {
        return $this->setFormOption('OPTION_LABEL_VALUE', $dataLeft);
    }

    public function idRight($idRight) {
        return $this->setFormOption('ID_RIGHT', $idRight);
    }

    public function idLeft($idLeft) {
        return $this->setFormOption('ID', $idLeft);
    }

    public function onlyComponent($onlyComponent) {
        return $this->setFormOption('ONLY_COMPONENT', $onlyComponent);
    }

    public function withButton($withButton) {
        return $this->setFormOption('WITH_BUTTON', $withButton);
    }

    public function autocomplete($autocomplete) {
        return $this->setFormOption('AUTO_COMPLETE', $autocomplete);
    }

    public function layoutTypeAhead($layoutTypeAhead) {
        return $this->setFormOption('LAYOUT_TYPEAHEAD', $layoutTypeAhead);
    }

    public function alignLabel($alignLabel) {
        return $this->setFormOption('ALIGN_LABEL', $alignLabel);
    }

    public function attrBtn($attrBtn) {
        return $this->setFormOption('ATTR_BUTTON', $attrBtn);
    }

    public function classComponent($classComponent) {
        return $this->setFormOption('CLASS_COMP', $classComponent);
    }

    public function titleBtn($titleBtn) {
        return $this->setFormOption('TITLE_BUTTON', $titleBtn);
    }

    public function formHeader() {
        $id = "form-newedit";
        if ($this->formOption['ID'] != "") {
            $id = $this->formOption['ID'];
        }
        $txt = '';
        $txt .= '<form role="form" id="' . $id . '" action="#" onsubmit="return false;" method="POST" novalidate="novalidate">
    <div class="form-body">
    <div id="form-message">
    </div>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
        </div>';
        $this->ResetObject();
        return $txt;
    }

    public function formFooter($btn_save_url = null, $manual_button = null, $event = null) {
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
            $txt .= '<button type="submit" id="btn-save" onclick="' . $str_event . '" class="btn green">' . lang('general.save') . '</button>
                <button type="reset" id="btn-reset" class="btn default">' . lang('general.reset') . '</button>';
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

    /**
     * (PHP 4, PHP 5+)<br/>
     * set ID Form Component used to Textbox,Combobox
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param String $id [optional] <p>
     * String id component
     * </p>
     * @return setFormOption <i>$formOption</i>.
     */
    public function id($id) {
        return $this->setFormOption('ID', $id);
    }

    /**
     * (PHP 4, PHP 5+)<br/>
     * set Data Form Component used to data combobox
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param Array() $data [optional] <p>
     * Array data component Combobox from rest or database
     * </p>
     * @return setFormOption <i>$formOption</i>.
     */
    public function data($data = array()) {
        return $this->setFormOption('OPTION_LABEL_VALUE', $data);
    }

    /**
     * (PHP 4, PHP 5+)<br/>
     * set Name Form Component used to Textbox,Combobox
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param String $name [optional] <p>
     * String name component
     * </p>
     * @return setFormOption <i>$formOption</i>.
     */
    public function name($name) {
        return $this->setFormOption('NAME', $name);
    }

    /**
     * (PHP 4, PHP 5+)<br/>
     * set Manual Attribute or add new Attribute for Form Component used to Textbox,Combobox
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param String $manualattribut [optional] <p>
     * String manual component
     * </p>
     * @return setFormOption <i>$formOption</i>.
     */
    public function attr($manualattribut) {
        return $this->setFormOption('MANUAL_ATTRIBUT', $manualattribut);
    }

    /**
     * (PHP 4, PHP 5+)<br/>
     * set Value Attribute for Form Component used to Textbox,Combobox
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param String $value [optional] <p>
     * String value;
     * </p>
     * @return setFormOption <i>$formOption</i>.
     */
    public function value($value) {
        return $this->setFormOption('VALUE', $value);
    }

    /**
     * (PHP 4, PHP 5+)<br/>
     * set Title Attribute for Form Component used to Label Group
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param String $title [optional] <p>
     * String title;
     * </p>
     * @return setFormOption <i>$formOption</i>.
     */
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

    /**
     * (PHP 4, PHP 5+)<br/>
     * Create Component textbox 
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param noparam<p>
     * </p>
     * @example $Form->id('textbox')->title('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->value('EXAMPLE')->placeholder('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->textbox();<br/>
     * @return string setFormOption <i>$formOption</i>.
     * @version 1.0
     * @desc Sorry cuk masih belajar
     */
    public function textbox() {
        $this->defaultOption();
        $textbox = '';
//        $textbox = '<div class="col-xs-3">';
        $type = 'text';
        if ($this->formOption['TYPE'] != null) {
            $type = $this->formOption['TYPE'];
        }

        $withButton = $this->formOption['WITH_BUTTON'];
        $str_withButton = "";
        if (!empty($withButton)) {
            $button = new Button();
            $str_withButton = $button->arrayButton($withButton);
        }

        $minlength = "";
        $maxlength = "";
        if ($this->formOption['MINLENGTH'] != null) {
            $minlength = ' minlength="' . $this->formOption['MINLENGTH'] . '"';
        }

        if ($this->formOption['MAXLENGTH'] != null) {
            $maxlength = ' maxlength="' . $this->formOption['MAXLENGTH'] . '"';
        }
        if (!empty($withButton)) {
            $textbox .= '<div class="input-group">';
        }
        $textbox .= '<input type="' . $type . '" 
            placeholder="' . $this->formOption['PLACEHOLDER'] . '" 
            name="' . $this->formOption['NAME'] . '" 
            id="' . $this->formOption['ID'] . '" 
            ' . $this->formOption['REQUIRED'] . ' 
            ' . $this->formOption['MANUAL_ATTRIBUT'] . ' 
            value="' . $this->formOption['VALUE'] . '"
            ' . $minlength . $maxlength . '
            class="form-control ' . $this->formOption['CLASS'] . '">';
        if (!empty($withButton)) {
            $textbox .= '<span class="input-group-btn">'
                    . $str_withButton
                    . '</span>'
                    . '</div>';
        }
//        $textbox .= '<div>';
        if ($this->formOption['ONLY_COMPONENT'] == false) {
            $rs = $this->formGroup($textbox);
        } else {
            $rs = $textbox;
        }
        $this->ResetObject();
        return $rs;
    }

    /**
     * (PHP 4, PHP 5+)<br/>
     * Create Component textbox 
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param noparam<p>
     * </p>
     * @example $Form->id('textbox')->title('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->value('EXAMPLE')->placeholder('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->textbox();<br/>
     * @return string setFormOption <i>$formOption</i>.
     * @version 1.0
     * @desc Sorry cuk masih belajar
     */
    public function inputSpinner() {
        $this->defaultOption();
        $textbox = '';
//        $textbox = '<div class="col-xs-3">';
        $type = 'text';
        if ($this->formOption['TYPE'] != null) {
            $type = $this->formOption['TYPE'];
        }

        $withButton = $this->formOption['WITH_BUTTON'];
        $str_withButton = "";
        if (!empty($withButton)) {
            $button = new Button();
            $str_withButton = $button->arrayButton($withButton);
        }

        $minlength = "";
        $maxlength = "";
        if ($this->formOption['MINLENGTH'] != null) {
            $minlength = ' minlength="' . $this->formOption['MINLENGTH'] . '"';
        }

        if ($this->formOption['MAXLENGTH'] != null) {
            $maxlength = ' maxlength="' . $this->formOption['MAXLENGTH'] . '"';
        }
        if ($this->formOption['VALUE'] == "") {
            $this->formOption['VALUE'] = 0;
        }
        $textbox .= '<div class="input-group input-spinner">';
        $textbox .= '<input type="number" 
            placeholder="' . $this->formOption['PLACEHOLDER'] . '" 
            name="' . $this->formOption['NAME'] . '" 
            id="' . $this->formOption['ID'] . '" 
            ' . $this->formOption['REQUIRED'] . ' 
            ' . $this->formOption['MANUAL_ATTRIBUT'] . ' 
            value="' . $this->formOption['VALUE'] . '"
            
                min="0"
            ' . $minlength . $maxlength . '
            class="form-control ' . $this->formOption['CLASS'] . '">';
        $textbox .= '<div class="input-group-btn-vertical">'
                . '<button onclick="upPlus(\'' . $this->formOption['ID'] . '\')" class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
      <button class="btn btn-default"  onclick="downMinus(\'' . $this->formOption['ID'] . '\')" type="button"><i class="fa fa-caret-down"></i></button>'
                . '</div>'
                . '</div>';
//        $textbox .= '<div>';
        if ($this->formOption['ONLY_COMPONENT'] == false) {
            $rs = $this->formGroup($textbox);
        } else {
            $rs = $textbox;
        }
        $this->ResetObject();
        return $rs;
    }

    /**
     * (PHP 4, PHP 5+)<br/>
     * Create Component textbox 
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param noparam<p>
     * </p>
     * @example $Form->id('textbox')->title('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->value('EXAMPLE')->placeholder('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->textbox();<br/>
     * @return string setFormOption <i>$formOption</i>.
     * @version 1.0
     * @desc Sorry cuk masih belajar
     */
    public function typeahead() {
        $this->defaultOption();
        $textbox = '';
//        $textbox = '<div class="col-xs-3">';
        $type = 'text';
        if ($this->formOption['TYPE'] != null) {
            $type = $this->formOption['TYPE'];
        }

        $withButton = $this->formOption['WITH_BUTTON'];
        $str_withButton = "";
        if (!empty($withButton)) {
            $button = new Button();
            $str_withButton = $button->arrayButton($withButton);
        }

        $minlength = "";
        $maxlength = "";
        if ($this->formOption['MINLENGTH'] != null) {
            $minlength = ' minlength="' . $this->formOption['MINLENGTH'] . '"';
        }

        if ($this->formOption['MAXLENGTH'] != null) {
            $maxlength = ' maxlength="' . $this->formOption['MAXLENGTH'] . '"';
        }
        if (!empty($withButton)) {
            $textbox .= '<div class="input-group">';
        }
        $textbox .= '<div id="layout-' . $this->formOption['ID'] . '">';
        $textbox .= '<input type="' . $type . '" 
            placeholder="' . $this->formOption['PLACEHOLDER'] . '" 
            name="' . $this->formOption['NAME'] . '" 
            id="' . $this->formOption['ID'] . '" 
            ' . $this->formOption['REQUIRED'] . ' 
            ' . $this->formOption['MANUAL_ATTRIBUT'] . ' 
            style="' . $this->formOption['STYLE'] . '"
            value="' . $this->formOption['VALUE'] . '"
            ' . $minlength . $maxlength . '
            class="form-control typeahead ' . $this->formOption['CLASS'] . '">';
        $data = $this->formOption['OPTION_LABEL_VALUE'];
        $LAYOUT_TYPEAHEAD = $this->formOption['LAYOUT_TYPEAHEAD'];

        $textbox .= '</div>';
        if (!empty($withButton)) {
            $textbox .= '<span class="input-group-btn">'
                    . $str_withButton
                    . '</span>'
                    . '</div>';
        }

        $textbox .= '<script>'
                . '$(function () {'
                . 'var icon = new Bloodhound({'
                . 'datumTokenizer: Bloodhound.tokenizers.obj.whitespace(\'name\'),'
                . 'queryTokenizer: Bloodhound.tokenizers.whitespace,'
                . 'local: ' . $data
                . '});'
                . '$(\'#layout-style .typeahead\').typeahead({'
                . 'hint: true,highlight: true,minLength: 1,},{name: \'icon\',display: \'name\',source: icon.ttAdapter(),'
                . 'templates: {'
                . 'empty: \'Not Found\','
                . 'suggestion: Handlebars.compile(\'' . $LAYOUT_TYPEAHEAD . '\'),'
                . '}});'
                . '});'
                . '</script>';
//        $textbox .= '<div>';
        $rs = $this->formGroup($textbox);
        $this->ResetObject();
        return $rs;
    }

    /**
     * (PHP 4, PHP 5+)<br/>
     * Create Component Checkbox <COMBOBOX>
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param noparam<p>
     * @default default class list if set inline => classComponent('mt-checkbox-inline');
     * </p>
     * @example $data = '$data = array(array("id"=>1,"label"=>"CHECKBOX 1"),array("id"=>2,"label"=>"CHECKBOX 2"));<br/>$Form->title('Checkbox Example')->id('checkbox')->data($json_data)->checkbox();
     * @return string setFormOption <i>$formOption</i>.
     * @version 1.0
     * @desc Sorry cuk masih belajar
     */
    public function checkbox() {
        $this->defaultOption();
        $textbox = '';
//        $textbox = '<div class="col-xs-3">';
        $type = 'text';
        if ($this->formOption['TYPE'] != null) {
            $type = $this->formOption['TYPE'];
        }
        $data = $this->formOption['OPTION_LABEL_VALUE'];
        $classComponent = 'mt-checkbox-list';
        if ($this->formOption['CLASS_COMP'] != null) {
            $classComponent = $this->formOption['CLASS_COMP'];
        }
        $textbox .= '<div class="' . $classComponent . '">';
//        print_r($data);
        $data = (array) $data;
        if (is_object($data)) {
            foreach ($data as $value) {
                $dt_value = $value->id;
                if ($value->id == $this->formOption['VALUE']) {
                    $dt_value = $this->formOption['VALUE'];
                }
                $textbox .= '<label class="mt-checkbox mt-checkbox-outline">
                            <input type="checkbox" 
                            name="' . $this->formOption['NAME'] . '" 
                            id="' . $this->formOption['ID'] . '" value="' . $dt_value . '"> ' . $value->label . '
                                <span></span>
                        </label>';
            }
        } else {
            foreach ($data as $value) {
                $val_id = $value['id'];
                $dt_value = $val_id;
                $checked_value = '';
                if (is_array($this->formOption['VALUE'])) {
                    if (in_array($val_id, $this->formOption['VALUE'])) {
                        $dt_value = $this->formOption['VALUE'];
                        $checked_value = 'checked';
                    }
                } else {
                    if ($val_id == $this->formOption['VALUE']) {
                        $dt_value = $this->formOption['VALUE'];
                        $checked_value = 'checked';
                    }
                }
                $textbox .= '<label class="mt-checkbox mt-checkbox-outline">
                            <input type="checkbox" 
                            name="' . $this->formOption['NAME'] . '" 
                            id="' . $this->formOption['ID'] . '" value="' . $dt_value . '" ' . $checked_value . '> ' . $value['label'] . '
                                <span></span>
                        </label>';
            }
        }

        $textbox .= '</div>';
        $rs = $this->formGroup($textbox);
        $this->ResetObject();
        return $rs;
    }

    /**
     * (PHP 4, PHP 5+)<br/>
     * Create Component Checkbox <COMBOBOX>
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param noparam<p>
     * @default default class list if set inline => classComponent('mt-checkbox-inline');
     * </p>
     * @example $data = '$data = array(array("id"=>1,"label"=>"CHECKBOX 1"),array("id"=>2,"label"=>"CHECKBOX 2"));<br/>$Form->title('Checkbox Example')->id('checkbox')->data($json_data)->checkbox();
     * @return string setFormOption <i>$formOption</i>.
     * @version 1.0
     * @desc Sorry cuk masih belajar
     */
    public function radiobox() {
        $this->defaultOption();
        $textbox = '';
//        $textbox = '<div class="col-xs-3">';
        $type = 'text';
        if ($this->formOption['TYPE'] != null) {
            $type = $this->formOption['TYPE'];
        }
        $data = $this->formOption['OPTION_LABEL_VALUE'];
        $classComponent = 'mt-checkbox-list';
        if ($this->formOption['CLASS_COMP'] != null) {
            $classComponent = $this->formOption['CLASS_COMP'];
        }
        $textbox .= '<div class="' . $classComponent . '">';
//        print_r($data);
        if (is_object($data[0])) {
            foreach ($data as $value) {
                $checked = '';
                if ($value->id == $this->formOption['VALUE']) {
                    $checked = ' checked="checked"';
                }
                $textbox .= '<label class="mt-checkbox mt-checkbox-outline">
                            <input type="radio" 
                            ' . $this->formOption['MANUAL_ATTRIBUT'] . ' 
                            name="' . $this->formOption['NAME'] . '" 
                            id="' . $this->formOption['ID'] . '" ' . $checked . ' value="' . $value->id . '"> ' . $value->label . '
                                <span></span>
                        </label><br/>';
            }
        } else {
            foreach ($data as $value) {
                $checked = '';
                if ($value['id'] == $this->formOption['VALUE']) {
                    $checked = ' checked="checked"';
                }
                $textbox .= '<label class="mt-checkbox mt-checkbox-outline">
                            <input type="radio" 
                            ' . $this->formOption['MANUAL_ATTRIBUT'] . ' 
                            name="' . $this->formOption['NAME'] . '" 
                            id="' . $this->formOption['ID'] . '" ' . $checked . ' value="' . $value['id'] . '"> ' . $value['label'] . '
                                <span></span>
                        </label><br/>';
            }
        }

        $textbox .= '</div>';
        $rs = $this->formGroup($textbox);
        $this->ResetObject();
        return $rs;
    }

    /**
     * (PHP 4, PHP 5+)<br/>
     * Create Component Tripoin Captcha 
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param noparam<p>
     * </p>
     * @example $Form->id('captcha')->title('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->value('EXAMPLE')->placeholder('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->captcha();<br/>
     * @return string setFormOption <i>$formOption</i>.
     * @version 1.0
     * @desc Sorry cuk masih belajar
     */
    public function captcha() {
        $TCaptcha = new TCaptcha();
        $_SESSION[SESSION_CAPTCHA] = $TCaptcha->simple_php_captcha();
        $this->defaultOption();
        $captcha = '';
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
        if ($this->formOption['FORM_LAYOUT'] == 'horizontal') {
            $captcha .= '<div class="col-md-4" style="background:#fffdcd;" id="captcha_image_' . $this->formOption['ID'] . '">';
        } else {
            $captcha .= '<div style="" id="captcha_image_' . $this->formOption['ID'] . '">';
        }
        $captcha .= '<img src="' . $_SESSION[SESSION_CAPTCHA]['image_src'] . '" alt="CAPTCHA code">';
        $captcha .= '</div>';
        if ($this->formOption['FORM_LAYOUT'] == 'horizontal') {
            $captcha .= '<div class="col-md-8" style="background:#fffdcd;height:73px;">';
        }
        $captcha .= '
            <div class="input-group">
            <input type="' . $type . '" 
            style="width:200px;margin-top:18px;"
            placeholder="' . $this->formOption['PLACEHOLDER'] . '" 
            name="' . $this->formOption['NAME'] . '" 
            id="' . $this->formOption['ID'] . '" 
            ' . $this->formOption['REQUIRED'] . ' 
            ' . $this->formOption['MANUAL_ATTRIBUT'] . ' 
            value="' . $this->formOption['VALUE'] . '"
            ' . $minlength . $maxlength . '
            class="form-control ' . $this->formOption['CLASS'] . '">';
        if ($this->formOption['FORM_LAYOUT'] == 'horizontal') {
            $captcha .= '<span class="input-group-btn">
                <button style="margin-top:18px;height:34px;" type="button" 
                onclick="ajaxPostManual(\'' . URL('captcha/reload') . '\',\'captcha_image_' . $this->formOption['ID'] . '\',\'\')" 
                    class="read_more button"><i class="fa fa-repeat"></i></button></span>
                </div></div>';
        } else {
            $captcha .= '<span class="input-group-btn">
                <button style="margin-top:18px;height:34px;margin-right:1000px;" type="button" 
                onclick="ajaxPostManual(\'' . URL('captcha/reload') . '\',\'captcha_image_' . $this->formOption['ID'] . '\',\'\')" 
                    class="read_more button btn-danger"><i class="fa fa-repeat"></i></button></span>
                </div></div>';
        }

        $rs = $this->formGroup($captcha);
        $this->ResetObject();
        return $rs;
    }

    /**
     * (PHP 4, PHP 5+)<br/>
     * Create Component File Input <UPLOAD FILE>
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param noparam<p>
     * </p>
     * @example $Form->id('fileinput')->title('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->value('EXAMPLE')->placeholder('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->fileinput();<br/>
     * @return string setFormOption <i>$formOption</i>.
     * @version 1.0
     * @desc Sorry cuk masih belajar
     */
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
            <label style="height:35px;"  for="' . $this->formOption['ID'] . '" ><span id="file-' . $this->formOption['ID'] . '"></span> 
                <strong><i class="fa fa-upload"></i> Choose a file &hellip;</strong>
           </label>
        </div>';
        $textbox .= '<script>$(function(){$("input[type=file]").on(\'change\',function(){'
                . '$(\'#file-' . $this->formOption['ID'] . '\').html(this.files[0].name);'
                . '});});</script>';
//        $textbox .= '<div>';
        $rs = $this->formGroup($textbox);
        $this->ResetObject();
        return $rs;
    }

    /**
     * (PHP 4, PHP 5+)<br/>
     * Create Component Textbox with Icon <First Icon then textbox>
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param noparam<p>
     * </p>
     * @example $Form->id('textboxicongroup')->title('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->value('EXAMPLE')->placeholder('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->textboxicongroup();<br/>
     * @return string setFormOption <i>$formOption</i>.
     * @version 1.0
     * @desc Sorry cuk masih belajar
     */
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
        $tooltip = "";
        if ($this->formOption['TOOLTIP_TITLE_BUTTON'] != "") {
            $tooltip = 'rel="tooltip" title="' . $this->formOption['TOOLTIP_TITLE_BUTTON'] . '"';
        }
        $textbox = '<div class="input-group" ' . $this->formOption['ATTR_GROUP'] . '> 
                            <input ' . $this->formOption['REQUIRED'] . ' 
                                ' . $this->formOption['MANUAL_ATTRIBUT'] . ''
                . ' type="' . $type . '" ' . $minlength . $maxlength . ' '
                . ' id="' . $this->formOption['ID'] . '" '
                . ' name="' . $this->formOption['NAME'] . '"'
                . ' class="form-control" '
                . ' value="' . $this->formOption['VALUE'] . '" '
                . ' placeholder="' . $this->formOption['PLACEHOLDER'] . '"> 
                                     <div class="input-group-btn" > 
                                   <button type="button" ' . $this->formOption['ATTR_BUTTON'] . ' '
                . $tooltip
                . 'id="btn-' . $this->formOption['ID'] . '" data-placement="right" class="btn btn-danger">
                                   <i class="' . $this->formOption['CLASS'] . '"></i>
                                       ' . $this->formOption['TITLE_BUTTON'] . '
                                       </button>
                                   
                            </div>
                        </div>
                    ';
        if ($this->formOption['TOOLTIP_TITLE_BUTTON'] != "") {
            $textbox .= '<script>$(function(){$("[rel=\'tooltip\']").tooltip();});</script>';
        }
        $textbox .= '';
        $rs = $this->formGroup($textbox);
        $this->ResetObject();
        return $rs;
    }
    
    /**
     * (PHP 4, PHP 5+)<br/>
     * Create Component Textbox with Icon <First Icon then textbox>
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param noparam<p>
     * </p>
     * @example $Form->id('textboxicongroup')->title('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->value('EXAMPLE')->placeholder('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->textboxicongroup();<br/>
     * @return string setFormOption <i>$formOption</i>.
     * @version 1.0
     * @desc Sorry cuk masih belajar
     */
    public function openLOV() {
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
        $tooltip = "";
        if ($this->formOption['TOOLTIP_TITLE_BUTTON'] != "") {
            $tooltip = 'rel="tooltip" title="' . $this->formOption['TOOLTIP_TITLE_BUTTON'] . '"';
        }
        $textbox = '<div class="input-group" ' . $this->formOption['ATTR_GROUP'] . '> 
                            <input ' . $this->formOption['REQUIRED'] . ' 
                                ' . $this->formOption['MANUAL_ATTRIBUT'] . ''
                .' readonly="readonly" '
                . ' type="' . $type . '" ' . $minlength . $maxlength . ' '
                . ' id="' . $this->formOption['ID'] . '-name" '
                . ' name="' . $this->formOption['NAME'] . '-name"'
                . ' class="form-control" '
                . ' value="' . $this->formOption['VALUE_NAME'] . '" '
                . ' placeholder="' . $this->formOption['PLACEHOLDER'] . '"> 
                                     <div class="input-group-btn" > 
                                   <button type="button" ' . $this->formOption['ATTR_BUTTON'] . ' '
                . $tooltip
                . 'id="btn-' . $this->formOption['ID'] . '" data-placement="right" 
                    onclick="ajaxPostModalByValue(\''.URL('search/lov').'\',\''.lang('general.list').' '.$this->formOption['TITLE'].'\',\'name=' . $this->formOption['NAME'] . '\');" class="btn btn-danger">
                                   <i class="' . $this->formOption['CLASS'] . '"></i>
                                       ' . $this->formOption['TITLE_BUTTON'] . '
                                       </button>
                            </div>
                        </div>
                    ';
        $textbox .= '<input type="hidden" value="' . $this->formOption['VALUE'] . '" id="' . $this->formOption['ID'] . '" name="' . $this->formOption['NAME'] . '"/>';
        if ($this->formOption['TOOLTIP_TITLE_BUTTON'] != "") {
            $textbox .= '<script>$(function(){$("[rel=\'tooltip\']").tooltip();});</script>';
        }
        $textbox .= '';
        $rs = $this->formGroup($textbox);
        $this->ResetObject();
        return $rs;
    }

    /**
     * (PHP 4, PHP 5+)<br/>
     * Create Component File Input <Upload Only Image>
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param noparam<p>
     * </p>
     * @example $Form->id('fileinputimage')->title('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->value('EXAMPLE')->placeholder('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->fileinputimage();<br/>
     * @return string setFormOption <i>$formOption</i>.
     * @version 1.0
     * @desc Sorry cuk masih belajar
     */
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

    /**
     * (PHP 4, PHP 5+)<br/>
     * Create Component File Input <Upload Only Image>
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param noparam<p>
     * </p>
     * @example $Form->id('datepicker')->title('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->value('EXAMPLE')->placeholder('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->fileinputimage();<br/>
     * @return string setFormOption <i>$formOption</i>.
     * @version 1.0
     * @desc Sorry cuk masih belajar
     */
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
        $textbox .= '<script>$(function(){$(\'#' . $this->formOption['ID'] . '\').datepicker()});</script>';
//        $textbox .= '<div>';
        $rs = $this->formGroup($textbox);
        $this->ResetObject();
        return $rs;
    }

    /**
     * (PHP 4, PHP 5+)<br/>
     * Create Component File Input <Upload Only Image>
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param noparam<p>
     * </p>
     * @example $Form->id('datepicker')->title('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->value('EXAMPLE')->placeholder('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->fileinputimage();<br/>
     * @return string setFormOption <i>$formOption</i>.
     * @version 1.0
     * @desc Sorry cuk masih belajar
     */
    public function timepicker() {
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
        $textbox .= '<script>$(function(){$(\'#' . $this->formOption['ID'] . '\').timepicker({showMeridian: false})});</script>';
        $rs = $this->formGroup($textbox);
        $this->ResetObject();
        return $rs;
    }

    public function onlyTimepicker() {
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
        $textbox .= '<script>$(function(){$(\'#' . $this->formOption['ID'] . '\').timepicker({showMeridian: false})});</script>';
        $this->ResetObject();
        return $textbox;
    }

    public function onlyDatepicker() {
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
        $textbox .= '<script>$(function(){$(\'#' . $this->formOption['ID'] . '\').datepicker()});</script>';
//        $rs = $this->formGroup($textbox);
        $this->ResetObject();
        return $textbox;
    }

    /**
     * (PHP 4, PHP 5+)<br/>
     * Create Component Textbox Hidden
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param noparam<p>
     * </p>
     * @example $Form->id('textbox_hidden')->title('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->value('EXAMPLE')->placeholder('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->textbox_hidden();<br/>
     * @return string setFormOption <i>$formOption</i>.
     * @version 1.0
     * @desc Sorry cuk masih belajar
     */
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

    /**
     * (PHP 4, PHP 5+)<br/>
     * Create Component Textbox Password
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param noparam<p>
     * </p>
     * @example $Form->id('textpassword')->title('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->value('EXAMPLE')->placeholder('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->textpassword();<br/>
     * @return string setFormOption <i>$formOption</i>.
     * @version 1.0
     * @desc Sorry cuk masih belajar
     */
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

    /**
     * (PHP 4, PHP 5+)<br/>
     * Create Component Text Area
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param noparam<p>
     * </p>
     * @example $Form->id('textarea')->title('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->value('EXAMPLE')->placeholder('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->textarea();<br/>
     * @return string setFormOption <i>$formOption</i>.
     * @version 1.0
     * @desc Sorry cuk masih belajar
     */
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

    /**
     * (PHP 4, PHP 5+)<br/>
     * Create Component CKEditor <Text Editor>
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param noparam<p>
     * </p>
     * @example $Form->id('ckeditor')->title('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->value('EXAMPLE')->placeholder('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->ckeditor();<br/>
     * @return string setFormOption <i>$formOption</i>.
     * @version 1.0
     * @desc Sorry cuk masih belajar
     */
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

    /**
     * (PHP 4, PHP 5+)<br/>
     * Create Component Default Date <DatePicker>
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param noparam<p>
     * </p>
     * @example $Form->id('defaultdate')->title('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->value('EXAMPLE')->placeholder('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->defaultdate();<br/>
     * @return string setFormOption <i>$formOption</i>.
     * @version 1.0
     * @desc Sorry cuk masih belajar
     */
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

    /**
     * (PHP 4, PHP 5+)<br/>
     * Create Component COMBOBOX <COMBOBOX>
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param noparam<p>
     * </p>
     * @example $data = '[{"id":"1","label":"EXAMPLE VALUE"},{"id":"2","label":"EXAMPLE VALUE"}]';<br/>$json_data = json_decode($data);<br/>$Form->title('Combobox Example')->id('combobox')->data($json_data)->combobox();
     * @return string setFormOption <i>$formOption</i>.
     * @version 1.0
     * @desc Sorry cuk masih belajar
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
//        print_r($data);
        if (!empty($data)) {
            foreach ($data as $value) {
                if (is_object($value)) {
                    if ($this->formOption['VALUE'] == $value->id) {
                        $combobox .= '<option value="' . $value->id . '" selected="selected">' . $value->label . '</option>';
                    } else {
                        $combobox .= '<option value="' . $value->id . '">' . $value->label . '</option>';
                    }
                } else {
                    if ($this->formOption['VALUE'] == $value['id']) {
                        $combobox .= '<option value="' . $value['id'] . '" selected="selected">' . $value['label'] . '</option>';
                    } else {
                        $combobox .= '<option value="' . $value['id'] . '">' . $value['label'] . '</option>';
                    }
                }
            }
        }
//        } else if (is_array($data)) {
        /*    foreach ($data as $value) {

          }
          }
         * 
         */
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
        if ($this->formOption['ONLY_COMPONENT'] == false) {
            $rs = $this->formGroup($combobox);
        } else {
            $rs = $combobox;
        }
        $this->data(array());
        $this->ResetObject();
        return $rs;
    }

    public function ajaxCombobox() {
        $this->defaultOption();
        $combobox = '<select type="text" 
            name="' . $this->formOption['NAME'] . '" 
            id="' . $this->formOption['ID'] . '" 
            ' . $this->formOption['REQUIRED'] . ' 
            ' . $this->formOption['MANUAL_ATTRIBUT'] . '
            value="' . $this->formOption['VALUE'] . '"
            class="form-control select2">';

        $combobox .= '</select>';
        $combobox .= '<div id="msg' . $this->formOption['ID'] . '">';
        $combobox .= '</div>';
//        $combobox .= '<script>$(function(){ $(\'#' . $this->formOption['ID'] . '\').select2(' . $plchldr . '); });</script>';
        if ($this->formOption['AUTO_COMPLETE'] == true) {
            $combobox .= '<script>$(function(){ $(\'#' . $this->formOption['ID'] . '\').select2({'
                    . 'data :[{id:\'value\',text:\'TEST DULU\'}]'
                    . '}); });</script>';
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

    /**
     * (PHP 4, PHP 5+)<br/>
     * Create Component Manual with Form Group
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param String @component<p>
     * </p>
     * @example $Form->formGroup('Example')
     * @return string setFormOption <i>$formOption</i>.
     * @version 1.0
     * @desc Sorry cuk masih belajar
     */
    public function formGroup($component) {
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
                $rs .= '<div id="comp' . $this->formOption['ID'] . '" class="' . $this->formOption['CLASS_COMP'] . '">' . $component . '</div>';
//            $rs .= '<p class="help-block">' . $msg_rq_tx . '</p>';
                $rs .= '<span class="material-input"></span>
    </div>';
            } else {
                $rs = '<div class="form-group" style="margin-bottom:40px;">
                <label class="col-md-3 control-label" for="focusedinput"  align="' . $this->formOption['ALIGN_LABEL'] . '">' . $title . $rq_l . '</label>
                <div class="col-md-9 ' . $this->formOption['CLASS_COMP'] . '" id="comp' . $this->formOption['ID'] . '">';
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

    /**
     * (PHP 4, PHP 5+)<br/>
     * Create Component Labels
     * <br/>
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param noparam<p>
     * </p>
     * @example $Form->id('labels')->title('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->value('EXAMPLE')->placeholder('EXAMPLE')<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->labels();<br/>
     * @return string setFormOption <i>$formOption</i>.
     * @version 1.0
     * @desc Sorry cuk masih belajar
     */
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

    public function getInputMedia() {
        $txt = '';
//        $txt .= $this->id($this->formOption['ID'])->title($this->formOption['TITLE'])->fileinputimage();
        $txt .= '<div class="input-group" id="input-' . $this->formOption['ID'] . '">
                    <div class="input-icon">
                        <i class="fa fa-globe fa-fw"></i>
                        <input class="form-control" type="text"  value="' . $this->formOption['VALUE'] . '"
                            placeholder="' . $this->formOption['PLACEHOLDER'] . '"
                               name="' . $this->formOption['ID'] . '" id="' . $this->formOption['ID'] . '"> 
                    </div>
                    <span class="input-group-btn">
                        <button id="chooseMediaThumbnail" 
                                onclick="getMedia(\'' . URL(getAdminTheme() . '/get-media') . '\', \'' . $this->formOption['ID'] . '\')" 
                                class="btn btn-success" type="button">
                            <i class="fa fa-picture-o fa-fw"></i> Media</button>
                    </span>
                </div>';
        $rs = $this->formGroup($txt);
        $this->ResetObject();
        return $rs;
    }

}
