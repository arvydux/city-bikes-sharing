<?php

class ScriptAutoloader
{
    public static function ClassLoader(string $class_name): void
    {
        $file_path = __DIR__ . "/$class_name.php";

        if (is_readable($file_path)) {
            require $file_path;
        }
    }
}

spl_autoload_register('ScriptAutoloader::ClassLoader');
