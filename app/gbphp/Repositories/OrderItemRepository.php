<?php

namespace App\Repositories;

use App\main\App;

class OrderItemRepository extends Repository
{
    public function getTableName()
    {
        return 'order_list';
    }
    public function getEntityClass()
    {
        return get_class(App::call()->OrderItem);
    }
}