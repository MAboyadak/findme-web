<?php
namespace MVC\Models;

class PersonGroupModel extends AbstractModel
{
    public $id;
    public $name;
    public $groupData;


    protected static $tableName = 'groups';
    protected static $tableSchema = array(
        'name'               => self::DATA_TYPE_STR,
        'groupData'               => self::DATA_TYPE_STR,

    );
    protected static $primaryKey = 'id';
    
    // public function __construct($name,$age,$address,$tax,$salary)
    // {
    //         $this->name      = $name;
    //         $this->age       = $age;
    //         $this->address   = $address;
    //         $this->tax       = $tax;
    //         $this->salary    = $salary;
    // }


    // public function getTableName()
    // {
    //     return $this->$tableName;
    // }
}