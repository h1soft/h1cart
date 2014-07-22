<?php

/*
 * This file is part of the H1Cart package.
 * (w) http://www.h1cart.com
 * (c) Allen Niu <h@h1soft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Module;

define('H1CART', '1.0');

use Module\Component\Language;
use Module\Component\Store;

class Bootstrap extends \H1Soft\H\Web\Bootstarp {

    public function ApplicationStart() {
        //加载语言包
        Language::getInstance()->load('common');
       
        //店铺
        Store::getInstance();
       
    }

}
