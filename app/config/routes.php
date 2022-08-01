<?php 

use app\core\Route;

Route::get('/', 'MainControllerr@index');
Route::get('/posts', 'PostController@index');
Route::get('/news', 'NewsController@index');

Route::check();