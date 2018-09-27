<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use View;
use Memcache;

class Hotspot extends Controller{
    //
    public function hotspot_list(){
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
                    $data = DB::table('hotspot')->get();
                    // print_r($data);exit;
                    return view('wechat.hotspot.hotspot_list',['data'=>$data]);
                }
            }
        }
    }
    //热点详细信息
    public function hotspot_view(){
        $id = input::get('h_id');
        $datainfo=DB::table('hotspot')
        ->where('h_id',$id)
        ->first();

        return view('wechat.hotspot.hotspot_view',['datainfo'=>$datainfo]);
    }
    //评论
    public function hotspot_comment(){
        $openid = Session::get('openid');
        $data = DB::table('user')
        ->where('wx_openid',$openid)
        ->first();
        $u_id=$data->u_id;
        $content = input::post('content');
        $h_id = input::post('h_id');
        $res=DB::table('con_hotspot')-insert([
            'h_id'=>$h_id,
            'u_id'=>$u_id,
            'content'=>$content,
            'level'=>0
        ]);
        if($res){
            return ['font'=>'评论成功','code'=>1]; 
        }else{
            return ['font'=>'网络繁忙','code'=>2]; 
        }

    }

}
