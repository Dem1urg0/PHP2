<?php
namespace App\modules;

class Good extends Model
{
    public $id; //в сущность
    public $name;
    public $price;
    public $type;
    public $img;
    public $info;

    /**
     * Возвращает имя таблицы в базе данных
     * @return string
     */
    public function getTableName(): string //в реп
    {
        return 'goods';
    }
}