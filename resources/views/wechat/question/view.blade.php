<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="/lib/layui/css/layui.css">
    <title>问题详情</title>
</head>
<body style="width: 100%;">
<style>
    span{
        font-size: 20px;
    }
    p{
        font-size: 20px;
    }
</style>
<div style="height: 110px;width: 100%;">
    <div style="float: left; width: 100px;padding-left: 20px;" >
        <img src="{{ $question_info->wx_headimg }}" alt="" width="100">
    </div>
    <div style="width: 100%; padding-left: 135px;">
        <div style="height: 50px;margin-top: 12px;">
            <span>{{ $question_info->u_id }}</span>
            <span style="float: right;margin-right: 160px;color: #3399ff;">{{ $question_info->q_type }}</span>
        </div>
        <p style="margin: 0px;padding: 0px;">{{ $question_info->q_content }}</p>
        <div style="height: 30px;margin-top:10px;margin-bottom: 10px">
            <span>{{ $question_info->money }}元</span>
            <span style="float: right;margin-right: 155px;">{{ $question_info->q_ctime }}</span>
        </div>
    </div>
</div>
<div style="height: 10px;width:100%;background-color: #3399ff;margin-top:10px;"></div>
<div style="height: 130px;width: 400px;margin-left: 30px;margin-top: 10px;margin-bottom: 10px;">
    <div class="layui-form-item">
        <textarea style="width: 350px;height: 70px; min-height: 70px;" placeholder="请输入内容" name="content" id="content" cols="30" rows="10" class="layui-textarea"></textarea>
        <div class="layui-input-block">
            <button onclick="sub()" class="layui-btn layui-btn-lg layui-btn-normal" style="height: 40px; margin-top: 10px;">我要回答</button>
        </div>
    </div>
</div>
<hr>
<div style="width: 100%;margin-top: 10px;">
    @csrf
    @foreach($question_info->comment_list as $comment)
        <div style="height: 80px;width: 100%;">
            <div style="float: left; width: 70px;padding-left: 15px;" >
                <img src="{{ $comment->headimg }}" alt="" width="70">
            </div>
            <div style="width: 100%; padding-left: 100px; height: 80px;">
                <div style="height: 35px;">
                    <span style="font-size: 15px;">{{ $comment->u_id }}</span>
                </div>
                <p style="margin: 0px;padding: 0px;font-size: 15px;">{{ $comment->c_content }}</p>
                <div style="height: 30px;margin-top:10px;">
                    <span style="float: right;margin-right: 105px;font-size: 15px;">{{ $comment->c_ctime }}</span>
                </div>
            </div>
        </div>
        <hr style="width: 100%;">
    @endforeach
</div>
</body>
</html>

<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<script>
    function sub(){
        var content = $('#content').html();
        var q_id = "{{ $question_info->q_id }}";
        var _token = $("input[name=_token]").val();

        $.ajax({
            url:"comment-do",
            type:"post",
            dataType:"json",
            data:{
                c_content:content,
                q_id:q_id,
                _token:_token,
            },
            cache:false,
            async:false,
            success:function (res) {
                if (res.code == 1){
                    layer.msg(res.msg, {icon: res.code, time: 1500}, function () {
                        window.location.reload();
                    });
                } else {
                    alert(res.msg);
                }
            }
        });
    }
</script>
