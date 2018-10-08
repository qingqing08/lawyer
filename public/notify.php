<?php
//$xml = file_get_contents('php://input','r');
//file_put_contents("./notify.log" , $xml."\r\n" , FILE_APPEND);

$xml = "<xml><appid><![CDATA[wx3d751ea7a2f7c064]]></appid>
<bank_type><![CDATA[CFT]]></bank_type>
<cash_fee><![CDATA[1]]></cash_fee>
<fee_type><![CDATA[CNY]]></fee_type>
<is_subscribe><![CDATA[N]]></is_subscribe>
<mch_id><![CDATA[1499304962]]></mch_id>
<nonce_str><![CDATA[24ca5fd7f6e7b389947d142ebfc49a21]]></nonce_str>
<openid><![CDATA[ooz740RFTFCCSNoAhMv8GqSnAeao]]></openid>
<out_trade_no><![CDATA[20181008154752741567]]></out_trade_no>
<result_code><![CDATA[SUCCESS]]></result_code>
<return_code><![CDATA[SUCCESS]]></return_code>
<sign><![CDATA[587DE429D8080599FF2B91C519E0AE09]]></sign>
<time_end><![CDATA[20181008154800]]></time_end>
<total_fee>1</total_fee>
<trade_type><![CDATA[NATIVE]]></trade_type>
<transaction_id><![CDATA[4200000162201810082843805694]]></transaction_id>
</xml>";
if($xml == '') $arr = [];
libxml_disable_entity_loader(true);
$arr = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);


//print_r($arr);die;
if ($arr['result_code'] == "SUCCESS" && $arr['return_code'] == "SUCCESS"){
    $data = file_get_contents('http://peng.jinxiaofei.xyz/nofity?arr='.json_encode($arr));

//    print_r($data);die;
    if ($data){
        $params = [
            'return_code'    => 'SUCCESS',
            'return_msg'    => 'OK'
        ];
        echo ArrToXml($params);
    } else {
        print_r($result);
    }
}

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