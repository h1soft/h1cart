<?php

/*
 * This file is part of the H1Cart package.
 * (w) http://www.h1cart.com
 * (c) Allen Niu <h@h1soft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Module\Component;

/**
 * 系统配置
 *
 * @author Allen Niu <h@h1soft.net>
 */
class Setting extends \H1Soft\H\Singleton {

    private $db;
    
    private $setting = array();

    public function init() {
        $this->db = \H1Soft\H\Db\Db::getConnection();
    }

    public function load($group_name, $store_id = 0){
        $settings = $this->db->where('group',$group_name)->where('store_id', $store_id)->get('setting');
        foreach($settings as $value){
            $this->setting[$value['group']][$value['key']] = $value['value'];
        }        
    }
    
    public function get($key){
        
    }
}
