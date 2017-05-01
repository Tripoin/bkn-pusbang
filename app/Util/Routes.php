<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Util;

/**
 * Description of Route
 *
 * @author sfandrianah
 */
class Routes {

    public static $route;
    public static $group;
    public $help;
    public static $url;
    public static $class;
    public static $urlClass = array();
    public static $test;
    public static $urut = 0;
    public static $url_group = null;
    public static $url_group2 = array();
    public static $ar_url = array();
    public static $fix_data = array();

    public function __construct() {
        
    }

    //put your code here
    public static function set($url, $class) {
//        Routes::checkURL($url);
//        if (is_callable($class)) {
//        }
        /*        if (isset(Routes::$group)) {
          $path = '';
          foreach (Routes::$group as $value) {
          $path .= $value . '/';
          }
          Routes::$route[] = [$path . $url, $class];
          } else {
          Routes::$route[] = [$url, $class];
          } */
//        echo $url.'<br/>';
//        Routes::$group['prefix'][] =$url;
//        return $url;
//        Routes::$url = $url;
//        Routes::$class = $class;
//        echo Routes::$urut;
//        echo Routes::$url_group."<br/>";
        $fix_url = '';
//        echo Routes::$urut;
        if (Routes::$url_group != null) {

            $fix_url = Routes::$urlgr . $url;
//            echo $fix_url.'<br/>';
            Routes::$urlClass[] = array(Routes::$urlgr . $url, $class);
        } else {
            $fix_url = $url;
            Routes::$urlClass[] = array($url, $class);
        }
        $rpl_url = str_replace("//", "/", $fix_url);
        $data = Routes::checkURL($rpl_url, $class);
        if (!empty($data)) {
            Routes::$fix_data = $data;
        }
    }

    public function urlGroup() {
        
    }

    public static function getUrlClass() {
        return Routes::$urlClass;
    }

    public $urlFromRoutes = "";

    public static function checkURL($url, $class) {

//        $str = str_replace("index.php", "", $_SERVER['PHP_SELF']);
//        echo $url."<br/>";
        $page_url = ltrim(str_replace(URL(), "", FULLURL()), "/");
        $ex_page_url = explode('?', $page_url);
        $ex_page_url2 = explode('/', $ex_page_url[0]);

        $ex_url = explode('/', $url);
        $url_1 = '';
        $param = array();
//        echo '<br/>';
        $urls = '';
        $newClass = '';
        if (count($ex_url) == count($ex_page_url2)) {

            for ($nok = 0; $nok < count($ex_page_url2); $nok++) {

                if (!empty($ex_url[$nok])) {
//                    echo "ex_page_url2:".$ex_page_url2[$nok]."<br/>";
//                    echo "ex_page_url:".$ex_url[$nok]."=";
//                    echo "url:".$url."<br/>";

                    $check_param = get_string_between($ex_url[$nok], '{', '}');
                    $url_str = "";
                    if ($check_param == "") {

                        $url_str = $ex_url[$nok];
//                    echo $ex_url[$nok];
//                        echo $url_str."/";
                        $urls .= '/' . $url_str;
                    } else {
//                    echo $ex_page_url[0];
                        $url_str = $ex_page_url2[$nok];
//                       $url_str = $check_param;
//                    echo $url_str."/";
                        $urls .= '/' . $url_str;
//                       echo $class;
                        $param[] = $ex_page_url2[$nok];
//                    echo $url;
                    }
                    if (!empty($url)) {
                        if (!empty($url_str)) {
//                        echo "url_str:".$url_str."<br/>";
                            if (!empty($param)) {
                                
                            }
                            if (strpos($ex_page_url[0], $url_str) !== false) {
                                $url_1 .= '/' . $ex_page_url2[$nok];
//                                $url_1 = '/' .$ex_page_url[0];
//                                echo $url_1.'<br/>';
                            }
                        }
                    }
                }
            }
        }


//        echo $urls;
//        echo URL();
//        echo '<br/>';
        $str_class = "";
        $url_3 = ltrim($url_1, '/');
        $url_2 = '';
        if (empty($url)) {
            if (empty($ex_page_url[0])) {
                $url_2 = '/';
                $str_class = $newClass;
            }
        } else {

            if (!empty($ex_page_url[0])) {
                if (strpos($url_3, $ex_page_url[0]) !== false) {
//                    echo 'url_3:'.$url_3."<br/>";
                    $url_2 = $ex_page_url[0];
//                    echo $class;
                }
            }
        }
//        echo $ex_page_url[0];
        if ($ex_page_url[0] == "") {
            if ($url == "") {
                return array(
                    "url" => $url_2,
                    "param" => $param,
                    "class" => $class
                );
            }
        } else if (URL($ex_page_url[0]) == URL($urls)) {
            $newClass = $class;
            return array(
                "url" => $url_2,
                "param" => $param,
                "class" => $newClass
            );
        } else {
            return array();
        }
    }

