<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use View;
use Memcache;


class Type extends Controller
{
    /***
     * 类型添加
     */
    public function type_add(){
        return view('admin.type.type_add',['title'=>'类型添加']);
    }

    /**
     * 执行添加
     */
    public function type_add_do(){
        $name=input::post('t_name');
        $res = DB::table('type')->insert([
            't_name'=>$name,
            'c_time'=>time()
        ]);
        if($res){
            return ['font'=>'添加成功','code'=>1];
        }else{
            return ['font'=>'添加失败','code'=>2];
        }
    }

    /**
    *类型列表
    */
    public function type_list(){
         $data = DB::table('type')->get();
         return view('admin.type.type_list',['data'=>$data,'title'=>'类型列表']);
    }
    /**
    * 类型修改
    */
    public function type_modify(){
        $tid=input::get('t_id');
        $data = DB::table('type')
        ->where('t_id',$tid)
        ->first();
        return view('admin.type.type_modify',['data'=>$data,'title'=>'类型修改']);
    }

    /**
    * 执行修改
    */
    public function type_modify_do(){
        $tid=input::post('t_id');
        $tname=input::post('t_name');
        $time=time();
        $res = DB::table('type')
              ->where('t_id',$tid)
              ->update(['t_name'=>$tname,'c_time'=>$time]);
        if($res){
                return ['font'=>'修改成功','code'=>1];
        }else{
                return ['font'=>'修改失败','code'=>2];
            }
    }

    /**
     * 类型删除
     */
    public function type_delete(){
        $t_id=input::post('id');
        $dele = DB::table('type')
            ->where(['t_id'=>$t_id])
            ->delete();
            // ->update(['stutus'=>2]);
        if($dele){
            return ['font'=>'删除成功','code'=>1];
        }else{
              return ['font'=>'删除失败','code'=>2];
        }
    }

}
