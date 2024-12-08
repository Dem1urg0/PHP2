<?php

namespace App\controllers;

class ErrorController extends Controller
{
    protected $defaultAction = 'error';

    public function errorAction()
    {
        return $this->render(
            'error',
            [
                'error' => '404'
            ]);
    }
}