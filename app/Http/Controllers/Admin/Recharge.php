<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use View;
use Memcache;

class Recharge extends Controller
{
    /**
     * 充值记录列表
     */
    public function recharge_List(){
    	$data = DB::table('recharge')
    	->join('user','recharge.u_id','user.u_id')
    	->get();                                                                               
    	return view("admin.recharge.recharge_list",['data'=>$data,'title'=>'充值记录']);
    }
}
