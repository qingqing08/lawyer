<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>投稿</title>
    <meta name="keywords" content="查法规，法律法规" /><meta name="description" content="　　《全国人民代表大会常务委员会关于修改〈中华人民共和国婚姻法〉的决定》已由中华人民共和国第九届全国" />	<link type="text/css" href="/css/law_touch.css" rel="stylesheet" />
    <script type="text/javascript" src="/css/mobi.min.js" charset="gbk"></script>

</head>
<body>
<header class="sub_header">
    <a href="/knowledge-list" class="b_link">列表</a>
    <ul class="top_nav">
        <li><a href="ask.html">发咨询</a></li>
        <li><a href="../lawyer/lawyer.html">找律师</a></li>
        <li><a href="../fagui/fagui.html">查法规</a></li>
    </ul>
    <h1 class="sub_title">法规正文</h1>
</header>
<form action="/knowledge-" method="post">
<div class="ask_art_tle"><input type="text" name="k_title" pleaseholder ="标题"></div>
        <select>
            <option value="" >请选择类型</option>
            @foreach($data as $v)
                <option value="{{$v->t_id}}">{{$v->t_name}}</option>
            @endforeach
        </select>
<div class="ask_art_box">
    <div class="fagui_text">
        <textarea name="k_content" pleaseholder ="内容"></textarea>
    </div>
    <p class="ask_name">
    <div class="fr">
        <!-- Baidu Button BEGIN -->
        <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare">
            <a class="bds_qzone"></a>
            <a class="bds_tsina"></a>
            <a class="bds_tqq"></a>
            <!--<a class="bds_renren"></a>
            <a class="bds_t163"></a>-->
            <span class="bds_more"></span>
            <!--<a class="shareCount"></a>-->
        </div>
        <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=0" ></script>
        <script type="text/javascript" id="bdshell_js"></script>
        <script type="text/javascript">
            document.getElementById("bdshell_js").src = "../../bdimg.share.baidu.com/static/js/shell_v2.js@cdnversion=" + Math.ceil(new Date()/3600000)
        </script>
        <!-- Baidu Button END -->
    </div>
    </p>
</div>
    </form>
<div class="search_bar fl_form">
    <form method="post" action="http://m.findlaw.cn/?m=fagui&a=search">
        <input class="txt_ipt mr10" type="text" name="kw" value="" x-webkit-speech="x-webkit-speech"/><input class="btn" value="搜法规" type="submit" />
        <input type="hidden" name="__hash__" value="30e182b25c853fc3b314d074c2ab4724" /></form>
</div>
<a class="tips_box" href="tel_3A400-676-8333"><div class="tips_inbox"><span class="tips_tel">400-676-8333</span><span class="tips_inbox-text">点击免费咨询律师</span></div></a>
<footer class="f16 tc c666">
    <div class="footer_bar">
        <a href="../login">登录</a>
        <a href="../register">注册</a>			<!--<a href="http://m.findlaw.cn/shortcut">下载到手机桌面</a>-->
        <a href="#" class="to_top tl">TOP</a>
    </div>
    <div class="footer_version">
        <a href="../../3g.findlaw.cn/default.htm">普通版</a>
        <a href="../default.htm">触屏版</a>
        <a href="../../china.findlaw.cn/default.htm">电脑版</a>
    </div>
    <div class="footer_nav">
        <a href="../default.htm">首页</a>
        <a href="../ask/ask.php">发咨询</a>
        <a href="../lawyer">找律师</a>
        <a href="../fagui">查法规</a>
    </div>
    <p class="copyright">Copyright@2003-2014　版权所有 找法网（Findlaw.cn）- 中国最大的法律服务平台</p>
</footer>
</body>
</html>
<script type="text/javascript">

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