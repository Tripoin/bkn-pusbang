<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$app = require 'config/app.php';
foreach ($app['global_class'] as $value) {
    require_once $value;
}
//print_r($app);