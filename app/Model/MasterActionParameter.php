<?php

/**
 * Description of MasterPost
 *
 * @author sfandrianah
 */

namespace app\Model;

use app\Model\GeneralAuditrail;

class MasterActionParameter extends GeneralAuditrail {

    public function __construct() {
        $this->setEntity('mst_action_parameter');
    }
}
