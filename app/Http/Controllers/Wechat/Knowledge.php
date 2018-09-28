<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class Knowledge extends Controller{
    //
    public function knowledge_list(){
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
                    $data=DB::table('knowledge')
                        ->join('type','knowledge.t_id','=','type.t_id')
                        ->get();
                    $type=DB::table('type')->select()->get();
                    foreach($data as $v){
                        $v->k_ctime=date('Y-m-d H:i:s',$v->k_ctime);
                    }
                    return view('wechat.knowledge.knowledge_list',['data'=>$data,'type'=>$type]);
                }
            }
        }
    }

    public function type(){
        $t_id=Input::get('t_id');
        $data=DB::table('knowledge')
            ->where(['type.t_id'=>$t_id])
            ->join('type','knowledge.t_id','=','type.t_id')
            ->get();
        $type=DB::table('type')->select()->get();
        foreach($data as $v){
            $v->k_ctime=date('Y-m-d H:i:s',$v->k_ctime);
        }
        return view('wechat.knowledge.type',['data'=>$data,'type'=>$type]);
    }
    public function knowledge_view(){
        $k_id=Input::get('k_id');
        $data=DB::table('knowledge')
            ->where(['knowledge.k_id'=>$k_id])
            ->join('type','knowledge.t_id','=','type.t_id')
            ->first();
            $data->k_ctime=date('Y-m-d H:i:s',$data->k_ctime);
        return view('wechat.knowledge.view',['data'=>$data]);
    }
    public function knowledge_vague(){
        $keyword=Input::post('keyword');
        $data=DB::table('knowledge')
            ->orwhere('knowledge.k_title','like','%'.$keyword.'%')
            ->join('type','knowledge.t_id','=','type.t_id')
            ->get();
//        dd($data);
        $type=DB::table('type')->select()->get();
        foreach($data as $v){
            $v->k_ctime=date('Y-m-d H:i:s',$v->k_ctime);
        }
        return view('wechat.knowledge.type',['data'=>$data,'type'=>$type]);
    }
    /** 投稿 */
    public function knowledge_submission(){
        $data=DB::table('type')->select()->get();
//        dd($data);
        return view('wechat.knowledge.submission',['data'=>$data]);
    }
}
