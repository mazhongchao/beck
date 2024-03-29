<?php
function class_autoloader($class_name): bool
{
    $class_name = strtolower($class_name);
    $class_file = __DIR__ . DIRECTORY_SEPARATOR . $class_name . '.php';

    if (file_exists($class_file)) {
        require_once $class_file;
    }

    return (class_exists($class_name, false) || interface_exists($class_name, false));
}

spl_autoload_register('class_autoloader');
