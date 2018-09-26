<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Wechat extends Controller{
    //
    public $appid = "wx996fa85abda5e676";
    public $secret = "4fa1f553b231ec2bed06cdc7d3491ae0";
    public function get_token(){
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appid."&secret=".$this->secret;
        $data = file_get_contents($url);

        $arr = json_decode($data , true);

        $access_token = $arr['access_token'];
        DB::table('token')->where('id' , 1)->update(['appid'=>$this->appid,'access_token'=>$access_token , 'ctime'=>time()]);

//        header("location:https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx1f551b722cc6090f&secret=ac38eb048d3f8c0822ffcff8b667dbcb");
    }

    public function get_message(){
        echo $_GET["echostr"];
        //     $a = file_get_contents('php://input','r');
        //     // file_put_contents(__DIR__.'/aa.log',$a,FILE_APPEND);
        //    file_put_contents(__DIR__.'/aa.log',"111",FILE_APPEND);
    }

    public function getAccessToken(){
        //这里获取accesstoken  请根据自己的程序进行修改
        $token = DB::table('token')->where('id' , 1)->first();
        return $token->access_token;
    }
    /**
     * 微信模板消息发送
     * @param $openid 接收用户的openid
     * return 发送结果
     */
    const TEMP_URL = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=';
    const MENU_URL = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=';
    public function send($openid , $username , $phone , $orderid){

        $tokens = $this->getAccessToken();

        $url = self::TEMP_URL . $tokens;
        $params = [
            'touser' => $openid,
            'template_id' => 'f4eVhKaktqDxlKRn6YeHPvps8NB5W3yVWwPEURTtams',//模板ID
            'url' => 'http://www.pengqq.xyz/self', //点击详情后的URL可以动态定义
            'data' =>
                [
                    'first' =>
                        [
                            'value' => '活动大促销,洗面奶9.9元既得',
                            'color' => '#173177'
                        ],
                    'username' =>
                        [
                            'value' => $username,
                            'color' => '#FF0000'
                        ],

                    'phone' =>
                        [
                            'value' => $phone,
                            'color' => '#173177'
                        ],
                    'kuaidigs' =>
                        [
                            'value' => 'EMS',
                            'color' => '#173177'
                        ],
                    'kuaidinum'  =>[
                        'value' => $orderid,
                        'color' => '#173177'
                    ],
                    'ordernum'  =>  [
                        'value' => $orderid,
                        'color' => '#173177'
                    ],
                    'remark'    =>  [
                        'value' =>  "今天是".date("Y-m-d H:i:s" , time())."祝您每天都有好的心情哦",
                        "color" =>  '#FF0000',
                    ],
                ]
        ];
        $json = json_encode($params,JSON_UNESCAPED_UNICODE);
        return $this->curlPost($url, $json);
    }
    /**
     * 通过CURL发送数据
     * @param $url 请求的URL地址
     * @param $data 发送的数据
     * return 请求结果
     */
    protected function curlPost($url,$data){
        $ch = curl_init();
        $params[CURLOPT_URL] = $url;    //请求url地址
        $params[CURLOPT_HEADER] = FALSE; //是否返回响应头信息
        $params[CURLOPT_SSL_VERIFYPEER] = false;
        $params[CURLOPT_SSL_VERIFYHOST] = false;
        $params[CURLOPT_RETURNTRANSFER] = true; //是否将结果返回
        $params[CURLOPT_POST] = true;
        $params[CURLOPT_POSTFIELDS] = $data;
        curl_setopt_array($ch, $params); //传入curl参数
        $content = curl_exec($ch); //执行
        curl_close($ch); //关闭连接
        return $content;
    }



    public function send_message(){
        $openid = Input::get('openid');
        $username = Input::get('username');
        $phone = Input::get('phone');
        $orderid = Input::get('orderid');
//        $openid = 'owRHY1cti1oJT7ZfEgzXNbTyJPEo';
        echo $this->send($openid , $username , $phone , $orderid);
    }

    public function create_menu(){
        $tokens = $this->getAccessToken();
        $url = self::MENU_URL . $tokens;

        $params = [
            'button'=>[
                [
                    'type'  =>  'view',
                    'name'  =>  '实时热点',
                    'url'   =>  'http://pengqq.jebt.top/hotspot-list',
//                    'url'   =>  'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx996fa85abda5e676&redirect_uri=http://pengqq.jebt.top/hotspot-list?response_type=code&scope=snsapi_userinfo&state=STATEA#wechat_redirect',
                ],
                [
                    "name"=>"法律服务",
                    "sub_button"=>[

                        [
                            'type'  =>  'view',
                            'name'  =>  '找律师',
                            'url'   =>  'http://pengqq.jebt.top/find-lawyer',
//                            'url'   =>  'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx996fa85abda5e676&redirect_uri=http://pengqq.jebt.top/find-lawyer?response_type=code&scope=snsapi_userinfo&state=STATEA#wechat_redirect',
                        ],
                        [
                            'type'  =>  'view',
                            'name'  =>  '法律常识',
                            'url'   =>  'http://pengqq.jebt.top/knowledge-list',
//                            'url'   =>  'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx996fa85abda5e676&redirect_uri=http://pengqq.jebt.top/legal-knowledge?response_type=code&scope=snsapi_userinfo&state=STATEA#wechat_redirect',
                        ],
                    ]
                ],
                [
                    'type'  =>  'view',
                    'name'  =>  '个人中心',
                    'url'   =>  'http://pengqq.jebt.top/self',
//                    'url'   =>  'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx996fa85abda5e676&redirect_uri=http://pengqq.jebt.top/self?response_type=code&scope=snsapi_userinfo&state=STATEA#wechat_redirect',
                ],
            ],
        ];
        
        $json = json_encode($params,JSON_UNESCAPED_UNICODE);
//        echo $json;die;
        return $this->curlPost($url, $json);
    }

    public function create(){
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx1f551b722cc6090f&secret=fb50ea0ad1f792d638a2227d3df11c20";
        $data = file_get_contents($url);

        $arr = json_decode($data , true);

        $access_token = $arr['access_token'];
        $url = self::MENU_URL . $access_token;

//        $params = [
//            'button'=>[
//                [
//                    'type'  =>  'view',
//                    'name'  =>  '欢迎访问',
//                    'url'   =>  'http://www.pengqq.xyz/',
//                ],
//                [
//                    'name'  =>  '微商城',
//                    'sub_button'    =>  [
//                        [
//                            'type'  =>  'view',
//                            'name'  =>  '登录',
//                            "url"   =>  "http://www.pengqq.xyz/login",
//                        ],
//                    ],
//                ],
//            ],
//        ];
        $json = '{
    "button": [
        {
            "name": "扫码", 
            "sub_button": [
                {
                    "type": "scancode_waitmsg", 
                    "name": "扫码带提示", 
                    "key": "rselfmenu_0_0", 
                    "sub_button": [ ]
                }, 
                {
                    "type": "scancode_push", 
                    "name": "扫码推事件", 
                    "key": "rselfmenu_0_1", 
                    "sub_button": [ ]
                }
            ]
        }, 
        {
            "name": "发图", 
            "sub_button": [
                {
                    "type": "pic_sysphoto", 
                    "name": "系统拍照发图", 
                    "key": "rselfmenu_1_0", 
                   "sub_button": [ ]
                 }, 
                {
                    "type": "pic_photo_or_album", 
                    "name": "拍照或者相册发图", 
                    "key": "rselfmenu_1_1", 
                    "sub_button": [ ]
                }, 
                {
                    "type": "pic_weixin", 
                    "name": "微信相册发图", 
                    "key": "rselfmenu_1_2", 
                    "sub_button": [ ]
                }
            ]
        }, 
        {
            "name": "发送位置", 
            "type": "location_select", 
            "key": "rselfmenu_2_0"
        },
    ]
}';
//        $json = json_encode($params,JSON_UNESCAPED_UNICODE);
//        echo $json;die;
        return $this->curlPost($url, $json);
    }


    public function weixin_auth(){
        $code = $_GET['code'];
        $state = $_GET['state'];

        $arr = DB::table('token')->where('type' , 2)->first();
        $time = time();
        $openid = Session::get('openid');

        $arr = json_decode($arr , true);
        if (empty($arr)){
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx996fa85abda5e676&secret=4fa1f553b231ec2bed06cdc7d3491ae0&code=".$code."&grant_type=authorization_code";
//
            $data = file_get_contents($url);
//
//        echo $data;die;
            $arr = json_decode($data , true);
            Session::put('openid' , $arr['openid']);

            $data = [
                'appid' =>  'wx996fa85abda5e676',
                'access_token'  =>  $arr['access_token'],
                'ctime' =>  time(),
            ];

            DB::table('token')->where('type' , 2)->update($data);
        } else {
            if ($arr->ctime - $time > 1800 ){
                $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx996fa85abda5e676&secret=4fa1f553b231ec2bed06cdc7d3491ae0&code=".$code."&grant_type=authorization_code";
//
                $data = file_get_contents($url);
//
//        echo $data;die;
                $arr = json_decode($data , true);
                Session::put('openid' , $arr['openid']);
                $data = [
                    'appid' =>  'wx996fa85abda5e676',
                    'access_token'  =>  $arr['access_token'],
                    'ctime' =>  time(),
                ];

                DB::table('token')->where('type' , 2)->update($data);
            }
        }


        if (empty($openid)){
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx996fa85abda5e676&secret=4fa1f553b231ec2bed06cdc7d3491ae0&code=".$code."&grant_type=authorization_code";
//
            $data = file_get_contents($url);
//
//        echo $data;die;
            $arr = json_decode($data , true);
            Session::put('openid' , $arr['openid']);
            $data = [
                'appid' =>  'wx996fa85abda5e676',
                'access_token'  =>  $arr['access_token'],
                'ctime' =>  time(),
            ];

            DB::table('token')->where('type' , 2)->update($data);
        }

        $user_url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$arr['access_token']."&openid=".$openid."&lang=zh_CN";

        $user_data = file_get_contents($user_url);
//
        $user_arr = json_decode($user_data , true);
        $user_info = DB::table('user')->where('wx_openid' , $user_arr['openid'])->first();
        $data = [
            'wx_openid' =>  $user_arr['openid'],
            'wx_name' =>  $user_arr['nickname'],
            'wx_headeimg'    =>  $user_arr['headimgurl'],
            'u_ctime'   =>  time(),

        ];

        if (empty($user_info)){
            DB::table('user')->insert($data);
            header("location:".$state);
        }
    }

}
