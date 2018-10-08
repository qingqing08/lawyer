<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

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
    public function send($openid , $username , $back_num , $money){

        $tokens = $this->getAccessToken();

        $url = self::TEMP_URL . $tokens;
        $params = [
            'touser' => $openid,
            'template_id' => 'ANpsYEDTUmSYCjAt_Zh3dVxCcl22nNU6Kdlb20Y5hyQ',//模板ID
            'url' => 'http://pengqq.jebt.top/self', //点击详情后的URL可以动态定义
            'data' =>
                [
                    'first' =>
                        [
                            'value' => '锁车成功',
                            'color' => '#173177'
                        ],
                    'username' =>
                        [
                            'value' => $username,
                            'color' => '#FF0000'
                        ],

                    'bake'  =>[
                        'value' => $back_num,
                        'color' => '#173177'
                    ],
                    'money'  =>  [
                        'value' => $money,
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
        $bake_num = Input::get('bake_num');
        $money = Input::get('money');
//        $openid = 'owRHY1cti1oJT7ZfEgzXNbTyJPEo';
        echo $this->send($openid , $username , $bake_num , $money);
    }

    public function create_menu(){
        $tokens = $this->getAccessToken();
        $url = self::MENU_URL . $tokens;

        $params = [
            'button'=>[
                [
                    'type'  =>  'view',
                    'name'  =>  '实时热点',
                    'url'   =>  'http://peng.jinxiaofei.xyz/hotspot-list',
//                    'url'   =>  'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx996fa85abda5e676&redirect_uri=http://pengqq.jebt.top/hotspot-list?response_type=code&scope=snsapi_userinfo&state=STATEA#wechat_redirect',
                ],
                [
                    "name"=>"法律服务",
                    "sub_button"=>[

                        [
                            'type'  =>  'view',
                            'name'  =>  '找律师',
                            'url'   =>  'http://peng.jinxiaofei.xyz/find-lawyer',
//                            'url'   =>  'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx996fa85abda5e676&redirect_uri=http://pengqq.jebt.top/find-lawyer?response_type=code&scope=snsapi_userinfo&state=STATEA#wechat_redirect',
                        ],
                        [
                            'type'  =>  'view',
                            'name'  =>  '法律常识',
                            'url'   =>  'http://peng.jinxiaofei.xyz/knowledge-list',
//                            'url'   =>  'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx996fa85abda5e676&redirect_uri=http://pengqq.jebt.top/legal-knowledge?response_type=code&scope=snsapi_userinfo&state=STATEA#wechat_redirect',
                        ],
                        [
                            'type'  =>  'view',
                            'name'  =>  '发布悬赏问题',
                            'url'   =>  'http://peng.jinxiaofei.xyz/question-list',
//                            'url'   =>  'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx996fa85abda5e676&redirect_uri=http://pengqq.jebt.top/legal-knowledge?response_type=code&scope=snsapi_userinfo&state=STATEA#wechat_redirect',
                        ],
                    ]
                ],
                [
                    'type'  =>  'view',
                    'name'  =>  '个人中心',
                    'url'   =>  'http://peng.jinxiaofei.xyz/self',
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

        $token = DB::table('token')->where('type' , 2)->first();
        $time = time();
        $openid = Session::get('openid');

        if (empty($token) || empty($openid)){
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx996fa85abda5e676&secret=4fa1f553b231ec2bed06cdc7d3491ae0&code=".$code."&grant_type=authorization_code";
//
            $data = file_get_contents($url);
//
            $arr = json_decode($data , true);
//            echo $arr['openid'];
//            print_r($arr);die;
            $openid = $arr['openid'];
            Session::put('openid' , $openid);

            $data = [
                'appid' =>  'wx996fa85abda5e676',
                'access_token'  =>  $arr['access_token'],
                'ctime' =>  time(),
            ];

            DB::table('token')->where('type' , 2)->update($data);
        } else {
            if ($token->ctime - $time > 1800 ){
                $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx996fa85abda5e676&secret=4fa1f553b231ec2bed06cdc7d3491ae0&code=".$code."&grant_type=authorization_code";
//
                $data = file_get_contents($url);
//
//        echo $data;die;
                $arr = json_decode($data , true);
                $openid = $arr['openid'];
                Session::put('openid' , $openid);

                $data = [
                    'appid' =>  'wx996fa85abda5e676',
                    'access_token'  =>  $arr['access_token'],
                    'ctime' =>  time(),
                ];

                DB::table('token')->where('type' , 2)->update($data);
            }
        }

        $token = DB::table('token')->where('type' , 2)->first();
        $user_url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$token->access_token."&openid=".$openid."&lang=zh_CN";

        $user_data = file_get_contents($user_url);
//
//        dd($user_data);
//        Session::put('userinfo' , $user_data);
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
//            echo $state;die;
            header("location:".$state);
        }
    }

    public function notify(){
        $xml = file_get_contents('php://input','r');
        file_put_contents("./notify.log" , $xml."\r\n" , FILE_APPEND);

        if($xml == '') $arr = [];
        libxml_disable_entity_loader(true);
        $arr = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);


//        print_r($arr);die;
        if ($arr['result_code'] == "SUCCESS" && $arr['return_code'] == "SUCCESS"){
            $data = DB::table('order')->where(['order_num'=>$arr['out_trade_no'] , 'o_paystatus'=>0])->first();

//            echo DB::table('order')->where(['order_num'=>$arr['out_trade_no'] , 'o_paystatus'=>0])->toSql();
//            dd($data);
            if ($arr['total_fee'] / 100 == $data->o_price){
                if ($data->o_type == 1){
                    $order_data = [
                        'o_status'    =>  2,
                        'o_paystatus'    =>  1,
                    ];

                    DB::table('question')->where(['q_id'=>$data->data_id , 'q_paystatus'=>0])->update(['q_paystatus'=>1]);
                    $result = DB::table('order')->where(['order_num'=>$arr['out_trade_no'] , 'o_paystatus'=>0])->update($order_data);
                    if ($result){
//                    echo "success";die;
                        $params = [
                            'return_code'    => 'SUCCESS',
                            'return_msg'    => 'OK'
                        ];
                        echo $this->ArrToXml($params);
                    } else {
                        print_r($result);
                    }
                }

                if($data->o_type == 2){
                    $order_data = [
                       'o_status' => 2,
                        'o_paystatus'    =>  1,
                    ];

                    $orderinfo = DB::table('order') -> where(['order_num' => $arr['out_trade_no']]) -> first();

                    DB::table('recharge') -> where(['r_id' => $orderinfo -> data_id]) -> update(['r_status' => 1]);

                    DB::table('user') -> where(['u_id' => $orderinfo -> u_id]) -> increment('balance' , $arr['total_fee'] /100);

                    $res = DB::table('order') -> where(['order_num' => $arr['out_trade_no']]) -> update($order_data);

                    if($res){

                        $params = [
                            'return_code'    => 'SUCCESS',
                            'return_msg'    => 'OK'
                        ];
                        echo $this->ArrToXml($params);

                    }else{
                        print_r($res);
                    }
                }
            } else {
                echo "订单金额不符合";
            }
        }
    }

    public function ArrToXml($shuzu){
        if(!is_array($shuzu) || count($shuzu) == 0) return '';

        $xml = "<xml>";
        foreach ($shuzu as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    /**
     * 获取ticket
     */
    const TICKET_URL = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=';
    public function get_ticket($i){
        $tokens = $this->getAccessToken();

        $url = self::TICKET_URL . $tokens;
        $rand = rand(100000 , 999999);
        Session::put('code' , $rand);
        Session::put('num_'.$i , $i);
        $params = [
            'action_name'    =>  'QR_LIMIT_STR_SCENE',
            'action_info'   =>  [
                'scene' =>  [
                    'scene_str'  =>  'http://pengqq.jebt.top/unlock?num='.$i.'&code='.$rand.'&openid=',
                ],
            ],
        ];

        $json = json_encode($params,JSON_UNESCAPED_UNICODE);
        return $this->curlPost($url, $json);

    }
    const QRCODE_URL = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=';
    public function qrcode(){
        for ($i=0;$i<3;$i++){
            $ticket_json = $this->get_ticket($i);

            $ticket_arr = json_decode($ticket_json , true);

            $ticket = urlencode($ticket_arr['ticket']);
            $url = self::QRCODE_URL .$ticket;
            $arr = [
                'url'   =>  $url,
                'code'  =>  Session::get('code'),
                'id'    =>  Session::get('num_'.$i),
            ];

            $data[$i] = $arr;
        }



        return json_encode($data);
//        header("location:".$url);
    }

}
