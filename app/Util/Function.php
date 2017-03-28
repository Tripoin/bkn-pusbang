<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * Description of City
 * @email : sfandrianah2@gmail.com
 * @author Syahrial Fandrianah
 * @FRAMEWORK NATIVE ECCOMERCE V.1.0
 */

use app\Model\SecurityFunction;
use app\Model\SecurityFunctionLanguage;
use app\Model\SecurityFunctionAssignment;
use app\Model\SecurityUser;
use app\Model\SecurityUserProfile;
use app\Util\PHPMail\PHPMailer;
use app\Model\SecurityGroup;
use app\Model\MasterSystemParameter;
use app\Model\MasterLanguage;
use app\Util\Database;
use app\Util\RestClient\TripoinRestClient;
use app\Constant\IRestCommandConstant;
use app\Util\Form;
use app\Util\Button;

function is_not_null($var) {
    return !is_null($var);
}

function checkUserLogin() {
    $db = new Database();
    $groupModel = new SecurityGroup();
    $user_data = array();
    $username = array();
    if (isset($_SESSION[SESSION_USERNAME_GUEST])) {
        $username = array(SESSION_USERNAME_GUEST => $_SESSION[SESSION_USERNAME_GUEST]);
    }

    $email = array();
    if (isset($_SESSION[SESSION_EMAIL_GUEST])) {
        $email = array(SESSION_EMAIL_GUEST => $_SESSION[SESSION_EMAIL_GUEST]);
    }

    $fullname = array();
    if (isset($_SESSION[SESSION_FULLNAME_GUEST])) {
        $fullname = array(SESSION_FULLNAME_GUEST => $_SESSION[SESSION_FULLNAME_GUEST]);
    }

    $group = array();
    if (isset($_SESSION[SESSION_GROUP_GUEST])) {
        if ($_SESSION[SESSION_GROUP_GUEST] == 2) {
            $group = array(SESSION_GROUP_GUEST => $_SESSION[SESSION_GROUP_GUEST]);
        } else {
            $res_group = $db->selectByID($groupModel, $groupModel->getId() . EQUAL . $_SESSION[SESSION_GROUP_GUEST]);
            if ($res_group[0][$groupModel->getParentId()] == 2) {
                $group = array(SESSION_GROUP_GUEST => $_SESSION[SESSION_GROUP_GUEST]);
            } else {
                $group = array();
            }
        }
    }

    if (!empty($group)) {
        $user_data = array_merge($username, $email, $fullname, $group);
    }
    return $user_data;
}

$title = '';

function getRestLov($code) {
    $tripoinRestClient = new TripoinRestClient();
    $url = URL_REST . IRestCommandConstant::API . SLASH . IRestCommandConstant::VERSI . SLASH .
            $code . SLASH .
            IRestCommandConstant::COMMAND_STRING . EQUAL . IRestCommandConstant::SELECT_LOV;
    $result = $tripoinRestClient->doGET($url, array());
    if (empty($result->getBody)) {
        return array();
    } else {
        return json_decode($result->getBody);
    }
}

function setTitle($value) {
    $GLOBALS['title'] = $value;
//    return 
}

function getTitle() {
    return $GLOBALS['title'];
}

$var_log = true;

function setLog($value) {
    $GLOBALS['var_log'] = $value;
}

/**
 * (PHP 4, PHP 5+)<br/>
 * Management Language from Framework in path FILE_PATH('resources/lang/<id>|<en>/<file_language>.<get_array_key>')
 * <br/>
 * @example : lang('general.name') result = 'Name' in en language
 * Licensed by Tripoin Team
 * @link http://www.tripoin.co.id/
 * @param String $lang [optional] <p>
 * get text language from FILE_PATH('resources/lang/<id>|<en>/<file_language>.<get_array_key>').
 * </p>

 * @return String A formatted version of <i>$result</i>.
 */
function lang($lang) {
    $explode = explode('.', $lang);
    $path = $explode[0];
    $language = LANGUAGE_DEFAULT;
//    $language = '';
    if (isset($_SESSION[LANGUAGE_SESSION])) {
        $language = $_SESSION[LANGUAGE_SESSION];
    } else {
        $language = getSystemParameter('GENERAL_LANGUAGE_DEFAULT');
        if ($language == '') {
            $language = LANGUAGE_DEFAULT;
        }
    }

//    echo '';

    $langs = require FILE_PATH('resources/lang/' . $language . '/' . $path . '.php');
    if (isset($langs[$explode[1]])) {
        $result = $langs[$explode[1]];
    } else {
        $result = $lang;
    }
//    echo $_GET['lang'];
//    echo $langs[$lang[1]];
    return $result;
}

function getFunctionAssign($db, $sfa, $column, $find) {
    $db->select(
            $sfa->getEntity(), $sfa->getFunction()->getEntity() . ".*", array($sfa->getFunction()->getEntity(), $sfa->getGroup()->getEntity()), $sfa->getFunction()->getEntity() . DOT . $sfa->getFunction()->getId() . EQUAL . $sfa->getEntity() . DOT . $sfa->getFunction()->getId()
            . " AND " . $sfa->getGroup()->getEntity() . DOT . $sfa->getGroup()->getId() . EQUAL . $sfa->getEntity() . DOT . $sfa->getGroup()->getId()
            . " AND " . $sfa->getEntity() . DOT . $sfa->getStatus() . EQUAL . "1"
            . " AND " . $sfa->getEntity() . DOT . $sfa->getGroup()->getId() . EQUAL . "1"
            . " AND " . $sfa->getFunction()->getEntity() . DOT . $column . EQUAL . "'" . $find . "'"
            . " AND " . $sfa->getGroup()->getEntity() . DOT . $sfa->getGroup()->getId() . EQUAL . "1", $sfa->getFunctionAssignmentOrder() . ' ASC'
    );
    $function_parent = $db->getResult();
//    print_r($function_parent);
    return $function_parent;
}

function getPost($db, $sfa, $column, $find) {
    $db->select(
            $sfa->getEntity(), $sfa->getFunction()->getEntity() . ".*", array($sfa->getFunction()->getEntity(), $sfa->getGroup()->getEntity()), $sfa->getFunction()->getEntity() . DOT . $sfa->getFunction()->getId() . EQUAL . $sfa->getEntity() . DOT . $sfa->getFunction()->getId()
            . " AND " . $sfa->getGroup()->getEntity() . DOT . $sfa->getGroup()->getId() . EQUAL . $sfa->getEntity() . DOT . $sfa->getGroup()->getId()
            . " AND " . $sfa->getEntity() . DOT . $sfa->getStatus() . EQUAL . "1"
            . " AND " . $sfa->getEntity() . DOT . $sfa->getGroup()->getId() . EQUAL . "1"
            . " AND " . $sfa->getFunction()->getEntity() . DOT . $column . EQUAL . "'" . $find . "'"
            . " AND " . $sfa->getGroup()->getEntity() . DOT . $sfa->getGroup()->getId() . EQUAL . "1", $sfa->getFunctionAssignmentOrder() . ' ASC'
    );
    $function_parent = $db->getResult();
//    print_r($function_parent);
    return $function_parent;
}

function shareSocMed() {
    $result = '';
    $result .= '<style type="text/css">

            #share-buttons img {
                width: 35px;
                padding: 5px;
                border: 0;
                box-shadow: 0;
                display: inline;
            }

        </style>';
    $result .= '<div id="share-buttons">

            

            <!-- Facebook -->
            <a href="http://www.facebook.com/sharer.php?u=' . FULLURL() . '" target="_blank">
                <img src="' . URL('/assets/img/socmed/facebook.png') . '" alt="Facebook" />
            </a>

            <!-- Google+ -->
            <a href="https://plus.google.com/share?url=' . FULLURL() . '" target="_blank">
                <img src="' . URL('/assets/img/socmed/google.png') . '" alt="Google" />
            </a>

            <!-- LinkedIn -->
            <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=' . FULLURL() . '" target="_blank">
                <img src="' . URL('/assets/img/socmed/linkedin.png') . '" alt="LinkedIn" />
            </a>

            

            <!-- Twitter -->
            <a href="https://twitter.com/share?url=' . FULLURL() . '&amp;text=Simple%20Share%20Buttons&amp;hashtags=simplesharebuttons" target="_blank">
                <img src="' . URL('/assets/img/socmed/twitter.png') . '" alt="Twitter" />
            </a>

            

        </div>';
    return $result;
}

function stringToArray($str) {
    $mstr = explode(",", $str);
    $a = array();
    foreach ($mstr as $nstr) {
        if (!empty($nstr)) {
            $narr = explode("=>", $nstr);
            $narr[0] = str_replace("\x98", "", $narr[0]);
            //   echo $narr[0];
            $ytr[1] = $narr[1];
            $a[$narr[0]] = $ytr[1];
        }
    }
    return $a;
}

function get_string_between($string, $start, $end) {
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0)
        return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

function get_end_string($string, $end) {
    $html = $string;
    $needle = $end;
    $lastPos = 0;
    $positions = array();
    while (($lastPos = strpos($html, $needle, $lastPos)) !== false) {
        $positions[] = $lastPos;
        $lastPos = $lastPos + strlen($needle);
    }
    return $positions;
}

function findArrayByValue($array, $field, $value) {
//    print_r($products);
    $stdClass = new stdClass();
    foreach ($array as $product) {
        if ($product->$field == $value) {

            $stdClass = $product;
        }
    }
    return $stdClass;
//    return false;
}

function findArrayByValueNoStd($products, $field, $value) {
//    print_r($products);
    $stdClass = new stdClass();
    foreach ($products as $product) {
        if ($product[$field] == $value) {

            $stdClass = $product;
        }
    }
    return $stdClass;
//    return false;
}

function setSessionLang() {
    $lang = '';
    if (isset($_POST['lang'])) {
        $_SESSION['lang'] = $_POST['lang'];
        $lang = $_SESSION['lang'];
    }
    if (isset($_SESSION['lang'])) {
        $lang = $_SESSION['lang'];
    } else {
        $lang = LANGUAGE_DEFAULT;
    }
}

function getSessionLang() {
    if (isset($_SESSION['lang'])) {
        return $_SESSION['lang'];
    } else {
        return LANGUAGE_DEFAULT;
    }
}

$activeMenuMember = '';

function setActiveMenuMember($value) {
    $GLOBALS['activeMenuMember'] = $value;
//    return 
}

function getActiveMenuMember() {
    return $GLOBALS['activeMenuMember'];
}

function pageMember($title_breadcrumb = '', $title = '') {
    include_once getTemplatePath('page/content-page.html.php');
    echo '<div id="content" class="container-fluid" style="padding-top: 130px;">
    
</div>';
    include_once FILE_PATH(PAGE_MEMBER_PATH);
    echo '<div class="signup col-md-9"  style="box-shadow: 0px 0px 0px 1px #B7B7B7;text-align: left;margin-top: -100px;">';
    echo '<h1>' . $title . '</h1>';
    echo '<div id="pageMember" style="background:#FFFFFF;">';
}

