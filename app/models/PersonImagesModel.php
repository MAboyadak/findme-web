<?php
namespace MVC\Models;
use MVC\Libs\Database\DatabaseHandler;

class PersonImagesModel extends AbstractModel
{
    public $personId;
    public $imgName;
    public $imgFaceId;


    protected static $tableName = 'person_images';
    protected static $tableSchema = array(
        'imgName'               => self::DATA_TYPE_STR,
        'imgFaceId'                 => self::DATA_TYPE_STR,
    );
    protected static $primaryKey = 'personId';

    public function getTableName()
    {
        return $this->$tableName;
    }
    public function getByPersonId($id)
    {
        $sql = 'SELECT * FROM ' . static::$tableName . ' WHERE personId'. ' = ' . "'" . $id . "'";
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}