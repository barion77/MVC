<?php 

use app\core\Route;
use app\exceptions\RouteException;

session_start();

include '../app/classes/dev.php';

require '../app/classes/BaseMethods.php';
require '../app/classes/autoload.php';
require '../routes/web.php';

try {

} catch (RouteException $e) {
    exit($e->getMessage());
}

Route::check();

