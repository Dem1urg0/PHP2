<?php
/*
1. Создать модуль корзины, в которую можно как добавлять товары, так и удалять их из неё. (через сессии)
Добавить товары можно в файле goods.php или Задача 1.1
*/

function indexAction()
{
    session_start();
    if (empty($_SESSION['user']['id'])) {
        header('Location: /?p=login');
    }
    $productsHtml = '';
    foreach ($_SESSION['goods'] as $good) {
        $totalPrice = $good['price'] * $good['count'];
        $productsHtml .= "<div class ='cart-item'>
            <h3>{$good['name']}</h3>
            <p>Price per item: {$good['price']} </p>
            <p>Count: {$good['count']} </p>
            <p>Total price: {$totalPrice} </p>
        </div>
        <div>
        <div class ='change'>
                        <button class='cart-button' type='submit' onclick='buttonGoods(`{$good["id"]}`,`dec`)'>-</button>
                <button class='cart-button' type='submit' onclick='buttonGoods(`{$good["id"]}`,`add`)'>+</button>
            </div>
        </div>
        ";
    }
    $html = file_get_contents(dirname(__DIR__) . '/tmpl/cart.html');
    return str_replace('{{PRODUCTS}}', $productsHtml, $html);
}

function AjaxAction()
{
    session_start();
    $type = $_GET['type'];
    switch ($type) {
        case 'add':
            add();
            break;
        case 'dec':
            dec();
            break;
    }
}

function add()
{
    $id = $_GET['id'];
    if (empty($id) || !is_numeric($id)) {
        return false;
    }
    $sql = 'SELECT name, price, type FROM products WHERE id = ' . $id;
    $product = mysqli_fetch_assoc(mysqli_query(connect(), $sql));
    $sql = "SELECT `procent` FROM discounts WHERE `type` = '{$product['type']}'";
    $discount = mysqli_fetch_assoc(mysqli_query(connect(), $sql))['procent'];
    if (!empty($discount)){
        $price = $product['price'] - ($product['price'] * $discount / 100);
    } else{
        $price = $product['price'];
    }
    if (!isset($_SESSION['goods'])) {
        $_SESSION['goods'] = [];
        $good = [
            'id' => $id,
            'name' => $product['name'],
            'price' => $price,
            'count' => 1,
        ];
        array_push($_SESSION['goods'], $good);
        return true;
    } else {
        foreach ($_SESSION['goods'] as &$good) {
            if ($good['id'] == $id) {
                $good['count']++;
                return true;
            }
        }
        $_SESSION['goods'][] = [
            'id' => $id,
            'name' => $product['name'],
            'price' => $price,
            'count' => 1,
        ];
        return true;
    }
}

function dec()
{
    $id = $_GET['id'];
    foreach ($_SESSION['goods'] as &$good) {
        if ($good['id'] == $id) {
            if ($good['count'] > 1) {
                $good['count']--;
                return true;
            } else {
                delete();
                return true;
            }
        }
    }
    return false;
}

function delete()
{
    $id = $_GET['id'];
    foreach ($_SESSION['goods'] as $key => $good) {
        if ($good['id'] == $id) {
            unset($_SESSION['goods'][$key]);
            return true;
        }
    }
    return false;
}

function OrderAction()
{
    session_start();
    $conn = connect();
    $order = [
        'user_id' => $_SESSION['user']['id'],
        'phone' => mysqli_real_escape_string($conn, $_GET['phone']),
        'email' => mysqli_real_escape_string($conn, $_GET['email']),
        'address' => mysqli_real_escape_string($conn, $_GET['address']),
        'status' => 'new',
    ];
    $sqlOrder = "INSERT INTO `orders` (`user_id`, `address`, `tel`, `email`, `status`) VALUES 
                 ('{$order['user_id']}', '{$order['address']}', '{$order['phone']}', '{$order['email']}', '{$order['status']}')";

    if (!mysqli_query($conn, $sqlOrder)) {
        die("Ошибка при добавлении заказа: " . mysqli_error($conn));
    }

    $order_id = mysqli_insert_id($conn);
    foreach ($_SESSION['goods'] as $good) {
        $sql = "INSERT INTO `order_list` (`order_id`, `prod_id`, `count`) VALUES 
                ('$order_id', '{$good['id']}', '{$good['count']}')";
        if (!mysqli_query($conn, $sql)) {
            die("Ошибка при добавлении товара в заказ: " . mysqli_error($conn));
        }
    }
    mysqli_close($conn);
    $_SESSION['goods'] = [];
    header('Location: /?p=cart');
}