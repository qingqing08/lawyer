<div>
    请输入问题内容：
    <textarea name="q_content" id="q_content" cols="30" rows="10"></textarea>
    <br>
    请输入悬赏金额：
    <input type="number" name="money" id="money" min="10">
    <br>
    <input type="button" onclick="pay()" value="发布">
</div>
<script src="http://res.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<script>
    wx.config({
        url:"{{$signPackage['url']}}",
        debug: true,
        appId: "{{$signPackage['appId']}}",
        timestamp: "{{$signPackage['timestamp']}}",
        nonceStr: "{{$signPackage['nonceStr']}}",
        signature: "{{$signPackage['signature']}}",
        jsApiList: [
            'chooseImage','updateAppMessageShareData','onMenuShareAppMessage','uploadImage','previewImage','scanQRCode'
        ] // 必填，需要使用的JS接口列表
    });
    function weixinpay(data){
        wx.chooseWXPay({
            timestamp: data.timestamp, // 支付签名时间戳，注意微信jssdk中的所有使用timestamp字段均为小写。但最新版的支付后台生成签名使用的timeStamp字段名需大写其中的S字符
            nonceStr: data.nonceStr, // 支付签名随机串，不长于 32 位
            package: data.package, // 统一支付接口返回的prepay_id参数值，提交格式如：prepay_id=\*\*\*）
            signType: data.signType, // 签名方式，默认为'SHA1'，使用新版支付需传入'MD5'
            paySign: data.paySign, // 支付签名
            success: function (res) {

            }
        });
    }

    function pay(){
        //alert(1);
        var money = $("#money").val();
        var q_content = $("#q_content").val();
        //var openid = "oSt2Q0Z4_n1vxX4QgKm-_HHAAcn0";

        var openid = "{{ $openid }}";
        var zz = /^\d+(\.\d{1,2})?$/;
        if (zz.test(money) && money != 0) {
            //alert(openid);
            $.ajax({
                url:"pay-do",
                type:'get',
                dataType:'json',
                data:{openid:openid,money:money,q_content:q_content},
                success:function(data){
                    //alert(data);
                    if(data.status == 1){
                        weixinpay(data);
                    }else{
                        alert('请求失败!')
                    }
                }
            });
        } else {
            alert('请输入正确金额')
        }
    }
</script>