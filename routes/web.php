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


/* 这几个方法勿动 */
//生成token
Route::get('get-token' , 'Wechat@get_token');

//发送模板消息
Route::get('send-message' , 'Wechat@send_message');

//创建自定义菜单
Route::get('create-menu' , 'Wechat@create_menu');
Route::get('create' , 'Wechat@create');

/* ---------------------------------------------------------------------- */

//后台首页
Route::get('/admin/index' , 'Admin\Index@index');

/* 管理员管理类 */
//管理员列表
Route::get('/admin/admin-list' , 'Admin\Admin@admin_list');
//添加管理员页面
Route::get('/admin/admin-add' , 'Admin\Admin@admin_add');