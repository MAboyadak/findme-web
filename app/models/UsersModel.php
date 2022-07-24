<?php
namespace MVC\Models;
use MVC\Libs\Database\DatabaseHandler;

class UsersModel extends AbstractModel
{
    public $id;
    public $username;
    public $password;
    public $email;
    public $city;
    public $number;

    protected static $tableName = 'users';

    protected static $tableSchema = array(
        'username'                  => self::DATA_TYPE_STR,
        'password'                  => self::DATA_TYPE_STR,
        'email'                     => self::DATA_TYPE_STR,
        'city'                      => self::DATA_TYPE_STR,
        'number'                    => self::DATA_TYPE_INT,
    );

    protected static $primaryKey = 'id';

    public function getTableName()
    {
        return $this->$tableName;
    }
    public static function getByName($username)
    {
        $sql = 'SELECT * FROM ' . static::$tableName . ' WHERE username ' . ' = ' . "'" . $username . "'";
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

}