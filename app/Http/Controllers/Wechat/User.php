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
            'u_id' => $user_info -> u_id,
            'r_money' => $money,
            'm_paytype' => 1,
            'r_status' => 0,
            'r_ctime' =>time()
        ];

//        dd($arr);
        $id = DB::table('recharge') -> insertGetId($arr);

        $data = [
            'u_id' => $user_info -> u_id,
            'data_id' => $id,
            'order_num' => $pid,
            'o_content' => '充值',
            'o_price' => $money,
            'o_type' => '2',
            'o_ctime' => time()
        ];

        DB::table('order') -> insert($data);

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

    /**
     *  提现
     */
    public function forward(){

        $openid = session::get('openid');

        $user_info = DB::table('user') -> where(['wx_openid' => $openid]) -> first();

        return view('wechat.user.forward' , ['balance' => $user_info -> balance]);
    }

    /**
     *  提现到微信
     */
    public function wechat(Request $request){

        $money = $request -> get('money') * 100;
        $openid = session :: get('openid');
        $key = 'sdg634fghgu5654rtghfghgfy4575htg';
        $order_id = date('YmdHis').rand(000000 , 999999);

        $user_info = DB::table('user') -> where(['wx_openid' => $openid]) -> first();

        //添加forward表
        $forward = [
            'u_id' => $user_info -> u_id,
            'f_money' => $money /100 ,
            'f_type' => 1,
            'f_account' => $user_info -> wx_name,
            'f_ctime' => time()
        ];
        $id = DB::table('forward') -> insertGetId($forward);

        //添加order表
        $order = [
            'u_id' => $user_info -> u_id,
            'data_id' => $id,
            'order_num' => $order_id,
            'o_content' => '提现',
            'o_price' => $money / 100,
            'o_type' => '3',
            'o_ctime' => time()
        ];

        DB::table('order') -> insert($order);

        $params = [
            'mch_appid' => 'wx3d751ea7a2f7c064',
            'mchid' => '1499304962' ,
            'nonce_str' => md5(time()),
            'partner_trade_no' => $order_id,
            'openid' => 'ooz740W33bwlhiNviuFzmmHwctOc',
            'check_name' => 'NO_CHECK',
            'amount' => $money,
            'desc' => '提现',
            'spbill_create_ip' => $_SERVER['REMOTE_ADDR']
        ];


        //排序
        ksort($params);

        //去除数组的空值
        array_filter($params);
        if(isset($params['sign'])){
            unset($params['sign']);
        }

        //组装字符
        $stringA = urldecode(http_build_query($params));

        $stringSignTemp = $stringA . '&key=' . $key;

        $sign = strtoupper(md5($stringSignTemp));

        $params['sign'] = $sign;

        //数组转xml
        function ArrToXml($arr)
        {
            if(!is_array($arr) || count($arr) == 0) return '';

            $xml = "<xml>";
            foreach ($arr as $key=>$val)
            {
                if (is_numeric($val)){
                    $xml.="<".$key.">".$val."</".$key.">";
                }else{
                    $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
                }
            }
            $xml.="</xml>";
            return $xml;
        }

        $xml = ArrToXml($params);
        
        //post 带证书
        function postData($url,$postfields){

            $ch = curl_init();
            $params[CURLOPT_URL] = $url;    //请求url地址
            $params[CURLOPT_HEADER] = false; //是否返回响应头信息
            $params[CURLOPT_RETURNTRANSFER] = true; //是否将结果返回
            $params[CURLOPT_FOLLOWLOCATION] = true; //是否重定向
            $params[CURLOPT_POST] = true;
            $params[CURLOPT_POSTFIELDS] = $postfields;
            $params[CURLOPT_SSL_VERIFYPEER] = false;
            $params[CURLOPT_SSL_VERIFYHOST] = false;
            //以下是证书相关代码
            $params[CURLOPT_SSLCERTTYPE] = 'PEM';
            $params[CURLOPT_SSLCERT] = '/home/wwwroot/lawyer/public/wx_zhengshu/apiclient_cert.pem';
            $params[CURLOPT_SSLKEYTYPE] = 'PEM';
            $params[CURLOPT_SSLKEY] = '/home/wwwroot/lawyer/public/wx_zhengshu/apiclient_key.pem';

            curl_setopt_array($ch, $params); //传入curl参数
            $content = curl_exec($ch); //执行
            curl_close($ch); //关闭连接
            return $content;
        }
        $url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";

        $comtent = postData($url , $xml);

        //将结果转化为数组
        function XmlToArr($xml)
        {
            if($xml == '') return '';
            libxml_disable_entity_loader(true);
            $arr = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
            return $arr;
        }
        $arr = XmlToArr($comtent);

        file_put_contents('forward.log' , print_r($arr , true) , FILE_APPEND);

        if($arr['return_code'] == 'SUCCESS' && $arr['result_code'] == 'SUCCESS'){

            $res = DB::table('order') -> where(['order_num' => $arr['partner_trade_no']]) -> update(['o_status' => 2 , 'o_paystatus' => 1]);

            $order_info = DB::table('order')-> where(['order_num' => $arr['partner_trade_no']]) -> first();

            DB::table('forward') -> where(['f_id' => $order_info -> data_id]) -> update(['f_status' => 1]);

            $openid = session::get('openid');

            $result = DB::table('user') -> where(['wx_openid' => $openid]) -> decrement('balance' , $money /100);

            if($res && $result){
                header("refresh:1;url=/self");
            }
        }
    }

}