function endPageMember($page = null) {
    echo '</div>';
    echo '</div>';
    include_once FILE_PATH(END_PAGE_MEMBER_PATH);
    include_once getTemplatePath('page/end-content-page.html.php');
    echo '<script>
    $(function () {

';

    if ($page != null) {
        echo 'ajaxGetPage(\'' . URL($page) . '\', \'pageMember\');';
    }
    echo '});
</script>';
}

function contentPage() {
    ob_start();
//require_once('lol.php');

    require_once getAdminTemplatePath(CONTENT_PAGE_PATH);

    $result = ob_get_clean();
//    echo $result;
    return $result;
}

function insertAuditrail($data) {
    
}

function modalHide() {
    return '<script>$(function(){$(\'.modal\').modal(\'hide\')});</script>';
}

function postAjaxPagination() {
    return '<script>$(function(){postAjaxPagination();});</script>';
}

function toastAlert($type, $title, $message) {
    $result = '';
    if ($type == 'success')
        $result = '<script>$(function(){toastr.success(\'' . $message . '\', \'' . $title . '\'); })</script>';
    else if ($type == 'error')
        $result = '<script>$(function(){toastr.error(\'' . $message . '\', \'' . $title . '\'); })</script>';
    return $result;
}

function endContentPage() {
//    echo 'masuk';
    ob_start();
//    echo 'masuk';file_get_contents

    require_once getAdminTemplatePath(END_CONTENT_PAGE_PATH);
//    $result = '';
//    require_once FILE_PATH('view/template/sticky_script.html.php');
//    require_once FILE_PATH(FOOTER_MODAL);
//    $result .= '';
//    $result .= file_get_contents(FILE_PATH('view/template/footer_copyright.html.php'));
//    $result .= '</body>';
//    echo '<script>$(function(){ alert(\''.$result.'\');});</script>';
    $result = ob_get_clean();

//    echo $result;
    return $result;
}

function LIKE($like) {
    $result = " LIKE '%" . $like . "%' ";
    return $result;
}

function FILE_PATH($path = "") {
//    echo json_encode($_SERVER);
    $str = str_replace("index.php", "", $_SERVER['SCRIPT_FILENAME']);
    $path_str = '';
//    echo $str;
    if (substr($path, 0, 1) != "/") {
        $path_str = "/" . $path;
    } else {
        $path_str = $path;
    }
    return $str . $path_str;
}

function FULLURL($url = '') {
    if ($_SERVER['SERVER_PORT'] == 443)
        $http = 'https';
    else
        $http = 'http';

    if ($url == '') {
        $actual_link = $http . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    } else {
        if (substr($url, 0, 1) != "/") {
//            $url_str = "/" . $url;
            $actual_link = $http . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" . "/" . $url;
        } else {
            $actual_link = $http . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" . $url;
        }
    }


    return $actual_link;
}

function STARTURL($start = null) {
    $replace_url = ltrim(str_replace(URL(), "", FULLURL()), "/");
    $exp_url = explode("/", $replace_url);
//    $end_url = end($exp_url);
//    echo $exp_url[1];
    if ($start == null) {
        $end_url = $exp_url[0];
    } else if ($start == 'url') {
        $end_url = $replace_url;
    } else {
        $end_url = $exp_url[$start];
    }
    return $end_url;
}

function ENDURL($minus = null) {
    $replace_url = ltrim(str_replace(URL(), "", FULLURL()), "/");
    $exp_url = explode("/", $replace_url);
//    $end_url = end($exp_url);
//    echo $exp_url[1];
    if ($minus == null) {
        $end_url = end($exp_url);
    } else {
        $ambil = count($exp_url) - intval($minus) - 1;
        $end_url = $exp_url[$ambil];
    }
    return $end_url;
}

function getURLFeatured($db, $mpf, $val_mn_child) {
//    $result = [];
//    $db->select(
//            $mpf->getFunction()->getEntity(), $mpf->getFunction()->getCode(), array(), $mpf->getFunction()->getId() . EQUAL . "'" . $val_mn_child[0][$mpf->getFunction()->getId()] . "'"
//    );
//    $cek_menu = $db->getResult();
//    
//    if (!empty($cek_menu)) {
//        $result[] = $cek_menu[0][ $mpf->getFunction()->getCode()];

    $db->select(
            $mpf->getFunction()->getEntity(), $mpf->getFunction()->getCode() . ',' . $mpf->getFunction()->getParent(), array(), $mpf->getFunction()->getId() . EQUAL . "'" . $val_mn_child[$mpf->getFunction()->getParent()] . "'"
    );
    $cek_menu_child = $db->getResult();
//    }
    return $cek_menu_child[0];
}

/**
 * (PHP 4, PHP 5+)<br/>
 * Management DEFAULT URL FROM FRAMEWORK V.1 
 * <br/>
 * @example : URL('contoh') => 'http://<SERVER>/<directory>/contoh'
 * <br/>
 * Licensed by Tripoin Team
 * @link http://www.tripoin.co.id/
 * @param String $url [optional] <p>
 * sets join url from url framework.
 * </p>

 * @return String A formatted version of <i>$result</i>.
 */
function URL($url = "") {
    if ($_SERVER['SERVER_PORT'] == 443)
        $http = 'https';
    else
        $http = 'http';
    $strs = $http . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

    $str = str_replace("index.php", "", $strs);
    $str = rtrim($str, '/');
    $query = '';
    if (isset($_GET['lang'])) {
        $language = $_GET['lang'];
        $query = http_build_query(array("lang" => $language));
    }
    if ($url == null) {
        $url_str = '';
    } else {
        if (substr($url, 0, 1) != "/") {
            $url_str = "/" . $url;
        } else {
            $url_str = $url;
        }
    }

    if (substr($url, 0, 7) == "http://") {
        return $url;
    } else if (substr($url, 0, 8) == "https://") {
        return $url;
    } else {
        return $str . $url_str;
    }
}

function URLUPLOAD($url = "") {
    if (substr($url, 0, 7) == "http://") {
        return $url;
    } else if (substr($url, 0, 8) == "https://") {
        return $url;
    } else {
        return URL(DIRECTORY_UPLOAD . $url);
    }
}

function errorHandler() {

    $errfile = "unknown file";
    $errstr = "shutdown";
    $errno = E_CORE_ERROR;
    $errline = 0;
//    echo $errno;
    $error = error_get_last();
//    print_r($error);
    if ($error !== NULL) {
        $message = '';
        $file = '';
        $line = '';
        if ($error['type'] == 2) {
            $message = $error['message'];
            $file = $error['file'];
            $line = $error['line'];
        } else {
            $message = $error['message'];
            $file = $error['file'];
            $line = $error['line'];
        }
//        print_r($error);
//        ob_end_clean();
//        echo 'masuk';
        include FILE_PATH('template/error.php');
        ob_start();
//        o();
//        print_r($error);
//        log_to_file($error);
//        $errno = $error["type"];
//        $errfile = $error["file"];
//        $errline = $error["line"];
//        $errstr = $error["message"];
    }
}

/**
 * (PHP 4, PHP 5+)<br/>
 * Create Logger <Logger Tripoin>
 * <br/>
 * Licensed by Tripoin Team
 * @link http://www.tripoin.co.id/
 * @param String $message [optional]<p>
 * </p>
 * @example LOGGER('test logger');
 * @return string write log in path logs/log.logs
 * @version 1.0
 * @desc Sorry cuk masih belajar
 */
function LOGGER($message = '') {
    $file_url = "logs/log.logs";
    $txt = '[' . date(DATE_FORMAT_PHP_DEFAULT) . '] : ';
    if (is_array($message)) {
//        $txt .= "Array(" . implode(",", $message) . ")";
        $txt .= json_encode($message);
    } else {
        $txt .= json_encode($message);
    }
    file_put_contents(FILE_PATH($file_url), $txt . PHP_EOL, FILE_APPEND | LOCK_EX);
}

function log_to_file($response) {

    $date_now = date('Y-m-d');
//    $file_url = "logs/log-ui-" . $date_now . ".logs";
    $file_url = "logs/log.logs";
    $str = str_replace("index.php", "", $_SERVER['SCRIPT_FILENAME']);

    $txt = 'Date : ' . date(DATE_FORMAT_PHP_DEFAULT) . "\n";
    $txt .= 'URL : ' . $_SERVER['REQUEST_URI'] . "\n";
    $txt .= 'METHOD : ' . $_SERVER['REQUEST_METHOD'] . "\n";
    $txt .= 'BODY : ' . json_encode($_POST) . "\n";
    $txt .= 'Response : '
            . 'Message : ' . $response['message'] . "\n"
            . 'file : ' . $response['file'] . "\n"
            . 'line : ' . $response['line'] . "\n";
    $txt .= "\n" . "\n";

//   echo json_encode($_SERVER);
//    file_put_contents($str . $file_url, $txt . PHP_EOL, FILE_APPEND | LOCK_EX);
//    print_r(error_get_last());
}

function the_autoloader($classname) {
    $filename = str_replace('\\', '/', $classname) . '.php';
    require_once $filename;
}

function breadCrumbV2($breadcrumb = array()) {
    $result = '';
    $result .= '
            <div class="col-md-offset-3 col-lg-offset-3 col-sm-24 col-md-13 col-lg-13">
                <ul class="breadcrumb" id="breadcrumb-ul">';
    $result .= '<li><a href="' . URL() . '">Home</a></li>';
    foreach ($breadcrumb as $key => $value) {
        $result .= '<li><a href="' . $key . '">' . $value . '</a></li>';
    }


    $result .= '</ul>
            </div>
        ';
    return $result;
}

function breadCrumb() {
    $breadcrumb = $GLOBALS['breadcrumb_global'];
//    print_r($breadcrumb);
    $result = '<ul class="page-breadcrumb">';
    $result .= '<li><a href="' . URL('') . '">Home</a>';
    if (!empty($breadcrumb)) {
        $result .= '<i class="fa fa-circle"></i>';
    }
    $result .= '</li>';
    $count_breadcrumb = count($breadcrumb);
    if (!empty($breadcrumb)) {
        $no = 0;
        foreach ($breadcrumb as $key => $value) {
            $no += 1;
            $result .= '<li>';
            if ($value == "") {
                $result .= '<span>' . $key . '</span>';
            } else {
                $result .= '<a href="' . $value . '">' . $key . '</a>';
            }
            if ($count_breadcrumb == $no) {
                
            } else {
                $result .= '<i class="fa fa-circle"></i>';
            }
            $result .= '</li>';
        }
    }
    $result .= '</ul>';
    return $result;
}

/**
 * (PHP 4, PHP 5+)<br/>
 * Convert Amount to Format Money
 * <br/>
 * Licensed by Tripoin Team
 * @link http://www.tripoin.co.id/
 * @param String $amount [optional]<p>
 * </p>
 * @example strToAmount('1000000');
 * @return String =>  1000000 be 1,000,000
 * @version 1.0
 * @desc Sorry cuk masih belajar
 */
function amountToStr($amount) {
    return ($amount == "-") ? $amount : number_format($amount, 0, ".", ",");
}

/**
 * (PHP 4, PHP 5+)<br/>
 * Convert String Amount to Amount
 * <br/>
 * Licensed by Tripoin Team
 * @link http://www.tripoin.co.id/
 * @param String $amount [optional]<p>
 * </p>
 * @example strToAmount('1,000,000');
 * @return Double => 1,000,000 be 1000000
 * @version 1.0
 * @desc Sorry cuk masih belajar
 */
function strToAmount($amount) {
    $uang = explode(',', $amount);
    for ($i = 0; $i < count($uang); $i++) {
        $money .= $uang[$i];
    }
    return $money;
}

function removeElementWithValue($array, $key, $value) {
    foreach ($array as $subKey => $subArray) {
        if ($subArray[$key] == $value) {
            unset($array[$subKey]);
        }
    }
    return $array;
}

function changeElementWithValue($array, $key, $value, $change, $changevalue) {
    foreach ($array as $subKey => $subArray) {
        if ($subArray[$key] == $value) {
//            print_r($array[$change]);
            $array[$subKey][$change] = $changevalue;
//            $array
//            unset($array[$subKey]);
        }
    }
//    session_unset($_SESSION['bucket']);
//    $_SESSION['bucket'] = $array;
    return $array;
}

function arrayMenuUser() {
    $array_menu = array(
        array("url" => URL('/page/user/change-order'), "url_id" => "change-order", "url_icon" => "assignment", "url_name" => lang('general.change_order')),
        array("url" => URL('/page/user/change-user'), "url_id" => "change-user", "url_icon" => "account_circle", "url_name" => lang('general.change_profile')),
        array("url" => URL('/page/user/change-password'), "url_id" => "change-password", "url_icon" => "lock_outline", "url_name" => lang('general.change_password')),
        array("url" => URL('/page/user/logout'), "url_id" => "signout", "url_icon" => "keyboard_tab", "url_name" => lang('general.sign_out'))
    );
    return $array_menu;
}

function getMenuUser($active) {
    $array_menu = arrayMenuUser();
    $result = '';
    $result .= '<div class="card card-profile" id="wizardProfile">
                    <div class="card-avatar">
                        <a href="#pablo">
                            <img class="img" src=""  onerror="this.src=\'' . URL('/assets/img/default_profile.jpg') . '\'">
                        </a>
                    </div>
                    <div class="content">
                        <h4 class="card-title">' . $_SESSION['username'] . '</h4>
                        
                    </div>
                    <ul class="menu-vertical">';
    $result .= getListUser($array_menu, $active);
    $result .= '</ul>
                </div>';

    return $result;
}

function getListUser($array_menu, $active) {
    foreach ($array_menu as $value) {
        if ($active == $value['url_id']) {
            $result .= '<li><a href="' . $value['url'] . '" class="active"><i class="material-icons">' . $value['url_icon'] . '</i> ' . $value['url_name'] . '</a></li>';
        } else {
            $result .= '<li><a href="' . $value['url'] . '"><i class="material-icons">' . $value['url_icon'] . '</i> ' . $value['url_name'] . '</a></li>';
        }
    }
    return $result;
}

function formLayoutHead($title) {
    $result = '';
    $result .= '<div class="row" style="">
    <div class="col-sm-10 col-sm-offset-1" style="margin-top: 20px;">
        <div class="col-sm-12">
            <div class="card card-contact card-raised" id="wizardProfile">
                <div class="header header-raised header-danger text-center">
                    <h4 class="card-title">' . $title . '</h4>
                </div>';
    return $result;
}

function formLayoutFooter() {
    $result = '';
    $result .= '</div>
        </div>
    </div>
</div>';
    return $result;
}

function panelLayoutHead($title) {
    $result = '';
    $result .= '<div class="panel panel-default">
    <div class="panel-heading" style="font-weight: bold;">' . $title . '</div>
    <div class="panel-body" style="margin-left:-15px;">';
    return $result;
}

function panelLayoutFooter() {
    $result = '';
    $result .= '</div></div>';
    return $result;
}

function dayString($value) {
    $string = '';
    if ($value == 1) {
        $string = "Senin";
    } else if ($value == 2) {
        $string = "Selasa";
    } else if ($value == 3) {
        $string = "Rabu";
    } else if ($value == 4) {
        $string = "Kamis";
    } else if ($value == 5) {
        $string = "Jumat";
    } else if ($value == 6) {
        $string = "Sabtu";
    } else if ($value == 7) {
        $string = "Minggu";
    }

    return $string;
}

function fullDateString($tgl) {
    $date = subMonth($tgl);

    $day = dayString(date("N", strtotime($tgl)));

    return $day . ", " . $date;
}

/**
 * (PHP 4, PHP 5+)<br/>
 * Convert Date Y-m-d
 * <br/>
 * Licensed by Tripoin Team
 * @link http://www.tripoin.co.id/
 * @param String $tgl [optional]<p>
 * </p>
 * @example ;
 * @return Date String
 * @version 1.0
 * @desc Sorry cuk masih belajar
 */
function subMonth($tgl) {
//    $date = substr($tgl, 8, 9);
//    $month = getMonth(substr($tgl, 5, 6));
//    $year = substr($tgl, 0, 4);
//    return $date . ' ' . $month . ' ' . $year;
    $date = date("d", strtotime($tgl));
    $month = getMonth(date("m", strtotime($tgl)));
    $year = date("Y", strtotime($tgl));
    return $date . ' ' . $month . ' ' . $year;
}

function subMonthDay($tgl) {
    $day = date("N", strtotime($tgl));
    $date = date("d", strtotime($tgl));
    $month = getMonth(date("m", strtotime($tgl)));
    $year = date("Y", strtotime($tgl));
    return $day . ' ' . $date . ' ' . $month . ' ' . $year;
}

function subTimeOnly($tgl) {
    $hours = date("H", strtotime($tgl));
    $minute = date("i", strtotime($tgl));
    //$second = date("s", strtotime($tgl));
    return $hours . ':' . $minute;
}

function selectMonth($month) {
    $bln = getMonth($month);
    return $bln;
}

/**
 * (PHP 4, PHP 5+)<br/>
 * Get String Month 
 * <br/>
 * Licensed by Tripoin Team
 * @link http://www.tripoin.co.id/
 * @param String $bln [optional]<p>
 * </p>
 * @example ;
 * @return String Month => 1 be Januari
 * @version 1.0
 * @desc Sorry cuk masih belajar
 */
function getMonth($bln) {
    switch ($bln) {
        case 1:
            return "Januari";
            break;
        case 2:
            return "Februari";
            break;
        case 3:
            return "Maret";
            break;
        case 4:
            return "April";
            break;
        case 5:
            return "Mei";
            break;
        case 6:
            return "Juni";
            break;
        case 7:
            return "Juli";
            break;
        case 8:
            return "Agustus";
            break;
        case 9:
            return "September";
            break;
        case 10:
            return "Oktober";
            break;
        case 11:
            return "November";
            break;
        case 12:
            return "Desember";
            break;
    }
}

/**
 * (PHP 4, PHP 5+)<br/>
 * Create Random Code 8 length
 * <br/>
 * Licensed by Tripoin Team
 * @link http://www.tripoin.co.id/
 * @param noparam<p>
 * </p>
 * @example createRandomBooking();
 * @return String
 * @version 1.0
 * @desc Sorry cuk masih belajar
 */
function createRandomBooking() {

    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
    srand((double) microtime() * 1000000);
    $i = 0;
    $pass = '';

    while ($i <= 7) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }

    return strtoupper($pass);
}

function readMore($value, $url = '') {
    $string = strip_tags($value);
    if (strlen($string) > 200) {
        $stringCut = substr($string, 0, 200);
        $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '... ';
    }
    if (isset($_SESSION[SESSION_EMAIL]) && isset($_SESSION[SESSION_USERNAME]) && isset($_SESSION[SESSION_GROUP])) {
//        $string .= '<a href="' . $_SERVER['HTTP_REFERER'] . '/' . $url . '">Read More</a>';
    } else {
//        $string .= '<a href="javascript:void(0)" onclick="ajaxPostModal(\'' . URL('/page/login') . '\', \'' . lang('general.title_sign_modal') . '\')">Read More</a>';
    }
    $string .= '<a href="' . $url . '"  class="text_uppercase more_read mg0" >Read More</a>';
    return $string;
}

function leftContentRightImg($value, $model, $category) {
    $string = '';
    if (isset($_SESSION[SESSION_EMAIL]) && isset($_SESSION[SESSION_USERNAME]) && isset($_SESSION[SESSION_GROUP])) {
        $string .= '<a href="' . $_SERVER['HTTP_REFERER'] . '/' . $value[$model->getPost()->getCode()] . '">' . $value[$model->getPost()->getTitle()] . '</a>';
    } else {
        $string .= '<a href="javascript:void(0)" onclick="ajaxPostModal(\'' . URL('/page/login') . '\', \'' . lang('general.title_sign_modal') . '\')">' . $value[$model->getPost()->getTitle()] . '</a>';
    }
    $result = '';
    $result = '<div class="row posts_item">
                <div class="col-md-offset-3 col-md-9 col-sm-12 col-xs-24 zeropad posts_text">
                    <label>
                        <span class="posts_category">' . $category . '</span>  / 
                        <span class="posts_date">' . fullDateString($value[$model->getPost()->getPublishOn()]) . '</span>
                    </label>
                    <h1>' . $string . '</h1>
                    <p>' . html_entity_decode(readMore($value[$model->getPost()->getContent()], $value[$model->getPost()->getCode()])) . '</p>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-24 zeropad posts_thumb_container">
                    <img ' . notFoundImg() . ' data-src="holder.js/800x400/auto/^8b2281:^fff/size:20/text: " class="img-responsive" alt="  [800x400]" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iODAwIiBoZWlnaHQ9IjQwMCIgdmlld0JveD0iMCAwIDgwMCA0MDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzgwMHg0MDAvYXV0by9eOGIyMjgxOl5mZmYvc2l6ZToyMC90ZXh0OiAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNThhZWNmNGMxOCB0ZXh0IHsgZmlsbDojZmZmO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjQwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1OGFlY2Y0YzE4Ij48cmVjdCB3aWR0aD0iODAwIiBoZWlnaHQ9IjQwMCIgZmlsbD0iIzhiMjI4MSIvPjxnPjx0ZXh0IHg9IjQwMCIgeT0iMjAwIj4gPC90ZXh0PjwvZz48L2c+PC9zdmc+" data-holder-rendered="true">
                    <img ' . notFoundImg() . ' src="' . URL('/contents/images/post/' . $value[$model->getPost()->getThumbnail()]) . '" class="posts_thumb img-responsive">
                </div>
            </div>';
    return $result;
}

function notFoundImg($src = null) {
    if ($src == null) {
        $result = 'onerror="this.src=\'' . URL('/assets/img/no-photo.png') . '\';"';
    } else {
        $result = 'onerror="this.src=\'' . URL('/assets/img/' . $src) . '\';"';
    }

    return $result;
}

function rightContentLeftImg($value, $model, $category) {
    $string = '';
    if (isset($_SESSION[SESSION_EMAIL]) && isset($_SESSION[SESSION_USERNAME]) && isset($_SESSION[SESSION_GROUP])) {
        $string .= '<a href="' . $_SERVER['HTTP_REFERER'] . '/' . $value[$model->getPost()->getCode()] . '">' . $value[$model->getPost()->getTitle()] . '</a>';
    } else {
        $string .= '<a href="javascript:void(0)" onclick="ajaxPostModal(\'' . URL('/page/login') . '\', \'' . lang('general.title_sign_modal') . '\')">' . $value[$model->getPost()->getTitle()] . '</a>';
    }
    $result = '';
    $result = '<div class="row posts_item">
                <div class="col-md-12 col-sm-12 col-xs-24 zeropad posts_thumb_container">
                    <img ' . notFoundImg() . ' data-src="holder.js/800x400/auto/^8b2281:^fff/size:20/text: " class="img-responsive" alt="  [800x400]" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iODAwIiBoZWlnaHQ9IjQwMCIgdmlld0JveD0iMCAwIDgwMCA0MDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzgwMHg0MDAvYXV0by9eOGIyMjgxOl5mZmYvc2l6ZToyMC90ZXh0OiAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNThhZWNmNGMxOCB0ZXh0IHsgZmlsbDojZmZmO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjQwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1OGFlY2Y0YzE4Ij48cmVjdCB3aWR0aD0iODAwIiBoZWlnaHQ9IjQwMCIgZmlsbD0iIzhiMjI4MSIvPjxnPjx0ZXh0IHg9IjQwMCIgeT0iMjAwIj4gPC90ZXh0PjwvZz48L2c+PC9zdmc+" data-holder-rendered="true">
                    <img ' . notFoundImg() . ' src="' . URL('/contents/images/post/' . $value[$model->getPost()->getThumbnail()]) . '" class="posts_thumb img-responsive">
                </div>
                <div class="col-md-offset-3 col-md-9 col-sm-12 col-xs-24 zeropad posts_text">
                    <label>
                        <span class="posts_category">' . $category . '</span>  / 
                        <span class="posts_date">' . fullDateString($value[$model->getPost()->getPublishOn()]) . ' </span>
                    </label>
                    <h1>' . $string . '</h1>
                    <p>' . html_entity_decode(readMore($value[$model->getPost()->getContent()], $value[$model->getPost()->getCode()])) . '</p>
                </div>
                
            </div>';
    return $result;
}

function getClientIp() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function FunctionLanguageName($value) {
    $function = new SecurityFunctionLanguage();
    $language = new MasterLanguage();
    if (isset($_SESSION[LANGUAGE_SESSION])) {

        $db = new Database();
        $db->connect();

        $rs_language = $db->selectByID($language, $language->getCode() . EQUAL . "'" . $_SESSION[LANGUAGE_SESSION] . "'");

        $db->select(
                $function->getEntity(), $function->getName(), array(), $function->getFunctionId() . EQUAL . "'" . $value[$function->getId()] . "'"
                . " AND " . $function->getLanguageId() . EQUAL . "'" . $rs_language[0][$language->getId()] . "'"
        );
        $cek_language = $db->getResult();
//    echo $_SESSION[LANGUAGE_SESSION]."";
        if (!empty($cek_language)) {
            return $cek_language[0][$function->getName()];
        } else {
            return $value[$function->getName()];
        }
    } else {
        return $value[$function->getName()];
    }
}

function formatSizeUnits($bytes) {
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' kB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}

function dateMili($format) {
    $micro_date = microtime();
    $date_array = explode(" ", $micro_date);
    $date = date($format, $date_array[1]);
    return $date . ':' . $date_array[0];
//echo "Date: $date:" . $date_array[0]."<br>";
}

function sort_by_date($a, $b) {
    $a = strtotime($a->last_date);
    $b = strtotime($b->last_date);
    return ($a < $b) ? -1 : 1;
}

/**
 * (PHP 4, PHP 5+)<br/>
 * Function Upload Image
 * <br/>
 * Licensed by Tripoin Team
 * @link http://www.tripoin.co.id/
 * @param String $files [optional]<p>
 * Files
 * </p>
 * @param String $path [optional]<p>
 * Path Name
 * </p>
 * @param String $file_names [optional]<p>
 * Files Name
 * </p>
 * @example ;
 * @return String Message Error Code
 * @version 1.0
 * @desc Sorry cuk masih belajar
 */
function uploadImage($files, $path, $file_names) {
    if (!file_exists(FILE_PATH($path))) {
        mkdir(FILE_PATH($path));
    }
    if ($files['error'][0] == 0) {
        $validextensions = array("jpeg", "jpg", "png");
        $temporary = explode(".", $files["name"][0]);
        $file_extension = end($temporary);
        $file_nm = str_replace(' ', '-', $file_names);
        $file_name = $file_nm . "." . $file_extension;
        $file_path_name = $path . $file_name;
        if ((($files["type"] == "image/png") || ($files["type"] == "image/jpg") || ($files["type"] == "image/jpeg")
                ) && in_array($file_extension, $validextensions)) {
            return '0,' . lang('message.054') . $files["type"][0];
        } else if ($files["size"][0] > 2097152) {
            return '0,' . lang('message.051') . $files["type"];
        } else {
            if (file_exists($file_name)) {
                $sourcePath = $files['tmp_name'][0];
                move_uploaded_file($sourcePath, $file_path_name);
            } else {
                $sourcePath = $files['tmp_name'][0];
                move_uploaded_file($sourcePath, $file_path_name);
            }
            return '1,' . $file_name;
//                print_r($r_upload);
        }
    } else {
        if ($files['error'][0] == 4) {
            return '0,' . lang('message.053');
        } else {
            $image_size = getimagesize($files['tmp_name'][0]);
            if ($image_size == false) {
                return '0,' . lang('message.051');
            }
        }
//            
    }
}

function resultPageMsg($type, $title, $message) {

    $txt = '<div class="alert alert-' . $type . '" style="text-align:center;">
    <strong>' . $title . ':</strong><br/> ' . $message . '
</div>';
    return $txt;
}

function getSystemParameter($code) {
    $db = new Database();
    $option = new MasterSystemParameter();
    $rs_option = $db->selectByID($option, $option->getCode() . "='" . $code . "'");
    if (empty($rs_option)) {
//        return "Not Found";
        return "";
    } else {
        return $rs_option[0][$option->getName()];
    }
}

function getIdLanguageByCode($code) {
    $db = new Database();
    $language = new MasterLanguage();
    $rs_lang = $db->selectByID($language, $language->getCode() . "='" . $code . "'");
    if (empty($rs_lang)) {
        return "Not Found";
    } else {
        return $rs_lang[0][$language->getId()];
    }
}

function getTemplateURL($url) {
    $themeName = TEMPLATE_DEFAULT;
    if (getSystemParameter("GENERAL_TEMPLATE_THEME") != "") {
        $themeName = getSystemParameter("GENERAL_TEMPLATE_THEME");
    }

    if (substr($url, 0, 1) != "/") {
        $path = URL("/template/" . $themeName) . "/" . $url;
    } else {
        $path = URL("/template/" . $themeName) . $url;
    }

    if (substr($url, 0, 7) == "http://") {
        return $url;
    } else if (substr($url, 0, 8) == "https://") {
        return $url;
    } else {
        return $path;
    }


//    return $path;
}

function checkStatusLogin() {
    if (isset($_SESSION[SESSION_USERNAME_GUEST]) && isset($_SESSION[SESSION_GROUP_GUEST])) {
        return true;
    } else {
        return false;
    }
}

function getTemplatePath($path) {
    $themeName = TEMPLATE_DEFAULT;
    if (getSystemParameter("GENERAL_TEMPLATE_THEME") != "") {
        $themeName = getSystemParameter("GENERAL_TEMPLATE_THEME");
    }
    if (substr($path, 0, 1) != "/") {
        $paths = FILE_PATH("/template/" . $themeName) . "/" . $path;
    } else {
        $paths = FILE_PATH("/template/" . $themeName) . $path;
    }
//    FILE_PATH(getTemplatePath());
    return $paths;
}

function getAdminTemplateURL($url) {
    $themeName = TEMPLATE_ADMIN_DEFAULT;
    if (getSystemParameter("SYSTEM_ADMINISTRATOR_THEME") != "") {
        $themeName = getSystemParameter("SYSTEM_ADMINISTRATOR_THEME");
    }

    if (substr($url, 0, 1) != "/") {
        $path = URL("/view/template/" . $themeName) . "/" . $url;
    } else {
        $path = URL("/view/template/" . $themeName) . $url;
    }


    return $path;
}

function getAdminTemplatePath($path) {
    $themeName = TEMPLATE_ADMIN_DEFAULT;
    if (getSystemParameter("SYSTEM_ADMINISTRATOR_THEME") != "") {
        $themeName = getSystemParameter("SYSTEM_ADMINISTRATOR_THEME");
    }
    if (substr($path, 0, 1) != "/") {
        $paths = FILE_PATH("/view/template/" . $themeName) . "/" . $path;
    } else {
        $paths = FILE_PATH("/view/template/" . $themeName) . $path;
    }
//    FILE_PATH(getTemplatePath());
    return $paths;
}

function STYLE($path = "") {
//    $str = str_replace("index.php", "", $_SERVER['SCRIPT_FILENAME']);
    $result = '<link href="' . URL($path) . '"  rel="stylesheet"></script>';
    return $result;
}

function get_file_mime_type($filename, $debug = false) {
    echo $filename;
    echo readfile_if_modified($filename);
    if (function_exists('finfo_open') && function_exists('finfo_file') && function_exists('finfo_close')) {
        $fileinfo = finfo_open(FILEINFO_MIME);
        if (readfile_if_modified($filename) == "404") {
            return "application/octet-stream";
        } else if (readfile_if_modified($filename) == "403") {
            return "application/octet-stream";
        } else {
            $mime_type = finfo_file($fileinfo, $filename);
        }
        finfo_close($fileinfo);

        if (!empty($mime_type)) {
            if (true === $debug)
                return array('mime_type' => $mime_type, 'method' => 'fileinfo');
            return $mime_type;
        }
    }
    if (function_exists('mime_content_type')) {
//        echo readfile_if_modified($filename);
        if (readfile_if_modified($filename) == "404") {
            return "application/octet-stream";
        } else if (readfile_if_modified($filename) == "403") {
            return "application/octet-stream";
        } else {
            $mime_type = mime_content_type($filename);

            if (!empty($mime_type)) {
                if (true === $debug)
                    return array('mime_type' => $mime_type, 'method' => 'mime_content_type');
                return $mime_type;
            }
        }
    }

    $mime_types = array(
        'ai' => 'application/postscript',
        'aif' => 'audio/x-aiff',
        'aifc' => 'audio/x-aiff',
        'aiff' => 'audio/x-aiff',
        'asc' => 'text/plain',
        'asf' => 'video/x-ms-asf',
        'asx' => 'video/x-ms-asf',
        'au' => 'audio/basic',
        'avi' => 'video/x-msvideo',
        'bcpio' => 'application/x-bcpio',
        'bin' => 'application/octet-stream',
        'bmp' => 'image/bmp',
        'bz2' => 'application/x-bzip2',
        'cdf' => 'application/x-netcdf',
        'chrt' => 'application/x-kchart',
        'class' => 'application/octet-stream',
        'cpio' => 'application/x-cpio',
        'cpt' => 'application/mac-compactpro',
        'csh' => 'application/x-csh',
        'css' => 'text/css',
        'dcr' => 'application/x-director',
        'dir' => 'application/x-director',
        'djv' => 'image/vnd.djvu',
        'djvu' => 'image/vnd.djvu',
        'dll' => 'application/octet-stream',
        'dms' => 'application/octet-stream',
        'doc' => 'application/msword',
        'dvi' => 'application/x-dvi',
        'dxr' => 'application/x-director',
        'eps' => 'application/postscript',
        'etx' => 'text/x-setext',
        'exe' => 'application/octet-stream',
        'ez' => 'application/andrew-inset',
        'flv' => 'video/x-flv',
        'gif' => 'image/gif',
        'gtar' => 'application/x-gtar',
        'gz' => 'application/x-gzip',
        'hdf' => 'application/x-hdf',
        'hqx' => 'application/mac-binhex40',
        'htm' => 'text/html',
        'html' => 'text/html',
        'ice' => 'x-conference/x-cooltalk',
        'ief' => 'image/ief',
        'iges' => 'model/iges',
        'igs' => 'model/iges',
        'img' => 'application/octet-stream',
        'iso' => 'application/octet-stream',
        'jad' => 'text/vnd.sun.j2me.app-descriptor',
        'jar' => 'application/x-java-archive',
        'jnlp' => 'application/x-java-jnlp-file',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'js' => 'application/x-javascript',
        'kar' => 'audio/midi',
        'kil' => 'application/x-killustrator',
        'kpr' => 'application/x-kpresenter',
        'kpt' => 'application/x-kpresenter',
        'ksp' => 'application/x-kspread',
        'kwd' => 'application/x-kword',
        'kwt' => 'application/x-kword',
        'latex' => 'application/x-latex',
        'lha' => 'application/octet-stream',
        'lzh' => 'application/octet-stream',
        'm3u' => 'audio/x-mpegurl',
        'man' => 'application/x-troff-man',
        'me' => 'application/x-troff-me',
        'mesh' => 'model/mesh',
        'mid' => 'audio/midi',
        'midi' => 'audio/midi',
        'mif' => 'application/vnd.mif',
        'mov' => 'video/quicktime',
        'movie' => 'video/x-sgi-movie',
        'mp2' => 'audio/mpeg',
        'mp3' => 'audio/mpeg',
        'mpe' => 'video/mpeg',
        'mpeg' => 'video/mpeg',
        'mpg' => 'video/mpeg',
        'mpga' => 'audio/mpeg',
        'ms' => 'application/x-troff-ms',
        'msh' => 'model/mesh',
        'mxu' => 'video/vnd.mpegurl',
        'nc' => 'application/x-netcdf',
        'odb' => 'application/vnd.oasis.opendocument.database',
        'odc' => 'application/vnd.oasis.opendocument.chart',
        'odf' => 'application/vnd.oasis.opendocument.formula',
        'odg' => 'application/vnd.oasis.opendocument.graphics',
        'odi' => 'application/vnd.oasis.opendocument.image',
        'odm' => 'application/vnd.oasis.opendocument.text-master',
        'odp' => 'application/vnd.oasis.opendocument.presentation',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ogg' => 'application/ogg',
        'otg' => 'application/vnd.oasis.opendocument.graphics-template',
        'oth' => 'application/vnd.oasis.opendocument.text-web',
        'otp' => 'application/vnd.oasis.opendocument.presentation-template',
        'ots' => 'application/vnd.oasis.opendocument.spreadsheet-template',
        'ott' => 'application/vnd.oasis.opendocument.text-template',
        'pbm' => 'image/x-portable-bitmap',
        'pdb' => 'chemical/x-pdb',
        'pdf' => 'application/pdf',
        'pgm' => 'image/x-portable-graymap',
        'pgn' => 'application/x-chess-pgn',
        'png' => 'image/png',
        'pnm' => 'image/x-portable-anymap',
        'ppm' => 'image/x-portable-pixmap',
        'ppt' => 'application/vnd.ms-powerpoint',
        'ps' => 'application/postscript',
        'qt' => 'video/quicktime',
        'ra' => 'audio/x-realaudio',
        'ram' => 'audio/x-pn-realaudio',
        'ras' => 'image/x-cmu-raster',
        'rgb' => 'image/x-rgb',
        'rm' => 'audio/x-pn-realaudio',
        'roff' => 'application/x-troff',
        'rpm' => 'application/x-rpm',
        'rtf' => 'text/rtf',
        'rtx' => 'text/richtext',
        'sgm' => 'text/sgml',
        'sgml' => 'text/sgml',
        'sh' => 'application/x-sh',
        'shar' => 'application/x-shar',
        'silo' => 'model/mesh',
        'sis' => 'application/vnd.symbian.install',
        'sit' => 'application/x-stuffit',
        'skd' => 'application/x-koan',
        'skm' => 'application/x-koan',
        'skp' => 'application/x-koan',
        'skt' => 'application/x-koan',
        'smi' => 'application/smil',
        'smil' => 'application/smil',
        'snd' => 'audio/basic',
        'so' => 'application/octet-stream',
        'spl' => 'application/x-futuresplash',
        'src' => 'application/x-wais-source',
        'stc' => 'application/vnd.sun.xml.calc.template',
        'std' => 'application/vnd.sun.xml.draw.template',
        'sti' => 'application/vnd.sun.xml.impress.template',
        'stw' => 'application/vnd.sun.xml.writer.template',
        'sv4cpio' => 'application/x-sv4cpio',
        'sv4crc' => 'application/x-sv4crc',
        'swf' => 'application/x-shockwave-flash',
        'sxc' => 'application/vnd.sun.xml.calc',
        'sxd' => 'application/vnd.sun.xml.draw',
        'sxg' => 'application/vnd.sun.xml.writer.global',
        'sxi' => 'application/vnd.sun.xml.impress',
        'sxm' => 'application/vnd.sun.xml.math',
        'sxw' => 'application/vnd.sun.xml.writer',
        't' => 'application/x-troff',
        'tar' => 'application/x-tar',
        'tcl' => 'application/x-tcl',
        'tex' => 'application/x-tex',
        'texi' => 'application/x-texinfo',
        'texinfo' => 'application/x-texinfo',
        'tgz' => 'application/x-gzip',
        'tif' => 'image/tiff',
        'tiff' => 'image/tiff',
        'torrent' => 'application/x-bittorrent',
        'tr' => 'application/x-troff',
        'tsv' => 'text/tab-separated-values',
        'txt' => 'text/plain',
        'ustar' => 'application/x-ustar',
        'vcd' => 'application/x-cdlink',
        'vrml' => 'model/vrml',
        'wav' => 'audio/x-wav',
        'wax' => 'audio/x-ms-wax',
        'wbmp' => 'image/vnd.wap.wbmp',
        'wbxml' => 'application/vnd.wap.wbxml',
        'wm' => 'video/x-ms-wm',
        'wma' => 'audio/x-ms-wma',
        'wml' => 'text/vnd.wap.wml',
        'wmlc' => 'application/vnd.wap.wmlc',
        'wmls' => 'text/vnd.wap.wmlscript',
        'wmlsc' => 'application/vnd.wap.wmlscriptc',
        'wmv' => 'video/x-ms-wmv',
        'wmx' => 'video/x-ms-wmx',
        'wrl' => 'model/vrml',
        'wvx' => 'video/x-ms-wvx',
        'xbm' => 'image/x-xbitmap',
        'xht' => 'application/xhtml+xml',
        'xhtml' => 'application/xhtml+xml',
        'xls' => 'application/vnd.ms-excel',
        'xml' => 'text/xml',
        'xpm' => 'image/x-xpixmap',
        'xsl' => 'text/xml',
        'xwd' => 'image/x-xwindowdump',
        'xyz' => 'chemical/x-xyz',
        'zip' => 'application/zip'
    );
    $explode = explode('.', $filename);
    $ext = strtolower(array_pop($explode));

//    print_r($ext);
    if (!empty($mime_types[$ext])) {
        if (true === $debug)
            return array('mime_type' => $mime_types[$ext], 'method' => 'from_array');
        return $mime_types[$ext];
    }

    if (true === $debug)
        return array('mime_type' => 'application/octet-stream', 'method' => 'last_resort');
    return 'application/octet-stream';
}

function url_exists($url) {
    if (!$fp = curl_init($url))
        return false;
    return true;
}

function readfile_if_modified($filename, $http_header_additionals = array()) {

    if (!is_file($filename)) {
//      header('HTTP/1.0 404 Not Found');
        return 404;
    }

    if (!is_readable($filename)) {
//      header('HTTP/1.0 403 Forbidden');
        return 403;
    }

    $stat = @stat($filename);
    $etag = sprintf('%x-%x-%x', $stat['ino'], $stat['size'], $stat['mtime'] * 1000000);

    header('Expires: ');
    header('Cache-Control: ');
    header('Pragma: ');

    if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] == $etag) {
        header('Etag: "' . $etag . '"');
//      header('HTTP/1.0 304 Not Modified');
        return 304;
    } elseif (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $stat['mtime']) {
        header('Last-Modified: ' . date('r', $stat['mtime']));
//      header('HTTP/1.0 304 Not Modified');
        return 304;
    }

    header('Last-Modified: ' . date('r', $stat['mtime']));
    header('Etag: "' . $etag . '"');
    header('Accept-Ranges: bytes');
    header('Content-Length:' . $stat['size']);
    foreach ($http_header_additionals as $header) {
        header($header);
    }

    if (@readfile($filename) === false) {
//      header('HTTP/1.0 500 Internal Server Error');
        return 500;
    } else {
//      header('HTTP/1.0 200 OK');
        return 200;
    }
}

