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
        $result = Routes::get();
//        print_r($result);
        if (!empty($result)) {
            $rpl = str_replace('/', '\\', $result['class']);
            $str = explode('@', $rpl);
            
            $filename = str_replace('\\', '/', $str[0]) . '.php';
            $exists = file_exists($filename);
//            LOGGER($filename);
//            echo $trim;
            if ($exists == true) {
                the_autoloader($str[0]);
                $class = new $str[0]();
                $txt = '';
//                print_r($exd);
//                echo $str2[0];
//                echo $str[1];
                if (empty($result['param'])) {
                    $str5 = $str[1];
                    echo $class->$str5();
                } else {
                  foreach ($result['param'] as $value) {
                        $txt .= $value . ',';
                    }
                    $txt = rtrim($txt, ',');
                    $str5 = $str[1];
                    echo call_user_func_array(array($class, $str5), explode(',', $txt));
                }
            } else {
//                LOGGER('NOT FOUND PAGE');
                include FILE_PATH(PAGE_404);
            }
        } else {
            include FILE_PATH(PAGE_404);
        }
    }

    public function routes($page) {
        $str = str_replace("index.php", "", $_SERVER['PHP_SELF']);
        $str2 = ltrim(str_replace(URL(), "", FULLURL()), "/");
        $ex_str = explode('?', $str2);
//        print_r($ex_str);
//        $page_ex = ['page/reservation/{id}/find{no}'];
        $ex_str1 = explode('/', $ex_str[0]);
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
