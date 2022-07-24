<?php
namespace MVC\Models;
use MVC\Libs\Database\DatabaseHandler;

class NotificationsModel extends AbstractModel
{
    public $id;
    public $message;
    public $time;
    public $seen;
    public $personId;
    

    protected static $tableName = 'notifications';

    protected static $tableSchema = array(            
            'message'                  => self::DATA_TYPE_STR,
            'time'                     => self::DATA_TYPE_STR,
            'seen'                     => self::DATA_TYPE_BOOLEAN,            
            'userId'                   => self::DATA_TYPE_INT,
            'type'                     => self::DATA_TYPE_STR,
            'personId'                 => self::DATA_TYPE_INT,

    );

    protected static $primaryKey = 'id';

    public function getTableName()
    {
        return $this->$tableName;
    }
    public function getUnread($userId)
    {
        $sql = 'SELECT * FROM notifications WHERE userId = ' . $userId . ' AND seen = ' . 0;
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getAllByUserId($userId)
    {
        $sql = 'SELECT * FROM notifications WHERE userId = ' . $userId .' ORDER BY id DESC LIMIT 5';
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}