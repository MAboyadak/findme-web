<?php
namespace MVC\Models;
use MVC\Libs\Database\DatabaseHandler;
class AbstractModel
{
    const DATA_TYPE_BOOLEAN = \PDO::PARAM_BOOL;
    const DATA_TYPE_STR = \PDO::PARAM_STR;
    const DATA_TYPE_INT = \PDO::PARAM_INT;
    const DATA_TYPE_DECIMAL = 4;
    const DATA_TYPE_DATE = 5;

    private function bindValues($stmt)
    {
        foreach(static::$tableSchema as $colName => $type){
                $stmt->bindValue(":$colName" , $this->$colName , $type);
        }
        return $stmt;
    }

    private static function buildNamedParams()
    {
        $namedParams = '';
        foreach(static::$tableSchema as $colName => $type){
            $namedParams .= $colName . ' = :' . $colName . ', ';
        }      
        return(trim($namedParams,', '));
    }

    public function create()
    {
        $sql = 'INSERT INTO ' . static::$tableName . ' SET ' . self::buildNamedParams();
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $stmt = $this->bindValues($stmt);
        if($stmt->execute()){
            $this->id = DatabaseHandler::factory()->lastInsertId();
            return $this->id;
        }
        return false;
    }

    public function lastInsertedId()
    {
        return DatabaseHandler::factory()->lastInsertId();
    }

    public function update($primaryKey)
    {
        $sql = 'UPDATE ' . static::$tableName . ' SET ' . self::buildNamedParams() . ' WHERE ' . static::$primaryKey . ' = ' . "'" . $primaryKey . "'";
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $this->bindValues($stmt);
        return $stmt->execute();
    }

    public function delete($primaryKey)
    {
        $sql = 'DELETE FROM ' . static::$tableName . ' WHERE ' . static::$primaryKey . ' = ' . "'" . $primaryKey . "'";
        $stmt = DatabaseHandler::factory()->prepare($sql);
        return $stmt->execute();
    }

    public static function getAll()
    {
        $sql = 'SELECT * FROM ' . static::$tableName . ' ORDER BY id DESC';
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getByPK($primaryKey)
    {
        $sql = 'SELECT * FROM ' . static::$tableName . ' WHERE ' . static::$primaryKey . ' = ' . "'" . $primaryKey . "'";;
        $stmt = DatabaseHandler::factory()->prepare($sql);
        if($stmt->execute()){
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        return false;
        
    }
    
}