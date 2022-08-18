<?php 

use app\core\Route;

Route::get('/', 'MainController@index');
Route::get('/posts', 'PostController@index');
Route::get('/news/:id', 'NewsController@index');
Route::put('/news/:id/:slug', 'NewsController@update');
