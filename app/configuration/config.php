<?php

if(!defined('DS')){
    define('DS', DIRECTORY_SEPARATOR);
}

define ('APP_PATH',realpath(dirname(__DIR__)));
define ('VIEWS_PATH', APP_PATH . DS .'views');
define ('TMP_PATH', APP_PATH . DS .'template');
define ('CSS', '/css');
define ('JS', '/js');

defined('DB_HOST_NAME')      ? null : define('DB_HOST_NAME','localhost') ;
defined('DB_NAME')           ? null : define('DB_NAME','findme') ;
defined('DB_USER_NAME')      ? null : define('DB_USER_NAME','root') ;
defined('DB_PASSWORD')       ? null : define('DB_PASSWORD','') ;

define( 'API_PRIMARY_KEY',      'abf19ce145a84efa86a33493170f0f89' );
define( 'LOST_PERSONS_GROUP',      '1' );
define( 'FOUND_PERSONS_GROUP',      '2' );