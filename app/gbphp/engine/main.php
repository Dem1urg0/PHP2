<?php

include __DIR__ . '/config/bd.php';

$page = !empty($_GET['p']) ? $_GET['p'] : 'index';
$action = !empty($_GET['a']) ? $_GET['a'] : 'index';

$dir = __DIR__ . '/page/';
if (! file_exists($dir . $page . '.php')) {
    $page = 'index';
}

include ($dir . $page . '.php');

if (!function_exists($action . 'Action')) {
    $action = 'index';
}
$action .= 'Action';
$content = $action();

$htmlButtons = '<form>
    <button name="p" value="goods">Задание 1.1</button>
    <button name="p" value="cart">Задание 1.2</button>
    <button name="p" value="login">Задание 2</button>
    <button name="p" value="reg">Задание 3</button>
</form>';

$html = file_get_contents(__DIR__ . '/tmpl/main.html');
echo str_replace('{{BUTTONS}}',$htmlButtons,str_replace('{{CONTENT}}', $content, $html));

