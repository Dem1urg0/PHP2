<?php

namespace App\modules\Repositories;

use App\modules\Entities\MUser;

class RUser extends Repository
{
    public function __construct()
    {
        parent::__construct(new MUser());
    }
}