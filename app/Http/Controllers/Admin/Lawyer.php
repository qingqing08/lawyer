<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Lawyer extends Controller
{
    /**
     * 用户/律师列表
     */
    public function lawyer_list(){
        $user_list = DB::table('user')->paginate(10);

        foreach ($user_list as $user){
            if ($user->u_type == 0){
                $user->u_type = '未选择身份';
            } else if ($user->u_type == 1) {
                $user->u_type = '用户';
            } else {
                $user->u_type = '律师';
            }

            $user->u_ctime = date("Y-m-d H:i:s" , $user->u_ctime);
        }
        $count = DB::table('user')->count();
        return view('admin.lawyer.list' , ['count'=>$count , 'title'=>'用户/律师列表' , 'user_list'=>$user_list]);
    }

    /**
     * 执行删除用户/律师操作
     */
    public function lawyer_delete(){

    }
}
