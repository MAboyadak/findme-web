<?php
namespace MVC\Models;
use MVC\Libs\Database\DatabaseHandler;

class PersonModel extends AbstractModel
{
    public $id;
    public $firstName;
    public $fatherName;
    public $lastName;
    public $fullName;
    public $age;
    public $gender;
    public $area;
    public $city;
    public $apiId;
    public $personData;
    public $identified;
    public $identifiedId;
    public $userId;
    public $groupId;


    protected static $tableName = 'persons';
    protected static $tableSchema = array(
        'firstName'                => self::DATA_TYPE_STR,
        'fatherName'               => self::DATA_TYPE_STR,
        'lastName'                 => self::DATA_TYPE_STR,
        'fullName'                 => self::DATA_TYPE_STR,
        'age'                      => self::DATA_TYPE_INT,
        'gender'                   => self::DATA_TYPE_STR,
        'area'                     => self::DATA_TYPE_STR,
        'city'                     => self::DATA_TYPE_STR,
        'apiId'                    => self::DATA_TYPE_STR,
        'personData'               => self::DATA_TYPE_STR,
        'identified'               => self::DATA_TYPE_BOOLEAN,
        'identifiedId'             => self::DATA_TYPE_INT,
        'userId'                   => self::DATA_TYPE_INT,
        'groupId'                  => self::DATA_TYPE_INT,
    );
    protected static $primaryKey = 'id';

    public function getTableName()
    {
        return $this->$tableName;
    }
    public function getByApiId($apiId)
    {
        $sql = 'SELECT * FROM persons WHERE apiId = ' ."'".$apiId."'";
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function getByUserId($userId)
    {
        $sql = 'SELECT * FROM persons WHERE userId = ' . $userId;
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function getByIdentifiedId($identifiedId)
    {
        $sql = 'SELECT * FROM persons WHERE identifiedId = ' . $identifiedId;
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function getByPersonAndUserId($id, $userId)
    {
        $sql = 'SELECT * FROM persons WHERE id = ' . $id . ' ' . 'AND userId = ' . $userId;
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
}