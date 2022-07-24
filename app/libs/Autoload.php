<?php
namespace MVC\Libs;

class Autoload{
    public static function autoloadFiles($classFileName){
        //echo $classFileName;
        //echo '<br>';
        $classFileName = strtolower(str_replace('MVC','',$classFileName));
        //echo $classFileName;
        
        //echo'<br>';
        $classFileName = APP_PATH . $classFileName . '.php';
        //echo $classFileName;
        //echo '<hr>';
        
        if (!file_exists($classFileName)){
            
        }else{
            require_once $classFileName;
        }
    }
}

spl_autoload_register(__NAMESPACE__ . '\Autoload::autoloadFiles');
