<?php 

use app\core\Route;

Route::get('/', 'MainController@index');
Route::get('/posts', 'PostController@index');
Route::get('/news-page', 'NewsController@index');

Route::check();