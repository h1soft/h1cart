<?php

namespace Module\Model;

/**
 * 分类
 *
 * @author Allen Niu <h@h1soft.net>
 */
class Category extends \H1Soft\H\Web\Model {

    private $currentCategoryId;

    public function getCategories($data) {
        $tbname = $this->db()->tb_name('category');
        $sql = "SELECT node.*, (COUNT(parent.category_id) - 1) AS depth "
                . "FROM $tbname AS node,$tbname AS parent "
                . "WHERE node.left_id BETWEEN parent.left_id AND parent.right_id AND parent.status=1";

        if (!empty($data['filter_name'])) {
            $sql .= " AND node.image LIKE '" . $this->db()->escape($data['filter_name']) . "%'";
        }

        $sql .= " GROUP BY node.category_id ORDER BY node.left_id";

        if (isset($data['offset']) || isset($data['pagesize'])) {
            if ($data['offset'] < 0) {
                $data['offset'] = 0;
            }

            if ($data['pagesize'] < 1) {
                $data['pagesize'] = 20;
            }

            $sql .= " LIMIT " . (int) $data['offset'] . "," . (int) $data['pagesize'];
        }
        $result = $this->db()->query($sql);

        return $result;
    }

    public function getCategory($data = array()) {
        $tbname = $this->db()->tb_name('category');
        $sql = "SELECT node.*,cl.name AS name, (COUNT(parent.category_id) - 1) AS depth "
                . "FROM $tbname AS node,$tbname AS parent,h_category_lang as cl "
                . "WHERE node.left_id BETWEEN parent.left_id AND parent.right_id AND node.category_id=cl.category_id AND parent.status=1";
        $lang_id = \Module\Component\Setting::getInstance()->get('system.admin_language');
        if ($lang_id) {
            $sql .= " AND cl.language_id=$lang_id ";
        }
        if (!empty($data['filter_name'])) {
            $sql .= " AND node.image LIKE '" . $this->db()->escape($data['filter_name']) . "%'";
        }

        $sql .= " GROUP BY node.category_id ";
        if (isset($data['depth'])) {
            $sql .= " HAVING depth >= {$data['depth']} ";
        }
        $sql .= " ORDER BY node.left_id";

        if (isset($data['offset']) || isset($data['pagesize'])) {
            if ($data['offset'] < 0) {
                $data['offset'] = 0;
            }

            if ($data['pagesize'] < 1) {
                $data['pagesize'] = 20;
            }

            $sql .= " LIMIT " . (int) $data['offset'] . "," . (int) $data['pagesize'];
        }

        $result = $this->db()->query($sql);

        return $result;
    }

    /**
     * 获取分类总数
     * @param type $data
     * @return int
     */
    public function getTotalCategory($data = array()) {
        $tbname = $this->db()->tb_name('category');
        $sql = "SELECT count(node.category_id) as total "
                . "FROM $tbname AS node "
                . "WHERE node.status=1";

        if (!empty($data['filter_name'])) {
            $sql .= " AND node.image LIKE '" . $this->db()->escape($data['filter_name']) . "%'";
        }


        $result = $this->db()->getRow($sql);
        if ($result) {
            return $result['total'];
        }
        return 0;
    }

    public function addCategory($data) {
        if ($data['category_id'] == 0) {
            $LeftId = 0;
            $RightId = 1;
        } else {
            $row = $this->checkCategory($data['category_id']);
//            print_r($row);die;
            //取得父类的左值,右值 
            $LeftId = $row['left_id'];
            $RightId = $row['right_id'];
            $this->db()->exec("UPDATE `" . $this->db()->tb_name('category') . "` SET `left_id`=`left_id`+2 WHERE `left_id`>$RightId");
            $this->db()->exec("UPDATE `" . $this->db()->tb_name('category') . "` SET `right_id`=`right_id`+2 WHERE `right_id`>=$RightId");
        }
        if (!isset($data['sort_order'])) {
            $data['sort_order'] = 0;
        }
        if (!isset($data['image'])) {
            $data['image'] = '';
        }
        if ($this->db()->exec("INSERT INTO `" . $this->db()->tb_name('category') . "` SET `left_id`='$RightId',`right_id`='$RightId'+1,`sort_order`='" . $data['sort_order'] . "',`parent_id`='" . $data['category_id'] . "',`image`='" . $data['image'] . "',`created_at`='" . time() . "',`updated_at`='" . time() . "'")) {
            return $this->db()->lastId();
        } else {
            return false;
        }
    }

