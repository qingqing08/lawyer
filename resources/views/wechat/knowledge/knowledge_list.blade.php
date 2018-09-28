<!DOCTYPE HTML>
<html>
<head>
    <meta charset="gbk" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>法律常识</title>
    <meta name="keywords" content="查法规，法律法规" /><meta name="description" content="找法网手机版为您提供宪法、民商法、婚姻法等最全面法律法规查询，同时提供律师为您解决法律难题" />	<link type="text/css" href="/css/law_touch.css" rel="stylesheet" />
    <script type="text/javascript" src="/css/mobi.min.js" charset="gbk"></script>


</head>
<body>
<header class="sub_header">
    <a href="../default.htm" class="b_link">首页</a>
    <ul class="top_nav">
        <li><a href="ask.html">发咨询</a></li>
        <li><a href="../lawyer/lawyer.html">找律师</a></li>
        <li><a href="../fagui/fagui.html">查法规</a></li>
    </ul>
    <h1 class="sub_title">查法规</h1>
</header>
<div>
    <dl class="tag_box c666 bgcfff dash_bb clearfix">
        <dt>法律体系：</dt>
        <dd><a href="/knowledge-list" class="cur">全部</a></dd>
        @foreach($type as $v)
        <dd><a class="" href="/type?t_id={{$v->t_id}}">{{$v->t_name}}</a></dd>
        @endforeach
    </dl>
    <ul class="fl_list">
        @foreach($data as $v)
        <li><a href="/knowledge-view?k_id={{$v->k_id}}">{{$v->k_title}}({{$v->t_name}})({{$v->k_ctime}})</a></li>
        @endforeach
    </ul>
</div>
<div class="search_bar fl_form">
    <form method="post" action="/knowledge-vague">
        @csrf
        <input class="txt_ipt mr10" type="text" name="keyword"/><input class="btn" value="搜法规" type="submit" />
    </form>
    <input type="button" id="tougao" value="投稿">
</div>
<a class="tips_box" href="../tel_3A400-676-8333"><div class="tips_inbox"><span class="tips_tel">400-676-8333</span><span class="tips_inbox-text">点击免费咨询律师</span></div></a>
<footer class="f16 tc c666">
    <div class="footer_bar">
        <a href="../login">登录</a>
        <a href="../register">注册</a>			<!--<a href="http://m.findlaw.cn/shortcut">下载到手机桌面</a>-->
        <a href="#" class="to_top tl">TOP</a>
    </div>
    <div class="footer_nav">
        <a href="../default.htm">首页</a>
        <a href="javascript:;" id="tougao">投稿</a>
        <a href="../lawyer">找律师</a>
        <a href="../fagui">查法规</a>
    </div>
    <p class="copyright">Copyright@2003-2014　版权所有 找法网（Findlaw.cn）- 中国最大的法律服务平台</p>
</footer>
</body>
</html>
<script type="text/javascript">
    {{--$("#tougao").on('click' , function(){--}}
        {{--if(money != ''){--}}
            {{--$('h3').html('请使用微信扫描二维码')--}}
            {{--$('img').attr('src' , 'http://pengqq.jebt.top/generateCode?order_id={{$order_id}}&money='+ money)--}}

        {{--}--}}

    $('input[type=submit]').click(function(){
        var token = $("input[name=_token]").val();
        var keyword=$('input[name=kw]').val();
        $.ajax({
            url:"/knowledge-vague",
            type:"post",
            data:{keyword:keyword,_token:token},
            cache:false,
            async:false,
        })
    })
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