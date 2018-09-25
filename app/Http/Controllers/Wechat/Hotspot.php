<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class Hotspot extends Controller{
    //
    public function hotspot_list(){
        $code = $_GET['code'];
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx996fa85abda5e676&secret=4fa1f553b231ec2bed06cdc7d3491ae0&code=".$code."&grant_type=authorization_code";
//
        $data = file_get_contents($url);
//
//        echo $data;die;
        $arr = json_decode($data , true);

        $user_url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$arr['access_token']."&openid=".$arr['openid']."&lang=zh_CN";

        $user_data = file_get_contents($user_url);
//
        $user_arr = json_decode($user_data , true);
//        $user_arr = [
//            'openid'    =>  "owRHY1cti1oJT7ZfEgzXNbTyJPEo",
//            'nickname'  =>  "晴晴",
//            'sex'   =>  2,
//            'language'  =>  'zh_CN',
//            'city'  =>  '昌平',
//            'province'  =>  '北京',
//            'country'   =>  '中国',
//            'headimgurl'    =>  'http://thirdwx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJ8cObich5lCfPGjZNRibJFhnOrazTad5cfKxQOPKSoq6oicXAVLJbwgl6FSaicibcraONsMC1FOW8zAFg/132',
//            'privilege' => Array (),
//        ];
//        dd($user_arr);
        $user_info = DB::table('user')->where('wx_openid' , $user_arr['openid'])->first();
        $data = [
            'wx_openid' =>  $user_arr['openid'],
            'wx_name' =>  $user_arr['nickname'],
            'wx_headeimg'    =>  $user_arr['headimgurl'],
            'u_ctime'   =>  time(),

        ];

        if (empty($user_info)){
            DB::table('user')->insert($data);
        }

//        $hot = DB::table('')
//        return view('');
        echo "实时热点";
    }
}
