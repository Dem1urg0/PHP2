<?php
/*Задание 1*/
echo "Задание 1<br>";
/*С помощью цикла while вывести все числа в промежутке от 0 до 100,
которые делятся на 3 без остатка.
*/
$i = 0;

while ($i <= 100) {
    if ($i % 3 == 0) {
        echo "$i ";
    }
    $i++;
}

/*Задание 2*/
echo "<br>Задание 2<br>";
/*С помощью цикла do…while написать функцию для вывода чисел от 0 до 10, чтобы результат выглядел так:
0 – это ноль.
1 – нечётное число.
2 – чётное число.
3 – нечётное число.
…
10 – чётное число.
*/
$n = 0;
do {
    if ($n == 0) {
        echo "$n - ноль ";
    } else if ($n % 2 == 0) {
        echo "$n - честное число ";
    } else {
        echo "$n - нечестное число ";
    }
    $n++;
} while ($n <= 10);

/*Задание 3*/
echo "<br>Задание 3<br>";
/*Объявить массив, в котором в качестве ключей будут использоваться названия областей,
а в качестве значений – массивы с названиями городов из соответствующей области.
Вывести в цикле значения массива, чтобы результат был таким:
Московская область:
Москва, Зеленоград, Клин.
Ленинградская область:
Санкт-Петербург, Всеволожск, Павловск, Кронштадт.
Рязанская область…(названия городов можно найти на maps.yandex.ru)
*/

$map = [
    'Moscow_obl' => ['Moscow', 'Khimki', 'Dedovsk'],
    'Leningrad_obl' => ['Gatchina', 'Vyborg', 'Saint Petersburg'],
    'Kaliningrad_obl' => ['Gusev', 'Sovetsk', 'Kaliningrad']
];
foreach ($map as $obl => $citys) {
    echo "<br>$obl:<br>";
    foreach ($citys as $city) {
        if ($city == end($citys)) {
            echo "$city.";
        } else {
            echo "$city, ";
        }
    }
}

/*Задание 4*/
echo "<br>Задание 4<br>";
/*Объявить массив, индексами которого являются буквы русского языка,
 а значениями – соответствующие латинские буквосочетания
(‘а’=> ’a’, ‘б’ => ‘b’, ‘в’ => ‘v’, ‘г’ => ‘g’, …, ‘э’ => ‘e’, ‘ю’ => ‘yu’, ‘я’ => ‘ya’).
Написать функцию транслитерации строк.
*/

$letters = [
    'а' => 'a',
    'б' => 'b',
    'в' => 'v',
    'г' => 'g',
    'д' => 'd',
    'е' => 'ea',
    'ё' => 'yo',
    'ж' => 'zh',
    'з' => 'z',
    'и' => 'i',
    'й' => 'ii',
    'к' => 'k',
    'л' => 'l',
    'м' => 'm',
    'н' => 'n',
    'о' => 'o',
    'п' => 'p',
    'р' => 'r',
    'с' => 's',
    'т' => 't',
    'у' => 'u',
    'ф' => 'f',
    'х' => 'h',
    'ц' => 'c',
    'ч' => 'ch',
    'ш' => 'sh',
    'щ' => 'shch',
    'ъ' => 'y',
    'ы' => 'i',
    'ь' => 'y',
    'э' => 'e',
    'ю' => 'iu',
    'я' => 'ja'
];
function transtLetter($str)
{
    global $letters;
    $newstr = '';
    foreach (mb_str_split($str) as $letter) {
        if (isset($letters[$letter])) {
            $newstr .= $letters[$letter];
        } else {
            $newstr .= $letter;
        }
    }
    return $newstr;
}

echo transtLetter('привет как дела?');

/*Задание 5*/
echo "<br>Задание 5<br>";
/*Написать функцию, которая заменяет в строке пробелы на подчеркивания и возвращает видоизмененную строчку.
*/

