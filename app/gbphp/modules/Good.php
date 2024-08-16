<?php
namespace App\modules;

class Good extends Model
{
    public $id;
    public $name;
    public $price;

    /**
     * Возвращает имя таблицы в базе данных
     * @return string
     */
    public function getTableName(): string
    {
        return 'goods';
    }
}