<?php

//error_reporting(E_ALL & ~E_NOTICE & E_STRICT );

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
//require 'app/Util/Home/Home.php';
//spl_autoload_extensions(".php");
session_start();

require 'config/autoload.php';

date_default_timezone_set(TIME_ZONE);
ini_set("display_errors", 'Off');


require ("vendor/autoload.php");
//require_once 'app/Util/Function.php';

//spl_autoload_register('the_autoloader');
register_shutdown_function('errorHandler');

//the_autoloader('app/Util/Form');
//will_this_undefined_function_raise_an_error();
// register the autoloader



use app\Util\Home;

class index extends Home {
    
}

$index = new index();
//print_r(error_get_last());
if ($GLOBALS['var_log'] == true) {
    log_to_file(error_get_last());
}

