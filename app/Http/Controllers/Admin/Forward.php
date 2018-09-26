<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use View;
use Memcache;

class Forward extends Controller
{
    /**
     * 提现明细列表
     */
    public function forward_list(){
       $data = DB::table('forward')
       ->join('user','forward.u_id','user.u_id')
       ->get();
       // print_r($data);exit;
       return view('admin.forward.forward_list',['data'=>$data,'title'=>'体现明细']);
    }
}
