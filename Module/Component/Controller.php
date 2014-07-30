<?php



namespace Module\Component;


class Controller extends \H1Soft\H\Web\Controller {
    private $breadcrumbs = array();
    
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
    public function lang($_key){
        return Language::getInstance()->get($_key);
    }
    
    /**
     * 
     * @param type $filename
     * @param type $autoset
     * @return \Module\Backend\Controller\AdminController
     */
    public function loadLang($filename,$autoset = true){
        if($autoset){
            $langs = Language::getInstance()->load($filename);
            foreach ($langs as $key => $value) {
                $this->assign($key, $value);
            }
        }else{
            Language::getInstance()->load($filename);
        }
        return $this;
    }
    
    public function render($tplFileName = false, $data = true, $output = true) {
        $this->assign('breadcrumbs', $this->breadcrumbs);
        parent::render($tplFileName, $data, $output);
    }
    
}
