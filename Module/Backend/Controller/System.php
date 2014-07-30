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

class System extends AdminController {    
    
    public function before() {
        parent::before();
        $this->language('backend/system');
    }

    public function indexAction() {
        $this->assign('backupList', \Module\Component\Database::getInstance()->getBackupList());
        $this->saveUrlRef();
        $this->render('admin/system/index');
    }

    public function backupAction() {
        \Module\Component\Database::getInstance()->backup();
        $this->showFlashMessage($this->lang('_success'), H_SUCCESS,  $this->urlRef());
    }

    public function backupremoveAction() {
        $file = \H1Soft\H\Web\Application::$varPath .'/backup/'.$this->get('file');
        if(is_file($file)){
            @unlink($file);
        }        
        $this->showFlashMessage($this->lang('_success'), H_SUCCESS,  $this->urlRef());
    }
    public function restoreAction() {
        
    }


   

}