function getAdminTheme() {
    $txt = getSystemParameter("SYSTEM_ADMINISTRATOR_URL");
    $txt_2 = rtrim($txt, "/");
//    return $GLOBALS['adminTheme'];
    return $txt_2;
}

function setBreadCrumb($breadcrumb = array()) {
//    echo 'masuk1';
    $GLOBALS['breadcrumb_global'] = $breadcrumb;
}

function pageBody() {
    $result = '';
    $result .= '<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            ' . breadCrumb() . '
        </div>
        <div class="row" style="margin-top:20px;">
            <div class="col-md-12 ">
                <div class="portlet light bordered">';

    $result .= pageHeadBody();
    $result .= '';
    $result .= '<div class="portlet-body form" id="bodyPage">';

    return $result;
}

function pageAutoCrudBody() {
    $result = '';
    $result .= '<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            ' . breadCrumb() . '
        </div>
        <div class="row" style="margin-top:20px;">
            <div class="col-md-12 ">
                <div class="portlet light bordered">';
    $result .= pageHeadBody();
    return $result;
}

function pageAutoCrudHeadBody() {
    $result = '';
    $result .= '<div class="portlet-body form" id="bodyPage">';

    return $result;
}

function endPageBody() {
    $result = '</div></div></div></div></div></div>';
    return $result;
}

