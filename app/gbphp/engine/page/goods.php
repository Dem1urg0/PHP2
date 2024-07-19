<?php
function indexAction()
{
    session_start();
    if(empty($_SESSION['user'])){
        header('Location: /?p=login');
    }
    $sql = 'SELECT * FROM `products`';
    $result = mysqli_query(connect(), $sql);

    $products = [];
    $i = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $products[$i] = $row;
        $i++;
    }
    $block = '';

    foreach ($products as $product) {
        $discount = discount($product['type']);
        $price = $product['price'] - $discount;
        $block .= "<div>
<a href=\"?p=goods&a=one&id={$product['id']}\"><img class=\"img\" src=\"img/{$product['img']}\"></a>
<div style='display: flex; justify-content: space-between'><p>" . $product['name'] . '</p>' . "<p>Disc: $discount%</p>" . '<p>Price:' . $price . '</p></div></div>';
    }
    $html = file_get_contents(dirname(__DIR__) . '/tmpl/catalog.html');
    return str_replace('{{BLOCK}}', $block, $html);
}

function oneAction()
{
    session_start();
    if(empty($_SESSION['user'])){
        header('Location: /?p=login');
    }
    $sql = "SELECT * FROM `products` WHERE `id` =" . $_GET['id'];
    $img = mysqli_fetch_assoc(mysqli_query(connect(), $sql));
    $block = "<img class=\"img\" src=\"/img/{$img['file']}\">";

    $views = $img['views'];
    $views++;
    $sqlUpd = 'UPDATE `imgs` SET `views` =' . $views . " WHERE `imgs`.`id` =" . $_GET['id'];
    mysqli_query(connect(), $sqlUpd);

    $sql_review = "INSERT INTO `reviews` (`img_id`, `id`, `stars`, `text`) VALUES ('2', NULL, '4', 'Хорошо')";

    $id = $_GET['id'];
    $sql_review = "SELECT `stars`, `text` FROM `reviews` WHERE `img_id` =" . "$id";
    $reviews = mysqli_fetch_all(mysqli_query(connect(), $sql_review));

    $block_review = '';
    $num = 1;
    foreach ($reviews as $review) {
        $block_review .= "<div><h4>ОТЗЫВ:$num</h4><p>SCORE:" . $review[0] . "/5" . "</p><p>TEXT:" . $review[1] . "</p></div>";
        $num++;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST["stars"]) && isset($_POST["message"])) {
            $stars = intval($_POST["stars"]);
            $message = mysqli_real_escape_string(connect(), $_POST['message']);

            $sqlUpd_review = "INSERT INTO `reviews` (`img_id`, `stars`, `text`) VALUES ($id, $stars, '$message')";
            mysqli_query(connect(), $sqlUpd_review) or die(mysqli_error(connect()));
        }
    }
    $sql_score = 'SELECT `stars` FROM `reviews` WHERE `img_id` =' . $id;
    $score = mysqli_fetch_all(mysqli_query(connect(), $sql_score));
    $sum = 0;
    foreach ($score as $item) {
        $sum += $item[0];
    }
    if (count($score) == 0) {
        $avg = 'нет';
    } else $avg = $sum / count($score);

    $html = file_get_contents(dirname(__DIR__) . '/tmpl/product.html');
    $addBlock = '<button class="add" onclick="addButton(' . $id . ')">ADD TO CART</button>';
    $placeholders = ['{{ADD}}', '{{REVIEW}}', '{{AVG}}', '{{BLOCK}}', '{{VIEWS}}'];
    $replacements = [$addBlock, $block_review, $avg, $block, $views];
    return str_replace($placeholders, $replacements, $html);
}

function discount($type)
{
    $sql = $sql = "SELECT `procent` FROM discounts WHERE `type` = '$type'";
    $result = mysqli_fetch_assoc(mysqli_query(connect(), $sql));
    return $result['procent'];
}

