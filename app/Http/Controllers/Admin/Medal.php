<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Medal extends Controller
{
    /**
     * 勋章级别添加
     */
    public function medal_add(){

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
        
        return view('admin.medal.medal_list');
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
