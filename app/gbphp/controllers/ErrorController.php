<?php

namespace App\controllers;

class ErrorController extends ModelController
{
    protected $defaultAction = 'error';
    public function errorAction()
    {
        return ['error' => '404'];
    }
}