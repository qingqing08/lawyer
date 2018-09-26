@include('admin.layouts.header')
<div class="x-body">
    <form action="" method="post" class="layui-form layui-form-pane">
        @csrf
        <div class="layui-form-item">
            <label for="name" class="layui-form-label">
                <span class="x-red">*</span>类型名称
            </label>
            <div class="layui-input-inline">
                <input type="text" id="t_name" name="t_name" required="" lay-verify="required"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <button class="layui-btn" lay-submit="" lay-filter="add">增加</button>
        </div>
    </form>
</div>
<script>
    layui.use(['form','layer'], function(){
        $ = layui.jquery;
        var form = layui.form
            ,layer = layui.layer;

        //自定义验证规则
        form.verify({
            // nikename: function(value){
            //     if(value.length < 5){
            //         return '昵称至少得5个字符啊';
            //     }
            // }
            // ,pass: [/(.+){6,12}$/, '密码必须6到12位']
            // ,repass: function(value){
            //     if($('#L_pass').val()!=$('#L_repass').val()){
            //         return '两次密码不一致';
            //     }
            // }
        });

        //监听提交
        form.on('submit(add)', function(data){
            console.log(data);
            //发异步，把数据提交给php
            $.ajax({
                url:"type-add-do",
                type:"post",
                dataType:"json",
                data:data.field,
                cache:false,
                async:false,
                success:function (res) {
                    if (res.code == 1){
                    layer.msg(res.font, {icon: res.code, time: 1500}, function () {
                        layer.close(layer.index);
                        window.parent.location.reload();
                    });
                    }  else {
                        layer.msg(data.font, {icon: data.code});
                    }
                }
            })

            return false;
        });


    });
</script>
<script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();</script>
</body>

</html>