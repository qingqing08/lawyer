<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Medal extends Controller
{
    /**
     * 勋章级别添加
     */
    public function medal_add(){
        echo "勋章级别添加";
    }

    /**
     * 执行添加
     */
    public function medal_add_do(){

    }

    /**
     * 勋章级别列表
     */
    public function medal_list(){
        $medal_list = DB::table('medal')->get();

        foreach ($medal_list as $medal){
            $medal->m_ctime = date('Y-m-d H:i:s' , $medal->m_ctime);
        }
        return view('admin.medal.medal_list' , ['title'=>'勋章级别列表' , 'medal_list'=>$medal_list]);
    }

    /**
     * 勋章级别修改
     */
    public function medal_modify(){


    }

    /**
     * 执行修改
     */
    public function medal_modify_do(){

    }

    /**
     * 勋章级别删除
     */
    public function medal_delete(){

    }
}
