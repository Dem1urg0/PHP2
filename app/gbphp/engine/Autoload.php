<?php

namespace engine;

class Autoload
{
    public function loadClass($FullclassName)
    {
        $filePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $FullclassName) . '.php';
        if (file_exists($filePath)) {
            include_once $filePath;
        }
    }
}