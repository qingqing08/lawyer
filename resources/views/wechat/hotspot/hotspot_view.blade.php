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
        <span> <?php echo date('M-d H:i:s',$datainfo->h_ctime);?> </span>
            <p>{{@$datainfo->h_content}}</p>              
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
        <div class="footer_version">
            <a href="../3g.findlaw.cn/default.htm">普通版</a>
            <a href="default.htm">触屏版</a>
            <a href="../china.findlaw.cn/default.htm">电脑版</a>
        </div>
        <div class="footer_nav">
            <a href="default.htm">首页</a>
            <a href="ask/ask.php">发咨询</a>
            <a href="lawyer">找律师</a>
            <a href="fagui">查法规</a>
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