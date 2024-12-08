<?php

namespace App\Entities;

class OrderItem extends Entity
{
    public $order_id;
    public $good_id;
    public $count = 1;
}