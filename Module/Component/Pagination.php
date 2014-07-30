<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Module\Component;

/**
 * Description of Page
 *
 * @author Administrator
 */
class Pagination extends \H1Soft\H\Web\Pagination {

    public function toHtml() {
        $action = strtolower(\H1Soft\H\Web\Application::router()->getActionName());
        $action = rtrim($action, 'action');
        $url = sprintf("%s/%s", strtolower(\H1Soft\H\Web\Application::router()->getControllerName()), $action);
        echo '<ul class="pagination">';
        if ($this->_cur_page <= 1) {
            echo '<li class="disabled" ><a href="javascript:void(0)">&laquo;</a></li>';
//            echo '<li class="paginate_button active " tabindex="0"><a href="#">1</a></li>';
        } else {
            echo '<li ><a href="', url_for($url, array('page' => $this->_cur_page - 1)), '">&laquo;</a></li>';
        }
        for ($i = 1; $i <= $this->_total_page; $i++) {
            if ($i == $this->_cur_page) {
                echo '<li class="paginate_button current " tabindex="0"><a href="#">', $i, '</a></li>';
            } else {
                echo '<li class="paginate_button " tabindex="0"><a href="', url_for($url, array('page' => $i)), '">', $i, '</a></li>';
            }
        }


        if ($this->_cur_page == $this->_total_page) {
            echo '<li class="disabled"  ><a href="javascript:void(0)">&raquo;</a></li>';
        } else {
            echo '<li ><a href="', url_for($url, array('page' => $this->_cur_page + 1)), '">&raquo;</a></li>';
        }


        echo '</ul>';
    }

}
