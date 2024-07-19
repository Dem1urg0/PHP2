<?php
/*
2.Создать модуль личного кабинета, на который будет перенаправляться пользователь после логина.
 Вывести там имя, логин и приветствие. (файлы: user.php & login.php/ login:login1;pass:pass1)
*/
function indexAction()
{
    session_start();
    if (!empty($_SESSION['user']['id'])) {
        header('Location: /?p=user&a=one');
    } else {
        header('Location: /?p=login');
    }
}

function oneAction()
{
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_POST['logout'] == 'true') {
            session_destroy();
            header('Location: /?p=login');
        }
    }
    $id = 0;
    if (!empty($_SESSION['user']['id'])) {
        $id = (int)$_SESSION['user']['id'];
    }

    $sql = "SELECT id, name, login, role FROM users WHERE id = {$id}";
    $result = mysqli_query(connect(), $sql);

    $row = mysqli_fetch_assoc($result);

    $role = 'admin';
    if (empty($row['role'])) {
        $role = 'user';
    }
    $html = file_get_contents(dirname(__DIR__) . '/tmpl/user.html');

    $userBlock = " <div class='user-info'>
    <h2>Привет {$row['name']}!</h2>
    <h3>Информация о пользователе:</h3>
    <p>Login: {$row['login']}</p>
    <p>Role: {$role}</p>
    <form method='POST'>
        <button class='logout-btn' name=\"logout\" value=\"true\">Выйти</button>
    </form>
    </div>";

    //Orders
    $sql = 'SELECT orders.id as order_id,orders.status,orders.address,order_list.prod_id,order_list.count,products.name as product_name, products.price FROM orders INNER JOIN order_list ON orders.id = order_list.order_id INNER JOIN products ON order_list.prod_id = products.id WHERE orders.user_id = ' . $id;
    $result = mysqli_fetch_all(mysqli_query(connect(), $sql));
    foreach ($result as $order) {
        $orderBlock = '';
        $order_id = null;
        if ($order[0] != $order_id) {
            $orderBlock .= "<div class='orders'>
        <div class='order'>
            <p>id: {$order[0]}</p>
            <h3>products</h3>";
            foreach ($result as $product) {
                if ($product[0] == $order[0]) {
                    $orderBlock .= "<div class='product'>
                    <p>NAME: {$product[6]}</p>
                    <p>COUNT: {$product[5]}</p>
                </div>";
                }
            }
            $orderBlock .= "<p>address: {$order[2]}</p><p>status: {$order[1]}</p></div></div>";
            if ($order[1] == 'new') {
                $orderBlock .= "<form method='GET'>
                <input type='hidden' value='user' name='p'>
                <input type='hidden' value='delOrder' name='a'>
                <input type='hidden' value='{$order[0]}' name='id'>
                <input type='submit' style = 'margin-top: 10px' class='logout-btn' value='Отменить заказ'>
                </form>";
            }
        }
        $order_id = $order[0];
    }
    if ($orderBlock == '') {
        $orderBlock .= '<p>Нет Заказов</p>';
    }
    return str_replace(['{{USER}}', '{{ORDERS}}'], [$userBlock, $orderBlock], $html);
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
php;
    }
    return $content;
}

function delOrderAction()
{
    session_start();
    $id = $_GET['id'];
    if (!empty($id) && is_numeric($id)) {
        $sql = 'SELECT status,user_id FROM orders WHERE id = ' . $id;
        $table = mysqli_fetch_all(mysqli_query(connect(), $sql));
        if ($table[0][0] == 'new' && $table[0][1] == $_SESSION['user']['id'] || $_SESSION['user']['admin'] == 1) {
            $sql = "DELETE FROM order_list WHERE order_id = $id";
            mysqli_query(connect(), $sql);
            $sql = "DELETE FROM orders WHERE id = $id";
            mysqli_query(connect(), $sql);
        }
    }
    header('Location:' . $_SERVER['HTTP_REFERER']);
}