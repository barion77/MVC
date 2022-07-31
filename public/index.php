<?php 

include '../app/classes/dev.php';

use app\core\Route;

spl_autoload_register(function ($class) {
    $path = str_replace('\\', '/', '../' . $class . '.php');
    if (file_exists($path)) {
        require $path;
    }
});

session_start();

$route = new Route;
$route->run();