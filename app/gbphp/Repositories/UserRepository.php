<?php

namespace App\Repositories;

use App\Entities\User;
use App\main\App;

class UserRepository extends Repository
{
    public function getTableName(): string
    {
        return 'users';
    }

    public function getEntityClass()
    {
        return get_class(App::call()->User);
    }

    public function getByLogin($login)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE login = :login";
        return $this->db->queryObject($sql, $this->getEntityClass(), [':login' => $login]);
    }
}