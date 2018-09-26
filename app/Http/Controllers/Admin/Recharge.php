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
    		// foreach ($data as $k => $v) {
    		// 	if($v->m_paytype==1){
    		// 		$v->m_pay=='微信';
    		// 	}elseif ($v->m_paytype==2) {
    		// 		$v->m_pay=='支付宝';
    		// 	}else{
    		// 		$v->m_pay=='银行卡';
    		// 	}
    		// }
    	// print_r($data);exit;
    	return view("admin.recharge.recharge_list",['data'=>$data,'title'=>'充值记录']);
    }
}
