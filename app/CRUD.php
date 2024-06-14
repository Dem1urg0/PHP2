<?php
/*
5*. Написать CRUD-блок для управления выбранным модулем через единую функцию
(doFeedbackAction()).
*/

$link = mysqli_connect('mariadb', 'root', 'rootroot', 'dbphp');

$sql = 'SELECT * FROM `products`';
$db = mysqli_query($link, $sql);
//можно написать функцию рендеринга полей input для create/update
$fields = mysqli_fetch_fields($db);

$sqlProductsCount = 'SELECT `id` FROM `products` ORDER BY `id` DESC LIMIT 1';
$productCount = mysqli_query($link, $sqlProductsCount);
$count = (int)mysqli_fetch_assoc($productCount)['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['CRUD']) {
        case 'create':
            $sqlRec = 'INSERT INTO `products` (`id`, `name`, `price`, `summery`, `img`) VALUES (NULL,' . " '" .
                $_POST['name'] . "' , " . $_POST['price'] . ", '" .
                mysqli_real_escape_string($link, $_POST['summery']) . "', '" . $_POST['img'] . "')";
            var_dump($sqlRec);
            mysqli_query($link, $sqlRec);
            break;
        case 'read':
            $sqlRec = 'SELECT * FROM `products` WHERE id =' . $_POST['id'];
            $sqlRec = mysqli_query($link, $sqlRec);
            var_dump(mysqli_fetch_assoc($sqlRec));
            break;
        case 'update':
            $postArr = [
                'id' => $_POST['id'],
                'name' => $_POST['name'],
                'price' => $_POST['price'],
                'summery' => $_POST['summery'],
                'img' => $_POST['img']
            ];;
            if ($postArr['id']) {
                $postArr = array_filter($postArr);
                $postArr = array_map(function($key, $value) {
                    return "$key = '$value'";
                }, array_keys($postArr), $postArr);
                $sqlProd = implode(',',$postArr );
                $sqlRec = 'UPDATE `products` SET `name` = ' . $sqlProd .
                    'WHERE `products`.`id` = '. $_POST['id'];
                mysqli_query($link, $sqlRec);
            } else echo 'Ведите id';
            break;
        case 'delete':
            $sqlRec = 'DELETE FROM `products` WHERE id = ' . $_POST['id'];
            mysqli_query($link, $sqlRec);
            break;
    }
}


?>
<form method="post">
    <h2>Create</h2>
    <input type="hidden" name="CRUD" value="create">
    <p>name: <input name="name" type="text"></p>
    <p>price: <input name="price" type="text"></p>
    <p>summery: <input name="summery" type="text"></p>
    <p>img: <input name="img" type="text"></p>
    <input type="submit">
</form>
<form method="post">
    <h2>Read</h2>
    <input type="hidden" name="CRUD" value="read">
    <p>id of product: <input name="id" type="text"></p>
    <input type="submit">
</form>
<form method="post">
    <h2>Update</h2>
    <input type="hidden" name="CRUD" value="update">
    <p>id of product: <input name="id" type="text"></p>
    <p>name: <input name="name" type="text"></p>
    <p>price: <input name="price" type="text"></p>
    <p>summery: <input name="summery" type="text"></p>
    <p>img: <input name="img" type="text"></p>
    <input type="submit">
</form>
<form method="post">
    <h2>Delete</h2>
    <input type="hidden" name="CRUD" value="delete">
    <p>id of product: <input name="id" type="text"></p>
    <input type="submit">
</form>
