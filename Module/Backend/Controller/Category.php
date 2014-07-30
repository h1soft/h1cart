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

class Category extends AdminController {

    public function before() {
        parent::before();
        $this->language('backend/category');
        $this->addBreadcrumbs($this->lang('_catalog'), "#");
        //Breadcrumbs
        $this->addBreadcrumbs($this->lang('_pageTitle'), url_for('category/index'));
    }

    public function indexAction() {
        $setting = \Module\Component\Setting::getInstance();
        
        $this->saveUrlRef();
        //Total
        $total = \Module\Model\Category::model()->getTotalCategory();
        //Pagination
        $page = new \Module\Component\Pagination($total, $this->get('page', 1), $setting->get('system.admin_item_pre_page'));
        //Category List
        $category = \Module\Model\Category::model()->getCategory(array('offset' => $page->getOffset(), 'pagesize' => $page->getPageSize(), 'depth' => 1));

        $this->assign('page', $page);
        $this->assign('category', $category);


        $this->render('admin/category/index');
    }

    public function addAction() {
        $langs = \Module\Model\Language::getInstance()->getLanguages();
        if ($this->isPost()) {
            $items = $this->post('category');
            $items['parent_id'] = intval($items['parent_id']);
            if ($this->validate($langs)) {
                $model = \Module\Model\Category::getInstance();
                $category_id = $model->addCategory(array(
                    'sort_order' => intval($items['sort_order']),
                    'category_id' => intval($items['parent_id']),
                    'image' => $items['image']
                ));
                foreach ($langs as $lang) {
                    $item = $items[$lang['id']];
                    $model->addCategoryLang($category_id, $lang['id'], $item);
                }
                $this->showFlashMessage($this->lang('_success'), H_SUCCESS);
            }
        }


        $category = \Module\Model\Category::model()->getCategory();
        $this->assign('categoryTree', \Module\Model\Category::model()->getULTree($category, 0));
        $this->assign('category', $category);
        $this->assign('languages', $langs);
        $this->render('admin/category/form');
    }

    public function editAction() {
        $langs = \Module\Model\Language::getInstance()->getLanguages();
        $category_id = intval($this->get('id'));
        if ($this->isPost()) {
            $items = $this->post('category');
            $items['parent_id'] = intval($items['parent_id']);
            if ($this->validate($langs)) {
                $model = \Module\Model\Category::getInstance();
                $model->updateCategory($category_id,$items);
                foreach ($langs as $lang) {
                    $item = $items[$lang['id']];
                    $model->updateCategoryLang($category_id, $lang['id'], $item);
                }
                $this->showFlashMessage($this->lang('_success'), H_SUCCESS);
            }
        }

        $this->assign('category_id', $category_id);

        //Category Description Lang
        $this->assign('langs', \Module\Model\Category::model()->getCategoryLangs($category_id));

        //Category Tree
        $category = \Module\Model\Category::model()->getCategory();
        $this->assign('categoryTree', \Module\Model\Category::model()->setCurrentCategoryId($category_id)->getULTree($category, 0));

        $this->assign('category', \Module\Model\Category::model()->getCategoryById($category_id));
        $this->assign('allSubCategory', \Module\Model\Category::model()->getCategoryById($category_id,1));

        $this->assign('languages', $langs);
        $this->render('admin/category/form');
    }

    public function removeAction() {
        $category_id = $this->get('id');
        if($category_id){
            $this->db()->delete('category', " category_id=$category_id");
        }
        $this->showFlashMessage($this->lang('_success'), H_SUCCESS, $this->urlRef());
    }

    public function remoteAction() {

        $category = \Module\Model\Category::model()->getCategory(array('filter_name' => $_GET['term'], 'pagesize' => 20, 'offset' => 0));
        $result = array();
        foreach ($category as $row) {
            $result[] = array(
                'value' => $row['cat_path'],
                'depth' => $row['depth'],
                'id' => $row['category_id']
            );
        }
        echo json_encode($result);
    }

    private function validate($langs) {
        $items = $this->post('category');
        if (empty($items['parent_id'])) {
            $this->setFlashMessage($this->lang('_parent_id_error'), H_ERROR);
        }        
        foreach ($langs as $lang) {
            $item = $items[$lang['id']];
            if (empty($item['name'])) {
                $this->setFlashMessage($this->lang('_category_name_error'), H_ERROR);
                return false;
            }
        }
        return true;
    }

}
