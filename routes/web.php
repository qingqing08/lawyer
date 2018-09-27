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
Route::get('weixin-auth' , 'Wechat@weixin_auth');

/* ---------------------------------------------------------------------- */

//后台首页
Route::get('/admin/index' , 'Admin\Index@index');
//后台登陆
Route::get('/admin/login' , 'Admin\Index@login');
//执行登陆页面
Route::post('/admin/login-do' , 'Admin\Index@login_do');
//执行退出操作
Route::get('/admin/loginout' , 'Admin\Index@loginout');
//加载右侧主体
Route::get('/admin/welcome' , 'Admin\Index@welcome');


/* 管理员管理类 ----- Admin */
//管理员列表
Route::get('/admin/admin-list' , 'Admin\Admin@admin_list');
//添加管理员页面
Route::get('/admin/admin-add' , 'Admin\Admin@admin_add');
//执行添加
Route::post('/admin/admin-add-do' , 'Admin\Admin@admin_add_do');
//修改管理员页面
Route::get('/admin/admin-modify' , 'Admin\Admin@admin_modify');
//执行修改管理员操作
Route::post('/admin/admin-modify-do' , 'Admin\Admin@admin_modify_do');
//执行删除管理员操作
Route::post('/admin/admin-delete' , 'Admin\Admin@admin_delete');
//管理员启停
Route::post('/admin/admin-startstop' , 'Admin\Admin@admin_startstop');

/* 类型管理类 ------ Type */
//类型列表
Route::get('/admin/type-list' , 'Admin\Type@type_list');
//添加类型
Route::get('/admin/type-add' , 'Admin\Type@type_add');
//执行添加类型
Route::post('/admin/type-add-do' , 'Admin\Type@type_add_do');
//修改类型页面
Route::get('/admin/type-modify' , 'Admin\Type@type_modify');
//执行修改类型操作
Route::post('/admin/type-modify-do' , 'Admin\Type@type_modify_do');
//执行删除修改类型操作
Route::post('/admin/type-delete' , 'Admin\Type@type_delete');

/* 勋章级别管理类 ------ Medal */
//勋章级别列表
Route::get('/admin/medal-list' , 'Admin\Medal@medal_list');
//添加勋章页面
Route::get('/admin/medal-add' , 'Admin\Medal@medal_add');
//执行添加
Route::post('/admin/medal-add-do' , 'Admin\Medal@medal_add_do');
//修改勋章页面
Route::get('/admin/medal-modify' , 'Admin\Medal@medal_modify');
//执行修改勋章操作
Route::post('/admin/medal-modify-do' , 'Admin\Medal@medal_modify_do');
//执行删除勋章操作
Route::post('/admin/medal-delete' , 'Admin\Medal@medal_delete');

/*充值管理类 ----- Recharge */
//充值记录列表
Route::get('/admin/recharge-list' , 'Admin\Recharge@recharge_list');

/*提现明细管理类 ----- Forward */
//提现明细列表
Route::get('/admin/forward-list' , 'Admin\Forward@forward_list');

/*法律常识管理类 ------ Knowledge */
//法律常识列表
Route::get('/admin/knowledge-list' , 'Admin\Knowledge@knowledge_list');
//添加法律常识页面
Route::get('/admin/knowledge-add' , 'Admin\Knowledge@knowledge_add');
//执行添加法律常识操作
Route::post('/admin/knowledge-add-do' , 'Admin\Knowledge@knowledge_add_do');
//修改法律常识页面
Route::get('/admin/knowledge-modify' , 'Admin\Knowledge@knowledge_modify');
//执行修改法律常识操作
Route::post('/admin/knowledge-modify-do' , 'Admin\Knowledge@knowledge_modify_do');
//执行删除法律常识操作
Route::post('/admin/knowledge-delete' , 'Admin\Knowledge@knowledge_delete');


/*用户、律师管理类 ----- Lawyer */
//用户/律师列表
Route::get('/admin/lawyer-list' , 'Admin\Lawyer@lawyer_list');
//执行删除用户/律师操作
Route::post('/admin/lawyer-delete' , 'Admin\Lawyer@lawyer_delete');

/*积分管理类 ------ Integral */
//积分详情列表
Route::get('/admin/integral-list' , 'Admin\Integral@integral_list');

/* 实时热点 */
Route::get('/hotspot-list' , 'Wechat\Hotspot@hotspot_list');

/* 找律师 */
Route::get('/find-lawyer' , 'Wechat\Lawyer@find_lawyer');

/* 个人中心 */
Route::get('/self' , 'Wechat\User@self');
Route::post('/register-do' , 'Wechat\User@register_do');

/* 法律常识 */
Route::get('/knowledge-list' , 'Wechat\Knowledge@knowledge_list');
//常识列表
Route::get('/type' , 'Wechat\Knowledge@type');

/* 发布悬赏问题 */
//问题列表
Route::get('/question-list' , 'Wechat\Question@question_list');
//发布问题
Route::get('/release-question' , 'Wechat\Question@release_question');
Route::get('pay-do' , 'Wechat\Question@pay_do');