$title_body_global = '';
$subtitle_body_global = '';
$url_create = '';
$url_datatable = '';
$url_edit = '';
$showActionHeader = true;

function showActionHeader($value) {
    $GLOBALS['showActionHeader'] = $value;
}

function pageHeadBody() {
    $result = '<div class="portlet-title">
                        <div class="caption font-red-sunglo">
                            <span class="caption-subject bold uppercase" > 
                                ' . $GLOBALS['title_body_global'] . '
                                <small style="text-transform: none;color: #969696">' . $GLOBALS['subtitle_body_global'] . ' </small>
                            </span>
                        </div>';
    if ($GLOBALS['showActionHeader'] == true) {
        $result .= '<div class="actions" id="actionHeader">
                        </div>';
    }
    $result .= '</div>';
    $url = $GLOBALS['url_datatable'];
    $result .= '<input type="hidden" id="urlPage" value="' . $url . '"/>';
    return $result;
}

function setTitleBody($title) {
    $GLOBALS['title_body_global'] = $title;
}

function setCreateURL($url) {
    $GLOBALS['url_create'] = $url;
}

function setEditURL($url) {
    $GLOBALS['url_edit'] = $url;
}

function setDatatableURL($url) {
    $GLOBALS['url_datatable'] = $url;
}

function setSubtitleBody($subtitle) {
    $GLOBALS['subtitle_body_global'] = $subtitle;
}

