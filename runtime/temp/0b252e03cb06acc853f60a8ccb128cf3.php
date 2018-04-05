<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:86:"/Applications/MxSrvs/www/shenkangxi/public/../application/admin/view/user/details.html";i:1522656660;s:85:"/Applications/MxSrvs/www/shenkangxi/public/../application/admin/view/public/base.html";i:1522395744;}*/ ?>
<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo $configArr['company']; ?>后台管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="__STATIC__/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="__STATIC__/layui/css/global.css" media="all">
    <style>
        .layui-nav-tree{vertical-align: top;}
        .content{border: 1px solid #BBBBBB;border-radius: 5px;padding-bottom: 30px;background-color: #fff;}
        .content .content-top{line-height: 40px;padding-left: 30px;background-color: #e1e1e1;font-size: 16px;border-radius: 5px 5px 0px 0px;color: #333;}
        @media (max-width:1200px){
            body{min-width: 1200px;overflow:auto;}
            .site-tree-mobile{position: absolute;}
        }
    </style>

    

    
    
<style type="text/css">
    .details{padding: 20px;}
    .details li{float: left;height: 30px;padding-top: 5px;line-height: 30px;width: 50%}
    .details li span{display: block;float: left;width: 200px;line-height: 30px;text-align: right;}
    .details li p{line-height: 30px;float: left;}
</style>


    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!--<link id="layuicss-skincodecss" rel="stylesheet" href="./导航菜单_面包屑 - 在线演示 - layui_files/code.css" media="all">-->

</head>


<body>
<div class="layui-layout layui-layout-admin">
    <div class="layui-header header header-demo">
        <div class="layui-main">
            <a class="logo" href="javascript:;">
                <p style="color: #fff;">后台管理</p>
                <!--<img src="./导航菜单_面包屑 - 在线演示 - layui_files/logo.png" alt="layui">-->
            </a>
            <!--<div class="layui-form component">-->
            <!--</div>-->
            <ul class="layui-nav layui-layout-right">
                <li class="layui-nav-item">
                    <a href="javascript:;">
                        <img src="__STATIC__/layui/images/admin_img.jpg" class="layui-nav-img">
                        <?php echo $userName; ?>
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a onclick="savePasswd()">修改密码</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item"><a href='<?php echo url("Admin/quitLogin"); ?>'>退出</a></li>
            </ul>
        </div>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
             
            <ul class="layui-nav layui-nav-tree site-demo-nav">

                <li class="layui-nav-item"><a href='<?php echo url("Index/index"); ?>'>首页</a></li>

                <?php foreach($navList as $v): ?>
                <li class='layui-nav-item <?php if( in_array( $navArr["nav_controller"], $v["controllers"]) ){ echo "layui-nav-itemed"; } ?>'>
                    <a class="javascript:;" href="javascript:;"><?php echo $v['name']; ?> <span class="layui-nav-more"></span></a>
                    <dl class="layui-nav-child">
                        <?php foreach($v['list'] as $vv): ?>
                        <dd class='<?php if( $vv["nav_controller"] == $navArr["nav_controller"] && $vv["nav_action"] == $navArr["nav_action"]){  echo "layui-this"; } ?>'>
                            <a href='<?php echo url($vv['url']); ?>'><?php echo $vv['name']; ?></a>
                        </dd>
                        <?php endforeach; ?>
                    </dl>
                </li>
                <?php endforeach; ?>

                <li class="layui-nav-item" style="height: 30px; text-align: center"></li>
                <span class="layui-nav-bar"></span>
            </ul>

        </div>
    </div>


    <div class="site-tree-mobile layui-hide">
        <i class="layui-icon"></i>
    </div>
    <div class="site-mobile-shade"></div>

    <div class="layui-body">
        <!-- 内容主体区域 -->
        

        <div style="padding: 15px 20px;">
            <div class="content">
                <div class="content-top">
                    <p><?php echo $headerName; ?></p>
                </div>
                <div style="padding: 10px;">
                    
<div class="details">
    <li>
        <span>会员ID：</span>
        <p><?php echo $Arr['uid']; ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>直推人ID：</span>
        <p><?php echo $Arr['pid']; ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>会员呢称：</span>
        <p><?php echo $Arr['nickname']; ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>会员账号：</span>
        <p><?php echo $Arr['username']; ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>手机号：</span>
        <p><?php echo $Arr['phone']; ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>真实姓名：</span>
        <p><?php echo $Arr['real_name']; ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>身份证：</span>
        <p><?php echo $Arr['id_card']; ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>消费等级：</span>
        <p><?php echo $Arr['lever']; ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>销售等级：</span>
        <p><?php echo $Arr['manage_lever']; ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>总业绩：</span>
        <p><?php echo $Arr['total_yeji']; ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>总收益：</span>
        <p><?php echo $Arr['total_profit']; ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>现金：</span>
        <p><?php echo $Arr['cash']; ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>奖金卷：</span>
        <p><?php echo $Arr['bonus']; ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>总积分：</span>
        <p><?php echo $Arr['jifen_total']; ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>注册时间：</span>
        <p><?php echo date("Y-m-d H:i",$Arr['add_time']); ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>最后登录时间：</span>
        <p><?php echo date("Y-m-d H:i",$Arr['last_login_time']); ?></p>
        <div style="clear: both"></div>
    </li>
    <div style="clear: both"></div>
    <div style="width: 360px;margin: 0px auto;padding-top: 30px;">
        <a href='javascript:;' onclick="edit_fuc('<?php echo $Arr['uid']; ?>')"  class="layui-btn">编辑</a>
        <a href='javascript:;' onclick="del_fuc('<?php echo $Arr['uid']; ?>')"  class="layui-btn">删除</a>
    </div>
</div>
<div>

</div>


                </div>
            </div>
        </div>

        
    </div>
</div>

<script src="__STATIC__/js/jquery-3.2.1.min.js" charset="utf-8"></script>
<!--<script src="__ADMIN__/layer/layer.js" charset="utf-8"></script>-->
<script src="__STATIC__/layui/layui.js"  charset="utf-8"></script>
<script src="__STATIC__/admin/js/common.js" charset="utf-8"></script>
<script src="__STATIC__/admin/js/fromCommon.js" charset="utf-8"></script>
<script>
    window.global = {
        pageType: 'demo'
        ,preview: function(){
            var preview = document.getElementById('LAY_preview');
            return preview ? preview.innerHTML : '';
        }()
    };
//    layui.config({
//        base: '//res.layui.com/lay/modules/layui/'
//        ,version: '1515376178738'
//    }).use('global');
    var web_width = window.innerWidth;
    if( web_width <= 1200 ){
        layui.config({
            base: '__STATIC__/layui/'
        }).use('global');
    }
    function savePasswd(){
        layui.use('layer', function(){
            var layer = layui.layer;

            layer.open({
                title:"修改密码",
                type: 2,
                area: ['500px', '300px'],
                content: ['<?php echo url("Admin/savePasswd"); ?>', 'no'],
                end: function () {
                    location.reload();
                }
            });
        });
    }
</script>

<div id="LAY_democodejs">
    <script>
        layui.use('element', function(){
            var element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

            //监听导航点击
            element.on('nav(demo)', function(elem){
                //console.log(elem)
                layer.msg(elem.text());
            });
        });
    </script>
</div>




<script type="text/javascript">

    function allocate_fuc(uid){
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.open({
                title:"拨币",
                type: 2,
                area: ['500px', '500px'],
                content: ['/admin/User/allocate?id='+uid, 'no'],
                end: function () {
                    location.reload();
                }
            });
        });
    }

    function del_fuc(uid){
        layer.confirm('确定此用户要删除吗？不可更改！', function(index){
            $.ajax({
                type: 'POST',
                url: '<?php echo url("User/user_del"); ?>',
                dataType: 'json',
                data: {id: uid},
                success: function (data) {
                    layer.close(index);
                    if( data.result == 0 ){
                        layer.open({
                            content: data.msg
                            ,style: 'color:#ffffff;border:none;'
                            ,time: 2 //2秒后自动关闭
                            ,end:function(){
                                location.href = '<?php echo url("user/index"); ?>';
                            }
                        });
                    }else{
                        prompt_From_one(data.msg);
                    }
                }
            });
            //向服务端发送删除指令
        });
    }

    function edit_fuc(uid){
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.open({
                title:"编辑会员",
                type: 2,
                area: ['800px', '800px'],
                content: ['/index.php/admin/user/edit?id='+uid, 'no'],
                end: function () {
                    location.reload();
                }
            });
        });
    }

</script>

</body>
</html>