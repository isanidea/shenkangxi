<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:85:"/Applications/MxSrvs/www/shenkangxi/public/../application/index/view/login/index.html";i:1522825104;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>登录</title>
    <link rel="stylesheet" href="__STATIC__/qiantai/css/style.css" />
    <link rel="stylesheet" href="__STATIC__/qiantai/css/font.css" />
    <script type="text/javascript" src="__STATIC__/qiantai/js/gVerify.js" ></script>
    <script type="text/javascript" src="__STATIC__/qiantai/js/jquery-1.11.3.min.js" ></script>
    <script src="__STATIC__/qiantai/js/layer/mobile/layer_mobile.js"></script>
    <script src="__STATIC__/qiantai/js/layer/mobile/layer.js"></script>
    <script src="__STATIC__/qiantai/js/layer/mobile/common.js"></script>
</head>
<body style="background: url(__STATIC__/qiantai/img/back.jpg);width: 100vw;height: 100vh;background-size: 100% 100%;">
<div class="login login_1">
    <h2>会 员 登 录</h2>
    <form method="post">
        <div class="locgin_i">
            <i class="iconfont icon-wo"></i>
            <input type="text" placeholder="账号" name="username" />
        </div>
        <div class="locgin_i">
            <i class="iconfont icon-mima1"></i>
            <input type="password" placeholder="密码" name="password"/>
        </div>
        <!--<div class="locgin_i">-->
        <!--<i class="iconfont icon-anquanzhongxin"></i>-->
        <!--<input id="code" id="code_input" class="text_in text_code" datatype="*" placeholder="请输入验证码" nullmsg="请输入验证码" sucmsg="通过验证" name="code" type="text">-->
        <!--<div id="v_container" style="width:40%;height: 40px;position: absolute;right: 1px;margin-top:-41px"></div>-->
        <!--</div>-->
        <input  style="width: 262px; height: 42px;margin-top: 10px;"  type="button" value="登录"/>
        <p style="overflow: hidden;"><a href="<?php echo url('register/index'); ?>" style="float: left;">立即注册</a><a href="<?php echo url("","",true,false);?>" style="float: right;">忘记密码？</a></p>
    </form>
</div>
<script>
    $(function(){
        $('input[type=button]').click(function(){
            var username = $('input[name=username]').val();
            var password = $('input[name=password]').val();
            if(username == ''){
                layer_alert("用户名不能为空");
            }
            if(password.length < 6){
                layer_alert('密码长度最少6位');
            }
            $.ajax({
                type: "POST",
                url: '<?php echo url("Login/login"); ?>',
                dataType: 'json',
                cache: false,
                data: {username: username, password: password},
                success: function(data) {
                    if(data == null){
                        layer_alert('服务器错误');
                        return;
                    }
                    if(data.status == 1){
                        layer_alert(data.msg);
                        return;
                    }
                    if(data.status ==2){
                        layer_alert(data.msg);
                        return;
                    }
                    layer.open({
                        content: data.msg
                        ,style: 'color:#ffffff;border:none;'
                        ,time: 2 //2秒后自动关闭
                        ,end:function(){
                            location.href = '<?php echo url("index/index"); ?>';
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        });
    })

</script>
</body>
</html>