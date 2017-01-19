<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of City
 * @email : sfandrianah2@gmail.com
 * @author Syahrial Fandrianah
 * @FRAMEWORK NATIVE ECCOMERCE V.1.0
 */

namespace app\Util;

use app\Util\Routes;

abstract class Home {

    public function __construct() {
        setSessionLang();

        include 'app/Http/routes.php';
        $dec = json_decode($Routes->get());
//        echo $Routes->get();
//        $rute = $Routes;
//        $Routes = new Routes();
        $page_include = $this->routes($dec);
//        echo $page_include;
//        $page_include = '';
        $page_decode = json_decode($page_include);
//        echo $page_include;
//        print_r($page_decode);
        if ($page_include != '') {
            $rpl = str_replace('/', '\\', $page_decode->files);
            $str = explode('@', $rpl);
            if (!isset($str[1]))
                $str[1] = '';
            $str2 = explode('(', $str[1]);
            if (!isset($str2[1]))
                $str2[1] = '';
            $trim = rtrim($str2[1], ')');
            $exd = explode(',', $trim);
            $filename = str_replace('\\', '/', $str[0]) . '.php';
            $exists = file_exists($filename);
            echo $trim;
            if ($exists == true) {
                the_autoloader($str[0]);
                $class = new $str[0]();
                $txt = '';
//                print_r($exd);
//                echo $str2[0];
                if ($exd[0] == "") {
                    $str5 = $str2[0];
                    echo $class->$str5();
//                    echo call_user_func_array(array($class, $str2[0]), '');
                } else {
                    foreach ($exd as $value) {
                        $txt .= $page_decode->data->$value . ',';
                    }
                    $txt = rtrim($txt, ',');
                    echo call_user_func_array(array($class, $str2[0]), explode(',', $txt));
                }
            } else {
                include FILE_PATH(PAGE_404);
            }
        } else {
            include FILE_PATH(PAGE_404);
        }
    }