function getActionType($value = null) {

    $db = new Database();
    $sfa = new SecurityFunctionAssignment();
    $str_replace_url = str_replace(URL(getAdminTheme()), "", $_SERVER['HTTP_REFERER']);
    $rs_function = $db->selectByID($sfa->getFunction(), $sfa->getFunction()->getUrl() . "='" . "/" . $str_replace_url . "'");
//    echo $_SERVER['HTTP_REFERER'].'<br/>';
//    echo URL();
//    print_r($rs_function);
//    echo json_encode($_SERVER);
    if (!empty($rs_function)) {
        $rs_sfa = $db->selectByID($sfa, $sfa->getFunction()->getId() . "='" . $rs_function[0][$sfa->getFunction()->getId()] . "'"
                . " AND " . $sfa->getGroup()->getId() . EQUAL . $_SESSION[SESSION_GROUP]);
//        print_r($rs_sfa);
        $action_type = $rs_sfa[0][$sfa->getActionType()];
//    $find_action_type = strp
        if (strpos($action_type, $value) !== false) {
            return true;
//        echo 'true';
        } else {
            return false;
        }
    } else {
        return true;
    }
//    $url_end = Url
}

/**
 * (PHP 4, PHP 5+)<br/>
 * Convert Combobox From Array to set ID and Label
 * <br/>
 * Licensed by Tripoin Team
 * @link http://www.tripoin.co.id/
 * @param Array() $data <p>
 * Data Array Multidimensional from get Table Database or Web Service
 * </p>
 * @param String $id [optional] <p>
 * change array key be from $data id combobox.
 * </p>
 * @param string $label [optional] <p>
 *  change array key from $data be label combobox.
 * </p>
 * @param Array() $manual_data [optional] <p>
 * Sets Manual Combobox 
 * example =>
 * $manual_data = [array("id"=>1,"label","Option 1"),array("id"=>2,"label","Option 2")];
 * </p>
 * @return json_decode A formatted version of <i>$data</i>.
 */
