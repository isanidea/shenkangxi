<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:86:"/Applications/MxSrvs/www/shenkangxi/public/../application/admin/view/Product/edit.html";i:1522482548;s:85:"/Applications/MxSrvs/www/shenkangxi/public/../application/admin/view/public/base.html";i:1522395744;}*/ ?>
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
    .hide{display: none}
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
                    

<div style="width: 800px; padding-top: 30px;">
    <form method="post"  class="layui-form" action='<?php echo url("product/edit"); ?>' enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo !empty($Arr['id'])?$Arr['id'] : 0; ?>">
        <div class="layui-form-item">
            <label class="layui-form-label">商品名</label>
            <div class="layui-input-inline">
                <input type="text" name="product_name" lay-verify="required" autocomplete="off" class="layui-input" value="<?php echo !empty($Arr['product_name'])?$Arr['product_name'] : ''; ?>">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">成本价</label>
            <div class="layui-input-inline">
                <input type="text" name="cost_jifen" lay-verify="number" autocomplete="off" class="layui-input" value="<?php echo !empty($Arr['cost_jifen'])?$Arr['cost_jifen'] : ''; ?>">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">出售价</label>
            <div class="layui-input-inline">
                <input type="text" name="sales_jifen"    lay-verify="number" autocomplete="off" class="layui-input" value="<?php echo !empty($Arr['sales_jifen'])?$Arr['sales_jifen'] : ''; ?>">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-inline">
                <input type="text" name="sort"  lay-verify="sort" autocomplete="off" class="layui-input" value="<?php echo !empty($Arr['sort'])?$Arr['sort'] : '1'; ?>">
            </div>
            <div class="layui-form-mid layui-word-aux">请输入1-99</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否上线</label>
            <div class="layui-input-inline">
                <select name="status">
                    <option value="5" <?php echo !empty($Arr['status']) && $Arr['status']==5?'selected' : ''; ?>>下线</option>
                    <option value="10" <?php echo !empty($Arr['status']) && $Arr['status']==10?'selected' : ''; ?> >上线</option>
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">商品图片</label>
            <div class="layui-input-inline">
                <div class="layui-upload">
                    <button type="button" class="layui-btn" id="test1">上传图片</button>
                    <div class="layui-upload-list">
                        <img src="<?php echo !empty($Arr['img'])?$Arr['img'] : ''; ?>" class="layui-upload-img" id="demo1" width="100px" height="100px">
                        <p id="demoText"></p>
                    </div>
                </div>
            </div>
            <input type="hidden" id="fileImg" name="img" value="<?php echo !empty($Arr['img'])?$Arr['img'] : ''; ?>">
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">商品详情</label>
            <div class="layui-input-block">
                <textarea name="details" id="editor" type="text/plain"   style="height: 600px; width: 100%"><?php echo !empty($Arr['details'])?$Arr['details'] : ''; ?></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
            </div>
        </div>
    </form>
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

<script src="__STATIC__/admin/js/fromCommon.js" charset="utf-8"></script>
<script charset="utf-8" src="__STATIC__/js/ueditor/ueditor.config.js"></script>
<script charset="utf-8" src="__STATIC__/js/ueditor/ueditor.all.min.js"></script>
<script charset="utf-8" src="__STATIC__/js/ueditor/lang/zh-cn/zh-cn.js"></script>



<script type="text/javascript">
    layui.use(['form', 'layedit', 'laydate'], function(){
        var form = layui.form;
        var layer = layui.layer;

        //自定义验证规则
        form.verify({

            sort: function(value){
                if( value == "" || 0 > parseInt(value) || parseInt(value) > 99 ){
                    return '请输入排序1到99数字';
                }
            }
        });

//        //监听提交
//        form.on('submit(formDemo)', function(data){
//            var url = $("#from").attr("data-url");
//            $.ajax({
//                type: 'POST',
//                url: url,
//                dataType: 'json',
//                data: data.field,
//                success: function (da) {
//                    if( da.result == 0 ){
//                        prompt_From_one("编辑成功！");
//                    }else{
//                        prompt_From_one("编辑失败！");
//                    }
//                }
//            });
//            return false;
//        });

    });


    layui.use('upload', function(){
        var upload = layui.upload;

        //执行实例
        var uploadInst = upload.render({
            elem: '#test1' //绑定元素
            ,url: '<?php echo url("product/up_image"); ?>' //上传接口
            ,done: function(res){
                if(res.code == 0){
                    var da = res.msg;
                    $('#demo1').attr('src', da.imgUrl); //图片链接（base64）
                    $("#fileImg").val(da.imgUrl);
                }else{
                    return layer.msg('上传失败');
                }
            }

        });
    });

    $(document).ready(function() {

        ue = UE.getEditor('editor', {
            autoHeightEnabled: false, toolbars: [
                [
                    'fullscreen',
                    'source',
                    'undo',
                    'redo',
                    'bold',
                    'indent',
                    'snapscreen',
                    'simpleupload', //单图上传
                    'insertimage',
                    'justifyleft', //居左对齐
                    'justifyright', //居右对齐
                    'justifycenter', //居中对齐
                    'justifyjustify', //两端对齐
                    'forecolor', //字体颜色
                    'backcolor', //背景色
                    'link', //超链接
                    'emotion', //表情
                ]

            ]
        });
    });
</script>

</body>
</html>