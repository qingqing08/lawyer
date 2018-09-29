<?php
    echo $_GET['echostr'];

    $xml = file_get_contents('php://input','r');
    file_put_contents('./weixin.log',$xml."\r\n",FILE_APPEND);

    if($xml == '') $arr = [];
    libxml_disable_entity_loader(true);
    $arr = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    $json = json_encode($arr);
    file_put_contents('./weixin.log',$json."\r\n",FILE_APPEND);

    $type = $arr["Event"];

    if ($type == 'VIEW'){
        $_SESSION['openid'] = $arr['FromUserName'];
        $_SESSION['url'] = $arr['EventKey'];
//        $url = $arr['EventKey']."?wx_openid=".$arr['FromUserName']."&wx_name=weixin_".rand('10000' , '99999');
//        file_put_contents('./weixin.log',$url."\r\n",FILE_APPEND);
//        header("location:".$url);
    }

    if ($type == "SCAN"){
        $url = $arr['EventKey'];
        $url = $url.$arr['FromUserName'];

        file_put_contents(__DIR__.'/saomiao.log',$url."\r\n",FILE_APPEND);
        $res = file_get_contents($url);
        file_put_contents(__DIR__.'/saomiao.log',$res."\r\n",FILE_APPEND);
        $xml_data = [
            "ToUserName"=>$arr['FromUserName'],
            "FromUserName"=>$arr['ToUserName'],
            "CreateTime"=>time(),
            "MsgType"   =>  "text",
            "Content"   =>  $res,
            // "Content"   =>  "你好",
        ];
        $return_xml = ArrToXml($xml_data);
        file_put_contents(__DIR__.'/saomiao.log',$return_xml."\r\n",FILE_APPEND);

        echo $return_xml;
    }
//
//
    function ArrToXml($shuzu){
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
?>