function convertJsonCombobox($data = null, $id, $label, $manual_data = array()) {
//    print_r($data);
    $json = '[';
    if (!empty($manual_data)) {
        foreach ($manual_data as $value_manual) {
            $json .= '{"id":"' . $value_manual['id'] . '","label":"' . $value_manual['label'] . '"},';
        }
    }
    if ($data != null) {

        foreach ($data as $value) {
//        echo key($value);
            $expl = "";
//            $ex = explode("-", $label);

            if (is_array($data)) {
                if (is_array($label)) {
                    foreach ($label as $values) {
                        $expl .= $value[$values] . " - ";
                    }
                    $expl = rtrim($expl, "- ");
                } else {
                    $expl = $value[$label];
                }
                $json .= '{"id":"' . $value[$id] . '","label":"' . $expl . '"},';
            } else {
                if (is_array($label)) {
                    foreach ($label as $values) {
                        $expl .= $value->$values . " - ";
                    }
                    $expl = rtrim($expl, "- ");
                } else {
                    $expl = $value->$label;
                }
                $json .= '{"id":"' . $value->$id . '","label":"' . $expl . '"},';
            }
        }
    }
    $json = rtrim($json, ',');
    $json .= ']';
//    print_r($data);
    return json_decode($json);
}

/**
 * (PHP 4, PHP 5+)<br/>
 * Convert Combobox From Array to set ID and Label in Jquery
 * <br/>
 * Licensed by Tripoin Team
 * @link http://www.tripoin.co.id/
 * @param Array() $data <p>
 * Data Array Multidimensional from get Table Database or Web Service
 * </p>
 * @param String $id [optional] <p>
 * change array key be from $data id combobox.
 * </p>
 * @param string $label [optional] <p>
 *  change array key from $data be label combobox.
 * </p>
 * @param Array() $manual_data [optional] <p>
 * Sets Manual Combobox 
 * example =>
 * $manual_data = [array("id"=>1,"label","Option 1"),array("id"=>2,"label","Option 2")];
 * </p>
 * @return json_decode A formatted version of <i>$data</i>.
 */
function convertJsonComboboxJquery($data = null, $id, $label, $manual_data = array()) {
//    print_r($data);
    $json = '[';
    if (!empty($manual_data)) {
        foreach ($manual_data as $value_manual) {
            $json .= '{"id":"' . $value_manual['id'] . '","text":"' . $value_manual['label'] . '"},';
        }
    }
    if ($data != null) {

        foreach ($data as $value) {
//        echo key($value);
            $expl = "";
//            $ex = explode("-", $label);

            if (is_array($data)) {
                if (is_array($label)) {
                    foreach ($label as $values) {
                        $expl .= $value[$values] . " - ";
                    }
                    $expl = rtrim($expl, "- ");
                } else {
                    $expl = $value[$label];
                }
                $json .= '{"id":"' . $value[$id] . '","text":"' . $expl . '"},';
            } else {
                if (is_array($label)) {
                    foreach ($label as $values) {
                        $expl .= $value->$values . " - ";
                    }
                    $expl = rtrim($expl, "- ");
                } else {
                    $expl = $value->$label;
                }
                $json .= '{"id":"' . $value->$id . '","text":"' . $expl . '"},';
            }
        }
    }
    $json = rtrim($json, ',');
    $json .= ']';
//    print_r($data);
    return json_decode($json);
}

function getSubMenu($countitem, $count_function_parent, $value_function_parent, $function_child, $idPost) {
    $db = new Database();
    $sfa = new SecurityFunctionAssignment();
    $sf = new SecurityFunction();
    $db->connect();



    if ($countitem != 0) {
        $adminthemeurl = getAdminTheme();



        $txt = '<ol class="dd-list" id="menu-parent-child' . $value_function_parent['fa_id'] . '">';
        foreach ($function_child as $value_function_child) {
            $db->sql(SELECT . "COUNT(" . $sfa->getFunction()->getId() . ") as count_function_parent " .
                    FROM . $sf->getEntity() .
                    WHERE . $sf->getParent() . EQUAL . $value_function_child[$sf->getId()]);
            $sf_count_parent = $db->getResult();

            $count_function_parents = intval($sf_count_parent[0]['count_function_parent']);

            $txt .= '<li class="dd-item dd3-item" data-id="' . $value_function_child['fa_id'] . '"  id="id-menu' . $value_function_child['fa_id'] . '">';
//            $txt .= '<div class="dd-handle dd3-handle"> </div>';
            $txt .= '<div class="dd3-content" id="content-menu">';
            $txt .= '<span id="text-menu' . $value_function_child['fa_id'] . '">' . $value_function_child[$sfa->getFunction()->getName()] . '</span>';
            if ($count_function_parents != 0) {
                $txt .= '<i class="fa fa-plus text-warning" onclick="addEditMenu(this, \'&id=' . $value_function_child['fa_id'] . '&id_group=' . $idPost . '&id_function=' . $value_function_child[$sfa->getFunction()->getId()] . '&id_function_assignment=' . $value_function_child['fa_id'] . '\', \'Add Menu\', \'' . URL($adminthemeurl . '/security/function-assignment/add-function') . '\')" rel="tooltip" data-original-title="Add" style="cursor:pointer"></i>';
            }
            $txt .= '<i class="fa fa-pencil text-primary" rel="tooltip" 
                                       data-original-title="Edit" style="cursor:pointer"
                                       id="btn-edit-menu' . $value_function_child['fa_id'] . '"
                                       onclick="addEditMenu(this, \'&id=' . $value_function_child['fa_id'] . '&id_function_parent=' . $value_function_parent[$sfa->getFunction()->getId()] . '&id_parent=' . $value_function_parent['fa_id'] . '&id_group=' . $idPost . '&id_function=' . $value_function_child[$sfa->getFunction()->getId()] . '&id_function_assignment=' . $value_function_child['fa_id'] . '\', \'Edit Menu\', \'' . URL($adminthemeurl . '/security/function-assignment/edit-function') . '\')"></i>';

            $txt .= '<i class="fa fa-minus text-danger" rel="tooltip" 
                                       alert-title="Delete Data" alert-button-delete="Yes, Delete it." 
                                       alert-message="Are you sure Delete this Data??" 
                                       onclick="deleteFunction(this, \'' . URL($adminthemeurl . '/security/function-assignment/delete-function') . '\',' . $value_function_child['fa_id'] . ')" data-original-title="Delete" style="cursor:pointer"></i>';
            $txt .= '</div>';

            $db->sql(SELECT . "COUNT(" . $sf->getEntity() . DOT . $sf->getId() . ") as count" .
                    FROM . $sfa->getEntity() . JOIN . $sf->getEntity() .
                    ON . $sf->getEntity() . DOT . $sf->getId() . EQUAL . $sfa->getEntity() . DOT . $sfa->getFunctionId() .
                    WHERE . $sf->getEntity() . DOT . $sf->getParent() . EQUAL . $value_function_child[$sfa->getFunction()->getId()] . ""
                    . " AND " . $sfa->getGroupId() . EQUAL . $idPost
            );
            $sf_item = $db->getResult();
//            LOGGER($sf_item);
            $countitem_2 = intval($sf_item[0]['count']);
//            print_r($sf_item);
            if ($countitem_2 != 0) {
//                echo $countitem_2;


                $db->select(
                        $sfa->getEntity(), $sfa->getFunction()->getEntity() . ".*," . $sfa->getEntity() . DOT . $sfa->getId() . " as fa_id", array($sfa->getFunction()->getEntity(), $sfa->getGroup()->getEntity()), $sfa->getFunction()->getEntity() . DOT . $sfa->getFunction()->getId() . EQUAL . $sfa->getEntity() . DOT . $sfa->getFunctionId()
                        . " AND " . $sfa->getGroup()->getEntity() . DOT . $sfa->getGroup()->getId() . EQUAL . $sfa->getEntity() . DOT . $sfa->getGroupId()
                        . " AND " . $sfa->getEntity() . DOT . $sfa->getStatus() . EQUAL . "1"
                        . " AND " . $sfa->getEntity() . DOT . $sfa->getGroupId() . EQUAL . $idPost
                        . " AND " . $sf->getEntity() . DOT . $sf->getParent() . EQUAL . $value_function_child[$sf->getId()]
                        , $sfa->getFunctionAssignmentOrder() . ' ASC'
                );
                $function_childs = $db->getResult();
                LOGGER($function_childs);
                $txt .= getSubMenu($countitem_2, $count_function_parents, $value_function_child, $function_childs, $idPost);
            }
            $txt .= '</li>';
        }
        $txt .= ' </ol>';
        return $txt;
    }
}

