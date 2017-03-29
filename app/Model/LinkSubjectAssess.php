<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Model;

/**
 * Description of LinkSubjectAssess
 *
 * @author sfandrianah
 */
class LinkSubjectAssess {
    //put your code here
    
    private $entity = 'link_subject_assess';
    private $subjectId = 'subject_id';
    private $categoryAssessId = 'category_assess_id';
    private $categoryAssessParentId = 'category_assess_parent_id';
    
    function getEntity() {
        return $this->entity;
    }

    function getSubjectId() {
        return $this->subjectId;
    }

    function getCategoryAssessId() {
        return $this->categoryAssessId;
    }

    function getCategoryAssessParentId() {
        return $this->categoryAssessParentId;
    }

    function setEntity($entity) {
        $this->entity = $entity;
    }

    function setSubjectId($subjectId) {
        $this->subjectId = $subjectId;
    }

    function setCategoryAssessId($categoryAssessId) {
        $this->categoryAssessId = $categoryAssessId;
    }

    function setCategoryAssessParentId($categoryAssessParentId) {
        $this->categoryAssessParentId = $categoryAssessParentId;
    }


}
