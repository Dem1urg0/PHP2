<?php
/*
1. Создать функционал контроля заказов администратором.
2. Создать функционал управления товарами.
3. Создать функционал контроля заказов пользователем.
4*. Изменить хранение цен в системе таким образом, чтобы они могли меняться в зависимости
от времени и действующих акций.
*/
include __DIR__ . '/config/bd.php';

$page = !empty($_GET['p']) ? $_GET['p'] : 'index';
$action = !empty($_GET['a']) ? $_GET['a'] : 'index';

$dir = __DIR__ . '/page/';
if (!file_exists($dir . $page . '.php')) {
    $page = 'index';
}

include($dir . $page . '.php');

if (!function_exists($action . 'Action')) {
    $action = 'index';
}
$action .= 'Action';
$content = $action();

$htmlButtons = '
<style>
.nav-menu {
  background-color: #ffffff;
  padding: 10px;
  margin-bottom: 20px;
}
.nav-menu button {
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  transition: background-color 0.3s;
}
.nav-menu button:hover {
  background-color: #45a049;
}
</style>
<div class="nav-menu">
<form>';
if (empty($_SESSION)){
    session_start();
}
if (empty($_SESSION['user']['id'])) {
    $htmlButtons .= '<button name="p" value="login">Вход</button>
    <button name="p" value="reg">Регистрация</button>';
} else {
    $htmlButtons .= '<button name="p" value="user">Личный кабинет</button>';
}
if(!empty($_SESSION['user'])){
    if ($_SESSION['user']['admin'] == '1'){
        $htmlButtons .= '<button name="p" value="orders">Управление заказами</button>';
        $htmlButtons .= '<button name="p" value="changeProd">Управление товарами</button>';
    }
}
$htmlButtons .= '<button name="p" value="goods">Товары</button>
    <button name="p" value="cart">Корзина</button>
</form>
</div>';


$html = file_get_contents(__DIR__ . '/tmpl/main.html');
echo str_replace('{{BUTTONS}}', $htmlButtons, str_replace('{{CONTENT}}', $content, $html));