/**
 * (PHP 4, PHP 5+)<br/>
 * Function UploadFileImg($img, $filenames, $path, $addExtension = array(), $addFileType = array());
 * <br/>
 * Licensed by Tripoin Team
 * @link http://www.tripoin.co.id/
 * @param Files $img [optional] <p>
 * param from $_FILES['{your-inputfile-id}']
 * </p>
 * @param string $filenames [optional] <p>
 * Filenames to be saved - example => example.jpg
 * </p>
 * @param string $path [optional] <p>
 * Your Path for File to be saved  - example => var/www/html/example/uploads
 * </p>
 * @param Array() $addExtension [optional] <p>
 * array typeExtension : example=> array('pdf','txt');
 * </p>
 * @param Array() $addFileType [optional] <p>
 * array typeFileMIMEContent : example=> array('application/pdf','application/vnd.ms-powerpoint','application/text');
 * you can see mime content-type in https://developer.mozilla.org/en-US/docs/Web/HTTP/Basics_of_HTTP/MIME_types/Complete_list_of_MIME_types
 * </p>
 * @return json_decode A formatted version of <i>$data</i>.
 */
function uploadFileImg($img, $filenames, $path, $addExtension = array(), $addFileType = array()) {
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
//    print_r($img);
    if ($img['error'] == 0) {
        $validextension1 = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
        $validextensions = array_merge($validextension1, $addExtension);

        $file_type = array("image/png", "image/jpg", "image/jpeg");
        $ex_file_type = array_merge($file_type, $addFileType);
        $temporary = explode(".", $img["name"]);
        $file_extension = end($temporary);
        $file_name = $filenames . "." . $file_extension;
        $file_path_name = $path . $file_name;
        if ($img["size"] > 2097152) {
            return array("result" => 0, "message" => lang('message.051'));
        } else if (in_array($img["type"], $ex_file_type) && in_array($file_extension, $validextensions)) {
            if (file_exists($file_name)) {
                $sourcePath = $img['tmp_name'];
                move_uploaded_file($sourcePath, $file_path_name);
            } else {
                $sourcePath = $img['tmp_name'];
                move_uploaded_file($sourcePath, $file_path_name);
            }
            return array("result" => 1, "message" => "Upload Success", "file_name" => $file_name);
        } else {

            return array("result" => 0, "message" => lang('message.054'));
        }
    } else {
        if ($img['error'] == 4) {
//            echo '0,' . lang('message.053');
            return array("result" => 0, "message" => lang('message.053'));
        } else {
            $image_size = getimagesize($img['tmp_name'][0]);
            if ($image_size == false) {
//                echo '0,' . lang('message.051');
                return array("result" => 0, "message" => lang('message.051'));
            }
        }
//            
    }
}

function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i = 0; $i < $file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}

function imageManager($title, $url, $link, $type) {
    if ($type == 3) {
        $stringCut = substr($title, 0, 10);
        $txt = '<div class="col-sm-2 col-md-2">
                    <a href="javascript:;" class="thumbnail"  
                    id="folder" action="' . $link . '" onclick="getFolder(this,event)" style="text-align: center;">
                        <img src="' . $url . '" style="padding-top: 25px;padding-bottom: 25px;"
                             height="50" width="50"
                             >
                        <span>' . $stringCut . '</span>
                    </a>
                </div>';
    } else if ($type == 1) {
        $stringCut = substr($title, 0, 10);
        $userAgent = getUserAgent();
        if ($userAgent == "web") {
            $txt = '<div class="col-sm-2 col-md-2">
                    <a href="javascript:;" class="thumbnail"  
                    id="folder" action="' . $link . '"  value="' . $title . '" value-type="0" onclick="checkFile(this)" ondblclick="getFolder2(this,event)" style="text-align: center;">
                        <img src="' . $url . '" style="padding-top: 25px;padding-bottom: 25px;"
                             height="50" width="50"
                             >
                        <span>' . $stringCut . '</span>
                    </a>
                </div>';
        } else {
            $txt = '<div class="col-sm-2 col-md-2">
                    <a href="javascript:;" class="thumbnail"  
                    id="folder" action="' . $link . '"  value="' . $title . '" value-type="0" onclick="getFolder(this,event)" style="text-align: center;">
                        <img src="' . $url . '" style="padding-top: 25px;padding-bottom: 25px;"
                             height="50" width="50"
                             >
                        <span>' . $stringCut . '</span>
                    </a>
                </div>';
        }
    } else {
        $exp_name = explode(".", $title);
        $file_name = '';
        foreach ($exp_name as $value) {
            if (end($exp_name) != $value) {
                $file_name .= $value;
            }
        }
        $stringCut = substr($file_name, 0, 10);
        $userAgent = getUserAgent();
        if ($userAgent == "web") {
            $txt = '<div class="col-sm-2 col-md-2 hidden-xs hidden-sm">
                    <a href="javascript:;" onclick="checkFile(this)" ondblclick="viewPicture2(\'' . $url . '\')" value="' . $title . '" value-type="0" name="fileimage[]" class="thumbnail" id="file" style="text-align: center;">
                        <img src="' . $url . '" style="height: 102px; width: 100%; display: block;"
                            
                             >
                        <span>' . $stringCut . '.' . end($exp_name) . '</span>
                    </a>
                </div>';
        } else {
            $txt = '<div class="col-sm-2 col-md-2 hidden-lg">
                    <a href="javascript:;"  onclick="viewPicture(this,\'' . $url . '\')" value="' . $title . '" value-type="0" name="fileimage[]" class="thumbnail" id="file" style="text-align: center;">
                        <img src="' . $url . '" style="height: 185px; width: 100%; display: block;"
                            
                             >
                        <span>' . $stringCut . '.' . end($exp_name) . '</span>
                    </a>
                </div>';
        }
    }
    return $txt;
}

function imageManagerList($title, $url, $link, $type) {

    if ($type == 1) {
        $stringCut = substr($title, 0, 10);
        $txt = '<div class="col-sm-2 col-md-2">
                    <a href="javascript:;" class="thumbnail"  
                    id="folder" action="' . $link . '" onclick="getFolder(this,event)" style="text-align: center;">
                        <img src="' . $url . '" style="padding-top: 25px;padding-bottom: 25px;"
                             height="50" width="50"
                             >
                        <span>' . $stringCut . '</span>
                    </a>
                </div>';
    } else {
        $exp_name = explode(".", $title);
        $file_name = '';
        foreach ($exp_name as $value) {
            if (end($exp_name) != $value) {
                $file_name .= $value;
            }
        }
        $stringCut = substr($file_name, 0, 10);
        $userAgent = getUserAgent();
        if ($userAgent == "web") {
            $txt = '<div class="col-sm-2 col-md-2 hidden-xs hidden-sm">
                    <a href="javascript:;"  onclick="checkFile(this)"  ondblclick="chooseFile()" value="' . $title . '" value-type="0" name="fileimage[]" class="thumbnail" id="file" style="text-align: center;">
                        <img src="' . $url . '" style="height: 102px; width: 100%; display: block;"
                            
                             >
                        <span>' . $stringCut . '.' . end($exp_name) . '</span>
                    </a>
                </div>';
        } else {
            $txt = '<div class="col-sm-2 col-md-2 hidden-lg">
                    <a href="javascript:;"  onclick="checkFile(this)" value="' . $title . '" value-type="0" name="fileimage[]" class="thumbnail" id="file" style="text-align: center;">
                        <img src="' . $url . '" style="height: 185px; width: 100%; display: block;"
                            
                             >
                        <span>' . $stringCut . '.' . end($exp_name) . '</span>
                    </a>
                </div>';
        }
    }
    return $txt;
}

$userBrowser = $_SERVER['HTTP_ACCEPT'];
if (stristr($userBrowser, 'application/vnd.wap.xhtml+xml')) {
    $_REQUEST['wap2'] = 1;
} elseif (stripos($_SERVER['HTTP_USER_AGENT'], "iPod")) {
    $_REQUEST['iphone'] = 1;
} elseif (stripos($_SERVER['HTTP_USER_AGENT'], "iPhone")) {
    $_REQUEST['iphone'] = 1;
} elseif (stripos($_SERVER['HTTP_USER_AGENT'], "Android")) {
    $_REQUEST['Android'] = 1;
} elseif (stripos($_SERVER['HTTP_USER_AGENT'], "IEMobile")) {
    $_REQUEST['IEMobile'] = 1;
} elseif (stristr($userBrowser, 'DoCoMo/' || 'portalmmm/')) {
    $_REQUEST['imode'] = 1;
} elseif (stristr($userBrowser, 'text/vnd.wap.wml')) {
    $_REQUEST['wap'] = 1;
} elseif (stristr($userBrowser, 'text/html')) {
    $_REQUEST['html'] = 1;
}
if (!defined('WAP'))
    define('WAP', isset($_REQUEST['wap']) || isset($_REQUEST['wap2']) || isset($_REQUEST['imode']) || isset($_REQUEST['html']) || isset($_REQUEST['Android']) || isset($_REQUEST['iphone']) || isset($_REQUEST['IEMobile']));
define('WIRELESS_PROTOCOL', isset($_REQUEST['wap']) ? 'wap' : (isset($_REQUEST['wap2']) ? 'wap2' : (isset($_REQUEST['iphone']) ? 'iphone' : (isset($_REQUEST['imode']) ? 'imode' : (isset($_REQUEST['IEMobile']) ? 'IEMobile' : (isset($_REQUEST['html']) ? 'html' : (isset($_REQUEST['Android']) ? 'Android' : '')))))));

