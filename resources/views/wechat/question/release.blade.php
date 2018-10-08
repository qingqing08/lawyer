<div>
    请输入问题内容：
    <textarea name="q_content" id="q_content" cols="30" rows="10"></textarea>
    <br>
    请输入悬赏金额：
    <input type="number" name="money" id="money" min="10">
    <br>
    <input type="button" onclick="pay()" value="发布">
</div>
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<script>
    function pay(){
        //alert(1);
        var money = $("#money").val();
        var q_content = $("#q_content").val();
        //var openid = "oSt2Q0Z4_n1vxX4QgKm-_HHAAcn0";

        var openid = "{{ $openid }}";

        window.location.href="http://peng.jinxiaofei.xyz/pay-do?money="+money+"&q_content="+q_content+"&openid="+openid;
    }
</script>