    public static function get() {
//        $filtered = array_filter(Routes::$route, 'is_not_null');
//        $foo2 = array_values($filtered);
//        echo json_encode(Routes::$group);
//        return json_encode($foo2);
//        echo count(Routes::$urlClass[15]);
//        echo json_encode(Routes::$fix_data);
//        print_r(Routes::$fix_data);
        return Routes::$fix_data;
    }

    public static $urlgr = '';

    public static function group($path = array(), $function, $no = 1) {
//        echo json_encode(Routes::getUrlClass());
        if (isset($path['prefix'])) {
            $no+=1;
//            Routes::$group['prefix'][] = $path['prefix'];
//            Routes::$urlClass['prefix'][] = $path['prefix'];
            Routes::$url_group = $path['prefix'];
            Routes::$urut += 1;
            Routes::$urlgr .= $path['prefix'] . '/';

//            print_r($path);
//            $test = Routes::$urlgr;
//            echo $test . '<br/>';
//            echo $no;
//            echo Routes::$urlgr;
//            echo Routes::$urut."<br/>";
//            Routes::$urlClass[] = array($test => Routes::$url_group2);
            $function();
            Routes::$urut = 0;
            Routes::$urlgr = "";
//            print_r(Routes::$url_group2);
            Routes::$url_group = null;
//            echo json_encode($function()->getUrlClass());
//            Routes::set($function());
//            Routes::$group['prefix'][] = $function();
//            print_r($function());
//            return false;
        }

//        print_r($function());
//        print_r(Routes::$function());
//        $function();
    }

    public static function getInstance() {
        if (!Routes::$instance instanceof self) {
            Routes::$instance = new self();
        }
        return Routes::$instance;
    }

    public static function setScaffolding($url, $class) {
        Routes::set($url, $class . "@index");
        Routes::set($url . '/view', $class . "@view");
        Routes::set($url . '/list', $class . "@listData");
        Routes::set($url . '/create', $class . "@create");
        Routes::set($url . '/edit', $class . "@edit");
        Routes::set($url . '/delete', $class . "@delete");
        Routes::set($url . '/save', $class . "@save");
        Routes::set($url . '/update', $class . "@update");
        Routes::set($url . '/deleteCollection', $class . "@deleteCollection");
//        echo 'masuk';
        /*
          Routes::$route[] = [$url, $class . "@index"];
          Routes::$route[] = [$url . '/list', $class . "@listData"];
          Routes::$route[] = [$url . '/create', $class . "@create"];
          Routes::$route[] = [$url . '/edit', $class . "@edit"];
          Routes::$route[] = [$url . '/delete', $class . "@delete"];
          Routes::$route[] = [$url . '/save', $class . "@save"];
          Routes::$route[] = [$url . '/update', $class . "@update"];
          Routes::$route[] = [$url . '/deleteCollection', $class . "@deleteCollection"];
         * 
         */
    }

    public static function getTest() {
        return Routes::$test;
    }

    public static function setTest($test) {
        Routes::$test = $test;
    }

}