    public function routes($page) {
//        $ltrim = ltrim($_SERVER['PHP_SELF'], "/");
//        print_r($_SERVER['PHP_SELF']);
//        echo json_encode($_SERVER);
        $str = str_replace("index.php", "", $_SERVER['PHP_SELF']);
//        echo "str:".$str."<br/>";
//        print_r($str);
//        echo $str.":".$_SERVER['REQUEST_URI'];
//        $str2 = str_replace($str, "", $_SERVER['REQUEST_URI']);
//        echo $_SERVER['REQUEST_URI'];
//        $str2 = ltrim($_SERVER['REQUEST_URI'],$str);
        $str2 = ltrim(str_replace(URL(), "", FULLURL()), "/");
//$exp_url = explode("/", $replace_url);
//        print_r( $_SERVER['PHP_SELF']);
//        print_r($str2);
//        echo "str2:".$str2;
//        $str2 .= $str2.'/';
        $ex_str = explode('?', $str2);
//        print_r($ex_str);
//        $page_ex = ['page/reservation/{id}/find{no}'];
        $ex_str1 = explode('/', $ex_str[0]);
//        print_r($ex_str1);
//        $ex_str1 .= ;
//        echo count($ex_str1);
//        print_r($page);
//                print_r($ex_str[0]);
//        echo $page;
        $ck_url = null;
        $json = '';
        for ($nok = 0; $nok < count($page); $nok++) {
//            echo $page[$nok][0].'<br/>';

            $page_ex1 = explode('/', $page[$nok][0]);
            if ($page_ex1 == "") {
                
            }

            if (count($ex_str1) == count($page_ex1)) {
//                echo count($ex_str1).' == '.count($page_ex1).'<br/>';
//            echo count($page_ex1);

                $check_spec = '';
                $class_1 = '';
                for ($no = 0; $no < count($ex_str1); $no++) {
                    if ($ex_str1[$no] == "") {
                        $ex_str1[$no] = "home";
                    }
//                    echo $page_ex1[$no];
                    if (isset($page_ex1[$no])) {
//                    echo $page_ex1[$no].' == '.$ex_str1[$no];
//                    if ($page_ex1[$no] == $ex_str1[$no]) {
//                        echo 'masuk';
//                    echo $ex_str1[$no].'/';
                        if (strpos($page_ex1[$no], '{') !== false) {
                            if (strpos($page_ex1[$no], '}') !== false) {
                                $check_spec[] = [$no, $page_ex1[$no] . '-' . $ex_str1[$no]];


                                $class_1 = $page_ex1[$no] . '/';

//                             echo $str_class[1].'<br/>';
//                            echo $msk.'<br/>';
//                            echo $betwen_url_param . '<br/>';
//                            echo $page[$nok][1].'<br/>';
                            }
                        } else {
                            $check_spec[] = [$no, $ex_str1[$no]];
                        }
//                    }
                    } else {
                        $check_spec[] = [$no, $ex_str1[$no]];
                    }
                }
//                echo '<br/>';
                $str_class = explode('@', $page[$nok][1]);
                $betwen_class_param = get_string_between($str_class[1], '(', ')');
                $ex_bw_class = explode(',', $betwen_class_param);
//            $betwen_url_param = get_string_between($page_ex1[$no], '{', '}');
//                foreach ($ex_bw_class as $value) {
//                    
//                }
//            echo $betwen_class_param.'-';
//            echo $class_1.'</br>';
//            echo count($check_spec);
//        print_r($check_spec);


                $json .= '{';

                for ($no1 = 0; $no1 < count($check_spec); $no1++) {
                    if (isset($check_spec[$no1][1])) {
//                        echo $check_spec[$no1][1];

                        $ext = explode('-', $check_spec[$no1][1]);
                        $start = get_end_string($ext[0], '{');
                        $key = get_string_between($ext[0], '{', '}');
//                        echo $key;
                        if ($key != "") {
//                            echo $key;
                            if (isset($check_spec[$no1])) {
//                                echo $page[$nok][0] . '-' . $ext[0] . '<br/>';
                                $value = substr($ext[1], $start[0]);
                                echo $value;
                                if ($value != "") {
                                    $json .= '"' . $key . '" : "' . $value . '",';
                                }
                            }
                        }
//                   echo $check_spec[$no1] . '/';
//                        echo $ext[0] . '/';

                        $ck_url .= $ext[0] . '/';
                    }
                }
//            echo '<br/>';
                $ck_url = substr($ck_url, 0, -1) . ',';
//                $ck_url = $ck_url;
                $json = rtrim($json, ',');
                $json .= '}';
//                echo $ck_url . '<br/>';
//                echo $json . 't<br/>';
            }
        }
//        print_r($json);

        $expl_url = explode(',', $ck_url);

        for ($nok = 0; $nok < count($page); $nok++) {
//            echo $page[$nok][0] .'</br>';
            foreach ($expl_url as $value_ck) {
//                echo $value_ck.'</br>';
                if ($value_ck == $page[$nok][0]) {
//                    echo 'masuk';
                    $ck_url = $page[$nok][0];
//                    echo $ck_url."<br/>";
                }
            }
        }
        $json = str_replace("{}", "", $json);

//        echo $ck_url;
//        echo json_encode($page);
        $class = '';
        $pages = '';
//        echo $ex_str[0];
//        echo $json;
        for ($nok = 0; $nok < count($page); $nok++) {
//            echo $page[$nok][0] .'=='. $ck_url.'</br>';
            if ($page[$nok][0] == $ex_str[0]) {
                $class = str_replace('\\', '/', $page[$nok][1]);
                $pages = $page[$nok][0];
//                echo $pages;
            } else if ($page[$nok][0] == $ck_url) {
                $class = str_replace('\\', '/', $page[$nok][1]);
                $pages = $page[$nok][0];
            }
//            echo $page[$nok][0] . '<br/>';
        }
//        echo $pages.'s';
//        echo $class.'s';
        $json_mix = '{"data":';
//        echo $json.'m';
        if ($json == "") {
            $json_mix .= '""';
        } else {
            $json_mix .= $json;
        }
        $json_mix .= ',"files":"' . $class . '"';
        $json_mix .= ',"page":"' . $pages . '"';
        $json_mix .= '}';
//        echo $json_mix;
        return $json_mix;
    }

}
