<?php
/* ЗАДАНИЕ 1
Объявить две целочисленные переменные $a и $b и задать им произвольные начальные значения.
Затем написать скрипт, который работает по следующему принципу:
Если $a и $b положительные, вывести их разность.
Если $а и $b отрицательные, вывести их произведение.
Если $а и $b разных знаков, вывести их сумму.
Ноль можно считать положительным числом.
*/
echo "Задание 1<br>";
$a = rand(-15, 15);
$b = rand(-15, 15);
echo "$a and $b <br>";
if ($a >= 0 && $b >= 0) {
    echo $a - $b;
} else if ($a <= 0 && $b <= 0) {
    echo $a * $b;
} else {
    echo $a + $b;
}
/* ЗАДАНИЕ 2
Присвоить переменной $а значение в промежутке [0..15].
С помощью оператора switch организовать вывод чисел от $a до 15.
*/
echo "<br>Задание 2<br>";
$a = rand(0, 15);
echo "number:$a<br>";
switch ($a) {
    case 0:
        echo "0<br>";
    case 1:
        echo "1<br>";
    case 2:
        echo "2<br>";
    case 3:
        echo "3<br>";
    case 4:
        echo "4<br>";
    case 5:
        echo "5<br>";
    case 6:
        echo "6<br>";
    case 7:
        echo "7<br>";
    case 8:
        echo "8<br>";
    case 9:
        echo "9<br>";
    case 10:
        echo "10<br>";
    case 11:
        echo "11<br>";
    case 12:
        echo "12<br>";
    case 13:
        echo "13<br>";
    case 14:
        echo "14<br>";
    case 15:
        echo "15<br>";
}
/* ЗАДАНИЕ 3
Реализовать основные 4 арифметические операции в виде функций с двумя параметрами.
Обязательно использовать оператор return.
*/
echo "Задание 3 <br>";
echo "$a and $b <br>";
function adding($a, $b)
{
    $c = $a + $b;
    return "$c<br>";
}

function subtract($a, $b)
{
    $c = $a - $b;
    return "$c<br>";
}

function multiply($a, $b)
{
    $c = $a * $b;
    return "$c<br>";
}

function split($a, $b)
{
    $c = $a / $b;
    return "$c<br>";
}

echo adding($a, $b);
echo subtract($a, $b);
echo multiply($a, $b);
echo split($a, $b);
/* ЗАДАНИЕ 4*/
echo "Задание 4 <br>";
/* Реализовать функцию с тремя параметрами: function mathOperation($arg1, $arg2, $operation),
где $arg1, $arg2 – значения аргументов, $operation – строка с названием операции.
В зависимости от переданного значения операции выполнить одну из арифметических операций
(использовать функции из пункта 3) и вернуть полученное значение (использовать switch).*/

function mathOperation($arg1, $arg2, $operation)
{
    switch ($operation) {
        case 'adding':
            echo adding($arg1, $arg2);
            break;
        case 'subtract':
            echo subtract($arg1, $arg2);
            break;
        case 'multiply':
            echo multiply($arg1, $arg2);
            break;
        case 'split':
            echo split($arg1, $arg2);
            break;
    }
}

mathOperation(2, 3, 'subtract');
/*ЗАДАНИЕ 5*/
echo "Задание 5 <br>";
/*Посмотреть на встроенные функции PHP. Используя имеющийся HTML шаблон,
вывести текущий год в подвале при помощи встроенных функций PHP.
*/

$html = file_get_contents('html.html');
echo str_replace('{{date}}', date('Y'), $html);

/*ЗАДАНИЕ 6 доп*/
echo "Задание 6* <br>";
/*С помощью рекурсии организовать функцию возведения числа в степень.
 Формат: function power($val, $pow), где $val – заданное число, $pow – степень.
 */

function power($val, $pow)
{
    if ($pow == 0) {
        echo "1 <br>";
    } else if ($pow == 1) {
        echo "$val<br>";
    } else {
        $pow--;
        $val *= $val;
        power($val, $pow);
    }
}

power(3, 3);

/*ЗАДАНИЕ 7 доп*/
echo "Задание 7* <br>";
/*Написать функцию, которая вычисляет текущее время и возвращает его в формате с правильными склонениями,
например: 22 часа 15 минут, 21 час 43 минуты.
*/
function getTime()
{
    $hours = date('h');
    $min = date('i');
    $sec = date('s');
    $hourName = switchName('hour',getName($hours));
    $minName = switchName('min',getName($min));
    $secName = switchName('sec',getName($sec));
    return "$hours час$hourName $min минут$minName $sec секунд$secName";
}

function getName($num)
{
    $lastNum = substr($num, -1);
    if ($num >= 11 && $num <= 14) {
        return 1;
    } elseif ($lastNum >= 5 || $lastNum == 0) {
        return 1;
    } elseif ($lastNum >= 2 && $lastNum <= 4) {
        return 2;
    } elseif ($lastNum == 1) {
        return 3;
    }
}

function switchName($name, $num)
{
    if ($name == 'min' || $name == 'sec') {
        switch ($num) {
            case 1:
                return '';
            case 2:
                return 'ы';
            case 3:
                return 'а';
        }
    } elseif ($name == 'hour') {
        switch ($num) {
            case 1:
                return 'ов';
            case 2:
                return 'а';
            case 3:
                return '';
        }
    }
    echo 'daaa';
}

echo getTime();