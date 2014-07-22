<?php

namespace Module\Catalog\Controller;

class Index extends \H1Soft\H\Web\Controller {
    public function indexAction() {
        \Module\Component\Language::getInstance()->get('text_home');
    }
}
