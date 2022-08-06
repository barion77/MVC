<?php 

use app\core\Route;

session_start();

include '../classes/dev.php';
include '../classes/basic.php';

require '../classes/autoload.php';
require '../routes/web.php';

Route::check();

