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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
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
        if (!$_SERVER['REQUEST_METHOD'] == 'GET') {
            return array();
        }
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
        if (!$_SERVER['REQUEST_METHOD'] == 'POST') {
            return array();
        }
        if (empty($params)) {
            return $this->params['post'];
        }
        if (!empty($this->params['post'][$params])) {
            return $this->params['post'][$params];
        }
        return array();
    }

    public function sessionSet($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function sessionGet($key)
    {
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        } else return array();
    }
    public function sessionDelete($key)
    {
        unset($_SESSION[$key]);
    }
    public function sessionAddToArr($key, $value)
    {
        if(!isset($_SESSION[$key]) || !is_array($_SESSION[$key])){
            $_SESSION[$key] = [];
        }
        $_SESSION[$key][] = $value;
    }
    public function isPost(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            return true;
        } else return false;
    }
}