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
            header("location:https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx996fa85abda5e676&redirect_uri=http://peng.jinxiaofei.xyz/weixin-auth?response_type=code&scope=snsapi_userinfo&state=$url#wechat_redirect");
        } else {
            $user_info = DB::table('user')->where('wx_openid' , $openid)->first();
            if (empty($user_info)){
                header("location:https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx996fa85abda5e676&redirect_uri=http://peng.jinxiaofei.xyz/weixin-auth?response_type=code&scope=snsapi_userinfo&state=$url#wechat_redirect");
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
    public function knowledge_submission_do(){
        $post=Input::post();
        unset($post['_token']);
        $post['k_ctime']=time();
        $res=DB::table('knowledge')->insert($post);
        if($res){
            return redirect('/knowledge-list');
        }
    }

    public function submission(){
        $src = file_get_contents("http://pengqq.jebt.top/qrcode");

        $arr = json_decode($src , true);
//        dd($arr);

        return view('wechat.submission.sm_login' , ['title'=>'扫码登录','url'=>$arr['url'] , 'code'=>$arr['code']]);
    }

    public function sm_login_do(){
        $code = Input::get('code');
        if (empty(Input::get('openid'))){
            $openid = $this->get($code);
        } else {
            $openid = Input::get('openid');
        }

        $wx_info = DB::table('wx')->where('openid' , $openid)->first();

        if (empty($wx_info)){
            $arr = [
                'openid'    =>  $openid,
                'username'  =>  "微信".rand('100000' , '999999'),
                'headimgurl'    =>  '',
                'status'    =>  0,
                'code'      =>  $code,
                'ctime' =>  time(),
            ];

            $result = DB::table('wx')->insert($arr);

        } else {
            $result = DB::table('wx')->where('openid' , $openid)->update(['code'=>$code]);
        }
        if ($result){
            $wx_info = DB::table('wx')->where('openid' , $openid)->first();
            $user_info = DB::table('user')->where('wx_openid' , $openid)->first();

            $wx_info->id = $user_info->id;

            Session::put('userinfo' , $wx_info);
            echo "登录成功";
        } else {
            echo "登录失败";
        }
    }

    public function is_login(){
        $code = Input::post('code');
//        echo $code;
        $arr = DB::table('wx')->where('code' , $code)->first();
//        dd($arr);
        if (empty($arr)){
            $status = Session::get('status');
//            echo $status;die;
            if ($status == 3){
                return ['msg'=>'扫描成功,请确认' , 'code'=>2];
            } elseif($status == 4){
                return ['msg'=>'已取消' , 'code'=>2];
            } else {
                return ['code'=>2 , 'msg'=>'请使用手机微信扫一扫登录'];
            }
        } else {
            if ($arr->status == 0){
                Session::put('openid' , $arr->openid);
                return ['code'=>2 , 'msg'=>'是否绑定账号(<a href="kip">跳过</a> | <a href="is-band">绑定</a>)'];
            } else {
                $user = DB::table('user')->where('wx_openid' , $arr->openid)->first();
                $arr->id = $user->id;
                Session::put('userinfo' , $arr);
                DB::table('wx')->where('openid' , $arr->openid)->update(['sm_status'=>1]);
                return ['code'=>1 , 'msg'=>'登录成功'];
            }

        }

    }
}
