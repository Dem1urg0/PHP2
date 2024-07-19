<?php
/*
3.Создать модуль регистрации пользователя. (Файлы reg.php, reg.html, login.php)
*/
function indexAction()
{
    if (!empty($_GET['login']) && !empty($_GET['pass'])) {
        header("Location:/?p=login&a=aut&login={$_GET['login']}&pass={$_GET['pass']}&mth=reg");
        exit;
    }
    $html = file_get_contents(dirname(__DIR__) . '/tmpl/reg.html');
    if ($_GET['le'] == 'true') {
        $html = str_replace('<div class="error-log"></div>', '<div class="error-message">Uncorrect login</div>', $html);
    }
    if ($_GET['pe'] == 'true') {
        $html = str_replace('<div class="error-pas"></div>', '<div class="error-message">Uncorrect login</div>', $html);
    }
    return $html;
}