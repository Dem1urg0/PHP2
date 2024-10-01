<?php

namespace App\controllers;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\services\Request;

abstract class ModelController
{
    protected $defaultAction = 'all';
    protected $loader;
    protected $twig;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(dirname(__DIR__) . '/views');
        $this->twig = new Environment($this->loader);
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
        return $this->twig->render($template,$params);
    }
    public function getGRequest($params = []){
        $request = new Request();
        return $request->get($params);
    }
    public function getPRequest($params = []){
        $request = new Request();
        return $request->post($params);
    }
}