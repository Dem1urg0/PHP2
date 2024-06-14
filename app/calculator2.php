<?php

/*
2. Создать калькулятор, который будет определять тип выбранной
пользователем операции, ориентируясь на нажатую кнопку.
*/
$a = '';
$b = '';
$type = 'Сложить';
$c = '?';
if (!empty($_GET['a']) && !empty($_GET['b']) && !empty($_GET['type'])) {
    if (is_numeric($_GET['a']) && is_numeric($_GET['b'])) {
        $a = $_GET['a'];
        $b = $_GET['b'];
        $type = $_GET['type'];
    } else echo 'Введите цифры';
} else echo 'Заполните поля';
switch ($type) {
    case'Plus':
        $c = $a + $b;
        break;
    case'Minus':
        $c = $a - $b;
        break;
    case'Multy':
        $c = $a * $b;
        break;
    case'Del':
        if ($b == 0) {
            echo 'На ноль делить нельзя';
        } else {
            $c = $a / $b;
        }
        break;
}

echo '<br>' . 'Ответ = ' . $c . '<br>';


?>
<form action="">
    <input type="hidden" name="page" value="2">
    <input type='text' name="a" value=<?= $a ?>>
    <input type='text' name="b" value=<?= $b ?>>
    <button name="type" value="Plus">Сложить</button>
    <button name="type" value="Minus">Отнять</button>
    <button name="type" value="Multy">Умножить</button>
    <button name="type" value="Del">Разделить</button>
</form>


