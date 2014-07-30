<?php

/*
 * This file is part of the H1Cart package.
 * (w) http://www.h1cart.com
 * (c) Allen Niu <h@h1soft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Module\Backend\Controller;

/**
 * 店铺设置
 */
class Setting extends AdminController {

    public function before() {
        $this->language('backend/setting');
    }
    
    public function indexAction() {
        if ($this->isPost()) {
            \Module\Component\Setting::getInstance()->save('system', $this->post('system'));
            \Module\Component\Setting::getInstance()->save('mail', $this->post('mail'));

            $this->showFlashMessage($this->lang('_success'), H_SUCCESS);
        }
        //System
        $this->assign('themes', $this->listDir(\H1Soft\H\Web\Application::$rootPath . 'themes/'));
        $this->assign('system', \Module\Component\Setting::getInstance()->group('system'));
        $this->assign('mail', \Module\Component\Setting::getInstance()->group('mail'));        
        //Language
        $this->assign('langs', $this->db()->get('lang'));
        
        $this->render('admin/setting/index');
    }

    private function listDir($dir) {        
        if (!file_exists($dir) || !is_dir($dir)) {
            return '';
        }
        $dirPath = $dir;
        $dirList = array();
        $dir = opendir($dir);
        while (false !== ($file = readdir($dir))) {
            if ($file !== '.' && $file !== '..' && is_dir($dirPath . $file)) {
                $dirList[] = $file;
            }
        }
        closedir($dir);
        return $dirList;
    }

}
