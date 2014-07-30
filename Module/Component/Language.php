<?php

/*
 * This file is part of the H1Cart package.
 * (w) http://www.h1cart.com
 * (c) Allen Niu <h@h1soft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Module\Component;

/**
 * 多语言
 */
class Language extends \H1Soft\H\Singleton {

    private $default = 'chinese';
    private $directory;
    public $data = array();
    private $accpetLang;
    private $selectLang = false;
    private $iso_code = 'zh';
    private $language_code = 'zh-cn';
    private $lang;
    
    /**
     * 初始化当前语言，根据浏览器语言 Cookie设置
     */
    protected function init() {
        $this->directory = \H1Soft\H\Web\Application::$rootPath . 'lang/';
        $this->accpetLang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        if (isset($_COOKIE['_hlang'])) {
            $this->accpetLang = $_COOKIE['_hlang'];
            $this->selectLang = true;
        }
        $isoCodestr = explode(';', $this->accpetLang);
        $langCodeArray = explode(',', isset($isoCodestr[0]) ? $isoCodestr[0] : "zh-CN,zh;q=0.8");
        if (isset($langCodeArray[1])) {
            $this->iso_code = strtolower($langCodeArray[1]);
            $this->language_code = strtolower($langCodeArray[0]);
        }
        $session = \H1Soft\H\Web\Session::getInstance();
        if (!$session->hasKey('_hlang')) {
            //检查默认语言
            $db = \H1Soft\H\Db\Db::getConnection();
            $langs = $db->where('active', 1)->where('iso_code', $this->iso_code)->or_where('default_lang', 1)->get('lang');
            $currentLang = NULL;
            foreach ($langs as $lang) {
                if ($this->selectLang && stripos($lang['language_code'], $this->language_code) !== FALSE) {
                    $currentLang = $lang;
                } else if ($this->selectLang == false && $lang['default_lang'] == 1) {
                    $currentLang = $lang;
                    break;
                } else if ($lang['default_lang'] == 1) {
                    $this->setDefault($lang['directory']);
                }
            }
            $session->set('_hlang', $currentLang);
        } else {
            $this->lang = $session->get('_hlang');
            $this->setDefault($this->lang['directory']);
        }
    }

    public function get($key) {
        return (isset($this->data[$key]) ? $this->data[$key] : $key);
    }

    public function isoCode() {
        return $this->iso_code;
    }
    
    public function langId() {
        $this->lang['id'];
    }

    public function setDefault($_default) {
        $this->default = $_default;
    }

    /**
     * 
     * @return string 当前浏览器支持的语言
     */
    public function languageCode() {
        return $this->language_code;
    }

    /**
     * 
     * @param string $filename 语言文件
     * @return \Module\Component\Language
     */
    public function load($filename) {
        $file = sprintf("%s%s/%s.php", $this->directory, $this->lang['directory'], $filename);

        if (file_exists($file)) {
            $_ = array();

            require($file);

            $this->data = array_merge($this->data, $_);
        }

        $file = sprintf("%s%s/%s.php", $this->directory, $this->default, $filename);
        if (file_exists($file)) {
            $_ = array();

            require($file);

            $this->data = array_merge($this->data, $_);
        } else {
            trigger_error('Error: Could not load language ' . $filename . '!');
            //	exit();
        }
        return $this;
    }

}

?>
