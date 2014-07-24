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

class AdminController extends \H1Soft\H\Web\Controller {

    private $breadcrumbs = array();

    public function init() {
        parent::init();
        $this->isAdmin();
        \H1Soft\H\Web\Config::set('view.theme', 'default');
        $this->loadLang('backend/common');
    }

    public function setTitle($_title) {
        $this->assign('pageTitle', $_title);
    }

    public function addBreadcrumbs($_name, $_link) {
        $this->breadcrumbs[] = array('name' => $_name, 'link' => $_link);
    }

    /**
     * 
     * @param type $_key
     * @return string
     */
    public function lang($_key) {
        return Language::getInstance()->get($_key);
    }

    /**
     * 
     * @param type $filename
     * @param type $autoset
     * @return \Module\Backend\Controller\AdminController
     */
    public function loadLang($filename, $autoset = true) {
        if ($autoset) {
            $langs = Language::getInstance()->load($filename);
            foreach ($langs as $key => $value) {
                $this->assign($key, $value);
            }
        } else {
            Language::getInstance()->load($filename);
        }
        return $this;
    }

    public function language($filename) {
        Language::getInstance()->load($filename);
        foreach (Language::getInstance()->data as $key => $value) {
            $this->assign($key, $value);
        }
        return $this;
    }

    public function render($tplFileName = false, $data = true, $output = true) {
        $this->assign('breadcrumbs', $this->breadcrumbs);
        parent::render($tplFileName, $data, $output);
    }

}
