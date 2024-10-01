<?php
namespace App\modules;

class User extends Model
{
    public $id; //сущ
    public $name;
    public $password;
    public $login;
    public $role;

    /**
     * Возвращает имя таблицы в базе данных
     * @return string
     */
    public function getTableName(): string //реп
    {
        return 'users';
    }
}