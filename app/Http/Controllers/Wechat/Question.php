<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use JSSDK;
use Base;


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
        $base = new Base();
        $openid = $_GET['openid'];
        $openid = "owRHY1cti1oJT7ZfEgzXNbTyJPEo";
        $money = $_GET['money'];
        $q_content = Input::get('q_content');
        $out_trade_no = date('Ymd').time().rand(10000,99999);
        $user_info = DB::table('user')->where('wx_openid' , $openid)->first();
        $user_id = $user_info->u_id;

        $data = [
            'u_id'  =>  $user_id,
            'q_content' =>  $q_content,
            'q_type'    =>  2,
            'money' =>  $money,
            'q_ctime'   =>  time(),
            'validity_time' =>  2,
        ];

        DB::table('question')->insert($data);
        $params = [
            'appid'=> $base::APPID,
            'mch_id'=> $base::MCHID,
            'nonce_str'=>uniqid(),
            'body'=> '发布悬赏问题',
            'out_trade_no'=> $out_trade_no,
            'total_fee'=> $money*100,//2分
            'spbill_create_ip'=>$_SERVER['REMOTE_ADDR'],
            'notify_url'=> $base::NOTIFY,
            'trade_type'=>'JSAPI',
            'openid'=> $openid,
        ];

        // var_dump($params);die;
        $arr = $base->unifiedorder($params);
        // var_dump($arr);die;

        // $arr = $this->getQrUrl($out_trade_no,$money * 100 , $openid);
        if($arr){
            $info['appid'] = $base::APPID;
            $info['package'] = "prepay_id=".$arr['prepay_id'];
            $info['timestamp'] = time();
            $info['nonceStr'] = uniqid();
            $info['signType'] = "MD5";
            $params = [
                'appId' => $info['appid'],
                'package' =>$info['package'],
                'timeStamp'	=> $info['timestamp'],
                'nonceStr'		=> $info['nonceStr'],
                'signType' => $info['signType']
            ];
            $sign = $base->getSign($params);
            $info['paySign'] = $sign;
            $info['status'] = 1;
            // return $info;
            echo json_encode($info);
        }else{
            echo json_encode(['status'=>2,'data'=>$arr]);
        }
    }
}
