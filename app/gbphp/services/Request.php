<?php

namespace App\services;

class Request
{
    protected $actionName;
    protected $controllerName;
    protected $requestString;
    protected $session;
    protected $params;

    public function __construct()
    {
        $this->requestString = $_SERVER['REQUEST_URI'];
        $this->params = [
            'get' => $_GET,
            'post' => $_POST,
        ];
        $this->parseRequest();
    }

    protected function parseRequest()
    {
        $pattern = "#(?P<controller>\w+)[/]?(?P<action>\w+)?[/]?[?]?(?P<params>.*)#ui";
        if (preg_match_all($pattern, $this->requestString, $matches)) {
            $this->controllerName = $matches['controller'][0];
            $this->actionName = $matches['action'][0];
        }
    }

    public function get($params = '')
    {
        if (empty($params)) {
            return $this->params['get'];
        }

        if (!empty($this->params['get'][$params])) {
            return $this->params['get'][$params];
        }

        return array();
    }

    public function getActionName()
    {
        return $this->actionName;
    }

    public function getControllerName()
    {
        return $this->controllerName;
    }
    public function post($params = '')
    {
        if (empty($params)) {
            return $this->params['post'];
        }
        if (!empty($this->params[$params])) {
            return $this->params[$params];
        }
        return array();
    }
}