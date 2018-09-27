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
                    $arr=DB::table('type')->select()->get();
                    print_r($arr);
                    dd($data);
                    return view('wechat.knowledge.knowledge_list');
                }
            }
        }
    }
}
