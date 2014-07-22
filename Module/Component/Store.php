<?php

namespace Module\Component;

/**
 * 店铺
 *
 * @author Allen Niu <h@h1soft.net>
 */
class Store extends \H1Soft\H\Singleton {

    private $currentDomain;
    private $store;

    public function init() {
        $this->db = \H1Soft\H\Db\Db::getConnection();
        $this->currentDomain = trim($_SERVER['SERVER_NAME'], 'www.');
        //查询当前域名的配置        
        $stores = $this->db->where('domain', $this->currentDomain)->get('store');
        if (!$stores) {
            Setting::getInstance()->load('system');
            $this->store = array(
                'store_id' => 0,
                'name' => '',
                'domain' => $this->currentDomain
            );
        } else {
            if (isset($stores[0])) {
                Setting::getInstance()->load('system',$stores[0]['store_id']);
                $this->store = array(
                    'store_id' => $stores[0]['store_id'],
                    'name' => $stores[0]['name'],
                    'domain' => $stores[0]['domain'],
                );
            }else{
                die('Store Not Found');
            }
        }
    }
    
    public function getStoreId() {
        return $this->store['store_id'];
    }

}
