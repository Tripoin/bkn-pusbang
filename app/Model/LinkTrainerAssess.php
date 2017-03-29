<?php
/**
 * Created by PhpStorm.
 * User: Dayat
 * Date: 29/03/2017
 * Time: 1:39
 */

namespace app\Model;


class LinkTrainerAssess
{
    /**
     * LinkTrainerAssess constructor.
     */
    public function __construct(){

    }

    public $entity = 'link_trainer_assess';

    public $curriculumId = 'curriculum_id';
    public $categoryAssessId = 'category_assess_id';

    /**
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param string $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return string
     */
    public function getCurriculumId()
    {
        return $this->curriculumId;
    }

    /**
     * @param string $curriculumId
     */
    public function setCurriculumId($curriculumId)
    {
        $this->curriculumId = $curriculumId;
    }

    /**
     * @return string
     */
    public function getCategoryAssessId()
    {
        return $this->categoryAssessId;
    }

    /**
     * @param string $categoryAssessId
     */
    public function setCategoryAssessId($categoryAssessId)
    {
        $this->categoryAssessId = $categoryAssessId;
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