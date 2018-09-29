<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class Qrcode extends Controller{
    //

    public function show(){
        $src = file_get_contents("http://pengqq.jebt.top/qrcode");

        $arr = json_decode($src , true);

//        dd($arr);

        return view('show' , ['data'=>$arr]);
    }

    public function status(){
        $code = Input::post('code');
        $num = Input::post('num');
//dd(Input::post());
        $openid = Session::get('openid');
        $code_show = DB::table('wx')->where(['code'=>$code,'num'=>$num])->first();
        if (!empty($code_show)){
//            echo $status;die;
            if ($code_show->status == 0){
                return ['msg'=>'已开锁' , 'code'=>1];
            } elseif($code_show->status == 1){
                return ['msg'=>'已取消' , 'code'=>2];
            } else {
                return ['msg'=>'已关锁' , 'code'=>3];
            }
        } else {
            return ['code'=>2 , 'msg'=>'请使用手机微信扫一扫登录'];
        }
    }

    public function unlock(){
        $code = Input::get('code');
        $num = Input::get('num');
        if (empty(Input::get('openid'))){
            $openid = $this->get($code);
        } else {
            $openid = Input::get('openid');
        }

        Session::put('openid' , $openid);
        $num_show = DB::table('wx')->where(['num'=>$num , 'status'=>0])->first();
        if (!empty($num_show)){
            echo "单车正在使用中";die;
        }
        $wx_info = DB::table('wx')->where(['openid'=>$openid , 'num'=>$num , 'code'=>$code])->first();

        if (empty($wx_info)){
            $wx_list = DB::table('wx')->where(['openid'=>$openid , 'status'=>0])->first();
            if (!empty($wx_list)){
                echo "您正在使用其他车辆,请关锁后在扫";die;
            } else {
                $arr = [
                    'openid'    =>  $openid,
                    'status'    =>  0,
                    'num'       =>  $num,
                    'code'      =>  $code,
                    'ctime' =>  time(),
                ];

                $result = DB::table('wx')->insert($arr);
            }


        } else {
            $result = DB::table('wx')->where('openid' , $openid)->update(['code'=>$code]);
        }

        if ($result){
            $wx_info = DB::table('wx')->where('openid' , $openid)->first();
            echo "已开锁";
        } else {
            echo "开锁失败";
        }
        file_put_contents('./unlock.log' , 'aaa' , FILE_APPEND);
    }

    public function close_lock(){
        dd(Input::get());
    }
}
