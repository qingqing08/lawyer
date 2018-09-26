<style>
    span{
        font-size: 30px;
    }
    p{
        font-size: 30px;
    }
</style>
@foreach($question_list as $question)
<div style="height: 150px;width: 100%;">
    <div style="float: left; width: 150px;padding-left: 20px;" >
        <img src="{{ $question->wx_headimg }}" alt="" width="150">
    </div>
    <div style="width: 100%; padding-left: 200px;">
        <div style="height: 50px;margin-top: 20px;">
            <span>{{ $question->u_id }}</span>
            <span style="float: right;margin-right: 250px;color: #3399ff;">{{ $question->q_type }}</span>
        </div>
        <p style="margin: 0px;padding: 0px">{{ $question->q_content }}</p>
        <span>{{ $question->money }}元</span>
        <span style="float: right;margin-right: 250px;">{{ $question->q_ctime }}</span>
    </div>
</div>
<hr style="width: 100%;">
@endforeach