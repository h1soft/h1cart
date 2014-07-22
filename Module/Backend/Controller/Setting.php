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
 * 店铺设置
 */
class Setting extends \H1Soft\H\Web\Controller {

    public function init() {
        Language::getInstance()->load('backend/account')->load('backend/common');
        foreach (Language::getInstance()->data as $key => $value) {
            $this->assign($key, $value);
        }
    }

    public function settingAction() {
        $this->isAdmin();
        $this->assign('menu_setting', 1);
        $this->assign('pageTitle', "Account Setting");
        $adminHelper = new \Module\Backend\Helper\Account();
        $auth = \H1Soft\H\Web\Auth::getInstance();
        $admin = $adminHelper->getAccount($auth->getId());
        if ($this->isPost()) {
            $username = $this->post('username');
            $oldpasswd = $this->post('oldpasswd');
            $newpasswd = $this->post('newpasswd');
            $renewpasswd = $this->post('renewpasswd');
            if ($oldpasswd && \H1Soft\H\Utils\Crypt::password($oldpasswd) != $admin['password']) {
                $this->showFlashMessage(Language::getInstance()->get('_error_old_password'));
            } else if (strlen($newpasswd) < 6) {
                $this->showFlashMessage(Language::getInstance()->get('_error_password_less6'));
            } else if ($newpasswd != $renewpasswd) {
                $this->showFlashMessage(Language::getInstance()->get('_error_new_password_neq'));
            } else {
                $admin['password'] = \H1Soft\H\Utils\Crypt::password($newpasswd);
            }



            if ($auth->getName() != $username) {
                //check user
                if ($adminHelper->checkUsername($username)) {
                    $this->showFlashMessage(Language::getInstance()->get('_error_username_already_exists'));
                } else if (strlen($username) < 3) {
                    $this->showFlashMessage(Language::getInstance()->get('_error_username_cs3char'));
                } else {
                    $admin['username'] = $username;
                }
            }

            //更新
            $this->db()->update('admin', $admin, "id='{$auth->getId()}'");
            $this->showFlashMessage(Language::getInstance()->get('_success'), H_SUCCESS);
        }

        $this->render('admin/account/setting', array('item' => $admin));
    }

}
