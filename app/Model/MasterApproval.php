<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Model;

/**
 * Description of MasterPostLanguage
 *
 * @author sfandrianah
 */
use app\Model\GeneralAuditrail;

class MasterApproval extends GeneralAuditrail {

    //put your code here
    public function __construct() {
        $this->setEntity('mst_approval');
    }
    
    protected $approvalCategoryId = 'approval_category_id';
    protected $approvalDetailId = 'approval_detail_id';
    protected $isExecuted = 'is_executed';
    
    function getApprovalCategoryId() {
        return $this->approvalCategoryId;
    }

    function getApprovalDetailId() {
        return $this->approvalDetailId;
    }

    function setApprovalCategoryId($approvalCategoryId) {
        $this->approvalCategoryId = $approvalCategoryId;
    }

    function setApprovalDetailId($approvalDetailId) {
        $this->approvalDetailId = $approvalDetailId;
    }
    function getIsExecuted() {
        return $this->isExecuted;
    }

    function setIsExecuted($isExecuted) {
        $this->isExecuted = $isExecuted;
    }

    
    
        
    public function search($key) {
        return $this->$key;
    }
    
    function setData($data) {
        $array_data = array();
        foreach ($data as $key => $value) {
            $array_data[$this->$key] = $value;
        }
        return $array_data;
    }


}
