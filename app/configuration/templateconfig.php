<?php

return[
    'pageBlocks' => [
        'wrapper_start'     => TMP_PATH . DS . 'page' . DS .  'WrapperStart.php',
        'header'            => TMP_PATH . DS . 'page' . DS .  'header.php',
        'nav'               => TMP_PATH . DS . 'page' . DS .  'nav.php',
        ':view'             => TMP_PATH . DS . 'page' . DS .  ':action_view',
        'wrapper_end'       => TMP_PATH . DS . 'page' . DS .  'WrapperEnd.php',
    ],
    'header_resources'  => [
        'css' => [
                'normailze'         => CSS . DS .'normalize.css' ,
                'bs'                => CSS . DS .'bootstrap.min.css' ,
                'gicons'            => CSS . DS .'googleicons.css' ,
                'fawsome'           => CSS . DS .'fawsome.min.css' ,
                'maincss'           => CSS . DS .'main.css' ,
        ],
        'js' => [
                'modernizer'        => JS . DS .'vendor' . DS . 'modernizr-2.8.3.min',
                'jquery'         => JS . DS . 'jquery-3.3.1.js',
                
        ]

    ],
    'footer_resources'     => [
        'popper-js'      => JS . DS . 'popper.min.js',
        'bs-js'          => JS . DS . 'bootstrap.min.js',
        'helper'         => JS . DS . 'helper.js',
        'myjs'           => JS . DS . 'myjs.js',
        'toggler'           => JS . DS . 'toggler.js',
    ]
];