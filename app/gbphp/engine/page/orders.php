<?php
//Страница заказов

function indexAction()
{
    session_start();
    if (empty($_SESSION['user'])) {
        header('Location: /?p=login');
    } elseif ($_SESSION['user']['admin'] != 1) {
        header('Location: /?p=user&a=one');
    }
    $sql = 'SELECT orders.id as order_id,orders.user_id,orders.status,orders.address,order_list.prod_id,order_list.count,products.name as product_name, products.price FROM orders INNER JOIN order_list ON orders.id = order_list.order_id INNER JOIN products ON order_list.prod_id = products.id';
    $result = mysqli_fetch_all(mysqli_query(connect(), $sql));
    $orderBlock = '';
    $order_id = null;
    foreach ($result as $order) {
        if ($order[0] != $order_id) {
            $orderBlock .= "<div class='orders'>
        <div class='order'>
            <p>id: {$order[0]}</p>
            <p>user id: {$order[1]}</p>
            <h3>products</h3>";
            foreach ($result as $product) {
                if ($product[0] == $order[0]) {
                    $orderBlock .= "<div class='product'>
                    <p>NAME: {$product[6]}</p>
                    <p>COUNT: {$product[5]}</p>
                </div>";
                }
            }
            $orderBlock .= "<p>address: {$order[3]}</p><p>status: {$order[2]}</p></div></div>";
            $orderBlock .= "<div>
                   <select id='typeStatus'>
                       <option selected disabled>Выберите</option>
                       <option value='new'>new</option>
                       <option value='in progress'>in progress</option>
                       <option value='done'>done</option>
                   </select>
                   <input type='submit' style = 'margin-top: 10px' onclick='change({$order[0]})' class='logout-btn' value='Сменить статус'>
                <form method='GET'>
                <input type='hidden' value='user' name='p'>
                <input type='hidden' value='delOrder' name='a'>
                <input type='hidden' value='{$order[0]}' name='id'>
                <input type='submit' style = 'margin-top: 10px' class='logout-btn' value='Отменить заказ'>
                </form>
                </div>";
        }
        $order_id = $order[0];
    }
    if ($orderBlock == '') {
        $orderBlock .= '<p>Нет Заказов</p>';
    }
    $html = file_get_contents(dirname(__DIR__) . '/tmpl/orders.html');
    return str_replace('{{ORDERS}}', $orderBlock, $html);
}

function statusAction()
{
    session_start();
    if ($_SESSION['user']['admin'] != 1) {
        header('Location: /?p=login');
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (empty($_GET['id']) || empty($_GET['type'])) {
            header('Location: /');
        } elseif (!is_numeric($_GET['id']) || !is_string($_GET['type'])) {
            header('Location: /');
        }
        $id = (int)$_GET['id'];
        $status = $_GET['type'];
        $sql = "UPDATE orders SET status = '{$status}' WHERE id = {$id}";
        mysqli_query(connect(), $sql);
    }
}