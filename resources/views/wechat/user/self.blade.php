<!DOCTYPE HTML>
<html>
<head>
    <meta charset="gbk" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>个人中心</title>
    <meta name="keywords" content="找律师，律师电话" /><meta name="description" content="欢迎光临网上法律咨询室。" />	<link type="text/css" href="../css/law_touch.css" rel="stylesheet" />
    <script type="text/javascript" src="../css/mobi.min.js" charset="gbk"></script>

</head>
<body>
<header class="sub_header">
    <a href="../lawyer" class="b_link">返回</a>
    <ul class="top_nav">
        <li><a href="ask.html">发咨询</a></li>
        <li><a href="../lawyer/lawyer.html">找律师</a></li>
        <li><a href="../fagui/fagui.html">查法规</a></li>
    </ul>
    <h1 class="sub_title">个人中心</h1>
</header>
<div class="f16">
    <div class="ly_info f17">
        <p class="hs_link"><img alt="{{$user_info -> wx_name}}" src="{{$user_info -> wx_headeimg}}" /></p>
        <p><span class="ly_name">{{$user_info -> wx_name}}</span></p>
        <p><span>
                @if($user_info -> u_type == 1)
                    <?php echo '普通会员'?>
                    @else
                    <?php echo '律师'?>
                    @endif
            </span></p>
        <input type="button" value="充值" id="Recharge">  <input type="button" value="提现" id="forward">  余额：<span>{{$user_info -> balance}}</span>
    </div>


</div>
</body>
</html>
<script type="text/javascript">

    //充值
    $('#Recharge').on('click' , function(){
        window.location.href="/Code";
    })

    //提现
    $('#forward').on('click' ,function(){
        
        window.location.href="/forward";
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