<!DOCTYPE HTML>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>实时热点</title>
    <meta name="keywords" content="法律咨询，律师，法律咨询电话" /><meta name="description" content="找法网手机版为您提供法律咨询、找律师、查询法律法规，各地区律师电话咨询服务" />    <link type="text/css" href="./css/law_touch.css" rel="stylesheet" />
        <script type="text/javascript" src="./css/mobi.min.js" charset="gbk"></script>
    
</head>
<body>
<div class="new_ask" style="margin-left: 10px;">
    <h2 class="hd"><a href="ask">最新实时热点</a></h2>
    <div class="bd f17">
        <ul class="fl_list">
            <li>
                <span>{{@$datainfo->h_title}}</span>
            </li>     
        </ul>
    </div>
</div>
    
    <div class="new_ask" >
        <span> <?php echo date('m-d H:i:s',$datainfo->h_ctime);?> </span>
        <br>
            <p>{{@$datainfo->h_content}}</p>              
    </div>
    <div>
        <span>评论区</span>
        <br>
        <input type="hidden" name="h_id" value="{{@$datainfo->h_id}}">
        <textarea id="content" style="width: 260px; height: 70px;"></textarea>
        &nbsp;&nbsp;<a id="pin" >评论</a> 
    </div>

    <ul>
        @foreach($condata as $v)
            <input type="hidden" value="{{@$v->con_id}}"  name="con_id">
        <li><a id="ret">{{@$v->wx_name}}:{{@$v->content}}</a></li>
        @endforeach
    </ul>

</body>
</html>
<script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">

    $("#pin").on('click',function(){
        // alert(dodo); return false;
        var content = $("#content").val();
        // alert(content);return false;
        var h_id = $('input[name=h_id]').val();
        $.ajaxSetup({
                  headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
              });
        $.ajax({
                url:"hotspot-comment",
                type:"post",
                dataType:"json",
                cache:false,
                async:false,
                data:{content:content,h_id:h_id},
                success:function (res) {
                    if (res.code == 1){
                        alert('评论成功');
                        window.location.href="hotspot-view?h_id="+h_id;
                    }else{
                        alert('网络繁忙,稍后重试');
                    }
                }
        });
    });

    $("#ret").on('click',function(){ 
        var con_id = $('input[name=con_id]').val();
        alert(con_id);return false;

        $.ajaxSetup({
                  headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
              });

        $.ajax({
                url:"hotspot-comment",
                type:"post",
                dataType:"json",
                data:{content:content,h_id:h_id},
                success:function (res) {
                    if (res.code == 1){
                        alert('跟帖成功');
                        window.location.href="hotspot-view?h_id="+h_id;
                    }else{
                        alert('网络繁忙,稍后重试');
                    }
                }
        });

    });

$(function(){
    $(window).bind("scroll",function(){
        if(document.body.scrollTop>60){
            $(".tips_box").show();
        }else{
            $(".tips_box").hide();
        }
    });
});

var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F16f2e7c9bbcd505f4a9cf6e267e10b0c' type='text/javascript'%3E%3C/script%3E"));
$(document).ready(function(){
    var $a = $('body>a');
    $a[$a.length - 1].style.display = 'none';
});
</script>