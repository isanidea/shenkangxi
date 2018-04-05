<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:88:"/Applications/MxSrvs/www/shenkangxi/public/../application/admin/view/recharge/index.html";i:1522814209;s:85:"/Applications/MxSrvs/www/shenkangxi/public/../application/admin/view/public/base.html";i:1522395744;}*/ ?>
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
                    

<div class="account-info">
    <div class="screening">
        <form class="layui-form" action="" method="get">

            <div class="layui-form-item" style="clear: none;float: left">
                <label class="layui-form-label">账号</label>
                <div class="layui-input-inline">
                    <input type="text" name="username"  lay-verify="sort" autocomplete="off" class="layui-input" value="<?php echo !empty($Arr['username'])?$Arr['username'] : ''; ?>">
                </div>
            </div>
            <div class="layui-form-item" style="clear: none;float: left">
                <label class="layui-form-label">订单状态</label>
                <div class="layui-input-inline">
                    <select name="status">
                        <option value="" >--请选择--</option>
                        <?php if(is_array($statusName) || $statusName instanceof \think\Collection || $statusName instanceof \think\Paginator): if( count($statusName)==0 ) : echo "" ;else: foreach($statusName as $k=>$v): ?>
                        <option value="<?php echo $k; ?>"  <?php echo !empty($Arr['status']) && $Arr['status']==$k?'selected' : ''; ?> ><?php echo $v; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
            <div class="layui-form-item" style="clear: none;float: left">
                <label class="layui-form-label">开始时间</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" lay-verify="start_time" value="<?php echo !empty($Arr['start_time'])?$Arr['start_time'] : ''; ?>" name="start_time" id="start_time" placeholder="yyyy-MM-dd HH:mm:ss">
                </div>
            </div>
            <div class="layui-form-item" style="clear: none;float: left">
                <label class="layui-form-label">结束时间</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="end_time" value="<?php echo !empty($Arr['end_time'])?$Arr['end_time'] : ''; ?>" id="end_time" placeholder="yyyy-MM-dd HH:mm:ss">
                </div>
            </div>

            <div class="layui-form-item" style="clear: none;float: left">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="formDemo">确定</button>
                </div>
            </div>
            <div style="clear: both"></div>
        </form>
    </div>
    <div class="info">
        <table id="demo" class="layui-table" lay-data="{height:730, url:'<?php echo $url; ?>', page:true, id:'test'}" lay-filter="test">
            <thead>
            <tr>
                <th lay-data="{field:'id', width:60, sort: true}">ID</th>
                <th lay-data="{field:'order_no', width:200}">订单编号</th>
                <th lay-data="{field:'uid', width:100}">购买人ID</th>
                <th lay-data="{field:'username', width:120}">账号</th>
                <th lay-data="{field:'money', width:120}">金额</th>
                <th lay-data="{field:'payway', width:100, sort: true}">支付类型</th>
                <th lay-data="{field:'add_time', width:200, sort: true}">创建时间</th>
                <th lay-data="{field:'statusName', width:150, sort: true}">状态</th>
                <th lay-data="{field:'statusVal', width:200,toolbar: '#barDemo'}">操作</th>
            </tr>
            </thead>
        </table>
    </div>
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

    layui.use('table', function(){
        var table = layui.table;
        //监听工具条
        table.on('tool(test)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
            var data = obj.data; //获得当前行数据
            var layEvent = obj.event; //获得 lay-event 对应的值
            var tr = obj.tr; //获得当前行 tr 的DOM对象

            if(layEvent === 'detail'){ //查看
                var id = data.id;
                layui.use('layer', function(){
                    var layer = layui.layer;
                    layer.open({
                        title:"充值详情",
                        type: 2,
                        area: ['800px', '800px'],
                        content: ['/index.php/admin/Recharge/order_details?id='+id, 'no'],
                        end: function () {
                            location.reload();
                        }
                    });
                });
            }else if(layEvent === 'del'){ //失败
                var status = data.statusVal;
                if( status == 5 || status == 20 ){
                    prompt_From_one("此订单不能驳回");
                    return false;
                }
                layer.confirm('确定为驳回吗？不可更改！', function(index){

                    var id = data.id;
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo url("Recharge/order_del"); ?>',
                        dataType: 'json',
                        data: {id: id,status:5},
                        success: function (data) {
                            layer.close(index);
                            if( data.result != 0 ){
                                prompt_From_one(data.msg);
                            }else{
                                location.reload();
                            }
                        }
                    });
                    //向服务端发送删除指令
                });

            }else if( layEvent === 'delivery' ){
                var id = data.id;
                layer.confirm('确定支付了吗？不可更改！', function(index){
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo url("Recharge/affirm_puy"); ?>',
                        dataType: 'json',
                        data: {id: id},
                        success: function (data) {
                            layer.close(index);
                            if( data.result != 0 ){
                                prompt_From_one(data.msg);
                            }else{
                                location.reload();
                            }
                        }
                    });
                });
            }

        });


    });

    layui.use('form', function(){
        var form = layui.form;
        form.verify({
            start_time: function(value){
                var  end_time = $("#end_time").val();
                if( end_time != ""){
                    if( value == "" ){
                        return '请选择开始时间';
                    }
                }
            }
        });
    });

    layui.use('laydate', function(){
        var laydate = layui.laydate;
        //时间选择器
        laydate.render({
            elem: '#start_time'
            ,type: 'datetime'
            ,trigger: 'click'
        });
        laydate.render({
            elem: '#end_time'
            ,type: 'datetime'
            ,trigger: 'click'
        });
    });
</script>
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-mini" lay-event="detail">查看</a>
    <a class="layui-btn layui-btn-normal layui-btn-mini" lay-event="del">驳回</a>
    <a class="layui-btn layui-btn-normal layui-btn-mini" lay-event="delivery">确认付款</a>
</script>

</body>
</html>