    public function updateCategory($category_id, $data) {
        $category = $this->checkCategory($category_id);
        if ($category['parent_id'] != $data['parent_id']) {
            //移动分类
            $this->moveCategory($category_id, $data['parent_id']);
        }
        if ($this->db()->exec("UPDATE `" . $this->db()->tb_name('category') . "` SET `sort_order`='" . $data['sort_order'] . "',`parent_id`='" . $data['parent_id'] . "',`image`='" . $data['image'] . "',`updated_at`='" . time() . "' WHERE category_id=$category_id")) {
            return $this->db()->affected_rows();
        } else {
            return false;
        }
    }
    /**
     * 添加分类 语言
     * @param type $category_id
     * @param type $lang_id
     * @param type $data
     */
    public function addCategoryLang($category_id, $lang_id, $data) {
        $this->db()->insert('category_lang', array(
            'category_id' => $category_id,
            'language_id' => $lang_id,
            'name' => $data['name'],
            'description' => $data['description'],
            'meta_description' => $data['meta_tag_description'],
            'meta_keyword' => $data['meta_tag_keywords']
        ));
    }
    public function updateCategoryLang($category_id, $lang_id, $data) {
        $this->db()->update('category_lang', array(            
            'name' => $data['name'],
            'description' => $data['description'],
            'meta_description' => $data['meta_tag_description'],
            'meta_keyword' => $data['meta_tag_keywords']
        ),array(
            'category_id' => $category_id,
            'language_id' => $lang_id,
        ));
    }

    /**
     * 
     * @param int $category_id
     * @return type
     */
    function checkCategory($category_id) {
        $row = $this->db()->getOne('category', "category_id=$category_id");

        if (!$row) {
            throw new Exception("Add Category category_id=$category_id not found");
        }
        return $row;
    }

    public function getRoot() {
        $row = $this->db()->order_by('left_id', 'ASC')->limit(1)->get('category');
        if (!$row) {
            return NULL;
        }
        return $row;
    }

    public function getRootId() {
        $row = $this->db()->order_by('left_id', 'ASC')->limit(1)->get('category');
        if (!$row) {
            return 0;
        }
        return $row['category_id'];
    }

    /**
     * 删除分类
     * @param type $category_id
     * @return boolean
     */
    function removeCategory($category_id) {
        $row = $this->checkCategory($category_id);
        $left_id = $row['left_id'];
        $right_id = $row['right_id'];
        if ($this->db()->exec("DELETE FROM `" . $this->db()->tb_name('category') . "` WHERE `left_id`>=$left_id AND `right_id`<=$right_id")) {
            $Value = $right_id - $left_id + 1;
            //更新左右值 
            $this->db()->exec("UPDATE `" . $this->db()->tb_name('category') . "` SET `left_id`=`left_id`-$Value WHERE `left_id`>$left_id");
            $this->db()->exec("UPDATE `" . $this->db()->tb_name('category') . "` SET `right_id`=`right_id`-$Value WHERE `right_id`>$right_id");
            return true;
        } else {
            return false;
        }
    }

    /**
     * 移动分类
     * @param int $category_id 当前类
     * @param int $parent_id 新的父类
     * @return boolean
     */
    function moveCategory($category_id, $parent_id) {
        $category = $this->checkCategory($category_id);
        $parentCategory = $this->checkCategory($parent_id);


        $left_id = $category['left_id'];
        $right_id = $category['right_id'];
        $rl_value = $right_id - $left_id;


        $category_list = $this->getCategoryById($category_id, 2);
        $category_ids = array();
        foreach ($category_list as $value) {
            $category_ids[] = $value['category_id'];
        }
        $cat_ids = implode(',', $category_ids);


//        $parentLeft = $parentCategory['left_id'];
        $parentRight = $parentCategory['right_id'];

        if ($parentRight > $right_id) {
            $updateLeftSQL = "UPDATE `" . $this->db()->tb_name('category') . "` SET `left_id`=`left_id`-$rl_value-1 WHERE `left_id`>$right_id AND `right_id`<=$parentRight";
            $updateRightSQL = "UPDATE `" . $this->db()->tb_name('category') . "` SET `right_id`=`right_id`-$rl_value-1 WHERE `right_id`>$right_id AND `right_id`<$parentRight";
            $pr_val = $parentRight - $right_id - 1;
            $updateSelfSQL = "UPDATE `" . $this->db()->tb_name('category') . "` SET `left_id`=`left_id`+$pr_val,`right_id`=`right_id`+$pr_val WHERE `category_id` IN($cat_ids)";
        } else {
            $updateLeftSQL = "UPDATE `" . $this->db()->tb_name('category') . "` SET `left_id`=`left_id`+$rl_value+1 WHERE `left_id`>$parentRight AND `left_id`<$left_id";
            $updateRightSQL = "UPDATE `" . $this->db()->tb_name('category') . "` SET `right_id`=`right_id`+$rl_value+1 WHERE `right_id`>=$parentRight AND `right_id`<$left_id";
            $pr_val = $left_id - $parentRight;
            $updateSelfSQL = "UPDATE `" . $this->db()->tb_name('category') . "` SET `left_id`=`left_id`-$pr_val,`right_id`=`right_id`-$pr_val WHERE `category_id` IN($cat_ids)";
        }
        $this->db()->exec($updateLeftSQL);
        $this->db()->exec($updateRightSQL);
        $this->db()->exec($updateSelfSQL);
        return true;
    }

// end func 

