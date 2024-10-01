<?php

namespace App\modules\Entities;

class MCart extends Model
{
    public $user_id = 1;
    public $id;
    public $count;


    public function getTableName(): string
    {
        return 'cart';
    }
}