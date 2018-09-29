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
//            if ($num == 0){
//                dd($code_show);
//            }

            if ($code_show->status == 0){
//                $price = date("s" , time()) - date("s" , $code_show->ctime);
                $data['price'] = round($code_show->price+0.2,1);

                DB::table('wx')->where(['code'=>$code , 'num'=>$num])->update($data);
//                if ($num == 0){
//                    dd($code_show);
//                }
                return ['msg'=>'已开锁' , 'code'=>1 , 'money'=>$data['price']];


            } elseif($code_show->status == 1){
                return ['msg'=>'已取消' , 'code'=>2];
            } else {
                return ['msg'=>'已关锁' , 'code'=>3];
            }
        } else {
            return ['code'=>2 , 'msg'=>'请使用手机微信扫一扫解锁'];
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
        $code = Input::get('code');
        $num = Input::get('num');

        $code_show = DB::table('wx')->where(['code'=>$code,'num'=>$num])->first();
        if (empty($code_show)){
            echo "无该车辆信息";
        } else {
            if ($code_show->status != 0){
                echo "该车辆不是开锁状态";
            } else {
                $data = [
                    'status'    =>  2,
                ];

                $result = DB::table('wx')->where(['code'=>$code,'num'=>$num,'status'=>0])->update($data);
                if ($result){
                    $user_info = DB::table('user')->where('wx_openid' , $code_show->openid)->first();
                    $num = $num+1;
                    $url = "http://pengqq.jebt.top/send-message?openid=".$code_show->openid."&username=".$user_info->wx_name."&bake_num=".$num."&money=".$code_show->price;
                    file_get_contents($url);
                    DB::table('wx')->where(['code'=>$code,'num'=>$num-1,'status'=>2])->delete();
                    echo "<script>window.history.back();</script>";
                } else {
                    echo "关锁失败";
                }
            }
        }
    }

    public function price(){
        $code = Input::post('code');
        $num = Input::post('num');

        $show = DB::table('wx')->where(['code'=>$code , 'num'=>$num])->first();

        $price = $show->ctime - time();
        $data['price'] = $price/10;

        $result = DB::table('wx')->where(['code'=>$code , 'num'=>$num])->update($data);
        if ($result){
            return $data['price'];
        }
    }
}
