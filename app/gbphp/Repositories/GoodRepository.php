<?php

namespace App\Repositories;

use App\main\App;

class GoodRepository extends Repository
{
    public function getTableName(): string
    {
        return 'goods';
    }
    public function getEntityClass()
    {
        return get_class(App::call()->Good);
    }
}