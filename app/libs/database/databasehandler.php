<?php
namespace MVC\Libs\Database;

abstract class DatabaseHandler
{   
    private function __construct(){
        return PDODatabaseHandler::getInstance();
    }

    abstract protected static function init();
    abstract protected static function getInstance();

    public static function factory(){
        return PDODatabaseHandler::getInstance();
    }
}