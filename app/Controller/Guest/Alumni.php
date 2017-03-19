<?php

namespace app\Controller\Guest;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ContactUs
 *
 * @author sfandrianah
 */
use app\Model\MasterUserAssignment;
use app\Util\Database;
use app\Model\ContactMessage;
use app\Util\Form;

class Alumni {

    //put your code here

    public function index() {
        $Form = new Form();
        $db = new Database();
        $db->connect();
        $db->sql("SELECT year_activity FROM trx_activity GROUP BY year_activity");
        $rs_years = $db->getResult();
        include getTemplatePath('page/global/alumni.html.php');
    }

    public function search(){
        $years = $_POST['years'];
        $Form = new Form();
        $db = new Database();
        $db->connect();
        $db->sql("SELECT upr.name participant_name, wun.name agencies, act.subject_name activity, act.generation FROM mst_user_assignment uas JOIN trx_activity act ON uas.activity_id = act.id 
                  JOIN mst_user_main uma ON uas.user_main_id = uma.id JOIN mst_working_unit wun ON uma.working_unit_id = wun.id 
                  JOIN sec_user_profile upr ON uma.user_profile_id = upr.id  JOIN sec_role rol ON uas.role_id = rol.id 
                  WHERE rol.code = 'PARTICIPANT' AND act.year_activity = ".$years);
        $rs_alumnus = $db->getResult();
        include getTemplatePath('/page/global/alumni/alumni-search.html.php');
    }
}