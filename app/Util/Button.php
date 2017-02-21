<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Util;

/**
 * Description of Button
 *
 * @author sfandrianah
 */
class Button {

    //put your code here
    protected $buttonOption = array(
        'ID' => '',
        'VALUE' => '',
        'URL' => '',
        'CLASS' => '',
        'ONCLICK' => '',
        'TITLE' => '',
        'LABEL' => '',
        'ALERT_TITLE' => '',
        'ALERT_MESSAGE' => '',
        'ALERT_BUTTON_TITLE' => '',
        'PLACEHOLDER' => '',
        'ICON' => '',
    );

    public function arrayButton($data = array()) {
        $class = 'btn btn-primary';
        if (!empty($data['class'])) {
            $class = $data['class'];
        }

        $title = 'Submit';
        if (!empty($data['title'])) {
            $title = $data['title'];
        }

        $onclick = '#';
        if (!empty($data['onclick'])) {
            $onclick = $data['onclick'];
        }

        $attr = '';
        if (!empty($data['attr'])) {
            $attr = $data['attr'];
        }
        $icon = '';
        if (!empty($data['icon'])) {
            $icon = $data['icon'];
        }


        $txt = '<button '
                . ' class="' . $class . '" '
                . ' onclick="' . $onclick . '" '
                . ' ' . $attr . ' '
                . ' type="button"> '
                . ' <i class="' . $icon . '"></i> '
                . ' ' . $title . ' '
                . '</button>';

        return $txt;
    }

    public function buttonDelete() {
        $txt = '';
        if (getActionType(ACTION_TYPE_DELETE) == true) {
            $txt .= '<a class="btn btn-circle btn-icon-only btn-default btn-danger" 
                id="delete' . $this->buttonOption['VALUE'] . '" onclick="postAjaxDelete(\'' . $this->buttonOption['URL'] . '\',\'' . $this->buttonOption['VALUE'] . '\')" rel="tooltip" title="' . lang('general.delete') . '" href="javascript:;">';
            if ($this->buttonOption['ICON'] == "") {
                $txt .= '<i class="icon-trash"></i>';
            } else {
                $txt .= '<i class="' . $this->buttonOption['ICON'] . '"></i>';
            }

            $txt .= '</a>
                <input type="checkbox" style="display:none;" value="' . $this->buttonOption['VALUE'] . '" id="checkboxdelete"/>
                ';
        }
        $this->ResetObject();
        return $txt;
    }

    public function buttonEdit() {
        $txt = '';
        $title = lang('general.edit');
        if ($this->buttonOption['TITLE'] != '') {
            $title = $this->buttonOption['TITLE'];
        }
        $icon = $this->buttonOption['ICON'];
        if ($icon == '') {
            $icon = 'icon-note';
        }
        if (getActionType(ACTION_TYPE_EDIT) == true) {
            $txt .= '<a class="btn btn-circle btn-icon-only btn-default btn-success" id="edit' . $this->buttonOption['VALUE'] . '" onclick="postAjaxEdit(\'' . $this->buttonOption['URL'] . '\',\'id=' . $this->buttonOption['VALUE'] . '\')" rel="tooltip" title="' . $title . '" href="javascript:;">
                    <i class="' . $icon . '"></i>
                </a>';
        }
        $this->ResetObject();
        return $txt;
    }

    public function buttonCircleManual() {
        $btn_icon_only = 'btn-icon-only';
        if ($this->buttonOption['LABEL'] != '') {
            $btn_icon_only = $this->buttonOption['LABEL'];
        }
        if ($this->buttonOption['CLASS'] == '') {
            $this->buttonOption['CLASS'] = 'btn-primary';
        }
        $txt = '<a class="btn btn-circle ' . $btn_icon_only . ' btn-default ' . $this->buttonOption['CLASS'] . '"
            alert-title="' . $this->buttonOption['ALERT_TITLE'] . '"
            alert-message="' . $this->buttonOption['ALERT_MESSAGE'] . '"
            alert-button-title="' . $this->buttonOption['ALERT_BUTTON_TITLE'] . '"
            id="' . $this->buttonOption['ID'] . '" 
                onclick="' . $this->buttonOption['ONCLICK'] . '" 
                    rel="tooltip" title="' . $this->buttonOption['TITLE'] . '" href="javascript:;">
                    <i class="' . $this->buttonOption['ICON'] . '"></i> ' . $this->buttonOption['LABEL'] . '
                </a>';
        $this->ResetObject();
        return $txt;
    }

    public function buttonManual() {
        $btn_icon_only = 'btn-icon-only';
        if ($this->buttonOption['LABEL'] != '') {
            $btn_icon_only = $this->buttonOption['LABEL'];
        }
        if ($this->buttonOption['CLASS'] == '') {
            $this->buttonOption['CLASS'] = 'btn-primary';
        }
        $txt = '<a class="btn ' . $btn_icon_only . ' btn-default ' . $this->buttonOption['CLASS'] . '"
            alert-title="' . $this->buttonOption['ALERT_TITLE'] . '"
            alert-message="' . $this->buttonOption['ALERT_MESSAGE'] . '"
            alert-button-title="' . $this->buttonOption['ALERT_BUTTON_TITLE'] . '"
            id="' . $this->buttonOption['ID'] . '" 
                onclick="' . $this->buttonOption['ONCLICK'] . '" 
                    rel="tooltip" title="' . $this->buttonOption['TITLE'] . '" href="javascript:;">
                    <i class="' . $this->buttonOption['ICON'] . '"></i> ' . $this->buttonOption['LABEL'] . '
                </a>';
        $this->ResetObject();
        return $txt;
    }

    function ResetObject() {
        $new = new $this;
        $this->buttonOption = $new->buttonOption;
    }

    public function placeholder($placeholder) {
        return $this->setButtonOption('PLACEHOLDER', $placeholder);
    }

    public function alertBtnMsg($alertBtnMsg) {
        return $this->setButtonOption('ALERT_BUTTON_TITLE', $alertBtnMsg);
    }

    public function label($label) {
        return $this->setButtonOption('LABEL', $label);
    }

    public function alertMsg($alertMsg) {
        return $this->setButtonOption('ALERT_MESSAGE', $alertMsg);
    }

    public function alertTitle($alertTitle) {
        return $this->setButtonOption('ALERT_TITLE', $alertTitle);
    }

    public function icon($icon) {
        return $this->setButtonOption('ICON', $icon);
    }

    public function onClick($onClick) {
        return $this->setButtonOption('ONCLICK', $onClick);
    }

    public function title($title) {
        return $this->setButtonOption('TITLE', $title);
    }

    public function setClass($class) {
        return $this->setButtonOption('CLASS', $class);
    }

    public function value($value) {
        return $this->setButtonOption('VALUE', $value);
    }

    public function url($url) {
        return $this->setButtonOption('URL', $url);
    }

    public function id($id) {
        return $this->setButtonOption('ID', $id);
    }

    protected function setButtonOption($key, $value) {
        $this->buttonOption[$key] = $value;
        return $this;
    }

}
