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
Route::any('get-token' , 'Wechat@get_token');

//发送模板消息
Route::any('send-message' , 'Wechat@send_message');

//创建自定义菜单
Route::any('create-menu' , 'Wechat@create_menu');
Route::any('create' , 'Wechat@create');

/* ---------------------------------------------------------------------- */

//后台首页
Route::any('/admin/index' , 'Admin\Index@index');
//后台登陆
Route::any('/admin/login' , 'Admin\Index@login');
//执行登陆页面
Route::any('/admin/login-do' , 'Admin\Index@login_do');
//执行退出操作
Route::any('/admin/loginout' , 'Admin\Index@loginout');
//加载右侧主体
Route::any('/admin/welcome' , 'Admin\Index@welcome');


/* 管理员管理类 */
//管理员列表
Route::any('/admin/admin-list' , 'Admin\Admin@admin_list');
//添加管理员页面
Route::any('/admin/admin-add' , 'Admin\Admin@admin_add');
//执行添加
Route::any('/admin/admin-add-do' , 'Admin\Admin@admin_add_do');
//修改管理员页面
Route::any('/admin/admin-modify' , 'Admin\Admin@admin_modify');
//执行修改管理员操作
Route::any('/admin/admin-modify-do' , 'Admin\Admin@admin_modify_do');
//执行删除管理员操作
Route::any('/admin/admin-delete' , 'Admin\Admin@admin_delete');


/* 类型管理类*/
//类型列表
Route::any('/admin/type-list' , 'Admin\Admin@type_list');
//添加类型
Route::any('/admin/type-add' , 'Admin\Admin@type_add');
//执行添加类型
Route::any('/admin/type-add-do' , 'Admin\Admin@type_add_do');
//修改类型页面
Route::any('/admin/type-modify' , 'Admin\Admin@type_modify');
//执行修改类型页面
Route::any('/admin/type-delete' , 'Admin\Admin@type_delete');

/* 勋章级别管理类*/
//勋章级别列表
Route::any('/admin/medal-list' , 'Admin\Admin@medal_list');
//添加勋章页面
Route::any('/admin/medal-add' , 'Admin\Admin@medal_add');
//执行添加
Route::any('/admin/medal-add-do' , 'Admin\Admin@medal_add_do');
//修改勋章页面
Route::any('/admin/medal-modify' , 'Admin\Admin@medal_modify');
//执行修改勋章操作
Route::any('/admin/medal-modify-do' , 'Admin\Admin@medal_modify_do');
//执行删除勋章操作
Route::any('/admin/medal-delete' , 'Admin\Admin@medal_delete');

/*充值管理类*/
//充值记录列表
Route::any('/admin/recharge-list' , 'Admin\Admin@recharge_list');

/*提现明细管理类*/
//提现明细列表
Route::any('/admin/forward-list' , 'Admin\Admin@forward_list');

/*法律常识管理类*/
//法律常识列表
Route::any('/admin/knowledge-list' , 'Admin\Admin@knowledge_list');
//添加法律常识页面
Route::any('/admin/knowledge-add' , 'Admin\Admin@knowledge_add');
//执行添加法律常识操作
Route::any('/admin/knowledge-add-do' , 'Admin\Admin@knowledge_add_do');
//修改法律常识页面
Route::any('/admin/knowledge-modify' , 'Admin\Admin@knowledge_modify');
//执行修改法律常识操作
Route::any('/admin/knowledge-modify-do' , 'Admin\Admin@knowledge_modify_do');
//执行删除法律常识操作
Route::any('/admin/knowledge-delete' , 'Admin\Admin@knowledge_delete');


/*用户、律师管理类*/
//用户/律师列表
Route::any('/admin/lawyer-list' , 'Admin\Admin@lawyer_list');
//执行删除用户/律师操作
Route::any('/admin/lawyer-delete' , 'Admin\Admin@lawyer_delete');

/*积分管理类*/
//积分详情列表
Route::any('/admin/integral-list' , 'Admin\Admin@integral_list');
