<?php

/*
 * This file is part of the H1Cart package.
 * (w) http://www.h1cart.com
 * (c) Allen Niu <h@h1soft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Module\Product\Controller;

class AdminProduct extends \Module\Backend\Controller\AdminController {

    public function before() {
        parent::before();
        $this->language('product/admin_product');
        //Breadcrumbs
        $this->addBreadcrumbs($this->lang('_catalog'), "#");
        $this->addBreadcrumbs($this->lang('_pageTitle'), url_for('options/index'));
    }

    public function indexAction() {
        $setting = \Module\Component\Setting::getInstance();

        $this->saveUrlRef();
        //Total
        $total = \Module\Model\Option::model()->getTotalOptions();
        //Pagination
        $page = new \Module\Component\Pagination($total, $this->get('page', 1), $setting->get('system.admin_item_pre_page'));
        //Category List
        $options = \Module\Model\Option::model()->getOptions(array('offset' => $page->getOffset(), 'pagesize' => $page->getPageSize()));

        $this->assign('page', $page);
        $this->assign('options', $options);


        $this->render('admin/options/index');
    }

    public function addAction() {
        $langs = \Module\Model\Language::getInstance()->getLanguages();
        if ($this->isPost()) {
            if ($this->validate($langs)) {
                $model = \Module\Model\Option::getInstance();
                $model->addOption();
                $this->showFlashMessage($this->lang('_success'), H_SUCCESS);
            }
        }

        $this->assign('languages', $langs);
        $this->render('admin/options/form');
    }

    public function editAction() {
        $langs = \Module\Model\Language::getInstance()->getLanguages();
        $option_id = intval($this->get('id'));
        if ($this->isPost()) {
            if ($this->validate($langs)) {
                $model = \Module\Model\Option::getInstance();
                $model->saveOption();
                $this->showFlashMessage($this->lang('_success'), H_SUCCESS);
            }
        }

        $this->assign('option_id', $option_id);
        //获取option名称
        $this->assign('option', \Module\Model\Option::model()->getOption($option_id));
        $this->assign('option_description', \Module\Model\Option::model()->getOptionDescriptions($option_id));
        //获取Option值        

        $option_value_list = \Module\Model\Option::model()->getOptionValueDescriptions($option_id);
        $option_values = array();

        foreach ($option_value_list as $option_value) {
            $option_values[] = array(
                'option_value_id' => $option_value['option_value_id'],
                'option_value_description' => $option_value['option_value_description'],
                'image' => $option_value['image'],
                'thumb' => '',
                'sort_order' => $option_value['sort_order']
            );
        }
        $this->assign('option_values', $option_values);


        $this->assign('languages', $langs);
        $this->render('admin/options/form');
    }

    public function removeAction() {
        $option_id = $this->get('id');
        if ($option_id) {
            \Module\Model\Option::getInstance()->deleteOption($option_id);
        }
        $this->showFlashMessage($this->lang('_success'), H_SUCCESS, $this->urlRef());
    }

    

    private function validate($langs) {
        $option_names = $this->post('option');

        //Check Option Name
        foreach ($langs as $lang) {
            $item = $option_names[$lang['id']];
            if (empty($item['name'])) {
                $this->setFlashMessage($this->lang('_option_name_error'), H_ERROR);
                return false;
            }
        }

        $option_values = $this->post('option_value', array());
        foreach ($option_values as $item) {
            $option_value_desc_langs = $item['option_value_description'];
            foreach ($langs as $lang) {
                $item = $option_value_desc_langs[$lang['id']];
                if (empty($item['name'])) {
                    $this->setFlashMessage($this->lang('_error_option_value'), H_ERROR);
                    return false;
                }
            }
        }
        return true;
    }

}
