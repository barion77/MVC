<?php 

use app\core\Route;
use app\exceptions\RouteException;

session_start();

include '../app/classes/dev.php';
include '../app/classes/basic.php';

try {

} catch (RouteException $e) {
    exit($e->getMessage());
}

require '../app/classes/autoload.php';
require '../routes/web.php';

Route::check();

