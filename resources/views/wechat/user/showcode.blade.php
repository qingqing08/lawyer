<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="./js/jquery-3.3.1.min.js"></script>
    <title>微信安全支付</title>
</head>
<body>
    <div style="margin-top: 20px; text-align: center">
        <p>请输入金额: <input type="number"id="money"></p>
        <input type="button" value="充值" id="Recharge">
    </div>
    <div style="margin-top: 40px; text-align: center">
        <h3></h3>
    </div>
    <div style="margin-top: 50px; text-align: center">
        <img src="" alt="" width="300px;" height="300px;">
    </div>

</body>
</html>

<script>
    $("input[type=button]").on('click' , function(){
        var money = $("input[type=number]").val();
        if(money != ''){
            $('h3').html('请使用微信扫描二维码')
            {{--$("h3").html('http://pengqq.jebt.top/generateCode?order_id={{$order_id}}&money='+ money);--}}
                window.location.href='http://pengqq.jebt.top/generateCode?order_id={{$order_id}}&money='+ money;
            {{--$('img').attr('src' , 'http://pengqq.jebt.top/generateCode?order_id={{$order_id}}&money='+ money)--}}
            // $('h3').html('请使用微信扫描二维码')
        }
    })
</script>