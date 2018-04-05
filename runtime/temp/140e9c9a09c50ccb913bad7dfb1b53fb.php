<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:84:"/Applications/MxSrvs/www/shenkangxi/public/../application/admin/view/menu/index.html";i:1522314136;s:85:"/Applications/MxSrvs/www/shenkangxi/public/../application/admin/view/public/base.html";i:1522395744;}*/ ?>
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
                    
<div style="height: 38px;">
    <div style="float: left;">
        <button class="layui-btn layui-btn-normal" onclick="addModule()">添加菜单</button>
    </div>
    <div style="float: left; padding-left: 30px;">
        <form class="layui-form" action='<?php echo url("Menu/index"); ?>'>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">模块选择</label>
                    <div class="layui-input-inline">
                        <select name="module_id" lay-verify="">
                            <?php foreach($moduleList as $v): ?>
                                <option value="<?php echo $v['id']; ?>" <?php if( $v['id']== $Arr['module_id'] ){ echo "selected"; } ?> ><?php echo $v["name"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">是否为导航</label>
                    <div class="layui-input-inline">
                        <select name="status" lay-verify="">
                            <option value="0" <?php echo !empty($Arr['status']) && $Arr['status']==0?'selected' : ''; ?> >--请选择--</option>
                            <option value="10" <?php echo !empty($Arr['status']) && $Arr['status']==10?'selected' : ''; ?> >是</option>
                            <option value="5" <?php echo !empty($Arr['status']) && $Arr['status']==5?'selected' : ''; ?>>否</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">

                    <button class="layui-btn" lay-submit lay-filter="formDemo">确定</button>

                </div>
            </div>

        </form>
    </div>
    <div class="clear"></div>
</div>
<table class="layui-table">
    <colgroup>
        <col width="60">
        <col width="150">
        <col width="200">
        <col width="200">
        <col width="200">
        <col width="200">
        <col width="200">
        <col width="200">
    </colgroup>
    <thead>
    <tr>
        <th>ID</th>
        <th>排序</th>
        <th>菜单名</th>
        <th>所属模块</th>
        <th>类名</th>
        <th>方法名</th>
        <th>是否为导航</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($list as $v): ?>
    <tr>
        <td><?php echo $v["id"]; ?></td>
        <td>
            <input type="text" value="<?php echo $v['sort']; ?>" style="width: 60px;" onblur="saveSingleVal(this,<?php echo $v['id']; ?>)" data-url='<?php echo url("Menu/saveSort"); ?>'>
        </td>
        <td><?php echo $v['menu_name']; ?></td>
        <td><?php echo $v['module_name']; ?></td>
        <td><?php echo $v['controller']; ?></td>
        <td><?php echo $v['action']; ?></td>
        <td><?php echo !empty($v['status']) && $v['status']==10?'是': '否'; ?></td>
        <td>
            <div class="layui-table-cell laytable-cell-1-10">
                <a class="layui-btn layui-btn-mini" onclick="editModule(<?php echo $v['id']; ?>)" lay-event="edit">编辑</a>
                <a class="layui-btn layui-btn-danger layui-btn-mini" onclick="deleteFuc(this,<?php echo $v['id']; ?>)" data-url='<?php echo url("Menu/delete"); ?>'>删除</a>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

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
    layui.use(['form', 'layedit', 'laydate'], function(){
        var form = layui.form;
        var layer = layui.layer;

    });

    function addModule(){
        layui.use('layer', function(){
            var layer = layui.layer;

            layer.open({
                title:"添加菜单",
                type: 2,
                area: ['500px', '480px'],
                content: ['<?php echo url("Menu/add"); ?>', 'no'],
                end: function () {
                    location.reload();
                }
            });
        });
    }

    function editModule(a){
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.open({
                title:"模块编辑",
                type: 2,
                area: ['500px', '480px'],
                content: ['/index.php/admin/Menu/edit?id='+a, 'no'],
                end: function () {
                    location.reload();
                }
            });
        });
    }

</script>

</body>
</html>