<?php

namespace Module\Model;

/**
 * 属性
 *
 * @author Allen Niu <h@h1soft.net>
 */
class Option extends \H1Soft\H\Web\Model {

    public function getOptions($data) {
        $tbname_option = $this->db()->tb_name('option');
        $tbname_option_description = $this->db()->tb_name('option_description');
        //Current LanguageID
        $lang_id = \Module\Component\Setting::getInstance()->get('system.admin_language');

        $sql = "SELECT * FROM `$tbname_option` o  LEFT JOIN `$tbname_option_description` od "
                . " ON (o.option_id = od.option_id) "
                . "WHERE od.language_id = '$lang_id'";
        if (!empty($data['filter_name'])) {
            $sql .= " AND od.name LIKE '" . $this->db()->escape($data['filter_name']) . "%'";
        }

        $sort_data = array(
            'od.name',
            'o.type',
            'o.sort_order'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY od.name";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

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
     * 获取Option总行数
     * @param type $data
     * @return int
     */
    public function getTotalOptions() {
        return $this->db()->select("COUNT(*) AS total")->scalar('option', 0);
    }

    /**
     * 添加属性
     */
    public function addOption() {
        $option = $_POST['option'];
        $option_values = $_POST['option_value'];
        $option_input_type = $_POST['input_type'];
        $option_sort_order = intval($_POST['sort_order']);

        //Insert Input Type
        $this->db()->insert('option', array('type' => $option_input_type, 'sort_order' => $option_sort_order));
        $option_id = $this->db()->lastId();

        //保存option_description
        foreach ($option as $lang_id => $value) {
            $this->db()->insert('option_description', array(
                'option_id' => $option_id,
                'language_id' => $lang_id,
                'name' => $value['name']
            ));
        }

        //保存option value
        if (is_array($option_values)) {
            foreach ($option_values as $option) {
                $option_value_description = $option['option_value_description'];
                $this->db()->insert('option_value', array(
                    'option_id' => $option_id,
                    'image' => '',
                    'sort_order' => $option['sort_order']
                ));
                $option_value_id = $this->db()->lastId();
                foreach ($option_value_description as $lang_id => $value) {
                    $this->db()->insert('option_value_description', array(
                        'option_value_id' => $option_value_id,
                        'option_id' => $option_id,
                        'language_id' => $lang_id,
                        'name' => $value['name']
                    ));
                }
            }
        }
    }

    public function saveOption() {
        $req = \H1Soft\H\Web\Application::request();
        $option_id = intval($_POST['option_id']);
        $option = $_POST['option'];
        $option_values = $req->post('option_value');
//        print_r($option_values);
        $option_input_type = $req->post('input_type');
        $option_sort_order = $req->post('sort_order',0);
        //更新option
        $this->db()->update('option', array('type' => $option_input_type, 'sort_order' => $option_sort_order), array(
            'option_id' => $option_id
        ));

        $this->db()->delete('option_description', array('option_id' => $option_id));
        //保存option_description
        foreach ($option as $lang_id => $value) {
            $this->db()->insert('option_description', array(
                'option_id' => $option_id,
                'language_id' => $lang_id,
                'name' => $value['name']
            ));
        }

        $this->db()->delete('option_value', array('option_id' => $option_id));
        $this->db()->delete('option_value_description', array('option_id' => $option_id));

        if (is_array($option_values)) {
            foreach ($option_values as $option) {
                $option_value_description = $option['option_value_description'];
                $this->db()->insert('option_value', array(
                    'option_id' => $option_id,
                    'image' => $option['image'],
                    'sort_order' => $option['sort_order']
                ));
//                echo $this->db()->last_query();
                $option_value_id = $this->db()->lastId();
                foreach ($option_value_description as $lang_id => $value) {
                    $this->db()->insert('option_value_description', array(
                        'option_value_id' => $option_value_id,
                        'option_id' => $option_id,
                        'language_id' => $lang_id,
                        'name' => $value['name']
                    ));
                }
            }
        }
    }

    /**
     * 删除属性
     * @param type $option_id
     */
    public function deleteOption($option_id) {
        $this->db()->delete('option', "option_id=$option_id");
        echo $this->db()->last_query();
        $this->db()->delete('option_description', "option_id=$option_id");
        $this->db()->delete('option_value', "option_id=$option_id");
        $this->db()->delete('option_value_description', "option_id=$option_id");
    }

    public function getOption($option_id) {
        //Current LanguageID
        $lang_id = \Module\Component\Setting::getInstance()->get('system.admin_language');
        $result = $this->db()->from('option', 'o')
                ->leftJoin('option_description od', "o.option_id = od.option_id")
                ->where('o.option_id', $option_id, false)
                ->where('od.language_id', $lang_id, false)
                ->get();
        return isset($result[0]) ? $result[0] : NULL;
    }

    //获取属性名称列表
    public function getOptionDescriptions($option_id) {
        $option_data = array();

        $result = $this->db()->where('option_id', (int) $option_id)->get("option_description");

        foreach ($result as $value) {
            $option_data[$value['language_id']] = array('name' => $value['name']);
        }

        return $option_data;
    }

    public function getOptionValue($option_value_id) {
        $lang_id = \Module\Component\Setting::getInstance()->get('system.admin_language');
        $result = $this->db()->from("option_value ov")->leftJoin('option_value_description ovd', 'ov.option_value_id = ovd.option_value_id')
                ->where('ov.option_value_id', $option_value_id)
                ->where('ovd.language_id', $lang_id)
                ->get();


        return isset($result[0]) ? $result[0] : NULL;
    }

    public function getOptionValues($option_id) {
        $option_value_data = array();
        $lang_id = \Module\Component\Setting::getInstance()->get('system.admin_language');
        $option_value_query = $this->db()->from('option_value', 'ov')->leftJoin('option_value_description ovd', 'ov.option_value_id = ovd.option_value_id')
                        ->where('ov.option_id', $option_id)
                        ->where('ovd.language_id', $lang_id)
                        ->order_by('ov.sort_order')->get();

        foreach ($option_value_query as $option_value) {
            $option_value_data[] = array(
                'option_value_id' => $option_value['option_value_id'],
                'name' => $option_value['name'],
                'image' => $option_value['image'],
                'sort_order' => $option_value['sort_order']
            );
        }

        return $option_value_data;
    }

    //获取属性值列表
    public function getOptionValueDescriptions($option_id) {
        $option_value_data = array();

        $option_value_query = $this->db()->where('option_id', $option_id)->get('option_value');

        foreach ($option_value_query as $option_value) {
            $option_value_description_data = array();

            $option_value_description_query = $this->db()->where('option_value_id', (int) $option_value['option_value_id'])->get("option_value_description");

            foreach ($option_value_description_query as $option_value_description) {
                $option_value_description_data[$option_value_description['language_id']] = array('name' => $option_value_description['name']);
            }

            $option_value_data[] = array(
                'option_value_id' => $option_value['option_value_id'],
                'option_value_description' => $option_value_description_data,
                'image' => $option_value['image'],
                'sort_order' => $option_value['sort_order']
            );
        }

        return $option_value_data;
    }

}

/*
 Array
(
      [option_value] => Array
        (
            [0] => Array
                (
                    [option_value_id] => 
                    [option_value_description] => Array
                        (
                            [0] => Array
                                (
                                    [name] => 擦拭地方
                                )

                            [1] => Array
                                (
                                    [name] => 阿斯蒂芬
                                )

                        )

                    [image] => 
                    [sort_order] => 2
                )

            [1] => Array
                (
                    [option_value_id] => 
                    [option_value_description] => Array
                        (
                            [0] => Array
                                (
                                    [name] => 4 2速读法
                                )

                            [1] => Array
                                (
                                    [name] => 爱的色放
                                )

                        )

                    [image] => 
                    [sort_order] => 0
                )

        )

)
 */