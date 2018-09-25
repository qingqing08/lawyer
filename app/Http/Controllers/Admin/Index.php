<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Index extends Controller
{
    /**
     *  后台登陆页面
     */
    public function login(){
        return view('admin.login.login');
    }

    /**
     *  执行登陆操作
     */
    public function login_do(Request $request){

        $username = $request -> post('username');

        $password = $request -> post('password');

        $userinfo = DB::table('admin_user') -> where(['a_name' => $username]) -> first();

        if(empty($userinfo)){

            return (['code' => 2 , 'msg' => '账号密码不匹配']);

        }else{

            $pwd = md5($password . $userinfo -> a_time);

            if($userinfo -> a_password != $pwd){

                return (['code' => 3 , 'msg' => '账号密码不匹配']);

            }else{

                session::put('userinfo' , $userinfo);

                return (['code' => 1 , 'msg' => '登陆成功']);


            }

        }



        return (['code' => 1 , 'msg' => '登陆成功']);
    }

    /**
     * 后台首页
     */
    public function index(Request $request){

        $userinfo =  session :: get('userinfo');

        return view('admin.index.index' , ['userinfo' => $userinfo]);
    }

    /**
     *  加载右侧主体
     */
    public function welcome(){

        return view ('admin.index.welcome');

    }

    /**
     *  执行退出操作
     */
    public function logout(){

        session :: put('userinfo' , null);
        
    }
}
