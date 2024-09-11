<?php

use App\modules\Good;

session_start();

// Подключаем автозагрузчик Composer
require_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Настройка Twig
$loader = new FilesystemLoader(dirname(__DIR__) . '/views');
$twig = new Environment($loader);

$controllerName = $_GET['c'] ?? 'user';
$actionName = $_GET['a'] ?? '';

$controllerClass = 'App\\controllers\\' . ucfirst($controllerName) . 'Controller';

if (class_exists($controllerClass)) {
    if($actionName == 'all'){
        $template = $controllerName . "s.php.twig";
    } else {
        $template = $controllerName . ".php.twig";
    }
    $controller = new $controllerClass();
    echo $twig->render($template,$controller->run($actionName));
}