function spaceChange($str)
{
    $newstr = '';
    foreach (mb_str_split($str) as $sim) {
        if ($sim == ' ') {
            $newstr .= '_';
        } else {
            $newstr .= $sim;
        }
    }
    return $newstr;
}

echo spaceChange('Как писать правильно?');

/*Задание 6*/
echo "<br>Задание 6<br>";
/*В имеющемся шаблоне сайта заменить статичное меню (ul - li) на генерируемое через PHP.
 Необходимо представить пункты меню как элементы массива и вывести их циклом. Подумать,
 как можно реализовать меню с вложенными подменю? Попробовать его реализовать.
*/
$menu = [
    'Главная' => [],
    'Новости' => ['Новости о спорте', 'Новости о политике', 'Новости о мире'],
    'Контакты' => [],
    'Справка' => []
];
function menuGen($menu)
{
    $html = file_get_contents('index.html');
    $menuRender = '';
    foreach ($menu as $menuItem => $subMenuItems) {
        if (count($subMenuItems) == 0) {
            $menuRender .= "<div><a><span>$menuItem</span></a></div>";
        } else {
            $menuRender .= "<div><a><span>$menuItem</span></a><div>";
            foreach ($subMenuItems as $subMenuItem) {
                $menuRender .= "<a>$subMenuItem</a>";
            }
            $menuRender .= "</div>";
        }
        $menuRender .= "</div>";

    }
    echo str_replace('Replace', $menuRender, $html);
}

menuGen($menu);

/*Задание 7*/
echo "<br>Задание *7<br>";
/*Вывести с помощью цикла for числа от 0 до 9,
 НЕ используя тело цикла. Выглядеть это должно так:
for(…){// здесь пусто}*/

for ($i = 0; $i < 10; print $i, $i++) {
}

/*Задание 8*/
echo "<br>Задание *8<br>";
/*Повторить третье задание, но вывести на экран только города, начинающиеся с буквы «К»*/

$map = [
    'Moscow_obl' => ['Moscow', 'Khimki', 'Dedovsk'],
    'Leningrad_obl' => ['Gatchina', 'Vyborg', 'Saint Petersburg'],
    'Kaliningrad_obl' => ['Gusev', 'Sovetsk', 'Kaliningrad']
];
foreach ($map as $obl => $citys) {
    echo "<br>$obl:<br>";
    foreach ($citys as $city) {
        foreach (str_split($city) as $letter) {
            if ($letter == 'K') {
                if ($city == end($citys)) {
                    echo "$city.";
                } else {
                    echo "$city, ";
                }
            }
            break;
        }
    }
}
/*Задание 9*/
echo "<br>Задание *9<br>";
/*Объединить две ранее написанные функции в одну, которая получает строку на русском языке,
 производит транслитерацию и замену пробелов на подчеркивания
(аналогичная задача решается при конструировании url-адресов на основе названия статьи в блогах).
 */

function transtLetterAndSpaces($str)
{
    global $letters;
    $newstr = '';
    foreach (mb_str_split($str) as $letter) {
        if (isset($letters[$letter])) {
            $newstr .= $letters[$letter];
        } elseif ($letter == ' ') {
            $newstr .= '_';
        } else {
            $newstr .= $letter;
        }
    }
    return $newstr;
}

echo transtLetterAndSpaces('как писать правильно?');

/*Задание 10*/
echo "<br>Задание *10<br>";
/*Обход деревьев с помощью рекурсии*/

$tree = [
    1 => [
        2 => [
            4 => [
                8 => ['a', 'b', 'c'],
                9 => ['a', 'b', 'c']
            ],
            5 => [
                10 => ['a', 'b', 'c'],
                11 => ['a', 'b', 'c']
            ]
        ],
        3 => [
            6 => ['a', 'b', 'c'],
            7 => ['a', 'b', 'c']
        ]
    ]
];

function treeWalk($tree)
{
    foreach ($tree as $element) {
        if (is_array($element)) {
            treeWalk($element);
        } else{
            echo $element;
        }
    }

}
treeWalk($tree);
