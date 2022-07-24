<?php

namespace MVC;
use MVC\Libs\FrontController;
use MVC\Libs\Autoload;
use MVC\Libs\Template;
error_reporting(E_ALL);
ini_set("display_errors", 1);

if(!defined('DS')){
    define('DS',DIRECTORY_SEPARATOR);
}

require_once '..' . DS . 'app' . DS . 'configuration' . DS . 'config.php';
require_once APP_PATH . DS .'libs' . DS . 'autoload.php';
require_once './vendor/autoload.php';


$pageParts = require_once APP_PATH . DS .'configuration' . DS . 'templateconfig.php';
$adminParts = require_once APP_PATH . DS .'configuration' . DS . 'templateconfig_admin.php';
$indexParts = require_once APP_PATH . DS .'configuration' . DS . 'templateconfig_index.php';

?>


<?php

$template = new Template($pageParts,$adminParts,$indexParts);
// echo'<pre>';
// print_r($template);
// echo'</pre>';
$frontController = new FrontController($template);

$frontController->dispatch();
