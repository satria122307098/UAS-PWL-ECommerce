<?php
session_start();
require_once 'config.php';

spl_autoload_register(function ($class) {
    if (file_exists("controllers/$class.php")) {
        require_once "controllers/$class.php";
    } elseif (file_exists("models/$class.php")) {
        require_once "models/$class.php";
    }
});

$controller = $_GET['c'] ?? 'UserController';
$method = $_GET['m'] ?? 'index';

if (class_exists($controller)) {
    $obj = new $controller();
    if (method_exists($obj, $method)) {
        $obj->$method();
    } else {
        echo "Method <b>$method</b> tidak ditemukan di controller <b>$controller</b>";
    }
} else {
    echo "Controller <b>$controller</b> tidak ditemukan.";
}