    /**
     * 根据ID获取分类
     * @param type $id
     * @param int $type  0 当前分类   
     * @return type
     */
    public function getCategoryById($id, $type = 0) {
        $category = $this->checkCategory($id);
        if ($type == 0) {
            return $category;
        }
        $left_id = $category['left_id'];
        $right_id = $category['right_id'];
        $sql = "SELECT * FROM `" . $this->db()->tb_name('category') . "` WHERE ";
        switch ($type) {
            case 1://1=所有子类,不包含自己
                $condition = "`left_id`>$left_id AND `right_id`<$right_id";
                break;
            case 2://2包含自己的所有子类
                $condition = "`left_id`>=$left_id AND `right_id`<=$right_id";
                break;
            case 3://3不包含自己所有父类
                $condition = "`left_id`<$left_id AND `right_id`>$right_id";
                break;
            case 4://4包含自己所有父类 
                $condition = "`left_id`<=$left_id AND `right_id`>=$right_id";
                break;
            default ://所有子类,不包含自己
                $condition = "`left_id`>$left_id AND `right_id`<$right_id";
                ;
        }
        $sql.= $condition . " ORDER BY `left_id` ASC";

        return $this->db()->query($sql);
    }

    /**
     * 获取分类语言
     * @param type $category_id
     * @return type
     */
    public function getCategoryLangs($category_id) {
        $category_langs = $this->db()->where('category_id', $category_id)->get('category_lang');
        $result = array();
        foreach ($category_langs as $lang) {
            $result[$lang['language_id']] = $lang;
        }
        return $result;
    }

    function getTree($data, $pId) {
        $tree = array();
        foreach ($data as $k => $v) {
            if ($v['parent_id'] == $pId) {
                $v['parent_id'] = $this->getTree($data, $v['category_id']);
                $tree[] = $v;
            }
        }
        return $tree;
    }

    function dataToHtml($tree) {
        $html = '';
        foreach ($tree as $t) {
            if ($t['cate_ParentId'] == '') {
                $html .= "<li>{$t['cate_Name']}</li>";
            } else {
                $html .= "<li>" . $t['cate_Name'];
                $html .= $this->dataToHtml($t['cate_ParentId']);
                $html = $html . "</li>";
            }
        }
        return $html ? '<ul>' . $html . '</ul>' : $html;
    }

    public function getULTree($data, $pId) {
        $html = '';
        foreach ($data as $v) {
            if ($v['parent_id'] == $pId) {
                $html .= "<li id='node_" . $v['category_id'] . "' data-id='" . $v['category_id'] . "'>" . $v['name'];
                $html .= $this->getULTree($data, $v['category_id']);
                $html = $html . "</li>";
            }
        }
        return $html ? '<ul>' . $html . '</ul>' : $html;
    }

    public function setCurrentCategoryId($category_id) {
        $this->currentCategoryId = $category_id;
        return $this;
    }

    /*
      顺序显示
      SELECT node.image
      FROM h_category AS node,
      h_category AS parent
      WHERE node.left_id BETWEEN parent.left_id AND parent.right_id
      AND parent.category_id = 1
      ORDER BY node.left_id;
     * 
     */

    /**
     * ok
     */
    /*
     * 
      SELECT node.image, (COUNT(parent.image) - 1) AS depth
      FROM h_category AS node,
      h_category AS parent
      WHERE node.left_id BETWEEN parent.left_id AND parent.right_id
      GROUP BY node.image
      ORDER BY node.left_id;
     */
}
