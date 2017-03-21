<?php
/**
 * Description of MasterPost
 *
 * @author sfandrianah
 */
namespace app\Model;
use app\Model\Auditrail;
class MasterSystemParameter extends Auditrail{

    private $filename = 'master-system-parameter';
    private $entity = 'mst_system_parameter';
    private $id = 'id';
    private $code = 'code';
    private $name = 'name';
    
    
    function getFilename() {
        return $this->filename;
    }

    function getEntity() {
        return $this->entity;
    }

    function getId() {
        return $this->id;
    }

    function getCode() {
        return $this->code;
    }

    function getName() {
        return $this->name;
    }

    function setFilename($filename) {
        $this->filename = $filename;
    }

    function setEntity($entity) {
        $this->entity = $entity;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function setName($name) {
        $this->name = $name;
    }



}
