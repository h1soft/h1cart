<?php

return array(    
    'router' => array(
        'app' => 'Catalog',
        'controller' => 'Index',
        'action' => 'Index',        
        'suffix' => '.html',
        'showscriptname'=>false,
        'uri_protocol'=> 'PATH_INFO',  
        'rewrite'=>array(
//            '(\d+)/(\d+)/(\d+)/(.*)' => 'index/index/year/{0}/m/{1}/day/{2}/title/{3}',
            '^(\w+).html'=>'index/{0}',
            'posts/page/(\d+).html'=>'index/index/page/{0}',
            'post/(\d+).html'=>'index/post/id/{0}',
            'category/(\d+).html'=>'index/category/id/{0}'
        )
    ),
    'alias' => array(
        'admin' => 'backend'
    ),
    'src' => 'Module',
    'autoload' => array(
        'psr0' => array(),
        'psr4' => array(),
    ),
    // database settings
    'databases' => array(
        'db' => array(
            'driver' => 'mysqli',
            'host' => '127.0.0.1',
            'database' => 'h1cart',
            'username' => 'root',
            'password' => '',
            'prefix' => 'h_',
            'charset' => 'utf8',            
            'port' => '3306'
        ),
    ),
    'debug' => true,
    'view' => array(
        'theme' => 'default',
        'template' => 'Twig',
        'cache' => false
    ),
);
