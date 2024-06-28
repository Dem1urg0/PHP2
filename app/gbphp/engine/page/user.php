<?php
/*
2.Создать модуль личного кабинета, на который будет перенаправляться пользователь после логина.
 Вывести там имя, логин и приветствие. (файлы: user.php & login.php/ login:login1;pass:pass1)
*/
function indexAction()
{
    if (!empty($_SESSION['user']['id'])) {
        header('Location: /?p=user&a=one');
    } else {
        header('Location: /?p=login');
    }
}

function oneAction()
{
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if ($_POST['logout'] == 'true'){
            session_destroy();
            header('Location: /?p=login');
        }
    }
    $id = 0;
    if (!empty($_SESSION['user']['id'])) {
        $id = (int) $_SESSION['user']['id'];
    }

    $sql = "SELECT id, name, login, role FROM users WHERE id = {$id}";
    $result = mysqli_query(connect(), $sql);

    $row = mysqli_fetch_assoc($result);

    $role = 'admin';
    if (empty($row['role'])) {
        $role = 'user';
    }
    return <<<php
        <h2>Привет {$row['name']}!</h2>
        <h3>Информация о пользователе:</h1>
        <p>{$row['login']}</p>
        <p>{$role}</p>
        <a href="?id={$row['id']}&page=4">Редактировать</a>
        <form method='POST'>
            <button name="logout" value="true">Выйти</button>
        </form>
php;
}

function allAction()
{
    $sql = "SELECT id, name, login, role FROM users";
    $result = mysqli_query(connect(), $sql);

    $content = '';
    while ($row = mysqli_fetch_assoc($result)) {
        $content .= <<<php
        <h2>{$row['login']}</h2>
        <p>{$row['role']}</p>
        <a href="?page=2&id={$row['id']}">Подробнее ...</a>
php;
    }
        return $content;
}