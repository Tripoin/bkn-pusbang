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

    public $route;
        public $group;
    public $help;

    public function __construct() {

    }

    //put your code here
    public function set($url, $class) {
        
        if (isset($this->group)) {
            $path = '';
            foreach ($this->group as $value) {
                $path .= $value . '/';
            }
            $this->route[] = [$path . $url, $class];
        } else {
            $this->route[] = [$url, $class];
        }
//        
    }

    public function get() {
//        foreach ($this->route as $vl){
//            echo $vl[0].'<br/>';
//        }
//        print_r($this->route);
        $filtered = array_filter($this->route, 'is_not_null');
        $foo2 = array_values($filtered);

//        echo json_encode($foo2);
        return json_encode($foo2);
    }

    public function group($path = array(), $function) {
        $this->group[] = $path['prefix'];
        $function();
    }

    public static function getInstance() {
        if (!Routes::$instance instanceof self) {
            Routes::$instance = new self();
        }
        return Routes::$instance;
    }
    
    public function setScaffolding($url,$class){
        $this->route[] = [$url, $class."@index"];
        $this->route[] = [$url.'/list', $class."@listData"];
        $this->route[] = [$url.'/create', $class."@create"];
        $this->route[] = [$url.'/edit', $class."@edit"];
        $this->route[] = [$url.'/delete', $class."@delete"];
        $this->route[] = [$url.'/save', $class."@save"];
        $this->route[] = [$url.'/update', $class."@update"];
        $this->route[] = [$url.'/deleteCollection', $class."@deleteCollection"];
        
    }

}
