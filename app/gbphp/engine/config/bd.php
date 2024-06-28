<?php

function connect()
{
    static $link;
    if (empty($link)) {
        $link = mysqli_connect('mariadb', 'root', 'rootroot', 'dbphp');
    }
    return $link;
}
