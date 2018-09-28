<style>
    span{
        font-size: 30px;
    }
    p{
        font-size: 30px;
    }
</style>
<title>问题列表</title>
<link rel="stylesheet" href="/lib/layui/css/layui.css">
@foreach($question_list as $question)
<div style="height: 150px;width: 100%;">
    <a href="question-view?q_id={{ $question->q_id }}">
    <div style="float: left; width: 150px;padding-left: 20px;" >
        <img src="{{ $question->wx_headimg }}" alt="" width="150">
    </div>
    <div style="width: 100%; padding-left: 200px;">
        <div style="height: 50px;margin-top: 20px;">
            <span>{{ $question->u_id }}</span>
            <span style="float: right;margin-right: 250px;color: #3399ff;">{{ $question->q_type }}</span>
        </div>
        <p style="margin: 0px;padding: 0px;margin-top: 10px;">{{ $question->q_content }}</p>
        <div style="height: 30px;margin-top:10px;">
        <span>{{ $question->money }}元</span>
        <span style="float: right;margin-right: 250px;">{{ $question->q_ctime }}</span>
        </div>
    </div>
    </a>
</div>
<hr style="width: 100%;">
@endforeach
<div style="height: 50px;width:100px;margin-left: 200px;margin-top: 10px;">
    <a href="release-question"><button class="layui-btn layui-btn-lg layui-btn-normal">发布问题</button></a>
</div>
