<?php
use \App\modules\Good;
session_start();

include dirname(__DIR__) . '/services/Autoload.php';
spl_autoload_register([new Autoload(), 'loadClass']);



$good = new Good();
$good->filling([
    'id' => '27',
    'name' => 'test',
    'price' => '999',
]);

$good->save();
$good->delete();



var_dump($good->getAll());
//var_dump($good->getOne(2));
//var_dump($good->getOne(12));
//
//$good2 = new \App\modules\User();
//var_dump($good2->getAll());
//var_dump($good2->getOne(12));