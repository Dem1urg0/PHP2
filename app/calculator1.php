<?php
/*
1. Создать форму-калькулятор операциями: сложение, вычитание, умножение, деление.
Не забыть обработать деление на ноль! Выбор операции можно осуществлять с помощью
 тега <select>.
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
switch ($type){
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
echo  '<br>'. 'Ответ = ' . $c . '<br>';
?>
<form>
    <input type='text' name="a" value=<?= $a ?>>
    <input type='text' name="b" value=<?= $b ?>>
    <select name="type" id="">
        <option value="Plus">Сложить</option>
        <option value="Minus">Отнять</option>
        <option value="Multy">Умножить</option>
        <option value="Del">Разделить</option>
    </select>
    <input type="submit">
</form>


