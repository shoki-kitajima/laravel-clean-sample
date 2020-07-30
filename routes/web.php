<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', '\Packages\Controllers\TaskController@view');
Route::post('/register', '\Packages\Controllers\TaskController@register');
Route::post('/toggleIsDone', '\Packages\Controllers\TaskController@toggleIsDone');
Route::post('/archive', '\Packages\Controllers\TaskController@archive');
