<?php

namespace App\controllers;

use App\services\renders\IRender;
use App\services\Request;

abstract class Controller
{
    protected $defaultAction = 'all';
    protected $render;
    protected $twig;
    protected $request;

    public function __construct(IRender $render, Request $request)
    {
        $this->render = $render;
        $this->request = $request;
    }

    public function run($action)
    {
        if (empty($action)) {
            $action = $this->defaultAction;
        }
        $method = $action . 'Action';
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        throw new \Exception("Метод не найден");
    }

    public function render($template, $params){
        return $this->render->render($template,$params);
    }

    public function getRequest($params = [])
    {
        return $this->request->get($params);
    }
    public function postRequest($params = []){
        return $this->request->post($params);
    }
}