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
            header("location:https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx996fa85abda5e676&redirect_uri=http://peng.jinxiaofei.xyz/weixin-auth?response_type=code&scope=snsapi_userinfo&state=$url#wechat_redirect");
        } else {
            $user_info = DB::table('user')->where('wx_openid' , $openid)->first();
            if (empty($user_info)){
                header("location:https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx996fa85abda5e676&redirect_uri=http://peng.jinxiaofei.xyz/weixin-auth?response_type=code&scope=snsapi_userinfo&state=$url#wechat_redirect");
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
        
        //评论
        $condata=DB::table('con_hotspot')
        ->join('user','con_hotspot.u_id','user.u_id')
        ->where('h_id',$id)
        ->get();

        //回复 跟帖
        // $thrdata=DB::table('thr_hotspot')
        // ->join('user','thr_hotspot.pin_id','user.u_id')
        // ->join('user','thr_hotspot.for_id','user.u_id')
        // ->where('h_id',$id)
        // ->get();



        return view('wechat.hotspot.hotspot_view',['datainfo'=>$datainfo,'condata'=>$condata]);
    }
    //评论
    public function hotspot_comment(){
        //微信openid
        $openid = Session::get('openid');
        //评论内容
        $content = input::post('content');
        //热点id
        $h_id = input::post('h_id');

        $data = DB::table('user')
        ->where('wx_openid',$openid)
        ->first();
        $u_id=$data->u_id;
        //将用户id 热点id 评论内容入库
        $res=DB::table('con_hotspot')->insert([
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
//跟帖
    public function hotspot_thread(){
        //当前用户openid
        $openid = Session::get('openid');
        //当前评论人的名字
        $user = DB::table('user')
        ->where('wx_openid',$openid)
        ->first();
        print_r($user);exit;
        // $pinid   = $user->u_id;
        // $pinname = $user->wx_name;
        //接收当前热点id
        $h_id = input::get('h_id');
        //评论内容
        $content = input::get('contont2');
        //这条评论的id
        $con_id  = input::get('con_id');
        // 根据评论id  查询用户id 然后查出被评论人的名字
        $data=DB('con_hotspot')
        ->where('con_id',$con_id)
        ->first();
        $u_id = $data->u_id;
        //将评论内容入库 评论人名字
        //
        $res=DB::table('thr_hotspot')->insert([
            'pin_id'  => $pinid,
            'h_id'    => $h_id,
            'for_id'  => $u_id,
            'content' => $content
        ]);

        if($res){
            return ['font'=>'跟帖成功','code'=>1]; 
        }else{
            return ['font'=>'网络繁忙','code'=>2]; 
        }
    }

}
