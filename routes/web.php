<?php

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('get-token' , 'Wechat@get_token');
Route::get('send-message' , 'Wechat@send_message');
Route::get('create-menu' , 'Wechat@create_menu');
Route::get('create' , 'Wechat@create');