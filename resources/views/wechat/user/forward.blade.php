<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="text/javascript" src="../css/mobi.min.js" charset="gbk"></script>
    <title>提现</title>
</head>
<body>
    <div style="text-align: center;margin-top: 30px">
            提现到:<select name="" id="mode">
                        <option value="1">微信</option>
                        <option value="2">银行卡</option>
                        <option value="3">支付宝</option>
                   </select>

    </div>

    <div style="text-align: center;margin-top: 10px;">
        <p><span style="color:red;">*</span>注意提现金额不能大于余额</p>
    </div>

    <div style="text-align: center;margin-top: 40px">
        请输入提现金额: <input type="text" width="30px;" id="money" placeholder="可提现{{$balance}}">
    </div>

    <div style="text-align: center;margin-top: 50px;">
        <input type="button" value="提现" id="forward">
    </div>
    <input type="hidden" value="{{$balance}}" id="balance">
</body>
</html>
<script>
    $('#forward').on('click' , function(){

        var mode = $('#mode').val();
        var money = $('#money').val();
        var balance = $('#blance').val()
        alert(mode)
        alert(money)
        alert(balance)
        if(money > balance){
            alert('提现金额不能大于余额');
        }
    })
</script>