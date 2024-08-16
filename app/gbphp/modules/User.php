<?php
namespace App\modules;

class User extends Model
{
    public $id;
    public $name;
    public $password;
    public $login;

    /**
     * Возвращает имя таблицы в базе данных
     * @return string
     */
    public function getTableName(): string
    {
        return 'users';
    }
}