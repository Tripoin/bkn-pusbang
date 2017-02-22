<?php

namespace app\Constant;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

interface IRestCommandConstant {

    // COMMAND GENERAL
    const COMMAND_STRING = 'command';
    const API = '000000';
    const VERSI = '1';
    const LOGIN = '100001';
    const LOGOUT = '100002';
    
    //COMMAND SCAFOLDING
    const SELECT_ALL_DATA = '100003';
    const INSERT_SINGLE_DATA = '100004';
    const UPDATE_SINGLE_DATA = '100005';
    const DELETE_SINGLE_DATA = '100006';
    const FIND_SINGLE_DATA_BY_ID = '100007';
    const FIND_SINGLE_DATA_BY_CODE = '100008';
    const FIND_SINGLE_DATA_BY_NAME = '100009';
    const ADVANCED_PAGINATION = '100010';
    const SIMPLE_PAGINATION = '100011';
    const SELECT_LOV = '100012';
    const REFUSAL = '100013';
    const APPROVAL = '100014';
    const DELETE_COLLECTION = '100015';
    const RETRIEVE_FIELDS_NAME_OF_MODEL = '100016';
    const SIMPLE_REPORT_DATA = '100017';

}
