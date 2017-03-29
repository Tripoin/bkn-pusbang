<?php
/**
 * Created by PhpStorm.
 * User: Dayat
 * Date: 29/03/2017
 * Time: 2:15
 */

namespace app\Model;

use app\Model\GeneralAuditrail;

class MasterCategoryAssess extends GeneralAuditrail
{

    public function __construct() {
        $this->setEntity('mst_category_assess');
    }

    public $parentId = 'parent_id';

    /**
     * @return string
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @param string $parentId
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
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