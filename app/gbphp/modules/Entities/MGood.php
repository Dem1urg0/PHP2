<?php

namespace App\modules\Entities;

class MGood extends Model
{
    public $id;
    public $name;
    public $price;
    public $type;
    public $img;
    public $info;

    /**
     * Возвращает имя таблицы в базе данных
     * @return string
     */
    public function getTableName(): string
    {
        return 'goods';
    }
}