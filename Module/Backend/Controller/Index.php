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

use \Module\Component\Language;

/**
 * 后台主页
 * @authName 后台主页
 * @authDescription 后台主页 登录 退出
 */
class Index extends \H1Soft\H\Web\Controller {

    public function init() {
        Language::getInstance()->load('backend/index')->load('backend/common');
        foreach (Language::getInstance()->data as $key => $value) {
            $this->assign($key, $value);
        }
    }

    public function indexAction() {
        $this->isAdmin();
        
        $this->assign('pageTitle', "Administrator");

        //php info
        $this->assign('PHP_VERSION', PHP_VERSION);
        $this->assign('UPLOAD_MAX_FILESIZE', ini_get('upload_max_filesize'));

        //version
        $this->assign('HVERSION', HVERSION);
        $this->assign('H1CART', H1CART);

        //check db        
        $this->assign('MYSQLI', function_exists('mysqli_connect'));

        //gd info
        $this->assign('GD_INFO', gd_info());
        $this->assign('GD_IMGTYPE', $this->getSupportedImageTypes());

        $this->render('admin/index');
    }

    /**
     * @skipAuth
     */
    function logoutAction() {
        \H1Soft\H\Web\Auth::getInstance()->logout();
        $this->redirect('index/login');
    }

    /**
     * @skipAuth
     */
    function loginAction() {
        $auth = \H1Soft\H\Web\Auth::getInstance();

        if ($this->isPost()) {
            $username = $this->post('username');
            $password = $this->post('password');

            if ($auth->login($username, $password)) {
//                $this->setFlashMessage("登录成功");
                $this->assign('lflag', 0);

                $this->redirect('index/index');
            } else {                
                $this->showFlashMessage(Language::getInstance()->get('_login_error'));
            }
        }
        $this->render('admin/login');
    }

    private function getSupportedImageTypes() {
        $aSupportedTypes = array();

        $aPossibleImageTypeBits = array(
            IMG_GIF => 'GIF',
            IMG_JPG => 'JPG',
            IMG_PNG => 'PNG',
            IMG_WBMP => 'WBMP'
        );

        foreach ($aPossibleImageTypeBits as $iImageTypeBits => $sImageTypeString) {
            if (imagetypes() & $iImageTypeBits) {
                $aSupportedTypes[] = $sImageTypeString;
            }
        }

        return $aSupportedTypes;
    }

}
