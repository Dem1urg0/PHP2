<?php
echo 'Задание 1';
/*Создать галерею фотографий. Она должна состоять из одной страницы,
 на которой пользователь видит все картинки в уменьшенном виде.
 При клике на фотографию она должна открыться в браузере в новой вкладке.
Размер картинок можно ограничивать с помощью свойства width.*/

$html = file_get_contents('index.html');
$block = '';
$pics = explode('
', file_get_contents('img/img.txt'));
foreach ($pics as $pic) {
    $block .= "<a target=\"_blank\" href=\"$pic\"><img class=\"img\" src=\"$pic\"></a>";
}

echo str_replace('{{image_placeholder}}', $block, $html);

echo 'Задание 2';
/*Строить фотогалерею, не указывая статичные ссылки к файлам,
 а просто передавая в функцию построения адрес папки с изображениями.
 Функция сама должна считать список файлов и построить фотогалерею со ссылками в ней.*/

$pics = scandir('img');
$block = '';
$pics = explode('
', file_get_contents('img/img.txt'));
foreach ($pics as $pic) {
    $block .= "<a target=\"_blank\" href=\"$pic\"><img class=\"img\" src=\"$pic\"></a>";
}
echo str_replace('{{image_placeholder}}', $block, $html);

echo 'Задание 3*';
/*[ для тех, кто изучал JS-1 ]
При клике по миниатюре нужно показывать полноразмерное изображение в модальном окне*/

$html = file_get_contents('js.html');
$block = '';
$pics = explode('
', file_get_contents('img/img.txt'));
foreach ($pics as $pic) {
    $block .= "<img class=\"img\" src=\"$pic\">";
    $block .= "";
}
echo str_replace('{{image_placeholder}}', $block, $html);

echo 'Задание 4**';
/*4.1 Создать логирование времени входа пользователся в log.txt*/
/*4.2 В файле log1.txt максимум 10 строк,
 как только больше - последняя строка уходит в файл log2.txt,
 когда он заполниться то его последняя строка в file3.txt и тд*/

function logWrite($num = 1, $stringToReplace = '')
{
    $filePath = __DIR__ . "/log/log$num.txt";
    $logArr = explode(PHP_EOL, file_get_contents($filePath));
        if ($stringToReplace !== '') {
            array_unshift($logArr, $stringToReplace);
        } else {
            array_unshift($logArr, date('Y-m-d H:i:s'));
        }
        file_put_contents("log/log$num.txt", implode(PHP_EOL, $logArr));
    if (count($logArr) === 10) {
        $num++;
        $stringToReplace = array_pop($logArr);
        file_put_contents($filePath, implode(PHP_EOL, $logArr));
        logWrite($num, $stringToReplace);
    }
}
logWrite();
