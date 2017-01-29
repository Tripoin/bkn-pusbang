<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controller\Base;

/**
 * Description of IRestController
 *
 * @author sfandrianah
 */
interface IController {

    //put your code here
    public function save();

    public function update();

    public function listData();

    public function create();

    public function delete();

    public function deleteCollection();

    public function setAutoCrud();
}
