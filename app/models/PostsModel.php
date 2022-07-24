<?php
namespace MVC\Models;
use MVC\Libs\Database\DatabaseHandler;

class PostsModel extends AbstractModel
{
    public $id;
    public $fullName;
    public $age;
    public $city;
    public $area;
    public $personData;
    public $gender;
    public $userId;
    public $personId;
    public $img1;
    

    protected static $tableName = 'posts';

    protected static $tableSchema = array(
            'fullName'                  => self::DATA_TYPE_STR,
            'age'                       => self::DATA_TYPE_INT,
            'city'                      => self::DATA_TYPE_STR,
            'area'                      => self::DATA_TYPE_STR,
            'personData'                => self::DATA_TYPE_STR,
            'gender'                    => self::DATA_TYPE_STR,
            'userId'                    => self::DATA_TYPE_INT,
            'personId'                  => self::DATA_TYPE_INT,
            'img1'                      => self::DATA_TYPE_STR,
    );

    protected static $primaryKey = 'id';

    public function getTableName()
    {
        return $this->$tableName;
    }

}