<?php
namespace MVC\Libs\Database;

class PDODatabaseHandler extends DatabaseHandler
{
    private static $_instance;
    private static $_conn;

    private function __construct(){
        self::init();
    }

    public function __call($name, $args){
        return call_user_func_array(array(&self::$_conn,$name),$args);
    }
    protected static function init()
    {
        try{
            self::$_conn = new \PDO('mysql:hostname=' . DB_HOST_NAME . ';dbname=' . DB_NAME , DB_USER_NAME , DB_PASSWORD);
            self::$_conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );      
        }catch(PDOException $e){
            $e->getMessage();
        }
    }
    public static function getInstance()
    {
        if(self::$_instance === null){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}