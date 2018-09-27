<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use JSSDK;
use Base;
use QRcode;


class Question extends Controller{
    //

    public function question_list(){
        $question_list = DB::table('question')->get();

        foreach ($question_list as $question){
            $user_info = DB::table('user')->where('u_id' , $question->u_id)->first();
            $question->u_id = $user_info->wx_name;
            $question->wx_headimg = $user_info->wx_headeimg;
            $type = DB::table('type')->where('t_id' , $question->q_type)->first();
            $question->q_type = $type->t_name;
            $question->q_ctime = date("Y-m-d H:i:s" , $question->q_ctime);
            $question->q_content = str_limit($question->q_content , 50 , '........');
        }
        return view('wechat.question.list' , ['question_list'=>$question_list]);
    }

    public function release_question(){
        $appid = "wx996fa85abda5e676";
        $appSecret = "4fa1f553b231ec2bed06cdc7d3491ae0";
        $jssdk = new JSSDK($appid, $appSecret);
//        dd($jssdk);
        //返回签名基本信息
        $signPackage = $jssdk->getSignPackage();
//        dd($signPackage);
        $openid = Session::get('openid');
//        echo $openid;
        return view('wechat.question.release' , ['openid'=>$openid , 'signPackage'=>$signPackage , 'webhost'=>"http://".$_SERVER['HTTP_HOST']]);
    }

    public function pay_do(){
        $money = Input::get('money');
        $q_content = Input::get('q_content');
        $openid = Input::get('openid');

        $user_info = DB::table('user')->where('wx_openid' , $openid)->first();
        $data = [
            'money' =>  $money,
            'q_content' =>  $q_content,
            'u_id'  =>  $user_info->u_id,
            'q_type'    =>  1,
            'q_ctime'   =>  time(),
            'validity_time' =>  7,
        ];

        $result = DB::table('question')->insertGetId($data);
        if ($result){
            $order_id = date("YmdHis").rand('100000' , 999999);
            $order_data = [
                'u_id'  =>  $user_info->u_id,
                'data_id'   =>  $result,
                'order_num' =>  $order_id,
                'o_content' =>  '发布悬赏问题',
                'o_price'   =>  $money,
                'o_type'    =>  1,
                'o_ctime'   =>  time(),
            ];

            $res = DB::table('order')->insert($order_data);
            if ($res){
                $qrcode = new QRcode();
                $qrurl = $this->getQrUrl($order_id,$money);

                //2.生成二维码
                $qrcode::png($qrurl,"./paycode.png",'H',10,1,false);
                echo "<img src='http://pengqq.jebt.top/paycode.png'>";
            }
        }

    }

    public function getQrUrl($pid,$money){
        $base = new Base();
        //调用统一下单API
        $params = [
            'appid'=> $base::APPID,
            'mch_id'=> $base::MCHID,
            'nonce_str'=>md5(time()),
            'body'=> '发布悬赏问题',
            'out_trade_no'=> $pid,
            'total_fee'=> $money*100,
            'spbill_create_ip'=>$_SERVER['SERVER_ADDR'],
            'notify_url'=> $base::NOTIFY,
            'trade_type'=>'NATIVE',
            'product_id'=>$pid
        ];
        $arr = $base->unifiedorder($params);
        return $arr['code_url'];
    }
}
