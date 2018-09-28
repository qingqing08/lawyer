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
<div style="height: 110px;">
    <div style="float: left; width: 100px;padding-left: 10px;" >
        <img src="{{ $question_info->wx_headimg }}" alt="" width="100">
    </div>
    <div style="padding-left: 125px;width: 278px;">
        <div style="height: 40px;margin-top: 12px;width: 278px;">
            <span>{{ $question_info->u_id }}</span>
            <span style="float: right;color: #3399ff;">{{ $question_info->q_type }}</span>
        </div>
        <div style="width: 278px;height:40px;">
            <p style="margin: 0px;padding: 0px;">{{ $question_info->q_content }}</p>
        </div>

        <div style="height: 20px;margin-bottom: 10px;width: 278px;">
            <span>{{ $question_info->money }}元</span>
            <span style="float: right;">{{ $question_info->q_ctime }}</span>
        </div>
    </div>
</div>
<div style="height: 10px;;background-color: #3399ff;margin-top:10px;"></div>
<div style="height: 130px;width: 330px;margin-left: 30px;margin-top: 10px;margin-bottom: 10px;">
    <div class="layui-form-item">
        <textarea style="width: 330px;height: 70px; min-height: 70px;" placeholder="请输入内容" name="content" id="content" cols="30" rows="10" class="layui-textarea"></textarea>
        <div class="layui-input-block">
            <button onclick="comment()" class="layui-btn layui-btn-lg layui-btn-normal" style="height: 40px; margin-top: 10px;">我要回答</button>
        </div>
    </div>
</div>
<hr>
<div style="width: 100%;margin-top: 10px;">
    @csrf
    @foreach($question_info->comment_list as $comment)
        <div style="height: 110px;" onclick="thread({{ $comment->c_id }})">
            <div style="float: left; width: 70px;padding-left: 15px;" >
                <img src="{{ $comment->headimg }}" alt="" width="70">
            </div>
            <div style=" padding-left: 100px; height: 100px;">
                <div style="height: 20px;">
                    <span style="font-size: 15px;">{{ $comment->u_id }}</span>
                </div>
                <div style="height: 60px; width: 300px;">
                    <p style="margin: 0px;padding: 0px;margin-top:10px;font-size: 15px;">{{ $comment->c_content }}</p>
                </div>
                <div style="height: 20px; width: 300px;margin-top:10px;">
                    <span style="float: right;font-size: 15px;">{{ $comment->c_ctime }}</span>
                </div>
            </div>
        </div>
        <hr style="width: 100%;">
        @foreach($comment->thread_list as $thread)
        <div style="height: 20px;font-size: 20px;margin-left: 20px;" onclick="thread('{{ $comment->c_id }}' , '{{ $thread->t_id }}')">
            <span style="margin-right: 10px;">{{ $thread->u_id }}</span>:<span style="margin-left: 10px;">{{ $thread->t_content }}</span>
        </div>
        <hr style="width: 100%;">
        @endforeach
    @endforeach
</div>

<div style="display: none;height: 130px;width: 330px;margin-left: 30px;margin-top: 10px;margin-bottom: 10px;" id="comment">
    <div class="layui-form-item">
        <textarea style="width: 330px;height: 40px; min-height: 40px;" placeholder="请输入内容" name="c_content" id="c_content" cols="30" rows="10" class="layui-textarea"></textarea>
        <input type="hidden" value="" id="c_id">
        <input type="hidden" value="0" id="p_id">
        <div class="layui-input-block">
            <button onclick="sub()" class="layui-btn layui-btn-lg layui-btn-normal" style="height: 40px; margin-top: 10px;">追评</button>
        </div>
    </div>
</div>
</body>
</html>

<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<script>
    function comment(){
        var content = $('#content').val();
        var q_id = "{{ $question_info->q_id }}";
        var _token = $("input[name=_token]").val();

        if (content == ''){
            alert('内容不能为空');
            return false;
        }
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
                alert(res.msg);
                window.location.reload();
            }
        });
    }

    function thread(c_id , p_id = 0){
        window.scrollTo(0, document.documentElement.clientHeight);
        $("#comment").show();
        $("#c_content").focus();
        $("#c_id").val(c_id);
        $("#p_id").val(p_id);

    }

    function sub(){
        var content = $("#c_content").val();
        var c_id = $("#c_id").val();
        var p_id = $("#p_id").val();
        var _token = $("input[name=_token]").val();

        $.ajax({
            url:"thread-do",
            type:"post",
            dataType:"json",
            data:{
                t_content:content,
                c_id:c_id,
                _token:_token,
                p_id:p_id,
            },
            async:false,
            cache:false,
            success:function (res) {
                alert(res.msg);
                window.location.href="http://pengqq.jebt.top/question-view?q_id={{ $question_info->q_id }}";
            }
        })
    }
</script>