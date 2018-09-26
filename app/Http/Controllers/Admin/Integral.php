<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Integral extends Controller
{
    /**
     * 积分详情列表
     */
    public function integral_list(){
        $integral_list = DB::table('integral_info')->paginate(10);
        foreach ($integral_list as $integral){
            $integral->i_ctime = date('Y-m-d H:i:s' , $integral->i_ctime);
        }
        return view('admin.integral.integral_list' , ['title'=>'积分列表' , 'integral_list'=>$integral_list]);
    }
}
