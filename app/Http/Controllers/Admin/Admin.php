<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Admin extends Controller
{
    /** 管理员添加 */
    public function admin_add(){
        return view('admin.admin.admin_add');
    }

    /** 执行添加 */
    public function admin_add_do(){

    }

    /** 管理员列表 */
    public function admin_list(){

    }

    /** 管理员修改 */
    public function admin_modify(){

    }

    /** 执行修改 */
    public function admin_modify_do(){

    }

    /** 管理员删除 */
    public function admin_delete(){

    }
}
