<?php
//echo 1;die;
//$xml = "<xml><appid><![CDATA[wx3d751ea7a2f7c064]]></appid>
//<bank_type><![CDATA[CFT]]></bank_type>
//<cash_fee><![CDATA[1]]></cash_fee>
//<fee_type><![CDATA[CNY]]></fee_type>
//<is_subscribe><![CDATA[N]]></is_subscribe>
//<mch_id><![CDATA[1499304962]]></mch_id>
//<nonce_str><![CDATA[5ba24d29ef7da]]></nonce_str>
//<openid><![CDATA[ooz740RFTFCCSNoAhMv8GqSnAeao]]></openid>
//<out_trade_no><![CDATA[20180905095422490468]]></out_trade_no>
//<result_code><![CDATA[SUCCESS]]></result_code>
//<return_code><![CDATA[SUCCESS]]></return_code>
//<sign><![CDATA[67B18C7359529059AC90858BD2E408E9]]></sign>
//<time_end><![CDATA[20180919212114]]></time_end>
//<total_fee>1</total_fee>
//<trade_type><![CDATA[NATIVE]]></trade_type>
//<transaction_id><![CDATA[4200000169201809197688956668]]></transaction_id>
//</xml>";
$xml = file_get_contents('php://input','r');
file_put_contents("./notify.log" , $xml."\r\n" , FILE_APPEND);

if($xml == '') $arr = [];
libxml_disable_entity_loader(true);
$arr = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);


//print_r($arr);die;
if ($arr['result_code'] == "SUCCESS" && $arr['return_code'] == "SUCCESS"){
    $connect=mysqli_connect('127.0.0.1','root','root','lawyer','3306');
    $sql = "select * from law_order where order_number={$arr['out_trade_no']} and pay_status=0";
    mysqli_query($connect,'set names utf8');
    $result=mysqli_query($connect,$sql);
    $data =mysqli_fetch_assoc($result);
    if ($arr['total_fee'] / 100 == $data['price']){
//        print_r($data);die;
        $order_data = [
            'status'    =>  2,
            'pay_status'    =>  1,
        ];

        $order_sql = "update law_order set status={$order_data['status']} and pay_status={$order_data['pay_status']} where order_number='{$arr['out_trade_no']}' and status=1";
        $status_sql = "update law_question set q_paystatus=1 where q_id='{$data['data_id']}' and q_paystatus=0";
//        echo $ordercontent_sql."<br>";
//        echo $order_sql;die;
        mysqli_query($connect,'set names utf8');
        mysqli_query($connect,$ordercontent_sql);
        mysqli_query($connect,$status_sql);
        $result=mysqli_query($connect,$order_sql);
//        var_dump($result);die;
        if ($result){
//            echo "success";die;
            $params = [
                'return_code'    => 'SUCCESS',
                'return_msg'    => 'OK'
            ];
            echo ArrToXml($params);
        } else {
            print_r($result);
        }
    } else {
        echo "订单金额不符合";
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