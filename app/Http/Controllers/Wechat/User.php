<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Base;
use QRcode;
class User extends Controller{
    //
    public function self(){
        $openid = Session::get('openid');
        $url = Input::url();
        if (empty($openid)){
            header("location:https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx996fa85abda5e676&redirect_uri=http://pengqq.jebt.top/weixin-auth?response_type=code&scope=snsapi_userinfo&state=$url#wechat_redirect");
        } else {
            $user_info = DB::table('user')->where('wx_openid' , $openid)->first();
            if (empty($user_info)){
                header("location:https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx996fa85abda5e676&redirect_uri=http://pengqq.jebt.top/weixin-auth?response_type=code&scope=snsapi_userinfo&state=$url#wechat_redirect");
            } else {
                if ($user_info->u_type == 0){
                    return view('wechat.user.register' , ['wx_openid'=>$openid]);
                } else {
                    $user_info = DB::table('user') -> where(['wx_openid' => $openid]) -> first();
                    return view('wechat.user.self' ,['user_info' => $user_info]);
                }
            }
        }
    }

    /**
     *  选择律师还是普通
     */
    public function register_do(Request $request){

        $data = $request -> post('sex');

        $openid = session::get('openid');

        if($data == '律师'){
            DB::table('user') -> where(['wx_openid' => $openid]) -> update(['u_type' => 2]);
        }else{
            DB::table('user') -> where(['wx_openid' => $openid]) -> update(['u_type' => 1]);
        }

        header("refresh:1;url=/selfShow");
    }


    /**
     *  展示自己
     */
    public function selfShow(){

        $openid = session::get('openid');

        $user_info = DB::table('user') -> where(['wx_openid' => $openid]) -> first();

        return view('wechat.user.self' , ['user_info' => $user_info]);
    }

    /**
     * 展示充值二维码
     */
    public function code(){
        $order_id = date("YmdHis").rand('100000' , 999999);
        return view('wechat.user.showcode' , ['order_id' => $order_id]);
    }

    /**
     *  充值
     */
    public function generateCode(Request $request){

        $pid = $request -> get('order_id');

        $money = $request -> get('money');

        $price = $money * 100;

        $openid = session::get('openid');

        $user_info = DB::table('user') -> where(['wx_openid' => $openid]) -> first();

        $arr = [
            'uid' => $user_info -> u_id,
            'r_money' => $money,
            'm_paytype' => 1,
            'r_status' => 0,
            'r_ctime' =>time()
        ];

        dd($arr);
        $id = DB::table('recharge') -> insertGetId($arr);

        $data = [
            'uid' => $user_info -> u_id,
            'data_id' => $id,
            'order_num' => $pid,
            'o_content' => '充值',
            'o_price' => 2,
            'o_type' => '充值',
            'o_ctime' => time()
        ];

        $base = new Base();

        $params = [
            'appid'=> $base::APPID,
            'mch_id'=> $base::MCHID,
            'nonce_str'=>md5(time()),
            'body'=> '扫码支付',
            'out_trade_no'=> $pid,
            'total_fee'=> $price,
            'spbill_create_ip'=>$_SERVER['SERVER_ADDR'],
            'notify_url'=> $base::NOTIFY,
            'trade_type'=>'NATIVE',
            'product_id'=>$pid
        ];

        $arr = $base -> unifiedorder($params);
        $url =  $arr['code_url'];

        $qrcode = new QRcode();
        $qrcode::png($url);

    }

}
