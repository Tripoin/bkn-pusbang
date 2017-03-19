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
use app\Util\DataTable;

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
        $db = new Database();
        $db->connect();
        $datatable = new DataTable();
        $Form = new Form();
        $datatable->perPage(5);
        $rs_alumnus = $datatable->select_pagination_sql("SELECT upr.name participant_name, uma.behind_degree, uma.front_degree, wun.name agencies, wun.government_agencies_id, act.subject_name activity, act.generation FROM mst_user_assignment uas JOIN trx_activity act ON uas.activity_id = act.id 
                  JOIN mst_user_main uma ON uas.user_main_id = uma.id JOIN mst_working_unit wun ON uma.working_unit_id = wun.id 
                  JOIN sec_user_profile upr ON uma.user_profile_id = upr.id  JOIN sec_role rol ON uas.role_id = rol.id 
                  WHERE rol.code = 'PARTICIPANT' AND act.year_activity = ".$years." group by upr.name order by upr.name");
        
//        echo json_encode($rs_alumnus);
        include getTemplatePath('/page/global/alumni/alumni-search.html.php');
    }
}