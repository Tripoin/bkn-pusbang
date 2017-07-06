<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Model;

/**
 * Description of LinkSubjectRequirements
 *
 * @author sfandrianah
 */
class LinkSubjectRequirements {
    //put your code here
    
    private $entity = 'link_subject_requirements';
    private $subjectId = 'subject_id';
    private $subjectRequirementsId = 'subject_requirements_id';
    
    public function getEntity() {
        return $this->entity;
    }

    public function getSubjectId() {
        return $this->subjectId;
    }

    public function getSubjectRequirementsId() {
        return $this->subjectRequirementsId;
    }

    public function setEntity($entity) {
        $this->entity = $entity;
    }

    public function setSubjectId($subjectId) {
        $this->subjectId = $subjectId;
    }

    public function setSubjectRequirementsId($subjectRequirementsId) {
        $this->subjectRequirementsId = $subjectRequirementsId;
    }



}
