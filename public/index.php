<?php 

use app\core\Route;

session_start();

include '../app/classes/dev.php';
include '../app/classes/basic.php';

require '../app/core/autoload.php';
require '../app/config/routes.php';

Route::check();