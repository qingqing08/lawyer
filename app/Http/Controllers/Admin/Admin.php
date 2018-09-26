<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class Admin extends Controller
{
    /** 管理员添加 */
    public function admin_add(){

        return view('admin.admin.admin_add');
    }

    /** 执行添加 */
    public function admin_add_do(){
        $post=Input::post();
        unset($post['_token']);
        unset($post['repass']);
        $post['a_time']=time();
        $post['a_password']=md5($post['a_password']);
        $res=DB::table('admin_user')->insert($post);
        if($res){
            return ['msg'=>'添加成功','code'=>1];
        }else{
            return ['msg'=>'添加失败','code'=>2];
        }
    }

    /** 管理员列表 */
    public function admin_list(){
        $data=DB::table('admin_user')->select()->get();
        foreach($data as $v){
            $v->a_time=date('Y-m-d H:i:s',$v->a_time);
        }
//        dd($data);
        return view('admin.admin.admin_list',['data'=>$data]);
    }

    /** 管理员修改 */
    public function admin_modify(){
        $a_id=Input::get('a_id');
        $data=DB::table('admin_user')->where(['a_id'=>$a_id])->get();
//        dd($data[0]);
        return view('admin.admin.admin_modify',['data'=>$data[0]]);
    }

    /** 执行修改 */
    public function admin_modify_do(){
        $post=Input::post();
        dd($post);
        $data=DB::table('admin_user')->where(['a_id'=>$a_id])->get();
    }

    /** 管理员删除 */
    public function admin_delete(){
        $a_id=Input::get('a_id');
        $res=DB::table('admin_user')->where(['a_id'=>$a_id])->delete();
        if($res){
            return ['msg'=>'删除成功','code'=>1];
        }else{
            return ['msg'=>'删除失败','code'=>2];
        }
    }
}