function getUserAgent() {
    if (WAP) {
//        if (!defined('WIRELESS_PROTOCOL_SELF'))


        if (WIRELESS_PROTOCOL == 'wap') {
            $browser_t = "mobile";
        } elseif (WIRELESS_PROTOCOL == 'wap2') {

            $browser_t = "mobile";
        } elseif (WIRELESS_PROTOCOL == 'imode') {

            $browser_t = "mobile";
        } elseif (WIRELESS_PROTOCOL == 'iphone') {


            $browser_t = "smartphone";
        } elseif (WIRELESS_PROTOCOL == 'Android') {


            $browser_t = "smartphone";
        } elseif (WIRELESS_PROTOCOL == 'IEMobile') {

            $browser_t = "smartphone";
        } elseif (WIRELESS_PROTOCOL == 'html') {

            $mobile_browser = '0';

            if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
                $mobile_browser++;
            }

            if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') > 0) or ( (isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
                $mobile_browser++;
            }

            $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
            $mobile_agents = array(
                'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
                'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
                'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
                'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
                'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
                'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
                'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
                'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
                'wapr', 'webc', 'winw', 'winw', 'xda', 'xda-');

            if (in_array($mobile_ua, $mobile_agents)) {
                $mobile_browser++;
            }
            if (isset($_SERVER['ALL_HTTP'])) {
                if (strpos(strtolower($_SERVER['ALL_HTTP']), 'OperaMini') > 0) {
                    $mobile_browser++;
                }
            }
            if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'iemobile') > 0) {
                $mobile_browser++;
            }
            if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') > 0) {
                $mobile_browser = 0;
            }


            if ($mobile_browser > 0) {
                // do something wap

                $browser_t = "mobile";
            }
// non-mobile
            else {

                $_SESSION['Browser_d'] = "web";
                $browser_t = "web";
            }
        } else {
            // do something else html

            $_SESSION['Browser_d'] = "web";
            $browser_t = "web";
        }
    } else {
        $mobile_browser = '0';

        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $mobile_browser++;
        }

        if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') > 0) or ( (isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
            $mobile_browser++;
        }

        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobile_agents = array(
            'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
            'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
            'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
            'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
            'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
            'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
            'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
            'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
            'wapr', 'webc', 'winw', 'winw', 'xda', 'xda-');

        if (in_array($mobile_ua, $mobile_agents)) {
            $mobile_browser++;
        }
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'iemobile') > 0) {
            $mobile_browser++;
        }
        if (isset($_SERVER['ALL_HTTP'])) {
            if (strpos(strtolower($_SERVER['ALL_HTTP']), 'OperaMini') > 0) {
                $mobile_browser++;
            }
        }
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') > 0) {
            $mobile_browser = 0;
        }


        if ($mobile_browser > 0) {
            // do something wap

            $browser_t = "mobile";
        }
// non-mobile
        else {
            $_SESSION['Browser_d'] = "web";
            $browser_t = "web";
        }
    }
    return $browser_t;
}

function Form() {
    $Form = new Form();
    return $Form;
}

function Button() {
    $Button = new Button();
    return $Button;
}

function valueComboBoxParent($entity, $id, $name, $parent, $where = null) {
    $str_where = "";
    if ($where != null) {
        $str_where = " AND " . $where;
    }
    $db = new Database();
    $db->connect();
    $db->sql("SELECT " . $id . ", " . $name . ", " . $parent . " 
                    FROM " . $entity . " WHERE " . $id . " NOT IN 
                    (SELECT " . $id . " FROM " . $entity . " WHERE " . $id . " IN (SELECT " . $parent . " FROM " . $entity . ")) " . $str_where);
    $res_subject = $db->getResult();
//echo json_encode($res_subject);
    $data = array();
    $t = '';
    foreach ($res_subject as $v_subj) {
        $t = getParentManual($entity, $id, $name, $parent, $v_subj[$parent], $v_subj[$name]);
        array_push($data, array("label" => $t, "id" => $v_subj[$id]));
    }
    return $data;
}

function getParentManual($entity, $id_field, $name_field, $parent_field, $parentId, $names, $tx = '') {
    $db = new Database();
//    $masterSubject = new MasterSubject();
    if ($parentId == null) {
        $tx .= $names;
    } else {
//        $res_subject_parent = $db->selectByID($masterSubject, $masterSubject->getId() . EQUAL . $parentId);
        $db->connect();

        $db->select($entity, "*", null, $id_field . EQUAL . $parentId);
        $res_subject_parent = $db->getResult();
        foreach ($res_subject_parent as $value) {
            $tx = $value[$name_field] . " > " . $tx;
//            echo $value[$masterSubject->getName()];
            return getParentManual($entity, $id_field, $name_field, $parent_field, $value[$parent_field], $names, $tx);
        }
    }
    return $tx;
}

function convertGender($type) {
    $result = "";
    if ($type == "L") {
        $result = lang('general.male');
    } else if ($type == "M") {
        $result = lang('general.male');
    } else if ($type == "F") {
        $result = lang('general.female');
    }
    return $result;
}

function convertMaritalStatus($type) {
    $result = "";
    if ($type == "N") {
        $result = "Belum Menikah";
    } else if ($type == "Y") {
        $result = "Menikah";
    }
    return $result;
}

function square_crop($src_image, $dest_image, $thumb_size = 64, $jpg_quality = 90) {

// Get dimensions of existing image
    $image = getimagesize($src_image);

// Check for valid dimensions
    if ($image[0] <= 0 || $image[1] <= 0)
        return false;

// Determine format from MIME-Type
    $image['format'] = strtolower(preg_replace('/^.*?\//', '', $image['mime']));

// Import image
    switch ($image['format']) {
        case 'jpg':
        case 'jpeg':
            $image_data = imagecreatefromjpeg($src_image);
            break;
        case 'png':
            $image_data = imagecreatefrompng($src_image);
            break;
        case 'gif':
            $image_data = imagecreatefromgif($src_image);
            break;
        default:
            // Unsupported format
            return false;
            break;
    }

// Verify import
    if ($image_data == false)
        return false;

// Calculate measurements
    if ($image[0] & $image[1]) {
        // For landscape images
        $x_offset = ($image[0] - $image[1]) / 2;
        $y_offset = 0;
        $square_size = $image[0] - ($x_offset * 2);
    } else {
        // For portrait and square images
        $x_offset = 0;
        $y_offset = ($image[1] - $image[0]) / 2;
        $square_size = $image[1] - ($y_offset * 2);
    }

// Resize and crop
    $canvas = imagecreatetruecolor($thumb_size, $thumb_size);
    if (imagecopyresampled(
                    $canvas, $image_data, 0, 0, $x_offset, $y_offset, $thumb_size, $thumb_size, $square_size, $square_size
            )) {

        // Create thumbnail
        switch (strtolower(preg_replace('/^.*\./', '', $dest_image))) {
            case 'jpg':
            case 'jpeg':
                return imagejpeg($canvas, $dest_image, $jpg_quality);
                break;
            case 'png':
                return imagepng($canvas, $dest_image);
                break;
            case 'gif':
                return imagegif($canvas, $dest_image);
                break;
            default:
                // Unsupported format
                return false;
                break;
        }
    } else {
        return false;
    }
}

function getLov($table, $where = "") {
    $db = new Database();
    $rs_lov = $db->selectByID($table, $where);
    $data = convertJsonCombobox($rs_lov, 'id', 'name');
    return $data;
}

function equalToIgnoreCase($value) {
    return "='" . $value . "' ";
}

function notEqualToIgnoreCase($value) {
    return "!='" . $value . "' ";
}

function in($array = array()) {
    $txt = '';
    foreach ($array as $value) {
        $txt .= "'" . $value . "',";
    }
    $txt = rtrim($txt, ',');

    return " IN (" . $txt . ") ";
}

function redirectURL($url) {
    echo '<script>window.location.href = "' . $url . '";</script>';
}

/**
 * (PHP 4, PHP 5+)<br/>
 * Convert Combobox From Array to set ID and Label in Jquery
 * <br/>
 * Licensed by Tripoin Team
 * @link http://www.tripoin.co.id/
 * @param Array() $mailTo <p>
 * Data Array Multidimensional and Have key "email","name"
 * @param string $subject [optional] <p>
 * String subject in mail
 * </p>
 * @param string $message [optional] <p>
 * String message in mail
 * example =>
 * $mailTo = [array("email"=>"sfandrianah2@gmail.com","name","Syahrial Fandrianah"),array("email"=>"tripoinstudio@gmail.com","name","Tripoin Studio")];
 * </p>
 * @return Boolean True or False.
 */
function sendMail($mailTo = array(), $subject = '', $message = '') {
    $mail = new PHPMailer;
    try {
        $mail->isSMTP();
        $mail->Host = MAIL_HOST;

        $mail->Port = MAIL_SMTP_PORT;
        $mail->SMTPSecure = MAIL_SMTPSECURE;
        $mail->SMTPAuth = MAIL_SMTPAUTH;

        $mail->Username = MAIL_USERNAME;
        $mail->Password = MAIL_PASSWORD;

        $mail->isHTML(true);

//Set who the message is to be sent from
        $mail->setFrom(MAIL_USERNAME, MAIL_FULLNAME);

//Set an alternative reply-to address
        if (is_array($mailTo)) {
            if (isset($mailTo['email']) && isset($mailTo['name'])) {
                $mail->addReplyTo($mailTo['email'], $mailTo['name']);
                $mail->addAddress($mailTo['email'], $mailTo['name']);
            } else {
                foreach ($mailTo as $value) {
                    if (isset($value['email']) && isset($value['name'])) {
                        $mail->addReplyTo($value['email'], $value['name']);
                        $mail->addAddress($value['email'], $value['name']);
                    } else {
                        $mail->addReplyTo($value, $value);
                        $mail->addAddress($value, $value);
                    }
                }
            }
        } else {
            $mail->addReplyTo($mailTo, $mailTo);
            $mail->addAddress($mailTo, $mailTo);
        }
//        $mail->addReplyTo($pic_email, $pic_name);
//        $mail->addAddress($pic_email, $pic_name);
//        $img_logo_tala = 'http://54.251.168.102/e-portal/contents/logo-kecil.png';
        $mail->Subject = $subject;
        $mail->Body = $message;
        if ($mail->smtpConnect()) {
            $mail->smtpClose();
            if (!$mail->send()) {
                return false;
                LOGGER($mail->ErrorInfo);
            } else {
                return true;
            }
        } else {
            LOGGER("Error Connect SMTP");
            return false;
        }
    } catch (\Exception $e) {
        return false;
        LOGGER($e->getMessage());
    }
}

function replace_between($str, $needle_start, $needle_end, $replacement) {
    $pos = strpos($str, $needle_start);
    $start = $pos === false ? 0 : $pos + strlen($needle_start);

    $pos = strpos($str, $needle_end, $start);
    $end = $start === false ? strlen($str) : $pos;

    return substr_replace($str, $replacement, $start, $end - $start);
}
?>

