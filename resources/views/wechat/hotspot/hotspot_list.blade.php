<!DOCTYPE HTML>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>实时热点</title>
    <meta name="keywords" content="法律咨询，律师，法律咨询电话" /><meta name="description" content="找法网手机版为您提供法律咨询、找律师、查询法律法规，各地区律师电话咨询服务" />    <link type="text/css" href="./css/law_touch.css" rel="stylesheet" />
        <script type="text/javascript" src="./css/mobi.min.js" charset="gbk"></script>
    
</head>
<body>
<div class="new_ask">
    <h2 class="hd"><a href="ask">最新实时热点</a></h2>
    <div class="bd f17">
        <ul class="fl_list">
        	@foreach($data as $v)
            <li>
                <a href="hotspot-view?h_id={{$v->h_id}}">{{@$v->h_title}}<span><?php echo date('m-d H:i:s',$v->h_ctime); ?></span></a>
            </li>   
            @endforeach    
        </ul>
    </div>
</div>

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