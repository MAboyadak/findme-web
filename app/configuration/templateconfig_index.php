<?php

return[
    'pageBlocks' => [
        'wrapper_start'     => TMP_PATH . DS . 'index' . DS .  'WrapperStart.php',
        'header'            => TMP_PATH . DS . 'index' . DS .  'header.php',
        'nav'               => TMP_PATH . DS . 'index' . DS .  'nav.php',
        ':view'             => TMP_PATH . DS . 'index' . DS .  ':action_view',
        'wrapper_end'       => TMP_PATH . DS . 'index' . DS .  'WrapperEnd.php',
    ],
    'header_resources'  => [
        'css' => [
                'normailze'         => CSS . DS .'normalize.css' ,
                'bs'                => CSS . DS .'bootstrap.min.css' ,
                'gicons'            => CSS . DS .'googleicons.css' ,
                'fawsome'           => CSS . DS .'fawsome.min.css' ,
                'maincss'           => CSS . DS .'index.css' ,
        ],
        'js' => [
                'modernizer'        => JS . DS .'vendor' . DS . 'modernizr-2.8.3.min',
        ]

    ],
    'footer_resources'     => [
        'jquery'         => JS . DS .'vnedor' . DS . 'jquery-1.12.0.min.js',    
        'helper'         => JS . DS .'helper.js',
        'myjs'           => JS . DS . 'myjs.js',
        'toggler'           => JS . DS . 'toggler.js',
    ]
];