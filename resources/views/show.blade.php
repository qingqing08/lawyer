@foreach($data as $v)
<div style="position: relative; width: 200px; height: 200px; " name="qrdiv">
    <img src="{{ $v['url'] }}" style="width: 100px;height: 100px;">
    <input type="hidden" name="id_{{ $v['id'] }}" id="id_{{ $v['id'] }}" value="{{$v['id']}}" />

    <input type="hidden" name="code_{{ $v['id'] }}" id="code_{{ $v['id'] }}" value="{{$v['code']}}" />
    <div id="message_{{ $v['id'] }}" style="position: absolute; top: 80px; left: 60px; background-color: #6c757d;"></div>
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
                    setTimeout('status()',2000);
                    var url = 'close-lock?code='+code+'&num='+id;
                    $('#message_'+id).html("<a href='"+url+"'><button>关锁</button></a><span>1号单车锁已开,当前计费<span>"+data.money+"</span>元</span>");

                } else if (data.code == 3){
                    setTimeout('status()',2000);
                    $('#message_'+id).html('1号单车未开锁,'+data.msg);
                }  else {
                    setTimeout('status()',2000);
                    $('#message_'+id).html('1号单车未开锁,'+data.msg);
                }
            }
        })
    }
    status();
    function status2() {
        var id = $("#id_1").val();
        var code = $("#code_1").val();
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
                    $('#message_'+id).html("<a href='"+url+"'><button>关锁</button></a><span>2号单车锁已开,当前计费<span>"+data.money+"</span>元</span>");

                    setTimeout('status2()',2000);} else if (data.code == 3){
                    setTimeout('status2()',2000);
                    $('#message_'+id).html('2号单车未开锁,'+data.msg);
                }  else {
                    setTimeout('status2()',2000);
                    $('#message_'+id).html('2号单车未开锁,'+data.msg);
                }
            }
        })
    }

    status2();
    function status3() {
        var id = $("#id_2").val();
        var code = $("#code_2").val();
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
                    $('#message_'+id).html("<a href='"+url+"'><button>关锁</button></a><span>3号单车锁已开,当前计费<span>"+data.money+"</span></span>");

                    setTimeout('status3()',2000);
                } else if (data.code == 3){
                    setTimeout('status3()',2000);
                    $('#message_'+id).html('3号单车未开锁,'+data.msg);
                }  else {
                    setTimeout('status3()',2000);
                    $('#message_'+id).html('3号单车未开锁,'+data.msg);
                }
            }
        })
    }
    status3();

</script>