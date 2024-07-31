<?php
include '../engine/Autoload.php';
use engine\Autoload;
spl_autoload_register([new Autoload(), 'loadClass']);

use modules\Users as Users;

$user = new Users();

var_dump($user->getOne(1));