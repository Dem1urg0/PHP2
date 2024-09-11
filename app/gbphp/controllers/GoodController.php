<?php

namespace App\controllers;

use App\modules\Good;

class GoodController extends ModelController
{
    public function allAction()
    {
        $goods = (new Good())->getAll();
        return ['goods' => $goods];
    }

    public function oneAction()
    {
        $oGood = new Good;
        $good = $oGood->getOne($_GET['id']);

        return ['good' => $good,];
    }
}