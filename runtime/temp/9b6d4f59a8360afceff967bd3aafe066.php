<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:86:"/Applications/MxSrvs/www/shenkangxi/public/../application/admin/view/public/login.html";i:1522309547;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>后台-登录</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" type="text/css" href="__STATIC__/admin/css/login.css" media="all">
    <link rel="stylesheet" type="text/css" href="__STATIC__/admin/css/default_color.css" media="all">
</head>
<body id="login-page">

<div id="main-content">

    <div class="login-body">
        <div class="login-main pr">
            <form action="" method="post" class="login-form">
                <h3 class="welcome">后台管理系统</h3>

                <div id="itemBox" class="item-box">
                    <div class="item">
                        <i class="icon-login-user"></i> <input type="text" id="account" name="account" placeholder="请填写账号" autocomplete="off"/>
                    </div>
                    <span class="placeholder_copy placeholder_un">请填写用户名</span>

                    <div class="item b0">
                        <i class="icon-login-pwd"></i> <input type="password" id="passwd" name="passwd" placeholder="请填写密码" autocomplete="off"/>
                    </div>
                    <span class="placeholder_copy placeholder_pwd">请填写密码</span>

                </div>
                <div class="login_btn_panel">
                    <button class="login-btn" type="button" onclick="submitFormFuc()">
                        <span class="in"><i class="icon-loading"></i>登 录 中 ...</span> <span class="on">登 录</span>
                    </button>
                    <div class="check-tips"></div>
                </div>
            </form>
        </div>
    </div>
</div>





<script src="__STATIC__/js/jquery-3.2.1.min.js" charset="utf-8"></script>
<script src="__STATIC__/layui.js"  charset="utf-8"></script>
<script src="__STATIC__/admin/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    $(function(){
        var random_bg = Math.floor(Math.random() * 10 + 1);
        var bg = 'url(__STATIC__/admin/images/bg_' + random_bg + '.jpg)';
        $("body").css("background-image", bg);
    });

    $(document).keyup(function(event){
        if( event.keyCode == 13 ){
            submitFormFuc();
        }
    });

    function submitFormFuc(){

        var account = $("#account").val();
        var passwd = $("#passwd").val();
        if( account == "" ){
            layui_alert("请输入账号");
            return false;
        }
        if( passwd == "" ){
            layui_alert("请输入密码");
            return false;
        }
        $("form").submit();
    }



</script>
</body>

</html>
