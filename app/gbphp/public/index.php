<?php

session_start();

// Подключаем автозагрузчик Composer
require_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';
$request = new \App\services\Request();


$controllerName = $request->getControllerName() ?? 'user';
$actionName = $request->getActionName() ?? '';

$controllerClass = 'App\\controllers\\' . ucfirst($controllerName) . 'Controller';
if ($controllerName == 'cart' && $actionName == ''){
    $actionName = 'get';
}
if ($actionName == 'all') {
    $template = $controllerName . "s.php.twig";
} else {
    $template = $controllerName . ".php.twig";
}

$error = false;
if (class_exists($controllerClass)) {
    $controller = new $controllerClass();
    try {
        $params = $controller->run($actionName);
    } catch (\Exception $e) {
        $error = true;
    }
} else {
    $error = true;
}
if ($error) {
    $controller = new \App\controllers\ErrorController();
    $template = '404.php.twig';
    $params = [];
}
echo $controller->render($template, $params);