<?php

namespace App\controllers;

abstract class ModelController
{
    protected $defaultAction = 'all';

    public function run($action)
    {
        if (empty($action)) {
            $action = $this->defaultAction;
        }
        $method = $action . 'Action';
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        header('Location: /');
        exit();
    }
}