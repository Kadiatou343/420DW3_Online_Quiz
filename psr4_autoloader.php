<?php
/*
 * A inclure dans mon index.php
 */
const PROJECT_ROOT = __DIR__ . DIRECTORY_SEPARATOR;

$spr4_autoloader = function (string $class_name) : bool {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class_name) . '.php';
    $file_path = PROJECT_ROOT . $file;
    if (file_exists($file_path)) {
        require_once $file;
        return true;
    }
    return false;
};

spl_autoload_register($spr4_autoloader);










