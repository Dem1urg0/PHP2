<?php
/*
1. Создать модуль корзины, в которую можно как добавлять товары, так и удалять их из неё. (через сессии)
Добавить товары можно в файле goods.php или Задача 1.1
*/

function indexAction()
{
    $productsHtml = '';
    foreach ($_SESSION['goods'] as $good){
        $totalPrice = $good['price'] * $good['count'];
        $productsHtml .= "<div class ='cart-item'>
            <h3>{$good['name']}</h3>
            <p>Price per item: {$good['price']} </p>
            <p>Total price: {$totalPrice} </p>
        </div>
        <div>
        <div class ='change'>
            <form>
                <input type='hidden' name='a' value='change'>
                <input type='hidden' name='p' value='cart'>
                <input type='hidden' name='id' value='{$good['id']}'>
                <input  type='text' name='count' value='{$good['count']}'>
                <button type='submit'>Change</button>
            </form> 
            <form>
                <input type='hidden' name='a' value='delete'>
                <input type='hidden' name='p' value='cart'>
                <input type='hidden' name='id' value='{$good['id']}'>
                <button class='delete'>Delete</button>
            </form>
            </div>
        </div>
        ";
    }
    $html = file_get_contents(dirname(__DIR__) . '/tmpl/cart.html');
    return str_replace('{{PRODUCTS}}', $productsHtml, $html);
}
function addAction()
{
    $id = $_GET['id'];
    $sql = 'SELECT name, price FROM products WHERE id = ' . $id;
    $product = mysqli_fetch_assoc(mysqli_query(connect(), $sql));
    if (!isset($_SESSION['goods'])) {
        $_SESSION['goods'] = [];
        $good = [
            'id' => $id,
            'name' => $product['name'],
            'price' => $product['price'],
            'count' => 1,
        ];
        array_push($_SESSION['goods'], $good);
    } else {
        $found = false;
        foreach ($_SESSION['goods'] as &$good) {
            if ($good['id'] == $id) {
                $good['count']++;
                $found = true;
                header('Location:' . $_SERVER['HTTP_REFERER']);
            }
        }
        if (!$found) {
            $_SESSION['goods'][] = [
                'id' => $id,
                'name' => $product['name'],
                'price' => $product['price'],
                'count' => 1,
            ];
        }
    }
    header('Location:' . $_SERVER['HTTP_REFERER']);
}

function changeAction()
{
    $id = $_GET['id'];
    $count = $_GET['count'];
    foreach ($_SESSION['goods'] as &$good) {
        if ($good['id'] == $id) {
            $good['count'] = $count;
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}

function deleteAction()
{
    $id = $_GET['id'];
    foreach ($_SESSION['goods'] as $key => $good) {
        if ($good['id'] == $id) {
            unset($_SESSION['goods'][$key]);
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}