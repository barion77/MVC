<?php 

use app\core\Route;

Route::get('/', 'MainController@index');
Route::get('/posts', 'PostController@indexx');
Route::get('/news', 'NewsController@index');
Route::put('/news', 'NewsController@update');