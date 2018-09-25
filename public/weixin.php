<?php
    echo $_GET['echostr'];

//    $xml = file_get_contents('php://input','r');
//    file_put_contents('./weixin.log',$xml."\r\n",FILE_APPEND);
//
//    if($xml == '') $arr = [];
//    libxml_disable_entity_loader(true);
//    $arr = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
//    $json = json_encode($arr);
//    file_put_contents('./weixin.log',$json."\r\n",FILE_APPEND);
//
//    $type = $arr["Event"];
//
//    if ($type == 'VIEW'){
//        $url = $arr['EventKey']."?wx_openid=".$arr['FromUserName']."&wx_name=weixin_".rand('10000' , '99999');
//        file_put_contents('./weixin.log',$url."\r\n",FILE_APPEND);
//        header("location:".$url);
//    }
//
//
//    function ArrToXml($shuzu){
//        if(!is_array($shuzu) || count($shuzu) == 0) return '';
//
//        $xml = "<xml>";
//        foreach ($shuzu as $key=>$val)
//        {
//            if (is_numeric($val)){
//                $xml.="<".$key.">".$val."</".$key.">";
//            }else{
//                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
//            }
//        }
//        $xml.="</xml>";
//        return $xml;
//    }
?>