<?php
function indexAction(){
    session_start();
    if($_SESSION['user']['admin'] != '1'){
        header('Location: /?p=user');
    }
    $products = search();
    $html = file_get_contents(dirname(__DIR__) . '/tmpl/changeProd.html');
    $prodBlock = '<div class="products-container">';
    $dir = dirname(dirname(__DIR__));
    foreach ($products as $product){
        $prodBlock .= "
    <div class='product-form'><form>
        <h3>ID: {$product[0]}</h3>
        <img src='{$dir}/public/img/{$product[4]}' class='product-image'>
        <div class='form-group'>
            <label for='image'>Image:</label>
            <input type='file' name='image' accept='image/*'>
        </div>
        <div class='form-group'>
        <label for='name'>NAME:</label>
        <input type='text' name='name' value='{$product[1]}'>
        </div>
        <div class='form-group'>
            <label for='price'>Price:</label>
            <input type='number' name='price' value='{$product[2]}'>
        </div>
        <div class='form-group'>
            <label for='type'>Type:</label>
            <input type='text' name='type' value='{$product[3]}'>
        </div>
        <div class='button-group'>
            <input type='hidden' name='id' value='{$product[0]}'>
            <input type='hidden' name='a' value='change'>
            <input type='hidden' name='p' value='changeProd'>
            <button class='change-btn' type='submit'>Change</button>
        </div>
       </form>
       <form class='deleteForm'>
            <input type='hidden' name='p' value='changeProd'>
            <input type='hidden' name='a' value='delete'>
            <input type='hidden' name='id' value='{$product[0]}'>
            <button class='delete-btn'>Delete</button>
        </form>
       </div>
        ";
    }
    $prodBlock .= '</div>';
    return str_replace('{{PRODUCTS}}', $prodBlock, $html);
}

function changeAction(){
    session_start();
    if ($_SESSION['user']['admin'] != '1'){
        header('Location: /?p=user');
    }
    if (empty($_GET['id']) || empty($_GET['name']) || empty($_GET['price']) || empty($_GET['type'])){
        header('Location: /?p=changeProd');
    }
    $id = $_GET['id'];
    $name = $_GET['name'];
    $price = $_GET['price'];
    $type = $_GET['type'];
    $sql = "UPDATE products SET name = '{$name}', price = '{$price}', type = '{$type}' WHERE id = {$id}";
    mysqli_query(connect(), $sql);
    header('Location: /?p=changeProd');
}
function deleteAction(){
    session_start();
    if ($_SESSION['user']['admin'] != '1'){
        header('Location: /?p=user');
    }
    $id = $_GET['id'];
    $sql = 'DELETE FROM products WHERE id = '.$id;
    mysqli_query(connect(), $sql);
    header('Location: /?p=changeProd');
}

function search()
{
    if($_SESSION['user']['admin'] != '1'){
        header('Location: /?p=user');
    }
    if (empty($_GET['name'])){
        $sql = 'SELECT * FROM products';
        $products = mysqli_fetch_all(mysqli_query(connect(), $sql));
        return $products;
    }
    $productName = $_GET['name'];
    $sql = 'SELECT * FROM products WHERE name LIKE "%'.$productName.'%"';
    $products = mysqli_fetch_all(mysqli_query(connect(), $sql));
    return $products;
}
function createAction()
{   session_start();
    if($_SESSION['user']['admin'] != '1'){
        header('Location: /?p=user');
    }
    if (empty($_GET['name']) || empty($_GET['price']) || empty($_GET['type'])){
        header('Location: /?p=changeProd');
    }
    $name = $_GET['name'];
    $price = $_GET['price'];
    $type = $_GET['type'];
    $sql = "INSERT INTO products (name, price, type, img) VALUES ('{$name}', '{$price}', '{$type}', '/')";
    mysqli_query(connect(), $sql);
    header('Location: /?p=changeProd');
}