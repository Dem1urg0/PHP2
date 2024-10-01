<?php

namespace App\modules\Repositories;

use App\modules\Entities\MGood;

class RGood extends Repository
{
  public function __construct()
  {
      parent::__construct(new MGood());
  }
}