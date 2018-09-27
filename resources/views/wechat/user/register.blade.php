<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>完善信息</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="./layui/css/font.css">
    <link rel="stylesheet" href="./layui/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="./layui/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="./layui/js/xadmin.js"></script>
</head>
<body>
<form class="layui-form" action="">
    <div class="layui-form-item">
        <label class="layui-form-label">单选框</label>
        <div class="layui-input-block">
            <input type="radio" name="sex" value="普通" title="普通">
            <input type="radio" name="sex" value="律师" title="律师" checked>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <input class="layui-btn" lay-submit lay-filter="formDemo">立即提交
        </div>
    </div>
</form>
<script>
    //Demo
    layui.use('form', function(){
        var form = layui.form;

        //监听提交
        form.on('submit(formDemo)', function(data){
            layer.msg(JSON.stringify(data.field));
            return false;
        });
    });
</script>