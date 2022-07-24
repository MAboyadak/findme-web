<?php

return[
    'pageBlocks' => [
        'wrapper_start'     => TMP_PATH . DS . 'admin' . DS . 'WrapperStart.php',
        'header'            => TMP_PATH . DS . 'admin' . DS . 'header.php',
        'nav'               => TMP_PATH . DS . 'admin' . DS . 'nav.php',
        ':view'             => TMP_PATH . DS . 'admin' . DS . ':action_view',
        'wrapper_end'       => TMP_PATH . DS . 'admin' . DS . 'WrapperEnd.php',
    ],
    'header_resources'  => [
        'css' => [
                'normailze'         => CSS . DS .'normalize.css' ,
                'bs'                => CSS . DS .'bootstrap.min.css' ,
                'gicons'            => CSS . DS .'googleicons.css' ,
                'fawsome'           => CSS . DS .'fawsome.min.css' ,
                'maincss2'           => CSS . DS .'admin.css' ,
        ],
        'js' => [
                'modernizer'        => JS . DS .'vendor' . DS . 'modernizr-2.8.3.min',
        ]

    ],
    'footer_resources'     => [
        'jquery'         => JS . DS .'vnedor' . DS . 'jquery-1.12.0.min.js',    
        'helper'         => JS . DS .'helper.js',       
    ]
];