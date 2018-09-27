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
<div style="height: 120px;width: 100%;">
    <div style="float: left; width: 100px;padding-left: 20px;" >
        <img src="{{ $question_info->wx_headimg }}" alt="" width="100">
    </div>
    <div style="width: 100%; padding-left: 150px;">
        <div style="height: 50px;margin-top: 20px;">
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
<div style="height: 45px;width: 120px;margin-left: 200px;margin-top: 10px;margin-bottom: 10px;">
    <a href="#"><button class="layui-btn layui-btn-lg layui-btn-normal">我要回答</button></a>
</div>
<hr>
<div style="width: 100%;margin-top: 20px;">
    @foreach($question_info->comment_list as $comment)
        <div style="height: 85px;width: 100%;">
            <div style="float: left; width: 70px;padding-left: 20px;" >
                <img src="{{ $comment->headimg }}" alt="" width="70">
            </div>
            <div style="width: 100%; padding-left: 100px; height: 80px;">
                <div style="height: 35px;">
                    <span style="font-size: 15px;">{{ $comment->u_id }}</span>
                </div>
                <p style="margin: 0px;padding: 0px;font-size: 15px;">{{ $comment->c_content }}</p>
                <div style="height: 30px;margin-top:10px;">
                    <span style="float: right;margin-right: 150px;font-size: 15px;">{{ $comment->c_ctime }}</span>
                </div>
            </div>
        </div>
        <hr style="width: 100%;">
    @endforeach
</div>
</body>
</html>
