<?php

namespace App\modules\Entities;

class MUser extends Model
{
    public $id;
    public $name;
    public $password;
    public $login;
    public $role;

    /**
     * Возвращает имя таблицы в базе данных
     * @return string
     */
    public function getTableName(): string
    {
        return 'users';
    }
}