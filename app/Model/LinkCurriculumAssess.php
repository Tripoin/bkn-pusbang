<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Model;

/**
 * Description of LinkCurriculumAssess
 *
 * @author sfandrianah
 */
class LinkCurriculumAssess {
    //put your code here
    
    private $entity = 'link_curriculum_assess';
    private $curriculumId = 'curriculum_id';
    private $categoryAssessId = 'category_assess_id';
    
    public function getEntity() {
        return $this->entity;
    }

    public function getCurriculumId() {
        return $this->curriculumId;
    }

    public function getCategoryAssessId() {
        return $this->categoryAssessId;
    }

    public function setEntity($entity) {
        $this->entity = $entity;
    }

    public function setCurriculumId($curriculumId) {
        $this->curriculumId = $curriculumId;
    }

    public function setCategoryAssessId($categoryAssessId) {
        $this->categoryAssessId = $categoryAssessId;
    }



}
