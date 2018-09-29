@foreach($data as $v)
<div style="position: relative; width: 200px; height: 200px; " name="qrdiv">
    <img src="{{ $v['url'] }}" style="width: 100px;height: 100px;">
    <input type="hidden" name="id_{{ $v['id'] }}" id="id_{{ $v['id'] }}" value="{{$v['id']}}" />

    <input type="hidden" name="code_{{ $v['id'] }}" id="code_{{ $v['id'] }}" value="{{$v['code']}}" />
    <div id="message" style="position: absolute; top: 80px; left: 60px; background-color: #6c757d;"></div>
</div>
@endforeach
@csrf
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<script>
    function status(){
        var id = $("#id_0").val();
        var code = $("#code_0").val();
        var token = $("input[name=_token]").val();
        $.ajax({
            url: "status",
            type: "post",
            data: {
                'code': code,
                '_token': token,
                'num':id,
            },
            async: false,
            cache: false,
            success: function (data) {
                if (data.code == 1) {
                    var url = 'close-lock?code='+code+'&num='+id;
                    $('#message').html("<a href='"+url+"'><button>关锁</button></a>");
                } else if (data.code == 3){
                    setTimeout('status()',2000);
                    $('#message').html('');
                }  else {
                    setTimeout('status()',2000);
                    $('#message').html(data.msg);
                }
            }
        })
    }
    status();
    function status2() {
        var id = $("#id_0").val();
        var code = $("#code_1").val();
        token = $("input[name=_token]").val();
        $.ajax({
            url:"status",
            type:"post",
            data:{
                _token:token,
                order_id:order_id,
                num:id,
            },
            async: false,
            cache: false,
            success: function (data) {
                if (data.code == 1) {
                    $('#message').html("<img width='20' height='20' src='./img/duihao.png' /><span style='font-size: 20px;color: red;'>扫码成功</span>");
                    setTimeout("status('"+data.msg+"')",2000);
                } else if(data.code == 3){
                    $('#message').html("<img width='20' height='20' src='./img/duihao.png' /><span style='font-size: 20px;color: red;'>支付成功</span>");
                    window.location.href="http://www.pengqq.xyz/order";
                } else {
                    $('#message').html();
                    setTimeout("status('"+data.msg+"')",2000);
                }
            }
        })
    }

    function status3() {
        var id = $("#id_0").val();
        var code = $("#code_2").val();
        token = $("input[name=_token]").val();
        $.ajax({
            url:"status",
            type:"post",
            data:{
                _token:token,
                order_id:order_id,
                num:id,
            },
            async: false,
            cache: false,
            success: function (data) {
                if (data.code == 1) {
                    $('#message').html("<img width='20' height='20' src='./img/duihao.png' /><span style='font-size: 20px;color: red;'>扫码成功</span>");
                    setTimeout("status('"+data.msg+"')",2000);
                } else if(data.code == 3){
                    $('#message').html("<img width='20' height='20' src='./img/duihao.png' /><span style='font-size: 20px;color: red;'>支付成功</span>");
                    window.location.href="http://www.pengqq.xyz/order";
                } else {
                    $('#message').html();
                    setTimeout("status('"+data.msg+"')",2000);
                }
            }
        })
    }
</script>