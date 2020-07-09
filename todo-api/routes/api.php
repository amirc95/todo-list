<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/items', "ToDoController@index");
Route::post('/item', "ToDoController@add");
Route::put('/item/{id}', "ToDoController@update");
Route::delete('/item/{id}', "ToDoController@delete");
