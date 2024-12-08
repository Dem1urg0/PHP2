<?php

namespace App\controllers;

use App\main\App;
use App\Repositories\GoodRepository;

class GoodController extends Controller
{

    public function allAction()
    {
        return $this->render(
            'goods',
            [
                'goods' => App::call()->GoodRepository->getAll()
            ]
        );
    }

    public function oneAction()
    {
        $id = $this->getRequest('id');
        return $this->render('good', [
            'good' => App::call()->GoodRepository->getOne($id),
            'title' => 'Name'
        ]);
    }
}