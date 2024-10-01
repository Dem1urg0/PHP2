<?php

namespace App\controllers;

use App\modules\Repositories\RGood;

class GoodController extends ModelController
{
    protected $oGood;

    public function __construct()
    {
        parent::__construct();
        $this->oGood = new RGood();
    }
    public function allAction()
    {
        $goods = (($this->oGood)->getAll());
        return ['goods' => $goods];
    }

    public function oneAction()
    {
        $id = $this->getGRequest('id');
        $good = $this->oGood->getOne($id);
        return ['good' => $good];
    }
}