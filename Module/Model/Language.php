<?php

namespace Module\Model;

class Language extends \H1Soft\H\Web\Model {
    
    public function getLanguages($data = array()) {

        if (isset($data['offset']) || isset($data['pagesize'])) {
            if ($data['offset'] < 0) {
                $data['offset'] = 0;
            }

            if ($data['pagesize'] < 1) {
                $data['pagesize'] = 20;
            }

            $this->db()->limit($data['pagesize'], $data['offset']);
        }
        $result = $this->db()->get('lang');
        return $result;
    }

}
